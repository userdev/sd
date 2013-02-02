<?php

class Games_model extends MY_model {

    function __construct() {
        parent::__construct();
    }

    public function get_catagories() {
        $query = $this->db->select('title, category_ID, url_title')->from('games_categories');
        return $query->get()->result();
    }

    public function save_game($title, $description, $category_ID) {
        $data = array(
            'title' => $title,
            'description' => $description,
            'owner' => $this->user_ID(),
            'category_ID' => $category_ID
        );
        $this->db->insert('games', $data);
        $this->id = $this->db->insert_id();
        return $this;
    }

   

    public function get_last_games() {
        $games_count = 20; //Skaits cik lasīt
        $query = $this->db->select('game_ID, title, description')->from('games')
                        ->limit($games_count)->order_by("game_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $games_count)
            $results[$games_count]->flag = 'less';
        else {
            $results[$games_count]->flag = 'more';
        }
        return $results;
    }

    public function get_more_games($last_ID) {
        $games_count = 20; //Skaits cik lasīt
        $query = $this->db->select('game_ID, title, description')->from('games')
                        ->where('game_ID <', $last_ID)->limit($games_count)->order_by("game_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $games_count)
            $results[$games_count]->flag = 'less';
        else {
            $results[$games_count]->flag = 'more';
        }

        return $results;
    }

    public function get_games_by_category($category_ID) {
        $games_count = 20; //Skaits cik lasīt
        $query = $this->db->select('game_ID, title, description')->from('games')
                        ->where('category_ID', $category_ID)->limit($games_count)->order_by("game_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $games_count)
            $results[$games_count]->flag = 'less';
        else {
            $results[$games_count]->flag = 'more';
        }

        return $results;
    }

    public function get_more_category_games($last_ID, $category_ID) {
        $games_count = 20; //Skaits cik lasīt
        $query = $this->db->select('game_ID, title, description')->from('games')
                        ->where('game_ID <', $last_ID)->where('category_ID', $category_ID)
                        ->limit($games_count)->order_by("game_ID", "desc");
        $results = $query->get()->result();
        if (count($results) < $games_count)
            $results[$games_count]->flag = 'less';
        else {
            $results[$games_count]->flag = 'more';
        }

        return $results;
    }

    public function get_game_by_ID($game_ID) {
        // unset($this);
        $query = $this->db->select('title, description, category_ID')->from('games')
                        ->where('game_ID', $game_ID)->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {//lietotājs ir atrasts           
            $this->title = $results[0]->title;
            $this->description = $results[0]->description;
            $this->category_ID = $results[0]->category_ID;
        }else
            $this->id = 0;
        return $this;
    }

}