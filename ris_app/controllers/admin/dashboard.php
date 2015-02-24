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
            $date = get_current_date_time()->get_date_for_db();
            
            $this->layout->view('admin/dashboard/view', $data);
        }
    }

    public function mail_testing($email){
        $option['tomailid'] = $email;
        $option['subject'] = 'Hi';
        $option['message'] = 'This is an test mail, for testing an SMTP server';
        send_mail($option);
    }
}
