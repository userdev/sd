<?php

class MY_model extends CI_Model {

    function __construct() {
        parent::__construct();

        
    }
    
     protected function user_ID() {
        return $_SERVER["REMOTE_ADDR"];
    }
    
    
    public function month_lv_name($month) {

        switch ($month) {
            case 1:
                return "janvārī";
                break;
            case 2:
                return "februārī";
                break;
            case 3:
                return "martā";
                break;
            case 4:
                return "aprīlī";
                break;
            case 5:
                return "maijā";
                break;
            case 6:
                return "jūnijā";
                break;
            case 7:
                return "jūlijā";
                break;
            case 8:
                return "augustā";
                break;
            case 9:
                return "septembrī";
                break;
            case 10:
                return "oktobrī";
                break;
            case 11:
                return "novembrī";
                break;
            case 12:
                return "decembrī";
                break;
        }
    }
    
     public function name_days() {
        $date = getdate();
        $month = $date["mon"];
        $day = $date["mday"];
        $query = $this->db->select('name_1, name_2, name_3, name_4, name_5, name_6')->from('name_days')
                ->where('month', $month)->where('day', $day)
                ->limit('1');
        return $query->get()->result();
    }
}