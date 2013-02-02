<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->view('header');
        $this->load->view('right_menu');
        $this->load->library('form_validation');
        $this->load->model('Users_in_out');
    }

    public function index() {
        //Lietotāja ID
        $user_ID = $this->session->userdata('user_ID');
        //Lietotāja informācija
        $user = $this->Users_in_out->get_user_data_by_ID($user_ID);
        $this->load->view('/user/profil_left_menu', $user);
        $this->load->view('user/profil');
        $this->load->view('footer');
    }

    //Reģistrēšanās forma
    public function register() {
        $data['user']->username = '';
        $data['user']->email = '';
        $data['user']->gender = '';
        $this->load->view('user/register', $data);
        $this->load->view('footer');
    }

    //Saglaba lietotāju
    public function saveuser() {
        //POST datu saņemšana
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        //Pārbaudu vai lietotājvārds jau nav aizņemts
        if ($this->Users_in_out->check_username($username) == FALSE)
            $username = ' ';
        //Pārbaudu vai epasts jau nav aizņemts
        if ($this->Users_in_out->check_email($email) == FALSE)
            $email = ' ';
        //Ievadlauku nosacījumi
        $this->form_validation->set_rules('username', 'Lietotājvārds', 'trim|required|min_length[3]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'Parole', 'trim|required|matches[password2]');
        $this->form_validation->set_rules('password2', 'Atkārtotā parole', 'trim|required');
        $this->form_validation->set_rules('email', 'E-pasts', 'trim|required|valid_email');
        $this->form_validation->set_rules('gender', 'Dzimums', 'required');
        //Ja nav izpildījušies ievadlauku nosacījumu vai nav norādīts vecums, vai epasts vai lietotājvārds jau ir aiņemts
        if ($this->form_validation->run() == FALSE || $this->input->post('gender') == 'option' || $username == ' ' || $email == ' ') {
            $data['user']->username = $username;
            $data['user']->email = $email;
            $data['user']->gender = $this->input->post('gender');
            $this->load->view('user/register', $data);
            $this->load->view('footer');
        } else {   //Izsaucu saglabāšanas metodi
            $this->Users_in_out->save_user($username, $this->input->post('password'), $email, $this->input->post('gender'));
            redirect('/user/login');
        }
    }

    public function login() {
        $data['user']->username = '';
        $data['user']->email = '';
        $this->load->view('user/login', $data);
        $this->load->view('footer');
    }

    public function takelogin() {
        //POST datu saņemšana
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        //Formas nosacījumi
        $this->form_validation->set_rules('username', 'Lietotājvārds', 'trim|required|min_length[3]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'Parole', 'trim|required');
        //Ja nosacījumi nav izpildījušies
        if ($this->form_validation->run() == FALSE) {
            $data['user']->username = $username;
            $this->load->view('user/login', $data);
            $this->load->view('footer');
        } else {
            //Medode, kas pārbauda vai ir šāds lietotājs un izveido sessiju
            if ($this->Users_in_out->login($username, $password) == FALSE) {
                echo 'nepareiz';
                exit;
            }
            else
                redirect('/news');
        }
    }

    public function logout() {
        //Dzēšam sessiju
        $this->session->sess_destroy();
        //Pāradresē uz ielogošanos
        redirect('/user/login');
    }
    
}
?>