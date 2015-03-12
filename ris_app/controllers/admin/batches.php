<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class batches extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Batch Templates');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewBatch() {
        $data['page_h1_title'] = 'List Batches';
        $this->layout->view('admin/batches/view', $data);
    }

    function addBatch() {
        if ($this->input->post() !== false) {
            $batch = new Batch();
            $batch->name = $this->input->post('name');
            $batch->st_date = date('Y-m-d', strtotime($this->input->post('st_date')));
            if($this->input->post('ed_date') != ''){
                $batch->ed_date = date('Y-m-d', strtotime($this->input->post('ed_date')));    
            }
            $batch->fee = $this->input->post('fee');
            $batch->status = $this->input->post('status');
            $batch->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'batch', 'refresh');
        } else {
            $batch = new Batch();
            $data['page_h1_title'] = 'Add Batch Details';
            $this->layout->view('admin/batches/add', $data);
        }
    }
    
    function editBatch($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $batch = new Batch();
                $batch->where('id', $id)->get();
                $batch->name = $this->input->post('name');
                $batch->st_date = date('Y-m-d', strtotime($this->input->post('st_date')));
                if($this->input->post('ed_date') != ''){
                    $batch->ed_date = date('Y-m-d', strtotime($this->input->post('ed_date')));    
                }
                $batch->fee = $this->input->post('fee');
                $batch->status = $this->input->post('status');
                $batch->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'batch', 'refresh');
            } else {
                $batch = new Batch();
                $data['batch'] = $batch->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit Batch Details';
                $this->layout->view('admin/batches/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'batch', 'refresh');
        }
    }
    
    function deleteBatch($id) {
        if (!empty($id)) {
            $obj_batch = new Batch();
            $obj_batch->where('id', $id)->get();
            if ($obj_batch->result_count() == 1) {
                $obj_batch->delete();
                $data = array('status' => 'success', 'msg' => 'Batch details deleted successfully');
            } else {
                $data = array('status' => 'error', 'msg' => 'Error deleting Batch details');
            }
        } else {
            $data = array('status' => 'error', 'msg' => 'Error deleting Batch details');
        }
        echo json_encode($data);
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('name', 'st_date', 'ed_date', 'status');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " batches";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['name'];
            $temp_arr[] = date('d-m-Y', strtotime($aRow['st_date']));
            if($aRow['ed_date'] != '' && $aRow['ed_date'] != '0000-00-00'){
                $temp_arr[] = date('d-m-Y', strtotime($aRow['ed_date']));
            } else {
                $temp_arr[] = '';
            }
            
            if($aRow['status'] == 'active') {
                $temp_arr[] = '<label class="label label-success">Active</label>';
            } else {
                $temp_arr[] = '<label class="label label-danger">InActive</label>';
            }

            $temp_arr[] = '<a href="' . ADMIN_URL . 'batch/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
