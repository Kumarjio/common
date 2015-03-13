<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class pages extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Page Templates');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewPage() {
        $data['page_h1_title'] = 'List Pages';
        $this->layout->view('admin/pages/view', $data);
    }
    
    function editPage($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $page = new Page();
                $page->where('id', $id)->get();
                $page->title = $this->input->post('title');
                $page->description = $this->input->post('description');
                $page->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'page', 'refresh');
            } else {
                $this->layout->setField('page_title', $this->lang->line('edit') . ' ' . $this->lang->line('page'));
                $page = new Page();
                $data['page'] = $page->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Page Details';
                $this->layout->view('admin/pages/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'page', 'refresh');
        }
    }
    

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('title');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " pages";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['title'];
            $temp_arr[] = '<a href="' . ADMIN_URL . 'page/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
