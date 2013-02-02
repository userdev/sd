<?php

class Users_in_out extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* Enkriptē paroli
     * @param string $password
     * @return string enkriptēto paroli
     */

    function _prep_password($password) {
        return sha1($password . $this->config->item('encryption_key'));
    }

    /* Pārbauda vai ir šāds lietotājs un izveido sessiju
     * @param string $username
     * @param string $password  
     * @return boolean TRUE, ja lietotājs tika atrasts db un izveidota sessija
     * @return boolean FALSE, ja lietotājs netika atrasts db
     */

    function login($username, $password) {
        //Meklēju lietotāju, pēc lietotājvārda un paroles
        $query = $this->db->select('user_ID')->from('users')
                ->where('username', $username)
                ->where('password', $this->_prep_password($password))
                ->limit(1, 0);
        $results = $query->get()->result();

        if (count($results) > 0) {
            //Sessijas datu sagatavošana
            $newdata = array(
                'username' => $username,
                'user_ID' => $results[0]->user_ID,
                'logged_in' => TRUE
            );
            //Sessijas izveidošana
            $this->session->set_userdata($newdata);


            return true;
        }
        //Ja lietotājs nav atrasts atgriežu FALSE
        return false;
    }

    /* Pievieno jaunu lietotāju
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $gender
     * @return void
     */

    function save_user($username, $password, $email, $gender) {
        $data = array(
            'username' => $username,
            'password' => $this->_prep_password($password),
            'email' => $email,
            'gender' => $gender
        );
        $this->db->insert('users', $data);
    }

    /* Pārbauda vai ir jau šāds lietotājvārds jau  reģistrēts
     * @param string $username
     * @return boolean TRUE, ja šāds lietotājvārda vēl nav datubāzē
     * @return boolean FALSE, ja datubāzē jau ir reģistrēts šāds lietotājvārds
     */

    public function check_username($username) {
        $query = $this->db->select('user_ID')->from('users')
                ->where('username', $username);

        $results = $query->get()->result();
        //Ja nav šāda lietotājvārda atgriž TRUE
        if (count($results) == 0)
            return TRUE;
        else
            return FALSE; //Ja jau ir šāds lietotājvārds
    }

    /* Pārbauda vai ir jau šāds e-pasts reģistrēts
     * @param string $email
     * @return boolean TRUE, ja šāds e-pasts vēl nav datubāzē
     * @return boolean FALSE, ja datubāzē jau ir reģistrēts šāds e-pasts 
     */

    public function check_email($email) {
        $query = $this->db->select('user_ID')->from('users')
                ->where('email', $email);

        $results = $query->get()->result();
        //Ja nav šāda epasta atgriž TRUE
        if (count($results) == 0)
            return TRUE;
        else
            return FALSE; //Ja jau ir šāds epasts
    }

    /* Lietotāja dati pēc viņa ID
     * @param int $user_ID
     * @return int 0, ja lietotājs nav atrasts
     * @return object ar lietotāja datiem 
     */

    public function get_user_data_by_ID($user_ID) {
        $query = $this->db->select('username, email, gender')
                        ->from('users')->where('user_ID', $user_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts
            $this->username = $results[0]->username;
            $this->email = $results[0]->email;
            $this->gender = $results[0]->gender;
        }else
            $this->username = 0;
        return $this;
    }

}