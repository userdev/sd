<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News extends MY_Controller {

    function __construct() {
        parent::__construct();        
        $this->load->view('header');
        $this->load->view('right_menu');
    }

    public function index() {
        $this->load->view('news/news');
        $this->load->model('Users_in_out');
       
        //$this->Users_in_out->register('jancisss', 'jaanis');
        $this->Users_in_out->login('jancisss', 'jaanis');
       
        $this->load->view('footer');
    }

    public function addnews() {
       
       
        $this->load->view('news/add_news');
        $this->load->view('footer');
    }

}

/* End of file welcome.php */
/* Locati */