<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class roles extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Roles');
        $this->session_data = $this->session->userdata('admin_session');
        $this->load->library('acl');
    }
    
    function viewRole() {
        $data['page_h1_title'] = 'View Roles';
        $this->layout->view('admin/roles/view', $data);
    }
    
    function addRole() {
        if ($this->input->post() !== false) {
            $role = new Role();
            $role->name = $this->input->post('name');
            $role->permission = serialize($this->input->post('perm'));
            $role->expense_date = date('Y-m-d', strtotime($this->input->post('expense_date')));
            $role->created_id = $this->session_data->id;
            $role->create_date_time = get_current_date_time()->get_date_time_for_db();
            $role->update_id = $this->session_data->id;
            $role->update_date_time = get_current_date_time()->get_date_time_for_db();
            $role->save();
            $this->session->set_flashdata('success', $this->lang->line('add_data_success'));
            redirect(ADMIN_URL . 'role', 'refresh');
        } else {
            $this->layout->setField('page_title', 'Add Role');

            $this->layout->view('admin/roles/add');
        }
    }
    
    function editRole($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
                $role = new Role();
                $role->where('id', $id)->get();
                $role->name = $this->input->post('name');
                $role->permission = serialize($this->input->post('perm'));
                $role->updated_id = $this->session_data->id;
                $role->update_datetime = get_current_date_time()->get_date_time_for_db();
                $role->save();
                $this->session->set_flashdata('success', 'Update Data Successfully');
                redirect(ADMIN_URL . 'role', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Role');
                
                $data['page_h1_title'] = 'Edit Role';

                $role = new Role();
                $data['role'] = $role->where('id', $id)->get();
                
                $this->layout->view('admin/roles/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(ADMIN_URL . 'role', 'refresh');
        }
    }
    
    function deleteRole($id) {
        if (!empty($id)) {
            $role = new Role();
            $role->where('id', $id)->get();
            $role->delete();
            $this->session->set_flashdata('success', $this->lang->line('delete_data_success'));
            redirect(ADMIN_URL . 'role', 'refresh');
        } else {
            $this->session->set_flashdata('error', $this->lang->line('delete_data_error'));
            redirect(ADMIN_URL . 'role', 'refresh');
        }
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('name');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = 'id';
        $this->datatable->sTable = 'roles';
        $this->datatable->myWhere = ' WHERE id > 1';
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();

            $temp_arr[] =  $aRow['name'];
            $temp_arr[] = '<a href="' . ADMIN_URL . 'role/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary text-center"></i></a>';
            
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
