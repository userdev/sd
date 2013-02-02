<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Etiquettes extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Etiquettes_model');
    }

    public function index() {

        $head_data['head_active_page'] = 'e';
        $head_data['title'] = 'Etiķete svētkos';
        $this->load->view('header', $head_data);
        
        //visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Etiquettes_model->get_etiquetts_categories();
        $menu_data['active_page'] = 0; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $right_menu_data['name_month'] = $this->Etiquettes_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $right_menu_data['month'] = $this->Etiquettes_model->month_lv_name($month); //Mēneša latviskais nosaukums
        $right_menu_data += parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $this->load->view('/etiquettes/etiquettes_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        $data['etiquettes'] = $this->Etiquettes_model->get_last_etiquettes();
        $this->load->view('/etiquettes/etiquettes_index', $data);
        $this->load->view('footer');
    }

    public function add() {

        $head_data['head_active_page'] = 'e';
        $head_data['title'] = 'Etiķete svētkos';
        $this->load->view('header', $head_data);
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $data['etiquette']->title = '';
        $data['etiquette']->description = '';
        $data['categories'] = $this->Etiquettes_model->get_etiquetts_categories();
        foreach ($data['categories'] as $category)
            $category->checked = FALSE; //atzīmēju, ka neviena kategorija nav atķeksēta
        $data['yes_category'] = TRUE;

        $this->load->view('/etiquettes/add', $data);
        $this->load->view('footer');
    }

    public function takeadd() {
        $this->load->model('Pic_model');

        //Ievadlauku nosacījumi
        $this->form_validation->set_rules('title', 'Nosaukums', 'trim|required|min_length[5]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('description', 'Raksts', 'trim|required|xss_clean');
        //Visas kategorijas
        $data['categories'] = $this->Etiquettes_model->get_etiquetts_categories();
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

            $head_data['head_active_page'] = 'e';
            $head_data['title'] = 'Etiķete';
            $this->load->view('header', $head_data);
            $right_menu_data = parent::get_last_poll();
            $this->load->view('right_menu', $right_menu_data);
            $data['etiquette']->title = $this->input->post('title');
            $data['etiquette']->description = $this->input->post('description');

            $this->load->view('/etiquettes/add', $data);
            $this->load->view('footer');
        } else {

            //regard_ID->id norāda uz tikko sagalbāto ierastu
            $etiquette_ID = $this->Etiquettes_model->save_etiquette($this->input->post('title'), nl2br($this->input->post('description')));

            foreach ($data['categories'] as $category) {
                if ($category->checked == TRUE) //Visas atzīmētās kategorijas
                    $this->Etiquettes_model->save_etiquettes_categoty($etiquette_ID->id, $category->category_ID); //Saglabāju atzīmētās kategorijas
            }
            if ($this->input->post('1'))
                $this->Pic_model->save_pic($this->input->post('1'), $etiquette_ID->id, 'e');
            if ($this->input->post('2'))
                $this->Pic_model->save_pic($this->input->post('2'), $etiquette_ID->id, 'e');
            if ($this->input->post('3'))
                $this->Pic_model->save_pic($this->input->post('3'), $etiquette_ID->id, 'e');
            if ($this->input->post('4'))
                $this->Pic_model->save_pic($this->input->post('4'), $etiquette_ID->id, 'e');
            if ($this->input->post('5'))
                $this->Pic_model->save_pic($this->input->post('5'), $etiquette_ID->id, 'e');
            if ($this->input->post('6'))
                $this->Pic_model->save_pic($this->input->post('6'), $etiquette_ID->id, 'e');
            if ($this->input->post('7'))
                $this->Pic_model->save_pic($this->input->post('7'), $etiquette_ID->id, 'e');
            redirect('/etiquettes');
        }
    }

    public function category($url_title = ' ', $categoty_ID = 0) {
       
        if ($categoty_ID == 0)
            redirect('/etiquettes');

        $head_data['head_active_page'] = 'e';
        $head_data['title'] = 'Etiķete';
        $this->load->view('header', $head_data);
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);

        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Etiquettes_model->get_etiquetts_categories();
        $menu_data['active_page'] = $categoty_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $menu_data['name_month'] = $this->Etiquettes_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $menu_data['month'] = $this->Etiquettes_model->month_lv_name($month); //Mēneša latviskais nosaukums
        $this->load->view('/etiquettes/etiquettes_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        //Dati par atvērto kategoriju
        foreach ($menu_data['categories']as $category) {
            if ($category->category_ID == $categoty_ID) {
                $data['category']->title = $category->title;
                $data['category']->category_ID = $category->category_ID;
            }
        }
        //Spēles pēc kategorijas
        $data['etiquettes'] = $this->Etiquettes_model->get_etiquettes_by_category($categoty_ID);

        foreach ($data['etiquettes'] as $etiquette) {
            if (isset($etiquette->etiquette_ID)) {
                $etiquette_det = $this->Etiquettes_model->get_etiquette_by_ID($etiquette->etiquette_ID);
                $etiquette->title = $etiquette_det->title;
                $etiquette->description = $etiquette_det->description;
            }
        }

        $this->load->view('etiquettes/etiquettes_category', $data);
        $this->load->view('footer');
    }
    
    public function view($etiquette_ID = 0) {
        if ($etiquette_ID == 0)
            redirect('/etiquettes');
        
        $this->load->model('Pic_model');
        $head_data['head_active_page'] = 'e';
        $head_data['title'] = 'Etiķete';
        $this->load->view('header', $head_data);
        $data['etiquette'] = $this->Etiquettes_model->get_etiquette_by_ID($etiquette_ID);

        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Etiquettes_model->get_etiquetts_categories();
        $menu_data['active_page'] = $etiquette_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $menu_data['name_month'] = $this->Etiquettes_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $menu_data['month'] = $this->Etiquettes_model->month_lv_name($month); //Mēneša latviskais nosaukums
       // $this->load->view('/etiquettes/games_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        //Bildes par spēli 
        $data['pictures'] = $this->Pic_model->get_pictures($etiquette_ID, 'g');
        $data['etiquette_ID'] = $etiquette_ID;
        //right menu dati
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);

        $this->load->view('etiquettes/view', $data);

        $this->load->view('footer');
    }

    public function etiquettes_more_no_c() {

        $lastmsg = $this->input->post('lastmsg');
        $etiquettes = $this->Etiquettes_model->get_more_etiquettes($lastmsg);


        foreach ($etiquettes as $etiquette) {
            if (!isset($etiquette->title)) {
                $flag = $etiquette->flag;
                continue;
            }
           ?> <div class="game_container"> <?php
            echo anchor("etiquettes/view/$etiquette->etiquette_ID", $etiquette->title, 'Skatīt rakstu');
           ?> 
    <div id="game_description_index"><?php echo mb_substr($etiquette->description, 0, 100, 'UTF-8'); ?>... </div>
</div> <?php
            $last_ID = $etiquette->etiquette_ID;
        }
       ?>  
        <?php if ($flag == 'more') { ?>
            <div id="more<?php echo $last_ID; ?>" class="morebox">
                <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div></div>
        <?php } 
    }

    public function more_category_etiquettes() {
       
        $lastmsg = $this->input->post('lastmsg');
        $category_ID = $this->input->post('category_ID');

        $etiquettes = $this->Etiquettes_model->get_more_category_etiquettes($lastmsg, $category_ID);
       
        foreach ($etiquettes as $etiquette) {
            if (isset($etiquette->etiquette_ID)) {
            $etiquette_det = $this->Etiquettes_model->get_etiquette_by_ID($etiquette->etiquette_ID);
           
                $etiquette->title = $etiquette_det->title;
                 $etiquette->description = $etiquette_det->description;
            }
        }

        foreach ($etiquettes as $etiquette) {
            if (!isset($etiquette->title)) {
                $flag = $etiquette->flag;
                continue;
            }
            ?> <div class="game_container"> <?php
            echo anchor("etiquettes/view/$etiquette->etiquette_ID", $etiquette->title, 'Skatīt spēli');
            ?> 
                <div id="game_description_index"><?php echo mb_substr($etiquette->description, 0, 100, 'UTF-8'); ?>... </div>
            </div> <?php
            $last_ID = $etiquette->etiquette_ID;
        }
        ?>  
        <?php if ($flag == 'more') { ?>
            <div id="more<?php echo $last_ID; ?>" class="morebox">
                <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div></div>
            <?php } 
    }

}