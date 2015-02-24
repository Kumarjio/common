<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class newslettertemplates extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Newsletter Templates');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    public function viewNewslettertemplate() {
        if (empty($this->session_data)) {
            redirect(ADMIN_URL . 'login', 'refresh');
        } else {
            $data['page_h1_title'] = 'List Newsletter Templates';           
            $this->layout->view('admin/newslettertemplates/view', $data);
        }
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('subject', 'status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " newslettertemplates";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['subject'];

            if($aRow['status'] == 'Active') {
                $temp_arr[] = '<label class="label label-success">Active</label>';
            } else {
                $temp_arr[] = '<label class="label label-danger">InActive</label>';
            }
            $temp_arr[] = '<a href="' . ADMIN_URL . 'newslettertemplate/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function addNewslettertemplate() {
        if ($this->input->post() !== false) {
            $newslettertemplate = new Newslettertemplate();
            $newslettertemplate->subject = $this->input->post('subject');
            $newslettertemplate->message = $this->input->post('message');
            $newslettertemplate->status = $this->input->post('status');
            $newslettertemplate->user_id = $this->session_data->id;
            $newslettertemplate->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'newslettertemplate', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add New Template');
            $data['page_h1_title'] = 'Add Newsletter Template'; 
            $this->layout->view('admin/newslettertemplates/add', $data);
        }
    }

    function editNewslettertemplate($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $newslettertemplate = new Newslettertemplate();
                $newslettertemplate->where('id', $id)->get();
                $newslettertemplate->subject = $this->input->post('subject');
                $newslettertemplate->message = $this->input->post('message');
                $newslettertemplate->status = $this->input->post('status');
                $newslettertemplate->user_id = $this->session_data->id;
                $newslettertemplate->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'newslettertemplate', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Template');
                $newslettertemplate = new Newslettertemplate();
                $data['newslettertemplate'] = $newslettertemplate->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Newsletter Template'; 
                $this->layout->view('admin/newslettertemplates/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'newslettertemplate', 'refresh');
        }
    }
}
