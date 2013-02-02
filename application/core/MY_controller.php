<?php

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();


        /* Jā grib lai ir obligāta ielogošanās
          if (!$this->session->userdata('logged_in'))
          {
          echo 'Neesi ielogojies!';
          exit;
          }
         * 
         */
    }

    protected function get_last_poll() {
        $this->load->model('Polls_model');
        $data = array();

        $data['poll'] = $this->Polls_model->user_voted($this->user_ID(), $this->Polls_model->last_poll_ID());

        $datas[1] = $this->Polls_model->get_poll();
        $poll_datas = $this->Polls_model->get_poll_data_by_ID($this->Polls_model->last_poll_ID());
        $data['one'] = 0;
        $data['two'] = 0;
        $data['three'] = 0;
        $data['four'] = 0;
        $data['five'] = 0;
        $data['six'] = 0;
        $data['seven'] = 0;
        $data['all_count'] = 0;
        foreach ($poll_datas as $poll_data) {
            $data['all_count']++;
            switch ($poll_data->answer) {
                case 1:
                    $data['one']++;
                    break;
                case 2:
                    $data['two']++;
                    break;
                case 3:
                    $data['three']++;
                    break;
                case 4:
                    $data['four']++;
                    break;
                case 5:
                    $data['five']++;
                    break;
                case 6:
                    $data['six']++;
                    break;
                case 7:
                    $data['seven']++;
                    break;
            }
        }
        return $data;
    }

    protected function user_ID() {
        return $_SERVER["REMOTE_ADDR"];
    }

    protected function category_links($category_ID, $type) {
        $this->load->model('Category_sites');
        $sites['categories'] = $this->Category_sites->get_category_sites($category_ID, $type);
       // print_r($sites['categories']);
        foreach ($sites['categories'] as $site) {
            if (isset($site->category_2_type)) {
                switch ($site->category_2_type) {
                    case 'r':
                        $category = $this->Category_sites->get_category($site->category_2_ID, 'regards_categories');
                        $site->title = $category[0]->title;
                        $site->random_records = $this->Category_sites->radom_records('poem', 'regards', 'regard_ID');
                        $site->type = $site->category_2_type;
                        $site->category_ID = $site->category_2_ID;
                        $site->url_title = $category[0]->url_title;
                        break;
                    case 't':
                         $this->load->model('Toasts_model');
                        $category = $this->Category_sites->get_category($site->category_2_ID, 'toasts_categories');
                        $site->title = $category[0]->title;
                        $site->random_records = $this->Category_sites->radom_records('toast', 'toasts', 'toast_ID');
                        $site->type = $site->category_2_type;
                        foreach ($site->random_records as $record){
                            $record->toast=$this->Toasts_model->get_toast_by_ID($record->toast_ID);
                        }
                       
                        break;
                    case 'e':
                        $category = $this->Category_sites->get_category($site->category_2_ID, 'etiquettes_categories');
                        $site->title = $category[0]->title;
                        $site->random_records = $this->Category_sites->radom_records('title', 'etiquettes', 'etiquettes_ID');
                        $site->type = $site->category_2_type;
                        $site->category_ID = $site->category_2_ID;
                        $site->url_title = $category[0]->url_title;
                        break;
                }
            } if (isset($site->category_1_type)) {
                switch ($site->category_1_type) {
                    case 'r':
                        $category = $this->Category_sites->get_category($site->category_1_ID, 'regards_categories');
                        $site->title = $category[0]->title;
                        $site->random_records = $this->Category_sites->radom_records('poem', 'regards', 'regard_ID');
                        $site->type = $site->category_1_type;
                        $site->category_ID = $site->category_1_ID;
                        $site->url_title = $category[0]->url_title;
                        break;
                    case 't':
                        $category = $this->Category_sites->get_category($site->category_1_ID, 'toasts_categories');
                        $site->title = $category[0]->title;
                        $site->random_records = $this->Category_sites->radom_records('toast', 'toasts', 'toast_ID');
                        $site->type = $site->category_1_type;
                        $site->category_ID = $site->category_1_ID;
                        $site->url_title = $category[0]->url_title;
                        break;
                    case 'e':
                        $category = $this->Category_sites->get_category($site->category_1_ID, 'etiquettes_categories');
                        $site->title = $category[0]->title;
                        $site->random_records = $this->Category_sites->radom_records('title', 'etiquettes', 'etiquette_ID');
                        $site->type = $site->category_1_type;
                        $site->category_ID = $site->category_1_ID;
                        $site->url_title = $category[0]->url_title;
                        break;
                }
            }
        }
        return $sites;
    }

}

?>