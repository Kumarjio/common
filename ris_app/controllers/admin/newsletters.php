<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class newsletters extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Newsletter Templates');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewNewsletter() {
        $data['page_h1_title'] = 'List Campaign\'s';
        
        $data['company_types'] = $this->config->item('company_type_array');
        
        $obj_cat = new Businesscategory();
        $data['categories'] = $obj_cat->get();

        $obj_cat = new Businesssubcategory();
        $data['sub_categories'] = $obj_cat->get();

        $this->layout->view('admin/newsletters/view', $data);
    }

    function addNewsletter() {
        if ($this->input->post() !== false) {
            $newsletter = new Newsletter();
            $newsletter->template_id = $this->input->post('template_id');
            $newsletter->site_type = $this->input->post('site_type');
            $newsletter->businesscategory_id = $this->input->post('businesscategory_id');
            $newsletter->businesssubcategory_id = $this->input->post('businesssubcategory_id');
            $newsletter->date_send = date('Y-m-d', strtotime($this->input->post('date_send')));
            $newsletter->users_at_time = $this->input->post('users_at_time');
            $newsletter->save();
            $this->session->set_flashdata('success', 'Data Updated Successfully');
            redirect(ADMIN_URL . 'newsletter', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add Newsletter');

            $newsletter_templates = new Newslettertemplate();
            $data['newsletter_templates'] = $newsletter_templates->get();
            
            $data['page_h1_title'] = 'Add Newsletter';
            $data['site_types'] = $this->config->item('company_type_array');
        
            $obj_cat = new Businesscategory();
            $data['categories'] = $obj_cat->get();

            $this->layout->view('admin/newsletters/add', $data);
        }
    }
    
    function editNewsletter($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $newsletter = new Newsletter();
                $newsletter->where('id', $id)->get();
                $newsletter->template_id = $this->input->post('template_id');
                $newsletter->site_type = $this->input->post('site_type');
                $newsletter->businesscategory_id = $this->input->post('businesscategory_id');
                $newsletter->businesssubcategory_id = $this->input->post('businesssubcategory_id');
                $newsletter->date_send = date('Y-m-d', strtotime($this->input->post('date_send')));
                $newsletter->users_at_time = $this->input->post('users_at_time');
                $newsletter->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'newsletter', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Campaign');
                $data['page_h1_title'] = 'Edit Campaign';
                $data['site_types'] = $this->config->item('company_type_array');

                $newsletter = new Newsletter();
                $data['newsletter'] = $newsletter->where('id', $id)->get();

                $newsletter_templates = new Newslettertemplate();
                $data['newsletter_templates'] = $newsletter_templates->get();

                $obj_cat = new Businesscategory();
                $data['categories'] = $obj_cat->get();

                if($newsletter->businesscategory_id != 0){
                    $businesssubcategory = New Businesssubcategory();
                    $data['sub_categories'] = $businesssubcategory->where('businesscategory_id', $newsletter->businesscategory_id)->get();
                }

                $this->layout->view('admin/newsletters/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'newsletter', 'refresh');
        }
    }
    
    public function getJsonData($type = 0, $cat_id = 0, $sub_cat = 0) {
        $where = '';

        if($type != 0){
            $where .= ' AND site_type = ' . $type;
        }

        if($cat_id != 0){
            $where .= ' AND newsletters.businesscategory_id = ' . $cat_id;
        }

        if($sub_cat != 0){
            $where .= ' AND newsletters.businesssubcategory_id = ' . $sub_cat;
        }

        $this->load->library('datatable');
        $this->datatable->aColumns = array('date_send', 'newslettertemplates.subject AS subject', 'site_type', 'IFNULL(businesscategories.name,\'ALL\') AS cat_name', 'IFNULL(businesssubcategories.name,\'ALL\') AS sub_cat');
        $this->datatable->eColumns = array('newsletters.id');
        $this->datatable->sIndexColumn = "newsletters.id";
        $this->datatable->sTable = " newsletters";
        $this->datatable->myWhere = " LEFT JOIN newslettertemplates ON newslettertemplates.id=newsletters.template_id LEFT JOIN businesscategories ON businesscategories.id=newsletters.businesscategory_id LEFT JOIN businesssubcategories ON businesssubcategories.id=newsletters.businesssubcategory_id WHERE 1=1" . $where;
        $this->datatable->datatable_process();
        
        $site_types = $this->config->item('company_type_array');
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = date('d-m-Y', strtotime($aRow['date_send']));
            $temp_arr[] = $aRow['subject'];
            if($aRow['site_type'] == 0){
                $temp_arr[] = 'All';
            } else {
                $temp_arr[] = $site_types[$aRow['site_type']];
            }

            $temp_arr[] = $aRow['cat_name'];
            $temp_arr[] = $aRow['sub_cat'];
            $temp_arr[] = '<a href="' . ADMIN_URL . 'newsletter/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
