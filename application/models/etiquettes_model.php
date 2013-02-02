<?php

class Etiquettes_model extends MY_model {

    function __construct() {
        parent::__construct();
    }

    public function get_etiquetts_categories() {
        $query = $this->db->select('title, category_ID, url_title, search_words')->from('etiquettes_categories');
        return $query->get()->result();
    }

    public function save_etiquette($title, $description) {
        $data = array(
            'title' => $title,
            'description' => $description,
            'owner' => $this->user_ID()
        );
        $this->db->insert('etiquettes', $data);
        $this->id = $this->db->insert_id();
        return $this;
    }

    public function save_etiquettes_categoty($etiquette_ID, $category_ID) {
        $data = array(
            'etiquette_ID' => $etiquette_ID,
            'category_ID' => $category_ID
        );
        $this->db->insert('etiquettes_has_categories', $data);
    }

    public function get_last_etiquettes() {
        $etiquettes_count = 20; //Skaits cik lasīt
        $query = $this->db->select('etiquette_ID, title, description')->from('etiquettes')
                        ->limit($etiquettes_count)->order_by("etiquette_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $etiquettes_count)
            $results[$etiquettes_count]->flag = 'less';
        else {
            $results[$etiquettes_count]->flag = 'more';
        }
        return $results;
    }

    public function get_more_etiquettes($last_ID) {
        $etiquettes_count = 20; //Skaits cik lasīt
        $query = $this->db->select('etiquette_ID, title, description')->from('etiquettes')
                        ->where('etiquette_ID <', $last_ID)->limit($etiquettes_count)->order_by("etiquette_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $etiquettes_count)
            $results[$etiquettes_count]->flag = 'less';
        else {
            $results[$etiquettes_count]->flag = 'more';
        }

        return $results;
    }
    
     public function get_etiquettes_by_category($category_ID) {
        $etiquettes_count = 20; //Skaits cik lasīt
        $query = $this->db->select('etiquette_ID')->from('etiquettes_has_categories')
                        ->where('category_ID', $category_ID)->limit($etiquettes_count)->order_by("etiquette_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $etiquettes_count)
            $results[$etiquettes_count]->flag = 'less';
        else {
            $results[$etiquettes_count]->flag = 'more';
        }

        return $results;
    }
    
      public function get_etiquette_by_ID($etiquette_ID) {
       
       $query = $this->db->select('title, description')->from('etiquettes')
                        ->where('etiquette_ID', $etiquette_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts           
            $this->title = $results[0]->title;
            $this->description = $results[0]->description;
          
        }else
            $this->id = 0;
        return $this;
    }
    
    public function get_more_category_etiquettes($last_ID, $category_ID) {
        $etiquettes_count = 20; //Skaits cik lasīt
        $query = $this->db->select('etiquette_ID')->from('etiquettes_has_categories')
                        ->where('etiquette_ID <', $last_ID)->where('category_ID', $category_ID)
                        ->limit($etiquettes_count)->order_by("etiquette_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $etiquettes_count)
            $results[$etiquettes_count]->flag = 'less';
        else {
            $results[$etiquettes_count]->flag = 'more';
        }

        return $results;
    }

}