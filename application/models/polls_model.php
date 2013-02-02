<?php

class Polls_model extends MY_model {

    function __construct() {
        parent::__construct();
    }

    public function save_poll($question, $answer_1, $answer_2, $answer_3, $answer_4, $answer_5, $answer_6, $answer_7) {
        $data = array(
            'question' => $question,
            'answer_1' => $answer_1,
            'answer_2' => $answer_2,
            'answer_3' => $answer_3,
            'answer_4' => $answer_4,
            'answer_5' => $answer_5,
            'answer_6' => $answer_6,
            'answer_7' => $answer_7
        );
        $this->db->insert('polls', $data);
    }

    public function user_vote($user_ID, $poll_ID, $vote) {
        $data = array(
            'user_ID' => $user_ID,
            'poll_ID' => $poll_ID,
            'answer' => $vote,
        );

        $this->db->insert('poll_answers', $data);
    }

    public function get_poll() {

        $query = $this->db->select('poll_ID, question, answer_1, answer_2, answer_3, answer_4, answer_5, answer_6, answer_7')
                        ->from('polls')->limit(1, 0)->order_by("poll_ID", "desc");
        $results = $query->get()->result();
        $this->poll_ID = $results[0]->poll_ID;
        $this->question = $results[0]->question;
        $this->answer_1 = $results[0]->answer_1;
        $this->answer_2 = $results[0]->answer_2;
        $this->answer_3 = $results[0]->answer_3;
        $this->answer_4 = $results[0]->answer_4;
        $this->answer_5 = $results[0]->answer_5;
        $this->answer_6 = $results[0]->answer_6;
        $this->answer_7 = $results[0]->answer_7;
        return $this;
    }

    public function user_voted($user_ID, $poll_ID) {

        $query = $this->db->select('answer')
                ->from('poll_answers')->where('user_ID', $user_ID)->where('poll_ID', $poll_ID)
                ->limit(1, 0);
        $results = $query->get()->result();
        if (count($results) > 0) {
            $this->answer = $results[0]->answer;
        }
        else
            $this->answer = 0;
        return $this;
    }

    public function last_poll_ID() {
        $query = $this->db->select('poll_ID')
                        ->from('polls')
                        ->limit(1, 0)->order_by("poll_ID", "desc");
        $results = $query->get()->result();
        return $results[0]->poll_ID;
    }

    public function get_poll_by_ID($poll_ID) {
        $query = $this->db->select('poll_ID, question, answer_1, answer_2, answer_3, answer_4, answer_5, answer_6, answer_7')
                        ->from('polls')->where('poll_ID', $poll_ID);
        $results = $query->get()->result();
        $this->question = $results[0]->question;
        $this->answer_1 = $results[0]->answer_1;
        $this->answer_2 = $results[0]->answer_2;
        $this->answer_3 = $results[0]->answer_3;
        $this->answer_4 = $results[0]->answer_4;
        $this->answer_5 = $results[0]->answer_5;
        $this->answer_6 = $results[0]->answer_6;
        $this->answer_7 = $results[0]->answer_7;
        return $this;
    }

    public function get_poll_data_by_ID($poll_ID) {
        $query = $this->db->select('answer')
                        ->from('poll_answers')->where('poll_ID', $poll_ID);
        return $query->get()->result();
        
    }

}