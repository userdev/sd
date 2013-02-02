<?php

class Session extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    function process() {
        $newdata = array(
            'username' => 'johndoe',
            'email' => 'johndoe@some-site.com',
            'logged_in' => TRUE
        );

        $this->session->set_userdata($newdata);
    }

    function get_data() {
        echo $this->session->userdata('username');
    }
    
    function delete_session() {
        $this->session->sess_destroy();
    }

}

?>