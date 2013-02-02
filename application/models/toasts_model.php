<?php

class Toasts_model extends MY_model {

    function __construct() {
        parent::__construct();
     
    }

    public function get_catagories() {
        $query = $this->db->select('title, category_ID, url_title')->from('toasts_categories');
        return $query->get()->result();
    }
    
     public function save_toast($toast) {
        $data = array(
            'toast' => $toast           
        );
        $this->db->insert('toasts', $data);
        $this->id = $this->db->insert_id();
        return $this;
    }
    
     public function save_toast_categoty($toast_ID, $category_ID) {
        $data = array(
            'toast_ID' => $toast_ID,
            'category_ID' => $category_ID
        );
        $this->db->insert('toasts_has_categories', $data);
    }
    
     public function get_category_id_by_title($title) {
        $title = $this->convert_title($title);
        $query = $this->db->select('category_ID')
                        ->from('toasts_categories')->where('url_title', $title)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {
            return $results[0]->category_ID;
        }else
            return 0; //nav šādas kategorijas
    }
    
     public function get_category_search_words($category_ID) {
        $query = $this->db->select('search_words')
                        ->from('toasts_categories')->where('category_ID', $category_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts           
            $this->search_words = $results[0]->search_words;
        }else
            $this->search_words = '';
        return $this;
    }
    
      public function get_toasts_by_category($category_ID) {
        $regard_count = 20; //Skaits cik lasīt
        $query = $this->db->select('toast_ID')->from('toasts_has_categories')
                        ->where('category_ID', $category_ID)
                        ->limit($regard_count)->order_by("toast_ID", "desc");
        return $query->get()->result();
    }
    
     public function get_last_toasts() {
        $regard_count = 20; //Skaits cik lasīt
        $query = $this->db->select('toast_ID, toast')->from('toasts')
                        ->limit($regard_count)->order_by("toast_ID", "desc");

        return $query->get()->result();
    }
    
    public function category_toasts($category_ID, $last_ID) {
        $toast_count = 20; //Skaits cik lasīt
        $query = $this->db->select('toast_ID')->from('toasts_has_categories')
                        ->where('toast_ID <', $last_ID)
                        ->where('category_ID', $category_ID)
                        ->limit($toast_count)->order_by("toast_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $toast_count)
            $results[$toast_count]->flag = 'less';
        else {
            $results[$toast_count]->flag = 'more';
        }

        return $results;
    }
    
        public function get_more_toasts($last_ID) {
        $toast_count = 20; //Skaits cik lasīt
        $query = $this->db->select('toast_ID, toast')->from('toasts')
                        ->where('toast_ID <', $last_ID)->limit($toast_count)->order_by("toast_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $toast_count)
            $results[$toast_count]->flag = 'less';
        else {
            $results[$toast_count]->flag = 'more';
        }
        
        return $results;
    }

    
    public function get_toast_by_ID($toast_ID) {
        // unset($this);
        $query = $this->db->select('toast')
                        ->from('toasts')->where('toast_ID', $toast_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts           
            $this->toast = $results[0]->toast;
           
            
        }else
            $this->id = 0;
        return $this;
    }
    
    public function get_category_id_by_toast($toast_ID) {
        $query = $this->db->select('category_ID')->from('toasts_has_categories')
                ->where('toast_ID', $toast_ID)
                ->limit('1');
        return $query->get()->result();
    }
}