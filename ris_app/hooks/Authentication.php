<?php

class Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->__clear_cache();
        $this->setSystemSetting();
    }

    private function __clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function checkLogin() {
        $array = array('authenticate', 'cronjobs');
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '192.168.1.29') {
            $path_admin = $path[2];
        } else {
            $path_admin = $path[1];
        }
        if ($path_admin == 'admin' && !in_array($this->router->class, $array)) {
            $session = $this->session->userdata('admin_session');
            if (empty($session)) {
                $this->session->set_flashdata('error', 'Please do login first');
                redirect(ADMIN_URL . 'login', 'refresh');
            }
        }
    }

    function setSystemSetting() {
        foreach (Systemsetting::getSystemSetting() as $value) {
            $this->config->set_item($value['sys_key'], $value['sys_value']);
        }
    }

}

?>