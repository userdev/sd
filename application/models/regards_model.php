<?php

class Regards_model extends MY_model {

    function __construct() {
        parent::__construct();
        define('TEST_CONSTANT', 'Works!'); //Jālielk cik lasīt no vienas 
    }

    public function get_catagories() {
        $query = $this->db->select('title, category_ID, url_title')->from('regards_categories');
        return $query->get()->result();
    }

    public function save_regard($poem, $author) {
        $data = array(
            'poem' => $poem,
            'author' => $author
        );
        $this->db->insert('regards', $data);
        $this->id = $this->db->insert_id();
        return $this;
    }

    public function save_regard_categoty($regard_ID, $category_ID) {
        $data = array(
            'regard_ID' => $regard_ID,
            'category_ID' => $category_ID
        );
        $this->db->insert('regards_has_categories', $data);
    }

    public function get_last_regards() {
        $regard_count = 20; //Skaits cik lasīt
        $query = $this->db->select('regard_ID, poem, author')->from('regards')
                        ->limit($regard_count)->order_by("regard_ID", "desc");

        return $query->get()->result();
    }

    public function get_more_regards($last_ID) {
        $regard_count = 20; //Skaits cik lasīt
        $query = $this->db->select('regard_ID, poem, author')->from('regards')
                        ->where('regard_ID <', $last_ID)->limit($regard_count)->order_by("regard_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $regard_count)
            $results[$regard_count]->flag = 'less';
        else {
            $results[$regard_count]->flag = 'more';
        }

        return $results;
    }

    public function category_regards($category_ID, $last_ID) {
        $regard_count = 20; //Skaits cik lasīt
        $query = $this->db->select('regard_ID')->from('regards_has_categories')
                        ->where('regard_ID <', $last_ID)
                        ->where('category_ID', $category_ID)
                        ->limit($regard_count)->order_by("regard_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $regard_count)
            $results[$regard_count]->flag = 'less';
        else {
            $results[$regard_count]->flag = 'more';
        }

        return $results;
    }

    public function get_regard_by_ID($regard_ID) {
        // unset($this);
        $query = $this->db->select('poem, author')
                        ->from('regards')->where('regard_ID', $regard_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts           
            $this->poem = $results[0]->poem;
            $this->author = $results[0]->author;
            
        }else
            $this->id = 0;
        return $this;
    }

    public function get_regards_by_category($category_ID) {
        $regard_count = 20; //Skaits cik lasīt
        $query = $this->db->select('regard_ID')->from('regards_has_categories')
                        ->where('category_ID', $category_ID)
                        ->limit($regard_count)->order_by("regard_ID", "desc");
        return $query->get()->result();
    }

    public function get_category_id_by_title($title) {
        $title = $this->convert_title($title);
        $query = $this->db->select('category_ID')
                        ->from('regards_categories')->where('url_title', $title)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {
            return $results[0]->category_ID;
        }else
            return 0; //nav šādas kategorijas
    }

    public function convert_title($title) {
        //Biblotēka, kas palīdz sagatavot kategorijas nosaukumu pirkš URL 
        $this->load->helper('text');
        //Dekodēšana
        $title = urldecode($title);
        //LV burtu un atsarpju noņemšana
        return url_title(convert_accented_characters($title), 'underscore', TRUE);
    }

   
   

    public function get_category_search_words($category_ID) {
        $query = $this->db->select('search_words')
                        ->from('regards_categories')->where('category_ID', $category_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts           
            $this->search_words = $results[0]->search_words;
        }else
            $this->search_words = '';
        return $this;
    }

    public function get_category_id_by_regard($regard_ID) {
        $query = $this->db->select('category_ID')->from('regards_has_categories')
                ->where('regard_ID', $regard_ID)
                ->limit('1');
        return $query->get()->result();
    }

}