<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class leads extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Manage Leads');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewLead() {
        $data['page_h1_title'] = 'Leads';

        $obj_cat = new Businesscategory();
        $obj_cat->order_by('name', 'ASC');
        $data['categories'] = $obj_cat->get();

        $obj_country = new Country();
        $obj_country->order_by('name', 'ASC');
        $data['countries'] = $obj_country->get();

        $this->layout->view('admin/leads/view', $data);
    }

    public function getJsonData() {
        $where = '';
        
        if($this->input->get('cat_id') != 0 && $this->input->get('cat_id') != ''){
            $where .= ' AND leads.businesscategory_id = ' . $this->input->get('cat_id');
        }

        if($this->input->get('sub_cat_id') != 0 && $this->input->get('sub_cat_id') != ''){
            $where .= ' AND leads.businesssubcategory_id = ' . $this->input->get('sub_cat_id');
        }

        if($this->input->get('country_id') != 0 && $this->input->get('country_id') != ''){
            $where .= ' AND leads.country_id = ' . $this->input->get('country_id');
        }

        if($this->input->get('state_id') != 0 && $this->input->get('state_id') != ''){
            $where .= ' AND leads.state_id = ' . $this->input->get('state_id');
        }

        if($this->input->get('city_id') != 0 && $this->input->get('city_id') != ''){
            $where .= ' AND leads.city_id = ' . $this->input->get('city_id');
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('leads.name AS lead', 'businesscategories.name AS cat_name', 'businesssubcategories.name AS sub_cat', 'countries.name AS country', 'states.name AS state', 'cities.name AS city');
        $this->datatable->eColumns = array('leads.id');
        $this->datatable->sIndexColumn = "leads.id";
        $this->datatable->sTable = " leads, businesscategories, businesssubcategories, countries, states, cities";
        $this->datatable->myWhere = " WHERE leads.businesscategory_id=businesscategories.id AND leads.businesssubcategory_id=businesssubcategories.id AND leads.country_id=countries.id AND leads.state_id=states.id AND leads.city_id=cities.id" . $where;
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['lead'];
            $temp_arr[] = $aRow['cat_name'];
            $temp_arr[] = $aRow['sub_cat'];
            $temp_arr[] = $aRow['country'];
            $temp_arr[] = $aRow['state'];
            $temp_arr[] = $aRow['city'];            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
