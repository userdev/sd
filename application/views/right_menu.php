
<script type="text/javascript">      
  
    $(function() 
    {  
        $('.answer').live("click",function() 
         
        {        
            var poll_ID = $('#poll_ID').val();
           
            var ID = $(this).attr("id");
            if(ID)
            {   
                $("#more"+ID).html('<img id = "ajax_pic" src="/img/ajax-loader.gif" />');

                $.ajax({
                    type: "POST",
                    url: "/polls/vote",
                   
                    data: "ID="+ ID+"&poll_ID="+poll_ID,
                    cache: false,
                    success: function(html){
                        $("div#poll_question").append(html);
                        $(".answer").remove(); // removing old more button
                        $(".poll_answer_text").remove(); // removing old more button
                    }
                });
            }
            else
            {
                $(".morebox").html('The End');// no results
            }

            return false;
        });
    });
  
    
    
</script>

<div id="sidebar_container">
    <div class="sidebar">

    </div>
<? /*
    <div class="sidebar">
        <div class="sidebar_top"></div>
        <div class="sidebar_item">
            <?php
            foreach ($categories as $category) {
                switch ($category->type) {
                    case 't':
                        echo '<div>'.$category->title.'</div>';
                      
                       foreach($category->random_records as $random_record){
                           foreach($random_record as $record){
                             foreach($record as $toast_record){
                                 echo $toast_record->tost;}
                           }
                       // print_r($random_record);
                           //echo anchor("toasts/$random_record->toast_ID", mb_substr($random_record->toast, 0, 5, 'UTF-8'));
                       }
                        break;
                }
                
            }
            ?>

        </div>
        <div class="sidebar_base"></div>
    </div>
 * 
 */ 


if(isset($name_month)){

?>
    
     <div class="left_sidebar">
        <div class="sidebar_top"></div>
        <div class="sidebar_item">
            <!-- insert your sidebar items here -->
            <?php $date = getdate();
            $day = $date["mday"];
            ?>
            <h5>Šodien <?php echo $day . '. ' . $month; ?> vārda dienu svin</h5>
            <?php
            foreach ($name_month[0] as $name) {
                if ($name != '')
                    echo '<li>' . $name . '</li>';
            }
            ?>

        </div>
        <div class="sidebar_base"></div>
    </div><?php }?>
    
    <div class="sidebar">

        <div class="sidebar_top"></div>
        <div class="sidebar_item">

            <?php
            //print_r($categories);



            if ($poll->answer == 0) {//Ja nav nobalsojis
                ?><div id="poll_question"><h4><?php echo $poll->question; ?></h4></div>
                    <?php
                    echo form_open('polls/vote');
                    ?>
                <table border="0">
    <?php if ($poll->answer_1) { // 1 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_1", 1) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 1
                        );

                        echo "<div class='answer' id='1'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
                    <?php }//Beidzas pirmais atbilžu varinats ?>

    <?php if ($poll->answer_2) { // 2 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_2", 2) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 2
                        );

                        echo "<div class='answer' id='2'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
                    <?php }//Beidzas otrais atbilžu varinats ?>


    <?php if ($poll->answer_3) { // 3 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_3", 3) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 3
                        );

                        echo "<div class='answer' id='3'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
                    <?php }//Beidzas 3 atbilžu varinats ?>


    <?php if ($poll->answer_4) { // 4 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_4", 4) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 4
                        );

                        echo "<div class='answer' id='4'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
                    <?php }//Beidzas 4 atbilžu varinats ?>


    <?php if ($poll->answer_5) { // 5 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_5", 5) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 5
                        );

                        echo "<div class='answer' id='5'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
                    <?php }//Beidzas 5 atbilžu varinats ?>


    <?php if ($poll->answer_6) { // 6 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_6", 6) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 6
                        );

                        echo "<div class='answer' id='6'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
                    <?php }//Beidzas 6 atbilžu varinats  ?>



    <?php if ($poll->answer_7) { // 7 atbilžu varinats
        ?>
                        <tr>

                            <td><?php
        echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_7", 7) . '</span></div>';
        ?></td> 
                            <td><?php
                        $data = array(
                            'name' => 'answer',
                            'id' => 7
                        );

                        echo "<div class='answer' id='7'>" . form_radio($data) . '</div>';
                        ?></td>
                        </tr>
    <?php }//Beidzas 7 atbilžu varinats  ?>



                </table>

                <?php /*
                  if ($poll->answer_2) { // 2 atbilžu varinats
                  echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_2", 2) . '</span></div>';


                  $data = array(
                  'name' => 'answer',
                  'id' => 2
                  );

                  echo "<div class='answer' id='2'>" . form_radio($data) . '</div>';
                  }//Beidzas 2 atbilžu varinats

                  if ($poll->answer_3) { // 3 atbilžu varinats
                  echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_3", 3) . '</span></div>';


                  $data = array(
                  'name' => 'answer',
                  'id' => 3
                  );

                  echo "<div class='answer' id='3'>" . form_radio($data) . '</div>';
                  }//Beidzas 3 atbilžu varinats


                  if ($poll->answer_4) { // 4 atbilžu varinats
                  echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_4", 4) . '</span></div>';


                  $data = array(
                  'name' => 'answer',
                  'id' => 4
                  );

                  echo "<div class='answer' id='4'>" . form_radio($data) . '</div>';
                  }//Beidzas 4 atbilžu varinats


                  if ($poll->answer_5) { // 5 atbilžu varinats
                  echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_5", 5) . '</span></div>';


                  $data = array(
                  'name' => 'answer',
                  'id' => 5
                  );

                  echo "<div class='answer' id='5'>" . form_radio($data) . '</div>';
                  }//Beidzas 5 atbilžu varinats


                  if ($poll->answer_6) { // 6 atbilžu varinats
                  echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_6", 6) . '</span></div>';


                  $data = array(
                  'name' => 'answer',
                  'id' => 6
                  );

                  echo "<div class='answer' id='6'>" . form_radio($data) . '</div>';
                  }//Beidzas 6 atbilžu varinats



                  if ($poll->answer_7) { // 7 atbilžu varinats
                  echo "<div class='poll_answer_text'><span>" . form_label("$poll->answer_7", 7) . '</span></div>';


                  $data = array(
                  'name' => 'answer',
                  'id' => 7
                  );

                  echo "<div class='answer' id='7'>" . form_radio($data) . '</div>';
                  }//Beidzas 7 atbilžu varinats */
                ?> <input id ="poll_ID" value="<?php echo $poll->poll_ID; ?>" type="hidden"></input><?php
            echo form_close();
        } else {
            echo $poll->question;
                ?>
                <table border="0">
    <?php
    if ($poll->answer_1) {
        $percents = $one / $all_count * 100;
        ?>
                        <tr>
                            <td><?php echo $poll->answer_1; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
                    <?php } ?>


    <?php
    if ($poll->answer_2) {
        $percents = $two / $all_count * 100;
        ?>
                        <tr>
                            <td><?php echo $poll->answer_2; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
    <?php } ?>


                    <?php
                    if ($poll->answer_3) {
                        $percents = $three / $all_count * 100;
                        ?>
                        <tr>
                            <td><?php echo $poll->answer_3; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
    <?php } ?>

                    <?php
                    if ($poll->answer_4) {
                        $percents = $four / $all_count * 100;
                        ?>
                        <tr>
                            <td><?php echo $poll->answer_4; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
                    <?php } ?>

    <?php
    if ($poll->answer_5) {
        $percents = $five / $all_count * 100;
        ?>
                        <tr>
                            <td><?php echo $poll->answer_5; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
                    <?php } ?>


                    <?php
                    if ($poll->answer_6) {
                        $percents = $six / $all_count * 100;
                        ?>
                        <tr>
                            <td><?php echo $poll->answer_6; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
                    <?php } ?>

                    <?php
                    if ($poll->answer_7) {
                        $percents = $seven / $all_count * 100;
                        ?>
                        <tr>
                            <td><?php echo $poll->answer_7; ?></td>
                            <td><?php echo ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></td>
                        </tr>
                <?php }
                ?>

                </table> <?php
            /*
              if ($poll->answer_2) {
              $percents = $two / $all_count * 100;
              ?><div><?php echo $poll->answer_2 . ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></div><?php
              }
              if ($poll->answer_3) {
              $percents = $three / $all_count * 100;
              ?><div><?php echo $poll->answer_3 . ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></div><?php
              }
              if ($poll->answer_4) {
              $percents = $four / $all_count * 100;
              ?><div><?php echo $poll->answer_4 . ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></div><?php
              }
              if ($poll->answer_5) {
              $percents = $five / $all_count * 100;
              ?><div><?php echo $poll->answer_5 . ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></div><?php
              }
              if ($poll->answer_6) {
              $percents = $six / $all_count * 100;
              ?><div><?php echo $poll->answer_6 . ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></div><?php
              }
              if ($poll->answer_7) {
              $percents = $seven / $all_count * 100;
              ?><div><?php echo $poll->answer_7 . ' ' . "<img width ='$percents'  height = '10' src='/img/poll_left_c8.gif'/> " . number_format($percents, 0, '.', '') . '%'; ?></div><?php
              }
             */
        }
        echo "<div id ='poll_all_vote_count' >Kopā nobalsojuši $all_count lietotāji</div>";
            ?>




        </div>
        <div class="sidebar_base"></div>
    </div>

</div>