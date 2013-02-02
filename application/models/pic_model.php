<?php

class Pic_model extends MY_model {

    function __construct() {
        parent::__construct();
    }

    public function save_pic($link, $record_ID, $type) {
        $data = array(
            'record_ID' => $record_ID,
            'type' => $type,
            'link' => $link
        );
        $this->db->insert('pictures', $data);
        $this->id = $this->db->insert_id();
        return $this;
    }
    
    public function get_pictures($record_ID, $type){
          $query = $this->db->select('pic_ID, link')->from('pictures')
                  ->where('record_ID', $record_ID)->where('type', $type);
        return $query->get()->result();
    }

}