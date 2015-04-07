<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');



class cronjobs extends CI_Controller {

    //php -f /home/rootigfk/public_html/labs/ris/index.php cron/test
    function __construct() {
        parent::__construct();
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '128M');
    }

    public function test($text) {
        $option['tomailid'] = 'ranasoyab@yopmail.com';
        $option['subject'] = $text;
        $option['message'] = 'Hello ' . $text;
        send_mail($option);
    }

    /* ************** ONE TO MANY URLS  ************** */

    public function getUrls($limit = 1) {
        $obj_scrap = new Scrap();
        $obj_scrap->where('link_status', '0');
        $obj_scrap->limit($limit);
        $obj_scrap->get();

        foreach ($obj_scrap as $scrap) {
            switch ($scrap->type) {
                case '1':
                    $this->_scrapUrlsJustDial($scrap);
                    break;

                case '2':
                    $this->_scrapUrlsYellowPages($scrap);
                    break;

                default:
                    break;
            }
        }
    }

    private function _scrapUrlsJustDial($scrap) {
        $main_link = $scrap->url;
        $links = array();
        $exit = false;
        $i = 2;
        do {
            $url = $main_link . '/page-' . $i;
            $this->db->where(array('url' => $url));
            $this->db->from('scraps');
            $count = $this->db->count_all_results();
            if ($count == 0) {
                $scraped_page = myCurl($url);
                preg_match_all('#<section class="jrcl "+.*?>(.+?)</section>#is', $scraped_page, $outer_sections);
                $outer_sections = array_filter($outer_sections);
                if (empty($outer_sections)) {
                    $exit = true;
                }
                else {
                    $obj_new_scrap = array();
                    $obj_new_scrap['type'] = $scrap->type;
                    $obj_new_scrap['businesscategory_id'] = $scrap->businesscategory_id;
                    $obj_new_scrap['businesssubcategory_id'] = $scrap->businesssubcategory_id;
                    $obj_new_scrap['url'] = $url;
                    $obj_new_scrap['link_status'] = '1';
                    $this->db->insert('scraps', $obj_new_scrap);
                }
            }
            $i++;
        } while ($exit == false);

        $this->db->where('id', $scrap->id);
        $this->db->update('scraps', array('link_status' => '1'));
        return true;
    }

    private function _scrapUrlsYellowPages($scrap) {
        $main_link = $scrap->url;
        $url_parts = explode('/',$main_link);
        $scraped_page = myCurl($main_link);

        preg_match_all('#<ul class="pagination inline"+.*?>(.+?)</ul>#is', $scraped_page, $outer_sections);
        $html = str_get_html($outer_sections[1][0]);
        $temp_link = $html->find('li', 0)->find('a'); 
        $append_link = 'http://' . $url_parts[2] . $temp_link[0]->attr['href'] . '&page=';
        $exit = false;
        $i = 2;

        do {
            $url = $append_link . $i;
            $this->db->where(array('url' => $url));
            $this->db->from('scraps');
            $count = $this->db->count_all_results();
            if ($count == 0) {
                $scraped_page = myCurl($url);
                preg_match_all('#<div class="MT_20"+.*?>(.+?)</div>#is', $scraped_page, $outer_sections);
                $outer_sections = array_filter($outer_sections);
                if (empty($outer_sections)) {
                    preg_match_all('#<div class="serpListDn"+.*?>(.+?)</div>#is', $scraped_page, $outer_sections);
                    $outer_sections = array_filter($outer_sections);
                    if (empty($outer_sections)) {
                        $exit = true;
                    }
                }

                if($exit == false){
                    $obj_new_scrap = array();
                    $obj_new_scrap['type'] = $scrap->type;
                    $obj_new_scrap['businesscategory_id'] = $scrap->businesscategory_id;
                    $obj_new_scrap['businesssubcategory_id'] = $scrap->businesssubcategory_id;
                    $obj_new_scrap['country_id'] = $scrap->country_id;
                    $obj_new_scrap['state_id'] = $scrap->state_id;
                    $obj_new_scrap['city_id'] = $scrap->city_id;
                    $obj_new_scrap['url'] = $url;
                    $obj_new_scrap['link_status'] = '1';
                    $this->db->insert('scraps', $obj_new_scrap);
                }
            }
            $i++;
        } while ($exit == false);

        $this->db->where('id', $scrap->id);
        $this->db->update('scraps', array('link_status' => '1'));
        return true;
    }
    /* ************************************************ */

    /* ************** Get Scrap Datas  ************** */

    public function getUrlData($limit = 1) {
        $obj_scrap = new Scrap();
        $obj_scrap->where(array('status' => '0'));
        $obj_scrap->limit($limit);
        $data = $obj_scrap->get();

        foreach ($data as $url) {  
            $this->db->where('id', $url->id);
            $this->db->update('scraps', array('s_time' => strtotime(date('Y-m-d H:i:s'))));

            switch ($url->type) {
                case '1':
                    $this->_scrapUrlDataJustDial($url->stored);
                    break;

                 case '2':
                    $this->_scrapUrlDataYellowPages($url->stored);
                    break;

                default:
                    break;
            }

            $this->db->where('id', $url->id);
            $this->db->update('scraps', array('status' => '1', 'e_time' => strtotime(date('Y-m-d H:i:s'))));
        }
        
        return true;
    }

    private function _scrapUrlDataJustDial($obj_scrap) {
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
            $temp['company_name'] = $this->_cleanText($c[0]->plaintext);

            preg_match_all('#<div class="trstfctr"+.*?>(.+?)</div>#is', $new_link, $section_4);
            $html_4 = str_get_html($section_4[1][0]);
            $estd = $html_4->find('ul li.estd span.rtngna');
            if (isset($estd[0]->plaintext) && $this->_cleanText($estd[0]->plaintext) != 'N/A') {
                $temp['estd'] = $this->_cleanText($estd[0]->plaintext);
            }

            preg_match_all('#<section class="moreinfo"+.*?>(.+?)</section>#is', $new_link, $section_2);
            $html_2 = str_get_html($section_2[1][0]);

            $address = $html_2->find('aside p .jaddt');
            if (isset($address[0]) && !empty($address[0]->plaintext)) {
                $temp['address'] = $this->_cleanText($address[0]->plaintext);
            }

            $mobile = $html_2->find('aside .jmob');
            if (isset($mobile[0]) && !empty($mobile[0]->parent()->plaintext)) {
                $temp['mobile'] = $this->_cleanText($mobile[0]->parent()->plaintext);
            }

            $landline = $html_2->find('aside .jtel');
            if (isset($landline[0]) && !empty($landline[0]->parent()->plaintext)) {
                $temp['landline'] = $this->_cleanText($landline[0]->parent()->plaintext);
            }

            $url = $html_2->find('aside .jwb');
            if (isset($url[0]) && !empty($url[0]->parent()->plaintext)) {
                $temp_urls = explode('|', $this->_cleanText($url[0]->parent()->plaintext));
                $urls = array();
                foreach ($temp_urls as $value) {
                    $urls[] = $this->_cleanText($value);
                }
                $temp['url'] = implode(',', $urls);
                $temp['type'] = 4;
            } 
            else {
                $temp['type'] = 1;
            }

            preg_match_all('#<section id="alsol"+.*?>(.+?)</section>#is', $new_link, $section_3);
            $html_3 = str_get_html($section_3[1][0]);
            $also_listed = array();
            foreach ($html_3->find('tr') as $tr) {
                foreach ($tr->find('td') as $td) {
                    $also_listed[] = $this->_cleanText($td->plaintext);
                }
            }
            $temp['listedin'] = implode(',', array_values(array_unique(array_filter($also_listed))));

            $this->db->select('*');
            $this->db->where(array('businesscategory_id' => $temp['businesscategory_id'], 'businesssubcategory_id' => $temp['businesssubcategory_id'], 'company_name' => $this->_cleanText($temp['company_name'])));
            $this->db->from('companies');
            $count = $this->db->count_all_results();
            if ($count == 0) {
                $this->db->insert('companies', $temp);
            }
        }
    }

    private function _scrapUrlDataYellowPages($obj_scrap) {

        $url_parts = explode('/',$obj_scrap->url);
        $scraped_page = myCurl($obj_scrap->url);
        preg_match_all('#<div class="MT_20"+.*?>(.+?)</div>#is', $scraped_page, $outer_sections);
        $outer_sections = array_filter($outer_sections);
        if (!empty($outer_sections)) {
            foreach ($outer_sections[1] as $outer_section) {
                $temp = array();
                $html = str_get_html($outer_section);
                $a_href = $html->find('.serp_tp_list a');
                $link = 'http://' . $url_parts[2] . $a_href[0]->attr['href'];
                $new_link = myCurl($link);

                preg_match_all('/\<div.+class=\"MT_20\"\>(.*)\<\/div\>/is', $new_link, $sections);
                preg_match_all('/\<div.+class=\"data_details2\"\>(.*)\<\/div\>/is', $new_link, $sections_1);

                if(!empty($sections[1][0]) && !empty($sections_1[1][0])){
                    $html_1 = str_get_html($sections[1][0]);
                    $html_2 = str_get_html($sections_1[1][0]);
                    if(!empty($html_1) && !empty($html_2)){
                        $dr_name = $html_1->find('.serp_tp_list .header1 .FL h1');
                        $temp['name'] = $this->_cleanText($dr_name[0]->plaintext);

                        $phone_number = $html_2->find('ul', 0)->find('li', 1)->find('h2');
                        if(isset($phone_number[0]) && $phone_number[0] != ''){
                            $temp['phone_number'] = $this->_cleanText(preg_replace('/\s+/', '', $phone_number[0]->plaintext));
                        } else {
                            $temp['phone_number'] = NULL;
                        }

                        if($html_2->find('ul', 0)->find('li[class=fax]')){
                            $i = 4;
                        } else {
                            $i = 2;    
                        }

                        $address = $html_2->find('ul', 0)->find('li', $i)->find('h3');
                        if(isset($address[0]) && $address[0] != ''){
                            $temp['address'] = $this->_cleanText(preg_replace('/\s+/', '', $address[0]->plaintext));
                        } else {
                            $temp['address'] = NULL;
                        }

                        $temp['email'] = NULL;
                        if($html_2->find('ul', 0)->find('li', ($i + 2))) {
                            $email = $html_2->find('ul', 0)->find('li', ($i + 2))->find('h3 script');
                            if(!empty($email[0]->innertext)){
                                $text = array_filter(explode(';', $email[0]->innertext));
                                $temp_email = NULL;
                                for($temp_email_i = 3; $temp_email_i <= count($text)- 3; $temp_email_i++){
                                    if($this->_cleanText($text[$temp_email_i]) != ''){
                                        $t = explode('=', $text[$temp_email_i]);
                                        $temp_email .= str_replace('"', '', $this->_cleanText($t[1])) ;     
                                    }
                                }
                                $temp['email'] = $temp_email;
                            }

                        }

                        $temp['website'] = NULL;
                        if($html_2->find('ul', 0)->find('li', ($i + 4))) {
                            $website = $html_2->find('ul', 0)->find('li', ($i + 4))->find('h3 a');
                            if(isset($website[0]) && isset($website[0]->plaintext)){
                                $temp['website'] = $this->_cleanText($website[0]->plaintext);
                            }   
                        }

                        $temp['businesscategory_id'] = $obj_scrap->businesscategory_id;
                        $temp['businesssubcategory_id'] = $obj_scrap->businesssubcategory_id;
                        $temp['country_id'] = $obj_scrap->country_id;
                        $temp['state_id'] = $obj_scrap->state_id;
                        $temp['city_id'] = $obj_scrap->city_id;

                        $this->db->select('*');
                        $this->db->where(
                            array_filter(array(
                                'businesscategory_id' => $temp['businesscategory_id'],
                                'businesssubcategory_id' => $temp['businesssubcategory_id'],
                                'country_id' => $temp['country_id'],
                                'state_id' => $temp['state_id'],
                                'city_id' => $temp['city_id'],
                                'name' => $this->_cleanText($temp['name']),
                                'email' => $this->_cleanText($temp['email']),
                            ))
                        );

                        $this->db->from('leads');
                        $count = $this->db->count_all_results();
                        if ($count == 0) {
                            $this->db->insert('leads', $temp);
                        }
                    }
                }
            }
        }

        preg_match_all('/\<div.+class=\"serpListDn\"\>(.*)\<\/div\>/is', $scraped_page, $outer_sections);
        $outer_sections = array_filter($outer_sections);
        if (!empty($outer_sections)) {
            foreach ($outer_sections[1] as $outer_section) {
                $html = str_get_html($outer_section);
                $ul = $html->find('ul', 0);
                foreach ($ul->find('li') as $li) {
                    $temp = array();
                    $a_href = $li->find('div', 0)->find('h2 a');
                    $link = 'http://' . $url_parts[2] . $a_href[0]->attr['href'];
                    $new_link = myCurl($link);

                    preg_match_all('/\<div.+class=\"MT_20 clearfix\"\>(.*)\<\/div\>/is', $new_link, $sections);
                    preg_match_all('/\<div.+class=\"non_detail_data_right MT_20\"\>(.*)\<\/div\>/is', $new_link, $sections_1);

                    if(!empty($sections[1][0]) && !empty($sections_1[1][0])){
                        $html_1 = str_get_html($sections[1][0]);
                        $html_2 = str_get_html($sections_1[1][0]);
                        if(!empty($html_1) && !empty($html_2)){
                            $dr_name = $html_1->find('div', 0)->find('h1');
                            $dr_name_span = $html_1->find('div', 0)->find('h1 span');
                            $temp['name'] = $this->_cleanText(str_replace($dr_name_span[0]->plaintext, ' ', $dr_name[0]->plaintext));

                            $i = 0;

                            $temp['phone_number'] = NULL;
                            if($html_2->find('ul', 0)->find('li[class=phone]')){
                                $temp['phone_number'] = $i;
                                $phone_number = $html_2->find('ul', 0)->find('li', ++$i)->find('h2');
                                if(isset($phone_number[0]) && $phone_number[0] != ''){
                                    $temp['phone_number'] = $this->_cleanText(preg_replace('/\s+/', ' ', str_replace('&nbsp;', ' ',$phone_number[0]->plaintext)));
                                    $i++;
                                }
                            }

                            if($html_2->find('ul', 0)->find('li[class=fax]')){
                                $i = 4;
                            }

                            $temp['address'] = NULL;
                            if($html_2->find('ul', 0)->find('li', $i)->find('h3')) {
                                $address = $html_2->find('ul', 0)->find('li', $i)->find('h3');
                                if(isset($address[0]) && $address[0] != ''){
                                    $temp['address'] = $this->_cleanText(preg_replace('/\s+/', ' ', $address[0]->plaintext));
                                }
                            }

                            $temp['email'] = NULL;
                            if($html_2->find('ul', 0)->find('li', ($i + 2))) {
                                $email = $html_2->find('ul', 0)->find('li', ($i + 2))->find('h3 script');
                                if(isset($email[0]->innertext)){
                                    $text = array_filter(explode(';', $email[0]->innertext));
                                    $temp_email = NULL;
                                    for($temp_email_i = 3; $temp_email_i <= count($text)- 3; $temp_email_i++){
                                        if($this->_cleanText($text[$temp_email_i]) != ''){
                                            $t = explode('=', $text[$temp_email_i]);
                                            if(str_replace('"', '', $this->_cleanText($t[1])) != 'emailParts' && str_replace('"', '', $this->_cleanText($t[1])) != '[]'){
                                                $temp_email .= str_replace('"', '', $this->_cleanText($t[1]));         
                                            }
                                        }
                                    }
                                    $temp['email'] = $temp_email;
                                }
                            }

                            $temp['website'] = NULL;
                            if($html_2->find('ul', 0)->find('li', ($i + 4))) {
                                $website = $html_2->find('ul', 0)->find('li', ($i + 4))->find('h3 a');
                                if(isset($website[0]) && isset($website[0]->plaintext)){
                                    $temp['website'] = $this->_cleanText($website[0]->plaintext);
                                }   
                            }

                            $temp['businesscategory_id'] = $obj_scrap->businesscategory_id;
                            $temp['businesssubcategory_id'] = $obj_scrap->businesssubcategory_id;
                            $temp['country_id'] = $obj_scrap->country_id;
                            $temp['state_id'] = $obj_scrap->state_id;
                            $temp['city_id'] = $obj_scrap->city_id;

                            $this->db->select('*');
                            $this->db->where(
                                array_filter(array(
                                    'businesscategory_id' => $temp['businesscategory_id'],
                                    'businesssubcategory_id' => $temp['businesssubcategory_id'],
                                    'country_id' => $temp['country_id'],
                                    'state_id' => $temp['state_id'],
                                    'city_id' => $temp['city_id'],
                                    'name' => $this->_cleanText($temp['name']),
                                    'phone_number' => $this->_cleanText($temp['phone_number']),
                                    'address' => $this->_cleanText($temp['address']),
                                    'email' => $this->_cleanText($temp['email']),
                                ))
                            );

                            $this->db->from('leads');
                            $count = $this->db->count_all_results();
                            if ($count == 0) {
                                $this->db->insert('leads', $temp);
                            }
                        }
                    }
                }
            }
        }
    }

    private function _cleanText($text){
        return html_entity_decode(trim($text));
    }

    /* ************** Get Scrap Datas  ************** */

}

?>