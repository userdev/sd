<?php

class Category_sites extends MY_model {

    function __construct() {
        parent::__construct();
    }

    public function get_category_sites($category_ID, $type) {
        //Meklēju pirmajā kolonā šo ID
        $query = $this->db->select('category_2_ID, category_2_type')->from('category_sites')
                        ->where('category_1_ID', $category_ID)->where('category_1_type', $type);
        $results = $query->get()->result();
        //Meklēju otrajā kolonā šo id
        $query = $this->db->select('category_1_ID, category_1_type')->from('category_sites')
                        ->where('category_2_ID', $category_ID)->where('category_2_type', $type);
        $results_2 = $query->get()->result();
        return array_merge($results, $results_2);
    }
    
    public function get_category($category_ID, $type){
        
        $query = $this->db->select('title, url_title')->from($type)
                        ->where('category_ID', $category_ID);
       return $query->get()->result();
    }
    
    public function radom_records($title, $type, $ID){
       
        $query = $this->db->select('toast_ID', 'toast')->from('toasts')
                        ->limit(3)->order_by($ID, "random");
       return $query->get()->result();
    }
    

    
}
?>