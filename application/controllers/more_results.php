<?php

class More_results extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
      public function ajax_more() {


      if ($this->input->post('lastmsg')) {
      $lastmsg = $this->input->post('lastmsg');
      $lastmsg = mysql_real_escape_string($lastmsg);

      $result = mysql_query("select * from messages where msg_id<'$lastmsg' order by msg_id desc limit 1");
      while ($row = mysql_fetch_array($result)) {
      $msg_id = $row['msg_id'];
      $message = $row['message'];
      ?>
      <li>
      <?php echo $message; ?>
      </li>
      <?php
      }
      ?>


      <div id="more<?php echo $msg_id; ?>" class="morebox">
      <a href="#" id="<?php echo $msg_id; ?>" class="more">more</a>
      </div>
      <?php
      }
      }
     */

    public function toasts_more() {
        $this->load->model('Toasts_model');

        if ($this->input->post('lastmsg') && $this->input->post('category_ID') != 0) {
            $lastmsg = $this->input->post('lastmsg');

            $category_toasts = $this->Toasts_model->category_toasts($this->input->post('category_ID'), $lastmsg);
        } else if ($this->input->post('lastmsg')) {
            $lastmsg = $this->input->post('lastmsg');
            $category_toasts = $this->Toasts_model->get_more_toasts($lastmsg);
        }


        foreach ($category_toasts as $toast) {
            if (isset($toast->toast_ID)) {
                $toast_show = $this->Toasts_model->get_toast_by_ID($toast->toast_ID);
                echo "<div id ='poem_container'>" . $toast_show->toast;

                echo "<div id = 'poem_author'></div>";
                ?><a href=" <?php echo base_url("/toasts/view/$toast->toast_ID"); ?>">...</a>
                <iframe class ="sug_frype" height="20" width="84" frameborder="0" 
                        src="http://www.draugiem.lv/say/ext/like.php?title=tosti&amp;url=<?php echo base_url("toasts/view/$toast->toast_ID"); ?> &amp;titlePrefix=Svētku dienai"></iframe>


                </div> <?php
                $last_ID = $toast->toast_ID;
            }
        }




        /*
          $results = $this->Regards_model->get_more_regards($lastmsg);
          foreach ($results as $result) {
          echo "<div id ='poem_container'>" . $result->poem;
          echo "<div id = 'poem_author'>".$result->author.'</div></div>';
          $last_ID = $result->regard_ID;
          } */
        if ($category_toasts[20]->flag != 'less') {
            ?>


            <div id="more<?php echo $last_ID; ?>" class="morebox">
                <div  class="more"  id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div>
            </div>
            <?php
        }
    }

    public function ajax_more() {
        $this->load->model('Regards_model');

        if ($this->input->post('lastmsg') && $this->input->post('category_ID') != 0) {
            $lastmsg = $this->input->post('lastmsg');

            $category_regards = $this->Regards_model->category_regards($this->input->post('category_ID'), $lastmsg);
        } else if ($this->input->post('lastmsg')) {
            $lastmsg = $this->input->post('lastmsg');
            $category_regards = $this->Regards_model->get_more_regards($lastmsg);
        }
        foreach ($category_regards as $regard) {
            if (isset($regard->regard_ID)) {
                $regard_show = $this->Regards_model->get_regard_by_ID($regard->regard_ID);
                echo "<div id ='poem_container'>" . $regard_show->poem;
                if (isset($regard_show->author))
                    echo "<div id = 'poem_author'>" . $regard_show->author . '</div>';
                ?><a href=" <?php echo base_url("/regards/view/$regard->regard_ID"); ?>">...</a>
                <iframe class ="sug_frype" height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=apsveikumi&amp;url=<?php echo base_url("regards/view/$regard->regard_ID"); ?> &amp;titlePrefix=Svētku dienai"></iframe>
                </div> <?php
                $last_ID = $regard->regard_ID;
            }
        }




        /*
          $results = $this->Regards_model->get_more_regards($lastmsg);
          foreach ($results as $result) {
          echo "<div id ='poem_container'>" . $result->poem;
          echo "<div id = 'poem_author'>".$result->author.'</div></div>';
          $last_ID = $result->regard_ID;
          } */
        if ($category_regards[20]->flag != 'less') {
            ?>


            <div id="more<?php echo $last_ID; ?>" class="morebox">
                <div  class="more"  id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div>
            </div>
            <?php
        }
    }

    public function ajax_pic() {

        $session_id = '1'; // User session id
        $path = "uploads/";
        $img_count = $this->input->post('img_count');
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];
            if (strlen($name)) {
                list($txt, $ext) = explode(".", $name);
                if (in_array($ext, $valid_formats)) {
                    if ($size < (1024 * 1024)) { // Image size max 1 MB
                        $actual_image_name = time() . $session_id . "." . $ext;
                        $tmp = $_FILES['photoimg']['tmp_name'];
                        if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                            //  mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
                            // $this->Pic_model->save_pic(base_url("uploads/$actual_image_name"));
                            ?> <img src="<?php echo base_url("uploads/$actual_image_name"); ?>" class ="preview" >
                            <input type="hidden" name="<?php echo $img_count; ?>" value="<?php echo base_url("uploads/$actual_image_name"); ?>" />
                            <?php
                        }
                        else
                            echo "failed";
                    }
                    else
                        echo "Image file size max 1 MB";
                }
                else
                    echo "Invalid file format..";
            }
            else
                echo "Please select image..!";
            exit;
        }
    }

}

