<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Polls extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Polls_model');
    }

    public function add() {
        $this->load->view('header');
        // $this->load->view('right_menu');
        $data['question'] = '';
        $data['answers']->answer_1 = '';
        $data['answers']->answer_2 = '';
        $data['answers']->answer_3 = '';
        $data['answers']->answer_4 = '';
        $data['answers']->answer_5 = '';
        $data['answers']->answer_6 = '';
        $data['answers']->answer_7 = '';
        $this->load->view('poll_add', $data);
        $this->load->view('footer');
    }

    public function takeadd() {
        $this->form_validation->set_rules('question', 'Jautājums', 'trim|required|min_length[5]|max_length[1000]|xss_clean');
        $this->form_validation->set_rules('answer_1', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('answer_2', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('answer_3', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('answer_4', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('answer_5', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('answer_6', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('answer_7', 'Atbilžu variants', 'trim|min_length[3]|max_length[255]|xss_clean');
        $answers_count = 0;
        for ($i = 1; $i <= 7; $i++) { //Skatos cik atbildes ir kaut kas ierakstīts
            if (trim($this->input->post("answer_$i")))
                $answers_count++; //ja kaut kas ierakstīts palieninu atbilžu skaitītāju
        }
        //Ja nav izpildījusies formu validācija vai nav aizpildītas vismaz 2 atbilžu varianti
        if ($this->form_validation->run() == FALSE || $answers_count < 2) {
            $this->load->view('header');
            $this->load->view('right_menu');
            $data['question'] = $this->input->post('question');
            $data['answers']->answer_1 = $this->input->post('answer_1');
            $data['answers']->answer_2 = $this->input->post('answer_2');
            $data['answers']->answer_3 = $this->input->post('answer_3');
            $data['answers']->answer_4 = $this->input->post('answer_4');
            $data['answers']->answer_5 = $this->input->post('answer_5');
            $data['answers']->answer_6 = $this->input->post('answer_6');
            $data['answers']->answer_7 = $this->input->post('answer_7');
            if ($answers_count < 2)//Ja nav norādīti vismaz 2 atbilžu varinati
                $data['error_message'] = 'Vismaz 2 atbilžu laukiem jābūt aizpildītiem';
            $this->load->view('poll_add', $data);
            $this->load->view('footer');
        }
        else {

            $this->Polls_model->save_poll($this->input->post('question'), $this->input->post('answer_1'), $this->input->post('answer_2'), $this->input->post('answer_3'), $this->input->post('answer_4'), $this->input->post('answer_5'), $this->input->post('answer_6'), $this->input->post('answer_7'));
            redirect('/regards');
        }
    }

    public function vote() {
        $user_ID = parent::user_ID();
        $poll_ID = $this->input->post('poll_ID');
        $voted = $this->Polls_model->user_voted($user_ID, $poll_ID)->answer;

        if ($voted != 0) {
            echo 'Jūs jau esiet nobalsojis šajā aptaujā!';
            return;
        }

        $vote_ID = $this->input->post('ID');

        $this->Polls_model->user_vote($user_ID, $poll_ID, $vote_ID);
        $poll = $this->Polls_model->get_poll_by_ID($poll_ID);
        $poll_datas = $this->Polls_model->get_poll_data_by_ID($poll_ID);
        $one = 0;
        $two = 0;
        $three = 0;
        $four = 0;
        $five = 0;
        $six = 0;
        $seven = 0;
        $all_count = 0;
        foreach ($poll_datas as $poll_data) {
            $all_count++;
            switch ($poll_data->answer) {
                case 1:
                    $one++;
                    break;
                case 2:
                    $two++;
                    break;
                case 3:
                    $three++;
                    break;
                case 4:
                    $four++;
                    break;
                case 5:
                    $five++;
                    break;
                case 6:
                    $six++;
                    break;
                case 7:
                    $seven++;
                    break;
            }
        }
        if ($poll->answer_1) {
            $percents = $one / $all_count * 100;
            ?><div ><?php echo $poll->answer_1 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        if ($poll->answer_2) {
            $percents = $two / $all_count * 100;
            ?><div><?php echo $poll->answer_2 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        if ($poll->answer_3) {
            $percents = $three / $all_count * 100;
            ?><div><?php echo $poll->answer_3 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        if ($poll->answer_4) {
            $percents = $four / $all_count * 100;
            ?><div><?php echo $poll->answer_4 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        if ($poll->answer_5) {
            $percents = $five / $all_count * 100;
            ?><div><?php echo $poll->answer_5 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        if ($poll->answer_6) {
            $percents = $six / $all_count * 100;
            ?><div><?php echo $poll->answer_6 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        if ($poll->answer_7) {
            $percents = $seven / $all_count * 100;
            ?><div><?php echo $poll->answer_7 . ' ' . number_format($percents, 0, '.', '') . '%'; ?></div><?php
        }
        ?> <?php
    }

}