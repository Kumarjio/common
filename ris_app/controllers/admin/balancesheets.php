<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class balancesheets extends CI_Controller {
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Balance Sheet');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewBalancesheet() {
        $data['page_h1_title'] = 'View balance Sheet';
        $this->layout->view('admin/balancesheets/view', $data);
    }

    function addBalancesheet() {
        if ($this->input->post() !== false) {
            $obj_balancesheet = new Balancesheet();
            $obj_balancesheet->type = $this->input->post('type');
            $obj_balancesheet->description = $this->input->post('description');
            $obj_balancesheet->amount = $this->input->post('amount');
            $obj_balancesheet->expense_date = date('Y-m-d', strtotime($this->input->post('expense_date')));
            $obj_balancesheet->created_id = $this->session_data->id;
            $obj_balancesheet->create_date_time = get_current_date_time()->get_date_time_for_db();
            $obj_balancesheet->update_id = $this->session_data->id;
            $obj_balancesheet->update_date_time = get_current_date_time()->get_date_time_for_db();
            $obj_balancesheet->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'balancesheet', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add Expense');
            $data['page_h1_title'] = 'Add Expense';
            $this->layout->view('admin/balancesheets/add', $data);
        }
    }

    function editBalancesheet($id) {
        if ($this->input->post() !== false) {
            $obj_balancesheet = new Balancesheet();
            $obj_balancesheet->where('id', $id)->get();
            $obj_balancesheet->type = $this->input->post('type');
            $obj_balancesheet->description = $this->input->post('description');
            $obj_balancesheet->amount = $this->input->post('amount');
            $obj_balancesheet->expense_date = date('Y-m-d', strtotime($this->input->post('expense_date')));
            $obj_balancesheet->update_id = $this->session_data->id;
            $obj_balancesheet->update_date_time = get_current_date_time()->get_date_time_for_db();
            $obj_balancesheet->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'balancesheet', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Edit Expense');
            $data['page_h1_title'] = 'Edit Expense';

            $obj_balancesheet = new Balancesheet();
            $data['expense'] = $obj_balancesheet ->where('id', $id)->get();

            $this->layout->view('admin/balancesheets/edit', $data);
        }
    }

    function deleteBalancesheet($id) {
        if (!empty($id)) {
            $obj_balancesheet = new Balancesheet();
            $obj_balancesheet->where('id', $id)->get();
            if ($obj_balancesheet->result_count() == 1) {
                $obj_balancesheet->delete();
                $data = array('status' => 'success', 'msg' => 'Balancesheet details deleted successfully');
            } else {
                $data = array('status' => 'error', 'msg' => 'Error deleting scrap details');
            }
        } else {
            $data = array('status' => 'error', 'msg' => 'Error deleting scrap details');
        }
        echo json_encode($data);
    }
    
    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('expense_date', 'SUM(CASE WHEN type = "O" THEN amount END) AS o_amount', 'SUM(CASE WHEN type = "I" THEN amount END) AS i_amount');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = 'id';
        $this->datatable->sTable = 'balancesheets';
        $this->datatable->groupBy = " GROUP BY expense_date";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();

            $temp_arr[] =  '<a href="javascript:;" data-url="'. ADMIN_URL .'balancesheet/get_detail_view/'. $aRow['expense_date'] .'" class="detailReport"><i class="fa fa-plus-circle"></i></a> &nbsp;&nbsp;' . date('d-m-Y', strtotime($aRow['expense_date']));
            
            if(!empty($aRow['o_amount'])){
                $temp_arr[] = $aRow['o_amount'];    
            } else {
                $temp_arr[] = 0;
            }

            if(!empty($aRow['i_amount'])){
                $temp_arr[] = $aRow['i_amount'];
            } else {
                $temp_arr[] = 0;
            }
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }

    function getDetailViewReport($date){
        $obj_balancesheet = new Balancesheet();
        $obj_balancesheet->where('expense_date', $date)->get();
        $html = NULL;
        if($obj_balancesheet->result_count() > 0){
            $html .= '<div class="table-responsive">';
                $html .= '<table class="table table-bordered table-hover">';
                    $html .= '<thead>';
                        $html .= '<tr class="active">';
                            $html .= '<th>Description</th>';
                            $html .= '<th>Outgoing</th>';
                            $html .= '<th>Income</th>';
                            $html .= '<th width="10%">Actions</th>';
                        $html .= '</tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';

                    foreach ($obj_balancesheet as $value) {
                        $html .= '<tr>';
                            $html .= '<td>'. $value->description .'</td>';

                            if($value->type == 'O'){
                                $html .= '<td>'. $value->amount .'</td>';
                            } else {
                                $html .= '<td> - </td>';
                            }
                            
                            if($value->type == 'I'){
                                $html .= '<td>'. $value->amount .'</td>';
                            } else {
                                $html .= '<td> - </td>';
                            }

                            $html .= '<td><a href="' . ADMIN_URL . 'balancesheet/edit/' . $value->id . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary text-center"></i></a>&nbsp;<a href="javascript:;" onclick="deletedata(this)" class="text-danger" id="'. $value->id .'" data-toggle="tooltip" data-original-title="Delete" title="Delete"><i class="fa fa-times icon-circle icon-xs icon-danger text-center"></i></a></td>';

                            
                        $html .= '</tr>';
                    }

                    $html .= '</tbody>';
                $html .= '</table>';
            $html .= '</div>';
        } else {
           $html = 'No Detalils Avaialbe';
        }

        echo $html;
    }
}
