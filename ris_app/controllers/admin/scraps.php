<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class scraps extends CI_Controller {
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Scrap Details');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewScrap() {
        $data['page_h1_title'] = 'List scraps';

        $obj_cat = new Businesscategory();
        $data['categories'] = $obj_cat->get();

        $obj_cat = new Businesssubcategory();
        $data['sub_categories'] = $obj_cat->get();
        
        $this->layout->view('admin/scraps/view', $data);
    }

    function addScrap() {
        if ($this->input->post() !== false) {
            $obj_scrap = new Scrap();
            $obj_scrap->type = $this->input->post('type');
            $obj_scrap->businesscategory_id = $this->input->post('businesscategory_id');
            $obj_scrap->businesssubcategory_id = $this->input->post('businesssubcategory_id');
            $obj_scrap->url = $this->input->post('url');
            $link_status = $this->input->post('link_status');
            if(!empty($link_status)){
                $obj_scrap->link_status = '0';
            } else {
                $obj_scrap->link_status = '1';
            }
            $obj_scrap->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'scrap', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add New Scrap');
            $data['page_h1_title'] = 'Add New Scrap';

            $data['scrap_sites'] = $this->config->item('scrap_sites');

            $obj_cat = new Businesscategory();
            $data['categories'] = $obj_cat->get();

            $this->layout->view('admin/scraps/add', $data);
        }
    }

    function deleteScrap($id) {
        if (!empty($id)) {
            $obj_scrap = new Scrap();
            $obj_scrap->where('id', $id)->get();
            if ($obj_scrap->result_count() == 1) {
                $obj_scrap->delete();
                $data = array('status' => 'success', 'msg' => 'Scrap details deleted successfully');
            } else {
                $data = array('status' => 'error', 'msg' => 'Error deleting scrap details');
            }
        } else {
            $data = array('status' => 'error', 'msg' => 'Error deleting scrap details');
        }
        echo json_encode($data);
    }
    
    public function getJsonData($cat_id = 0, $sub_cat = 0) {
        $where = '';

        if($cat_id != 0){
            $where .= ' AND scraps.businesscategory_id = ' . $cat_id;
        }

        if($sub_cat != 0){
            $where .= ' AND scraps.businesssubcategory_id = ' . $sub_cat;
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('businesscategories.name AS cat_name', 'businesssubcategories.name AS sub_cat', 'url');
        $this->datatable->eColumns = array('scraps.id', 'scraps.status');
        $this->datatable->sIndexColumn = "scraps.id";
        $this->datatable->sTable = " scraps, businesscategories, businesssubcategories";
        $this->datatable->myWhere = " WHERE scraps.businesscategory_id=businesscategories.id AND scraps.businesssubcategory_id=businesssubcategories.id" . $where;
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['cat_name'];
            $temp_arr[] = $aRow['sub_cat'];

            if($aRow['status'] == 0){
                $str = '<label class="label label-warning pull-right">Pending</label>';
            } else {
                $str = '<label class="label label-success pull-right">Done</label>';
            }
            $temp_arr[] = $aRow['url'] . $str;
            
            $temp_arr[] = '<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
