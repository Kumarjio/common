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
            $temp_arr[] = '<a href="javascript:;" data-url="'. ADMIN_URL .'student/get_fee_report/'. $aRow['id'] .'" class="detailReport"><i class="fa fa-plus-circle"></i></a> &nbsp;&nbsp;' . $aRow['student_name'];
            $temp_arr[] = $aRow['batch_name'];
            $temp_arr[] = $aRow['college'];
            $temp_arr[] = $aRow['project'];

            $temp_arr[] = '<a href="' . ADMIN_URL . 'student/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function getStudentFeeReport($id){
        $obj_student_fees = new Studentfee();
        $obj_student_fees->where('student_id', $id);
        $obj_student_fees->get();

        $html = NULL;

        if($obj_student_fees->result_count() > 0){
            $html .= '<table class="table table-bordered table-full-width">';
                $html .= '<thead>';
                    $html .= '<tr class="active">';
                        $html .= '<th>Date</th>';
                        $html .= '<th>Fee</th>';
                    $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                    $total = 0;
                    foreach ($obj_student_fees as $obj_student_fee) {
                        $html .= '<tr>';
                            $html .= '<td>'. date('l jS F Y', strtotime($obj_student_fee->given_date)) .'</td>';
                            $html .= '<td>'. $obj_student_fee->fee .'</td>';
                        $html .= '</tr>';
                        $total = $total + $obj_student_fee->fee; 
                    }
                    $html .= '<tr>';
                        $html .= '<td>&nbsp;</td>';
                        $html .= '<td class="text-right"><b>'. number_format($total, 2) .'</b></td>';
                    $html .= '</tr>';
                $html .= '</tbody>';
            $html .= '</table>';
        } else {
            $html .= 'No Details Available';
        }

        echo $html;
    }

    function viewStudentFees(){
        $data['page_h1_title'] = 'List Student Fees';
        $this->layout->view('admin/students/view_fee', $data);
    }

    function getFeeJsonData(){
        $this->load->library('datatable');
        $this->datatable->aColumns = array('students.name AS student_name', 'studentfees.fee', 'given_date');
        $this->datatable->eColumns = array('studentfees.id');
        $this->datatable->sIndexColumn = "studentfees.id";
        $this->datatable->sTable = " students, studentfees";
        $this->datatable->myWhere = " WHERE studentfees.student_id=students.id";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['student_name'];
            $temp_arr[] = $aRow['fee'];
            $temp_arr[] = date('d-m-Y', strtotime($aRow['given_date']));

            $temp_arr[] = '<a href="' . ADMIN_URL . 'student/fee/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $aRow['id'] .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function addStudentFee() {
        if ($this->input->post() !== false) {
            $studentfee = new Studentfee();
            $studentfee->student_id = $this->input->post('student_id');
            $studentfee->fee = $this->input->post('fee');
            $studentfee->given_date = date('Y-m-d', strtotime($this->input->post('given_date')));
            $studentfee->save();
            $this->session->set_flashdata('success', 'Data Updated Successfully');
            redirect(ADMIN_URL . 'student/fee', 'refresh');
        } else {
            $data['page_h1_title'] = 'Add Student Fee Details';

            $obj_student = new Student();
            $data['students'] = $obj_student->get();

            $this->layout->view('admin/students/add_fee', $data);
        }
    }
    
    function editStudentFee($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $studentfee = new Studentfee();
                $studentfee->where('id', $id)->get();
                $studentfee->student_id = $this->input->post('student_id');
                $studentfee->fee = $this->input->post('fee');
                $studentfee->given_date = date('Y-m-d', strtotime($this->input->post('given_date')));
                $studentfee->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'student/fee', 'refresh');
            } else {
                $studentfee = new Studentfee();
                $data['studentfee'] = $studentfee->where('id', $id)->get();

                $obj_student = new Student();
                $data['students'] = $obj_student->get();

                $data['page_h1_title'] = 'Edit Student Fee Details';
                
                $this->layout->view('admin/students/edit_fee', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'student', 'refresh');
        }
    }
    
    function deleteStudentFee($id) {
        if (!empty($id)) {
            $obj_student_fee = new Studentfee();
            $obj_student_fee->where('id', $id)->get();
            if ($obj_student_fee->result_count() == 1) {
                $obj_student_fee->delete();
                $data = array('status' => 'success', 'msg' => 'Student Fee details deleted successfully');
            } else {
                $data = array('status' => 'error', 'msg' => 'Error deleting Student Feedetails');
            }
        } else {
            $data = array('status' => 'error', 'msg' => 'Error deleting Student Fee details');
        }
        echo json_encode($data);
    }

}
