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
            $obj_balancesheet->amount = $this->input->post('amount');
            $obj_balancesheet->expense_date = date('Y-m-d', strtotime($this->input->post('expense_date')));
            $obj_balancesheet->created_id = $this->session_data->id;
            $obj_balancesheet->create_date_time = get_date_time()->get_date_time_for_db();
            $obj_balancesheet->update_id = $this->session_data->id;
            $obj_balancesheet->update_date_time = get_date_time()->get_date_time_for_db();
            $obj_balancesheet->save();
            $this->session->set_flashdata('success', 'Data Added Successfully');
            redirect(ADMIN_URL . 'balancesheet', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add Expense');
            $data['page_h1_title'] = 'Add Expense';
            $this->layout->view('admin/balancesheets/add', $data);
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

            $temp_arr[] =  '<a href="javascript:;" data-url="'. ADMIN_URL .'balancesheet/get_detail_view/'. $aRow['expense_date'] .'" class="detailReport"><i class="fa fa-plus-circle"></i></a> &nbsp;&nbsp;' . $aRow['expense_date'];
            
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
        if($obj_balancesheet->result_count > 0){
            $html .= '<table class="table table-striped table-bordered table-hover table-full-width">';
                $html .= '<thead>';
                    $html .= '<tr class="active">';
                        $html .= '<th>Campaign Name</th>';
                        $html .= '<th>Current Budget</th>';
                    $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                    foreach ($earnings as $earning) {
                        $html .= '<tr>';
                            $html .= '<td>'. $earning->name .'</td>';
                            $html .= '<td>'. $earning->current_budget .'</td>';
                            $html .= '<td>'. $earning->earning .'</td>';

                            $total = $earning->earning - $earning->current_budget;
                            if($total > 0){
                                $percentage = (($earning->earning - $earning->current_budget) / $earning->current_budget) * 100;
                                $html .= '<td class="text-success">'. $total .'&nbsp;(' . round($percentage, 2) . '%)</td>';    
                            } else {
                                $percentage = (($earning->current_budget - $earning->earning) / $earning->current_budget) * 100;
                                $html .= '<td class="text-danger">'. $total .'&nbsp;(' . round($percentage, 2) . '%)</td>';
                            }

                        $html .= '</tr>';
                    }
                $html .= '</tbody>';
            $html .= '</table>';
        }

        echo $html;
    }
}
