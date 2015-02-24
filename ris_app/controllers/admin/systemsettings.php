<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class systemsettings extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Settings');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    public function viewSystemSetting($type = null) {
        if (is_null($type) || is_integer($type)) {
            $this->session->set_flashdata('error', $this->lang->line('unauthorize_access'));
            redirect(ADMIN_URL . 'dashboard', 'refresh');
        }
        
        $setting = new Systemsetting();
        $data['setting'] = $setting->where('type', $type)->order_by('sequence', 'ASC')->get();

        switch ($type) {
            case 'general':
                $data['page_h1_title'] = 'General Setting';
                $this->layout->view('admin/systemsettings/general_setting', $data);
                break;
            case 'update_general':
                $this->_updateSetting('general');
                $this->session->set_flashdata('success', 'Data updated successfully');
                redirect(ADMIN_URL . 'system_setting/general', 'refresh');
                break;
            case 'mail':
                $data['page_h1_title'] = 'Mail Setting';
                $this->layout->view('admin/systemsettings/mail_setting', $data);
                break;
            case 'update_mail':
                $this->_updateSetting('mail');
                $this->session->set_flashdata('success', 'Data updated successfully');
                redirect(ADMIN_URL . 'system_setting/mail', 'refresh');
                break;
            case 'login_credential':
                $data['page_h1_title'] = 'Login Credential';
                $this->layout->view('admin/systemsettings/login_credential_setting', $data);
                break;
            case 'update_login_credential':
                $this->_updateSetting('login_credential');
                $this->session->set_flashdata('success', 'Data updated successfully');
                redirect(ADMIN_URL . 'system_setting/login_credential', 'refresh');
                break;
            default:
                $data['page_h1_title'] = 'General Setting';
                $this->layout->view('admin/systemsettings/general_setting', $data);
                break;
        }
    }
    
    private function _updateSetting($type) {
        $setting = new Systemsetting();
        $setting->where('type', $type)->get();

        if($type == 'login_credential'){
            $user = new Admin();
            $user->where('id', $this->session_data->id)->get();
            $user->fullname = $this->input->post('fullname');
            $user->email = $this->input->post('email');
            if($this->input->post('password') != ''){
                $user->password = md5($this->input->post('password'));    
            }
            $user->save();

            $user_data = $this->session_data;
            $user_data->name = $this->input->post('fullname');
            $user_data->email = $this->input->post('email');
            $newdata = array('admin_session' => $user_data);
            $this->session->set_userdata($newdata);
        } else {
            foreach ($setting as $value) {
                if ($value->sys_key == 'login_logo' || $value->sys_key == 'main_logo') {
                    if ($_FILES[$value->sys_key]['name'] != '') {
                        $avtar = $this->_uploadAvtar($value->sys_key);
                        $setting->where('sys_key', $value->sys_key)->update('sys_value', $avtar['file_name']);
                    }
                } else if ($value->sys_key == 'post_last_wish') {
                    $post_last_wish = $this->input->post('post_last_wish_input') .'_' . $this->input->post('post_last_wish_select');
                    $setting->where('sys_key', $value->sys_key)->update('sys_value', $post_last_wish);
                } else {
                    $setting->where('sys_key', $value->sys_key)->update('sys_value', $this->input->post($value->sys_key));
                }
            }
        }
        return TRUE;
    }
    
    private function _uploadAvtar($sys_key) {
        $this->upload->initialize(array('upload_path' => "./assets/img", 'allowed_types' => 'jpg|jpeg|gif|png|bmp', 'overwrite' => FALSE, 'remove_spaces' => TRUE, 'encrypt_name' => TRUE));
        
        $setting = new Systemsetting();
        $setting->where('sys_key', $sys_key)->get();
        
        if (!$this->upload->do_upload($sys_key)) {
            $data = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data($sys_key));
        }
        
        if (isset($data['upload_data'])) {
            if ($data['upload_data']['file_name'] != '') {
                
                if ($setting->sys_value != null && $setting->sys_value != 'no_avatar.jpg') {
                    if (file_exists('assets/img/' . $setting->sys_value)) {
                        unlink('assets/img/' . $setting->sys_value);
                    }
                }
                
                $image = str_replace(' ', '_', $data['upload_data']['file_name']);
                
                if ($sys_key == 'main_logo' && $data['upload_data']['image_width'] > 250) {
                    $this->load->helper('image_manipulation/image_manipulation');
                    include_lib_image_manipulation();
                    
                    $magicianObj = new imageLib('./assets/img/' . $image);
                    $magicianObj->resizeImage(250, 70, 'landscape');
                    $magicianObj->saveImage('./assets/img/' . $image, 100);
                } else if ($sys_key == 'login_logo' && $data['upload_data']['image_height'] > 120) {
                    $this->load->helper('image_manipulation/image_manipulation');
                    include_lib_image_manipulation();
                    
                    $magicianObj = new imageLib('./assets/img/' . $image);
                    $magicianObj->resizeImage(320, 120, 'portrait');
                    $magicianObj->saveImage('./assets/img/' . $image, 100);
                }
                
                return $data['upload_data'];
            }
        } else if (isset($data['error'])) {
            $this->session->set_flashdata($sys_key, $data['error']);
            redirect(ADMIN_URL . 'system_setting/' . $setting->type, 'refresh');
        }
    }
}
