<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Toasts extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Toasts_model');
        $this->load->model('Polls_model');
    }

    public function index($category_name = '', $category_ID = 0) {

        //Ja nav norādīts ID
        if ($category_name != '' && $category_ID == 0)
            $category_ID = $this->Toasts_model->get_category_id_by_title($category_name); //Mēģiina sameklēt pēc nosaukuma ID 
        $head_data['search_words'] = $this->Toasts_model->get_category_search_words($category_ID); //Atslēgas vārdi priekš head
        $head_data['head_active_page'] = 't';
        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Toasts_model->get_catagories();
        $menu_data['active_page'] = $category_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $right_menu_data['name_month'] = $this->Toasts_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $right_menu_data['month'] = $this->Toasts_model->month_lv_name($month); //Mēneša latviskais nosaukums
        /* foreach ($menu_data['categories'] as $category) { //Kategorijas nosaukums
          if ($category->category_ID == $category_ID)
          $head_data['title'] = $category->title; //nosaukumu headam priekš page title
          }
         */
        if (!isset($head_data['title']))
            $head_data['title'] = 'Tosti'; //ja nav atvērta neiena sadaļa uztādu page title 

        $this->load->view('header', $head_data); //Fead skats ar datiem
        $right_menu_data += parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $this->load->view('/toasts/toasts_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        //Dati skatam kura kategorija   
        $data['category']->category_ID = $category_ID;
        //Ja norādīts categorijas nosaukums un ID       
        if ($category_name != '' && $category_ID != 0) {
            //Visi novēlējumu ID atilstošajai sadaļai
            $data['category_toasts'] = $this->Toasts_model->get_toasts_by_category($category_ID);
            //Iegūstu informāciju par katru novēlējuma ID
            foreach ($data['category_toasts'] as $categoty_toast) {
                $toast = $this->Toasts_model->get_toast_by_ID($categoty_toast->toast_ID);

                $categoty_toast->toast = $toast->toast;
                //$categoty_regard->author = $regard->author;
            }
        } else {//Ja nav norādis kura sadaļa jāatver
            //Visas kategorijas skatam
            $data['all_categories'] = $menu_data['categories'];
            //Pēdējie vēlējumi
            $data['toasts'] = $this->Toasts_model->get_last_toasts();
        }
        $this->load->view('/toasts/toast_index', $data);
        $this->load->view('footer');
    }

    public function add() {
        $head_data['head_active_page'] = 't';
        $this->load->view('header', $head_data);
        //Labās sānu izvēlnes dati       
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $data['categories'] = $this->Toasts_model->get_catagories();
        foreach ($data['categories'] as $category)
            $category->checked = FALSE; //atzīmēju, ka neviena kategorija nav atķeksēta
        $data['yes_category'] = TRUE;
        $data['toast']->toast = '';

        $this->load->view('/toasts/add', $data);
        $this->load->view('footer');
    }

    public function takeadd() {
        //Ievadlauku nosacījumi
        $this->form_validation->set_rules('toast', 'Tosts', 'trim|required|min_length[5]|max_length[50000]|xss_clean');

        //Visas kategorijas
        $data['categories'] = $this->Toasts_model->get_catagories();
        $data['yes_category'] = FALSE; //Karodziņš, ka nav neviena atzīmēta
        foreach ($data['categories'] as $category) {
            if ($this->input->post('category_' . $category->category_ID)) {//ja atzīmēta kāda kategorija
                $data['yes_category'] = TRUE; //pazīme ka kāda no kategorijām ir atdzīmēta          
                $category->checked = TRUE; //Atzīme, ka šī kategorija bija atķeksēta
            }
            else
                $category->checked = FALSE; //Atzīme, ka šī kategorija nebija atķeksēta
        }
        //Ja nav izpildījušies ievadlauku nosacījumu , atzīmēta kaut viena kategorija
        if ($this->form_validation->run() == FALSE || $data['yes_category'] == FALSE) {
            $head_data['head_active_page'] = 'r';
            $this->load->view('header', $head_data);
            $this->load->view('right_menu'); //labās izvēlnes skats
            $data['regard']->poem = $this->input->post('toast');

            $this->load->view('/toasts/add', $data);
            $this->load->view('footer');
        } else {

            //regard_ID->id norāda uz tikko sagalbāto ierastu
            $regard_ID = $this->Toasts_model->save_toast(nl2br($this->input->post('toast')));

            foreach ($data['categories'] as $category) {
                if ($category->checked == TRUE) //Visas atzīmētās kategorijas
                    $this->Toasts_model->save_toast_categoty($regard_ID->id, $category->category_ID); //Saglabāju atzīmētās kategorijas
            }
            redirect('/toasts/add');
        }
    }

    public function view($toast_ID = 0) {
        $head_data['head_active_page'] = 't';
        $this->load->view('header', $head_data);
        if ($toast_ID == 0)
            redirect('/toasts');

        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        //Menu data
        $category_ID = $this->Toasts_model->get_category_id_by_toast($toast_ID);
        $menu_data['categories'] = $this->Toasts_model->get_catagories();
        $menu_data['active_page'] = $category_ID[0]->category_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $menu_data['name_month'] = $this->Toasts_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $menu_data['month'] = $this->Toasts_model->month_lv_name($month); //Mēneša latviskais nosaukums
        foreach ($menu_data['categories'] as $category) { //Kategorijas nosaukums
            if ($category->category_ID == $category_ID)
                $head_data['title'] = $category->title; //nosaukumu headam priekš page title
        }
        $this->load->view('/toasts/toasts_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        $data['toast'] = $this->Toasts_model->get_toast_by_ID($toast_ID);
        $data['toast_ID'] = $toast_ID;
        $this->load->view('/toasts/view', $data);
        $this->load->view('footer');
    }

}

?>