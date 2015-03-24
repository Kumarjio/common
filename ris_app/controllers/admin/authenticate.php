<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class authenticate extends CI_Controller
{
    
    function __construct() {
        parent::__construct();
        $this->layout->setLayout('admin/template/layout_login');
        $this->layout->setField('page_title', 'Admin Login');
    }
    
    public function index() {
        $session = $this->session->userdata('admin_session');
        if (!empty($session)) {
            redirect(ADMIN_URL . 'dashboard', 'refresh');
        } else {
            $this->layout->view('admin/authenticate/login');
        }
    }
    
    private function _setSessionData($admin) {
        $user_data = new stdClass();
        $user_data->id = $admin->id;
        $user_data->role = $admin->role_id;
        $user_data->name = $admin->fullname;
        $user_data->profile_pic = $admin->profile_pic;
        $user_data->email = $admin->email;
        $newdata = array('admin_session' => $user_data);
        $this->session->set_userdata($newdata);
        
        return true;
    }
    
    function validateUser() {
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'All fields are compulsory');
            redirect(ADMIN_URL .'login', 'refresh');
        } else {
            $admin = new User();
            $admin->where('email', $this->input->post('email'));
            $admin->where('password', md5($this->input->post('password')));
            $admin->get();
            
            if ($admin->result_count() != 1) {
                $this->session->set_flashdata('error', 'Login failed');
                redirect(ADMIN_URL . 'login', 'refresh');
            } else {
                $this->_setSessionData($admin);
                redirect(ADMIN_URL . 'dashboard', 'refresh');
            }
        }
    }

    function optimizeTable() {
        $this->load->dbutil();
        CI_DB_utility::optimizeTable();
    }
    
    function logout() {
        $this->session->unset_userdata('admin_session');
        $this->session->sess_destroy();
        
        redirect(ADMIN_URL . 'login', 'refresh');
    }
    
    function userForgotPassword() {
        $this->layout->setField('page_title', 'Forgot Password');
        $this->layout->view('admin/authenticate/forgot_password');
    }
    
    function userSendResetPasswordLink() {
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'All fields are compulsory');
            redirect(ADMIN_URL .'forgot_password', 'refresh');
        } else {
            $user = new User();
            $user->where('email', $this->input->post('email'))->get();
            
            $email = new Email();
            $email->where('type', 'forgot_password')->get();
            if ($user->result_count() == 1 && $email->result_count() == 1) {
                $random_string = random_string('alnum', 32);
                $user->password = $random_string;
                $user->save();
                $message = $email->message;
                $message = str_replace('#admin_name', $user->fullname, $message);
                $link = '<a href="' . ADMIN_URL . 'reset_password/' . $random_string . '">Click Here to reset password</a>';
                $message = str_replace('#reset_link', $link, $message);
                
                $option['tomailid'] = $user->email;
                $option['subject'] = $email->subject;
                $option['message'] = $message;
                if (!is_null($email->attachment)) {
                    $option['attachement'] = 'assets/email_attachments/' . $email->attachment;
                }
                
                if (send_mail($option)) {
                    $this->session->set_flashdata('success', 'Please check the mail address & follow the instruction');
                } else {
                    $this->session->set_flashdata('error', 'Mail Sending failed, please try again');
                }
            } else {
                $this->session->set_flashdata('error', 'Email address does not exit');
            }
            redirect(ADMIN_URL . 'forgot_password', 'refresh');
        }
    }
    
    function userResetPassword($random_string) {
        if ($this->input->post() !== false) {
            $this->form_validation->set_rules('new_password', 'Password', 'required');
            $this->form_validation->set_rules('new_cpassword', 'Confirm Password', 'required');

            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error', 'All fields are compulsory');
                redirect(ADMIN_URL .'reset_password/' . $random_string , 'refresh');
            } else if($this->input->post('new_password') != $this->input->post('new_cpassword')){
                $this->session->set_flashdata('error', 'Both password does not match');
                redirect(ADMIN_URL .'reset_password/' . $random_string , 'refresh');
            } else {
                $user = new User();
                $user->where('password', $random_string)->get();
                if ($user->result_count() == 1) {
                    $user->password = md5($this->input->post('new_password'));
                    $user->save();
                    $this->session->set_flashdata('success', 'Password reset successfully');
                    redirect(ADMIN_URL . 'login', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Error in reseting the password, please try again.');
                    redirect(ADMIN_URL . 'reset_password/' . $random_string, 'refresh');
                }
            }
        } else {
            $this->layout->setField('page_title', 'Reset Password');
            $data['random_string'] = $random_string;
            $this->layout->view('admin/authenticate/reset_password', $data);
        }
    }

    function permissionDenied() {
        $this->layout->view('authenticate/permission');
    }
    
    function error_404() {
        $this->layout->view('authenticate/error_404');
    }

}
