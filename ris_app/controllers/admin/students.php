<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class students extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Student Templates');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewStudent() {
        $data['page_h1_title'] = 'List Students';
        $this->layout->view('admin/students/view', $data);
    }

    function addStudent() {
        if ($this->input->post() !== false) {
            $student = new Student();
            $student->batch_id = $this->input->post('batch_id');
            $student->name = $this->input->post('name');
            $student->college = $this->input->post('college');
            $student->project = $this->input->post('project');
            $student->fee = $this->input->post('fee');
            $student->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'student', 'refresh');
        } else {
            $data['page_h1_title'] = 'Add Student Details';

            $obj_batch = new Batch();
            $data['batches'] = $obj_batch->get();

            $this->layout->view('admin/students/add', $data);
        }
    }
    
    function editStudent($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $student = new Student();
                $student->where('id', $id)->get();
                $student->batch_id = $this->input->post('batch_id');
                $student->name = $this->input->post('name');
                $student->college = $this->input->post('college');
                $student->project = $this->input->post('project');
                $student->fee = $this->input->post('fee');
                $student->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'student', 'refresh');
            } else {
                $student = new Student();
                $data['student'] = $student->where('id', $id)->get();

                $obj_batch = new Batch();
                $data['batches'] = $obj_batch->get();

                $data['page_h1_title'] = 'Edit Student Details';
                
                $this->layout->view('admin/students/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'student', 'refresh');
        }
    }
    
    function deleteStudent($id) {
        if (!empty($id)) {
            $obj_student = new Student();
            $obj_student->where('id', $id)->get();
            if ($obj_student->result_count() == 1) {
                $obj_student->delete();
                $data = array('status' => 'success', 'msg' => 'Student details deleted successfully');
            } else {
                $data = array('status' => 'error', 'msg' => 'Error deleting Student details');
            }
        } else {
            $data = array('status' => 'error', 'msg' => 'Error deleting Student details');
        }
        echo json_encode($data);
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('students.name AS student_name', 'batches.name AS batch_name', 'college', 'project');
        $this->datatable->eColumns = array('students.id');
        $this->datatable->sIndexColumn = "students.id";
        $this->datatable->sTable = " students, batches";
        $this->datatable->myWhere = " WHERE students.batch_id=batches.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['student_name'];
            $temp_arr[] = $aRow['batch_name'];
            $temp_arr[] = $aRow['college'];
            $temp_arr[] = $aRow['project'];

            $temp_arr[] = '<a href="' . ADMIN_URL . 'student/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
