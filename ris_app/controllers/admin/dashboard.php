<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller
{
    
    var $session_data;
    
    function __construct() {
        parent::__construct();
        $this->layout->setField('page_title', 'Dashboard');
        $this->session_data = $this->session->userdata('admin_session');
    }
    
    public function index() {
        if (empty($this->session_data)) {
            redirect(ADMIN_URL . 'login', 'refresh');
        } else {
            $data['page_h1_title'] = 'Dashboard';           
            $this->layout->view('admin/dashboard/view', $data);
        }
    }

    public function mail_testing($email){
        //$option['tomailid'] = $email;
        //$option['subject'] = 'Testing';
        //$option['message'] = $this->load->view('admin/template/layout_news_letter', NULL, true);
        //send_mail($option);
        $this->load->view('admin/template/layout_news_letter');
    }
}
