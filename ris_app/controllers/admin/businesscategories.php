<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class businesscategories extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Business categories');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    public function viewBusinesscategory() {
        if (empty($this->session_data)) {
            redirect(ADMIN_URL . 'login', 'refresh');
        } else {
            $data['page_h1_title'] = 'List Business categories';           
            $this->layout->view('admin/businesscategories/view', $data);
        }
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('name', 'status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " businesscategories";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['name'];

            if($aRow['status'] == 'Active') {
                $temp_arr[] = '<label class="label label-success">Active</label>';
            } else {
                $temp_arr[] = '<label class="label label-danger">InActive</label>';
            }
            $temp_arr[] = '<a href="' . ADMIN_URL . 'businesscategory/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function addBusinesscategory() {
        if ($this->input->post() !== false) {
            $businesscategory = new Businesscategory();
            $businesscategory->name = $this->input->post('name');
            $businesscategory->status = $this->input->post('status');
            $businesscategory->user_id = $this->session_data->id;
            $businesscategory->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'businesscategory', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add Business category');
            $data['page_h1_title'] = 'Add Business category'; 
            $this->layout->view('admin/businesscategories/add', $data);
        }
    }

    function editBusinesscategory($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $businesscategory = new Businesscategory();
                $businesscategory->where('id', $id)->get();
                $businesscategory->name = $this->input->post('name');
                $businesscategory->status = $this->input->post('status');
                $businesscategory->user_id = $this->session_data->id;
                $businesscategory->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'businesscategory', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Business category');
                $businesscategory = new Businesscategory();
                $data['businesscategory'] = $businesscategory->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Business categories'; 
                $this->layout->view('admin/businesscategories/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'businesscategory', 'refresh');
        }
    }
}
