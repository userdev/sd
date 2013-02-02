<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Games extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Games_model');
    }

    //Spēļu sadaļa, kad nav izvēlēta neviena spēle
    public function index() {
        
        $head_data['head_active_page'] = 'g';
        $head_data['title'] = 'Spēles/Rotaļas';
        $this->load->view('header', $head_data);
        

        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Games_model->get_catagories();
        $menu_data['active_page'] = 0; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $right_menu_data['name_month'] = $this->Games_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $right_menu_data['month'] = $this->Games_model->month_lv_name($month); //Mēneša latviskais nosaukums
        $this->load->view('/games/games_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        $right_menu_data += parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $data['games'] = $this->Games_model->get_last_games();
        $this->load->view('games/games_index', $data);

        $this->load->view('footer');
    }

    public function category($url_title = ' ', $categoty_ID = 0) {
        if ($categoty_ID == 0)
            redirect('/games');
        
        $head_data['head_active_page'] = 'g';
        $head_data['title'] = 'Spēles/Rotaļas';
        $this->load->view('header', $head_data);
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);

        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Games_model->get_catagories();
        $menu_data['active_page'] = $categoty_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $menu_data['name_month'] = $this->Games_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $menu_data['month'] = $this->Games_model->month_lv_name($month); //Mēneša latviskais nosaukums
        $this->load->view('/games/games_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        //Dati par atvērto kategoriju
        foreach ($menu_data['categories']as $category) {
            if ($category->category_ID == $categoty_ID) {
                $data['category']->title = $category->title;
                $data['category']->category_ID = $category->category_ID;
            }
        }
        //Spēles pēc kategorijas
        $data['games'] = $this->Games_model->get_games_by_category($categoty_ID);
        $this->load->view('games/games_category', $data);
        $this->load->view('footer');
    }

    public function view($game_ID = 0) {
        if ($game_ID == 0)
            redirect('/games');
        
        $this->load->model('Pic_model');
        $head_data['head_active_page'] = 'g';
        $head_data['title'] = 'Spēles/Rotaļas';
        $this->load->view('header', $head_data);
        $data['game'] = $this->Games_model->get_game_by_ID($game_ID);

        //Visu novēlējumu kategorjas
        $menu_data['categories'] = $this->Games_model->get_catagories();
        $menu_data['active_page'] = $data['game']->category_ID; //atvērtā kategorija
        //Noskaidro kas šodien svin vārdadienu
        $menu_data['name_month'] = $this->Games_model->name_days();
        $date = getdate(); //datums
        $month = $date["mon"]; //mēnesis
        $menu_data['month'] = $this->Games_model->month_lv_name($month); //Mēneša latviskais nosaukums
        $this->load->view('/games/games_left_menu', $menu_data); //Padodu datus kreisajai izvēlnei, kur ir kategoriju izvēlne
        //Bildes par spēli 
        $data['pictures'] = $this->Pic_model->get_pictures($game_ID, 'g');
        $data['game_ID'] = $game_ID;
        //right menu dati
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);

        $this->load->view('games/view', $data);

        $this->load->view('footer');
    }

    public function add() {

        $head_data['head_active_page'] = 'g';
        $head_data['title'] = 'Spēles/Rotaļas';
        $this->load->view('header', $head_data);
        $right_menu_data = parent::get_last_poll();
        $this->load->view('right_menu', $right_menu_data);
        $data['game']->title = '';
        $data['game']->description = '';
        $data['categories'] = $this->Games_model->get_catagories();
        foreach ($data['categories'] as $category) { //Sagatavoju datus prieks dropdowna
            $categories_array[$category->category_ID] = $category->title;
        }
        $categories_array[0] = 'Izvēlēties vienu';
        $data['defult_category'] = 0;
        $data['categories_drop'] = $categories_array;
        $this->load->view('/games/add', $data);
        $this->load->view('footer');
    }

    public function takeadd() {
        $this->load->model('Pic_model');
        //Ievadlauku nosacījumi
        $this->form_validation->set_rules('title', 'Nosaukums', 'trim|required|min_length[5]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('description', 'Apraksts', 'trim|required||max_length[10000]|xss_clean');
        //Ja nav izpildījušies ievadlauku nosacījumi
        if ($this->form_validation->run() == FALSE || $this->input->post('category') == 0) {
            $head_data['head_active_page'] = 'g';
            $this->load->view('header', $head_data);
            $right_menu_data = parent::get_last_poll();
            $this->load->view('right_menu', $right_menu_data);
            $data['game']->title = '';
            $data['game']->description = '';
            $data['categories'] = $this->Games_model->get_catagories();
            foreach ($data['categories'] as $category) { //Sagatavoju datus prieks dropdowna
                $categories_array[$category->category_ID] = $category->title;
            }
            $categories_array['no_selected'] = 'Izvēlēties vienu';
            $data['defult_category'] = $this->input->post('category'); //Kategorija kura tika atķeksēta
            $data['categories_drop'] = $categories_array;
            if ($this->input->post('category') == 0)
                $data['category_error'] = 'Izvēlieties kategoriju';
            $this->load->view('/games/add', $data);
            $this->load->view('footer');
        }
        else {
            $id = $this->Games_model->save_game($this->input->post('title'), nl2br($this->input->post('description')), $this->input->post('category'));
            if ($this->input->post('1'))
                $this->Pic_model->save_pic($this->input->post('1'), $id->id, 'g');
            if ($this->input->post('2'))
                $this->Pic_model->save_pic($this->input->post('2'), $id->id, 'g');
            if ($this->input->post('3'))
                $this->Pic_model->save_pic($this->input->post('3'), $id->id, 'g');
            if ($this->input->post('4'))
                $this->Pic_model->save_pic($this->input->post('4'), $id->id, 'g');
            if ($this->input->post('5'))
                $this->Pic_model->save_pic($this->input->post('5'), $id->id, 'g');
            if ($this->input->post('6'))
                $this->Pic_model->save_pic($this->input->post('6'), $id->id, 'g');
            if ($this->input->post('7'))
                $this->Pic_model->save_pic($this->input->post('7'), $id->id, 'g');
            redirect('/games');
        }
    }

    public function games_more_no_c() {

        $lastmsg = $this->input->post('lastmsg');
        $games = $this->Games_model->get_more_games($lastmsg);


        foreach ($games as $game) {
            if (!isset($game->title)) {
                $flag = $game->flag;
                continue;
            }
            ?> <div class="game_container"> <?php
            echo anchor("games/view/$game->game_ID", $game->title, 'Skatīt spēli');
            ?> 
                <div id="game_description_index"><?php echo mb_substr($game->description, 0, 100, 'UTF-8'); ?>... </div>
            </div> <?php
            $last_ID = $game->game_ID;
        }
        ?>  
        <?php if ($flag == 'more') { ?>
            <div id="more<?php echo $last_ID; ?>" class="morebox">
                <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div></div>
        <?php } ?>


        <?php
    }

    public function more_category_games() {

        $lastmsg = $this->input->post('lastmsg');
        $category_ID = $this->input->post('category_ID');
        $games = $this->Games_model->get_more_category_games($lastmsg, $category_ID);


        foreach ($games as $game) {
            if (!isset($game->title)) {
                $flag = $game->flag;
                continue;
            }
            ?> <div class="game_container"> <?php
            echo anchor("games/view/$game->game_ID", $game->title, 'Skatīt spēli');
            ?> 
                <div id="game_description_index"><?php echo mb_substr($game->description, 0, 100, 'UTF-8'); ?>... </div>
            </div> <?php
            $last_ID = $game->game_ID;
        }
        ?>  
        <?php if ($flag == 'more') { ?>
            <div id="more<?php echo $last_ID; ?>" class="morebox">
                <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div></div>
            <?php } ?>


        <?php
    }

}