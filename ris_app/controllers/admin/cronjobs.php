<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class cronjobs extends CI_Controller {
    
    //php -f /home/rootigfk/public_html/labs/ris/index.php cron/test
    function __construct() {
        parent::__construct();
    }

    public function test(){
    	$option['tomailid'] = 'ranasoyab@yopmail.com';
	    $option['subject'] = 'Testing';
	    $option['message'] = 'Hello';
	    send_mail($option);
    }

    /* ************** ONE TO MANY URLS  ************** */ 
	    public function getUrls($limit = 5){
	    	$obj_scrap = new Scrap();
	    	$obj_scrap->where('link_status', '0');
	    	$obj_scrap->limit($limit);
	        $obj_scrap->get();

	        foreach ($obj_scrap as $scrap) {
	        	 switch ($scrap->type) {
	        	 	case '1':
	        	 		$this->_scrapUrlsJustDial($scrap);
	        	 		break;
	        	 	
	        	 	default:
	        	 		break;
	        	 }
	        }
	    }

	    private function _scrapUrlsJustDial($scrap){
	    	$main_link = $scrap->url;
			$scraped_page = myCurl($main_link);
			preg_match_all('#<div class="jpag" +.*?>(.+?)</div>#is', $scraped_page, $sections);
			if(isset($sections[1][0])){
				$html_1 = str_get_html($sections[1][0]);
				foreach ($html_1->find('a') as $key => $value) {
				    if(isset($value->attr['rel'])){
				        continue;
				    }
				    $last_page = trim($value->plaintext);
				}

				for ($i=2; $i<=$last_page;$i++) {
					$obj_new_scrap = array();
					$obj_new_scrap['type'] = $scrap->type;
					$obj_new_scrap['businesscategory_id'] = $scrap->businesscategory_id;
		            $obj_new_scrap['businesssubcategory_id'] = $scrap->businesssubcategory_id;
		            $obj_new_scrap['url'] = $main_link .'/page-' . $i;
		            $obj_new_scrap['link_status'] = '1';

		            $this->db->select('*');
			        $this->db->where(array('url' => $obj_new_scrap['url']));
			        $this->db->from('scraps');
					$count = $this->db->count_all_results();
					if($count == 0) {
						$this->db->insert('scraps', $obj_new_scrap); 
					}
				}
			}

			$this->db->where('id', $scrap->id);
			$this->db->update('scraps', array('link_status' => '1'));

			return true;
	    }
    /* ************************************************ */ 

    /* ************** Get Scrap Datas  ************** */ 
	    public function getUrlData($limit = 1){
	    	$obj_scrap = new Scrap();
	    	$obj_scrap->where('status', '0');
	    	$obj_scrap->limit($limit);
	        $obj_scrap->get();

	        switch ($obj_scrap->type) {
	        	case '1':
	        		$this->_scrapUrlDataJustDial($obj_scrap);
	        		break;
	        	
	        	default:
	        		break;
	        }

	        $this->db->where('id', $obj_scrap->id);
			$this->db->update('scraps', array('status' => '1')); 

			return true;
	    }

	    private function _scrapUrlDataJustDial($obj_scrap){
	    	$scraped_page = myCurl($obj_scrap->url);
	    	preg_match_all('#<section class="jrcl "+.*?>(.+?)</section>#is', $scraped_page, $outer_sections);

	    	foreach ($outer_sections[1] as $outer_section) {
		        $temp = array();
		        $temp['businesscategory_id'] = $obj_scrap->businesscategory_id;
		        $temp['businesssubcategory_id'] = $obj_scrap->businesssubcategory_id;
		        $html = str_get_html($outer_section);
		        $a = $html->find('aside span a');
		        $new_link = myCurl($a[0]->attr['href']);

		        preg_match_all('#<section class="jcnwrp"+.*?>(.+?)</section>#is', $new_link, $section_1);
		        $html_1 = str_get_html($section_1[1][0]);
		        $c = $html_1->find('aside h1 span span');
		        $temp['company_name'] = trim($c[0]->plaintext);

		        preg_match_all('#<div class="trstfctr"+.*?>(.+?)</div>#is', $new_link, $section_4);
		        $html_4 = str_get_html($section_4[1][0]);
		        $estd = $html_4->find('ul li.estd span.rtngna');
		        if(isset($estd[0]->plaintext) && trim($estd[0]->plaintext) != 'N/A'){
		            $temp['estd'] = trim($estd[0]->plaintext);    
		        }
		        

		        preg_match_all('#<section class="moreinfo"+.*?>(.+?)</section>#is', $new_link, $section_2);
		        $html_2 = str_get_html($section_2[1][0]);

		        $address = $html_2->find('aside p .jaddt');
		        if(isset($address[0]) && !empty($address[0]->plaintext)){
		        	$temp['address'] = trim($address[0]->plaintext);
		        }

		        $mobile = $html_2->find('aside .jmob');
		        if(isset($mobile[0]) && !empty($mobile[0]->parent()->plaintext)){
		        	$temp['mobile'] = trim($mobile[0]->parent()->plaintext);
		        }

		        $landline = $html_2->find('aside .jtel');
		        if(isset($landline[0]) && !empty($landline[0]->parent()->plaintext)){
		        	$temp['landline'] = trim($landline[0]->parent()->plaintext);
		        }

				$url = $html_2->find('aside .jwb');
		        if(isset($url[0]) && !empty($url[0]->parent()->plaintext)){
		        	$temp['url'] = trim($url[0]->parent()->plaintext);
		        	$temp['type'] = 4;
		        } else {
		        	$temp['type'] = 1;
		        }

		        preg_match_all('#<section id="alsol"+.*?>(.+?)</section>#is', $new_link, $section_3);
		        $html_3 = str_get_html($section_3[1][0]);
		        $also_listed = array();
		        foreach ($html_3->find('tr') as $tr) {
		            foreach ($tr->find('td') as $td) {
		                $also_listed[] = trim($td->plaintext);
		            }
		        }
		        $temp['listedin'] = implode(',',array_values(array_unique(array_filter($also_listed))));

		        /*$this->db->select('*');
		        $this->db->where(
		        	array(
		        		'businesscategory_id' => $temp['businesscategory_id'],
		        		'businesssubcategory_id' => temp['businesssubcategory_id'],
		        		'company_name' => $temp['company_name'],
		        		'address' => $temp['address']
		        	)
		        );*/

		        //$this->db->from('companies');
				//$count = $this->db->count_all_results();
				//if($count == 0) {
					$this->db->insert('companies', $temp);
				//}
		        
		    }
	    }
    /* ************** Get Scrap Datas  ************** */ 

}
?>