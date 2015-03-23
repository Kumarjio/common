<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class roles extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Role');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewRole() {
        $data['page_h1_title'] = 'List Roles';
        $this->layout->view('admin/roles/view', $data);
    }
    
    function addRole() {
        if ($this->input->post() !== false) {
            $role = new Role();
            $role->$temp = $this->input->post('role_name');
            $role->permission = serialize($this->input->post('perm'));
            $role->user_id = $this->session_data->id;
            $role->save();
            $this->session->set_flashdata('success', 'Add data successfully');
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
                foreach ($this->config->item('custom_languages') as $key => $value) {
                    $temp = $key . '_role_name';
                    if ($this->input->post($temp) != '') {
                        $role->$temp = $this->input->post($temp);
                    } else {
                        $role->$temp = $this->input->post('en_role_name');
                    }
                }
                
                if ($this->input->post('is_manager') == '1') {
                    $role->is_manager = 1;
                } else {
                    $role->is_manager = 0;
                }
                
                $role->permission = serialize($this->input->post('perm'));
                $role->user_id = $this->session_data->id;
                $role->save();
                $this->session->set_flashdata('success', $this->lang->line('edit_data_success'));
                redirect(ADMIN_URL . 'role', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Role');
                
                $role = new Role();
                $data['role'] = $role->where('id', $id)->get();
                
                $this->layout->view('admin/roles/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('edit_data_error'));
            redirect(ADMIN_URL . 'role', 'refresh');
        }
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('role_name');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " roles";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['role_name'];
            
            $str = NULL;
            if (hasPermission('roles', 'editRole')) {
                $str.= '<a href="' . ADMIN_URL . 'role/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="' . $this->lang->line('edit') . '"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            }

            $temp_arr[] = $str;
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
    
}
