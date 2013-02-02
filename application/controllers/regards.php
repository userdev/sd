<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Regards extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Regards_model');
    }

    /* Atvēr jaunākos vēlējumus un categorijas, ja nav parametru
     * @param string $category_name - kategorijas url nosaukums
     * @param int $category_ID  - kategorijas ID    
     */

    public function index($category_name = '', $category_ID = 0) {
        //Ja nav norādīts ID
        if ($category_name != '' && $category_ID == 0)
            $category_ID = $this->Regards_model->get_category_id_by_title($category_name); //Mēģiina sameklēt pēc nosaukuma ID 
        $head_data['search_words'] = $this->Regards_model->get_category_search_words($category_ID); //Atslēgas vārdi priekš head
        $head_data['head_active_page'] = 'r';
        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Regards_model->get_catagories();
        $menu_data['active_page'] = $category_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $right_menu_data['name_month'] = $this->Regards_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $right_menu_data['month'] = $this->Regards_model->month_lv_name($month); //Mēneša latviskais nosaukums
        /* foreach ($menu_data['categories'] as $category) { //Kategorijas nosaukums
          if ($category->category_ID == $category_ID)
          $head_data['title'] = 'Apsveikumi '.$category->title; //nosaukumu headam priekš page title

          } */
        if (!isset($head_data['title']))
            $head_data['title'] = 'Apsveikumi'; //ja nav atvērta neiena sadaļa uztādu page title 
        $this->load->view('header', $head_data); //Head skats ar datiem
        $right_menu_data += parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $this->load->view('/regards/regards_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        //Dati skatam kura kategorija   
        $data['category']->category_ID = $category_ID;
        //Ja norādīts categorijas nosaukums un ID       
        if ($category_name != '' && $category_ID != 0) {
            //Visi novēlējumu ID atilstošajai sadaļai
            $data['category_regards'] = $this->Regards_model->get_regards_by_category($category_ID);
            //Iegūstu informāciju par katru novēlējuma ID
            foreach ($data['category_regards'] as $categoty_regard) {
                $regard = $this->Regards_model->get_regard_by_ID($categoty_regard->regard_ID);

                $categoty_regard->poem = $regard->poem;
                $categoty_regard->author = $regard->author;
            }
        } else {//Ja nav norādis kura sadaļa jāatver
            //Visas kategorijas skatam
            $data['all_categories'] = $menu_data['categories'];
            //Pēdējie vēlējumi
            $data['regards'] = $this->Regards_model->get_last_regards();
        }
        $this->load->view('/regards/regards_index', $data);
        $this->load->view('footer');
    }

    public function add() {
        $head_data['head_active_page'] = 'r';
        $this->load->view('header', $head_data);
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $data['categories'] = $this->Regards_model->get_catagories();
        foreach ($data['categories'] as $category)
            $category->checked = FALSE; //atzīmēju, ka neviena kategorija nav atķeksēta
        $data['yes_category'] = TRUE;
        $data['regard']->poem = '';
        $data['regard']->author = '';
        $this->load->view('/regards/add', $data);
        $this->load->view('footer');
    }

    public function takeadd() {
        //Ievadlauku nosacījumi
        $this->form_validation->set_rules('poem', 'Dzejolis', 'trim|required|min_length[5]|max_length[50000]|xss_clean');
        $this->form_validation->set_rules('author', 'Autors', 'trim');
        //Visas kategorijas
        $data['categories'] = $this->Regards_model->get_catagories();
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
            // $this->load->view('right_menu'); //labās izvēlnes skats
            $data['regard']->poem = $this->input->post('poem');
            $data['regard']->author = $this->input->post('author');
            $this->load->view('/regards/add', $data);
            $this->load->view('footer');
        } else {

            //regard_ID->id norāda uz tikko sagalbāto ierastu
            $regard_ID = $this->Regards_model->save_regard(nl2br($this->input->post('poem')), $this->input->post('author'));

            foreach ($data['categories'] as $category) {
                if ($category->checked == TRUE) //Visas atzīmētās kategorijas
                    $this->Regards_model->save_regard_categoty($regard_ID->id, $category->category_ID); //Saglabāju atzīmētās kategorijas
            }
            redirect('/regards/add');
        }
    }

    public function view($regard_ID = 0) {
        $this->load->model('Category_sites');
        $head_data['head_active_page'] = 'r';
        $this->load->view('header', $head_data);
        if ($regard_ID == 0)
            redirect('/regards');
        $category_ID = $this->Regards_model->get_category_id_by_regard($regard_ID);
       
      
        //right menu data
      //  $right_menu_data = parent::category_links($category_ID[0]->category_ID, 'r');
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        //Menu data
        $menu_data['categories'] = $this->Regards_model->get_catagories();
        $menu_data['active_page'] = $category_ID[0]->category_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $menu_data['name_month'] = $this->Regards_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $menu_data['month'] = $this->Regards_model->month_lv_name($month); //Mēneša latviskais nosaukums
        foreach ($menu_data['categories'] as $category) { //Kategorijas nosaukums
            if ($category->category_ID == $category_ID)
                $head_data['title'] = $category->title; //nosaukumu headam priekš page title
        }
        $this->load->view('/regards/regards_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        $data['regard'] = $this->Regards_model->get_regard_by_ID($regard_ID);
        $data['regard_ID'] = $regard_ID;
        $this->load->view('/regards/view', $data);
        $this->load->view('footer');
    }

}