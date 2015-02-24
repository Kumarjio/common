<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class emails extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Email Templates');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    function viewEmail() {
        $data['page_h1_title'] = 'List Email Templates';
        $this->layout->view('admin/emails/view', $data);
    }
    
    function editEmail($id) {
        if (!empty($id)) {
            if ($this->input->post() !== false) {
            
                $email = new Email();
                $email->where('id', $id)->get();
                $email->subject = $this->input->post('subject');
                $email->message = $this->input->post('message');
                $email->user_id = $this->session_data->id;
                $email->save();
                $this->session->set_flashdata('success', 'Data Updated Successfully');
                redirect(ADMIN_URL . 'email', 'refresh');
            } else {
                $this->layout->setField('page_title', 'Edit Email Template');
                $email = new Email();
                $data['email'] = $email->where('id', $id)->get();
                $data['page_h1_title'] = 'Edit E-Mail Template';
                $this->layout->view('admin/emails/edit', $data);
            }
        } else {
            $this->session->set_flashdata('error', 'Error in editing data');
            redirect(ADMIN_URL . 'email', 'refresh');
        }
    }
    
    function uploadAttachment($id) {
        $this->upload->initialize(array('upload_path' => "./assets/admin_assets/email_attachments/", 'allowed_types' => '*', 'overwrite' => FALSE, 'remove_spaces' => TRUE, 'encrypt_name' => TRUE));
        
        if (!$this->upload->do_upload('attachment')) {
            $data = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data('attachment'));
        }
        
        if (isset($data['upload_data'])) {
            if ($data['upload_data']['file_name'] != '') {
                $obj = new Email();
                $obj->where('id', $id)->get();
                $old_location = $obj->attachment;
                if ($old_location != null) {
                    $full_path_of_old = './assets/admin_assets/email_attachments/' . $old_location;
                    $path_to_be_removed = substr($full_path_of_old, 2);
                    if (file_exists($path_to_be_removed)) {
                        unlink($path_to_be_removed);
                    }
                }
                $obj->attachment = str_replace(' ', '_', $data['upload_data']['file_name']);
                $obj->save();
                return TRUE;
            }
        } else if (isset($data['error'])) {
            $this->session->set_flashdata('file_errors', $data['error']);
            redirect(ADMIN_URL . 'email/edit/' . $id, 'refresh');
        }
    }
    
    function removeAttachment($id) {
        $obj = new Email();
        $obj->where('id', $id)->get();
        $old_location = $obj->attachment;
        if ($old_location != null) {
            $full_path_of_old = './assets/admin_assets/email_attachments/' . $old_location;
            $path_to_be_removed = substr($full_path_of_old, 2);
            if (file_exists($path_to_be_removed)) {
                unlink($path_to_be_removed);
            }
        }
        $obj->attachment = NULL;
        $obj->save();
        $this->session->set_flashdata('success', $this->lang->line('attachment_removed'));
        redirect(ADMIN_URL . 'email/edit/' . $id, 'refresh');
    }

    public function getJsonData() {
        $this->load->library('datatable');
        $this->datatable->aColumns = array('subject');
        $this->datatable->eColumns = array('id');
        $this->datatable->sIndexColumn = "id";
        $this->datatable->sTable = " emails";
        $this->datatable->datatable_process();
        
        foreach ($this->datatable->rResult->result_array() as $aRow) {
            $temp_arr = array();
            $temp_arr[] = $aRow['subject'];
            $temp_arr[] = '<a href="' . ADMIN_URL . 'email/edit/' . $aRow['id'] . '" class="actions" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil icon-circle icon-xs icon-primary"></i></a>';
            
            $this->datatable->output['aaData'][] = $temp_arr;
        }
        echo json_encode($this->datatable->output);
        exit();
    }
}
