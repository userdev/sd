<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" src="/scripts/jquery.form.js"></script>
<script type="text/javascript" >
    var i=1;
    $(document).ready(function() { 
	
       
        $('#photoimg').live('change', function(){ 
         
            $("#preview").html('');
            $("#preview").html('<img src="/img/loader.gif" alt="Uploading...."/>');
            $("#imageform").ajaxForm({	
                target: '#preview'+i
              
            }).submit(); 
            $(".img_count").remove(); 
            $("<input>").attr('name','img_count').attr('type','hidden').attr('value',i).attr('class','img_count').appendTo('#photoimg');
            i++;
        
        });
    }); 
     
</script>


<div id = 'content'>
    <h2>Pievienot spēli/rotaļu</h2>
    <div class ='form_settings'>
        <?php echo form_open('games/takeadd'); ?>

        <p>
            <?php
            echo form_error('title');
            echo '<span>' . form_label('Nosaukms', 'title') . '</span>';

            $data = array(
                'name' => 'title',
                'id' => 'title',
                'maxlength' => '255',
                'value' => $game->title
            );

            echo form_input($data);
            ?>
        </p>


        <p>
            <?php
            echo form_error('description');
            echo '<span>' . form_label('Apraksts', 'description') . '</span>';


            $data = array(
                'name' => 'description',
                'id' => 'description',
                'maxlength' => '50000',
                'value' => $game->description
            );

            echo form_textarea($data);
            ?>
        </p>



        <p>
            <?php
            if (isset($category_error)) //Ja nav norāditā kategorija ir padota kļudas ziņa
                echo '<div>' . $category_error . '</div>';
            echo '<span>' . form_label('Kategorija', 'category') . '</span>';
            if ($defult_category == 0) //Ja nav norādīta kura kategorija 0 -defultā
                echo form_dropdown('category', $categories_drop, 0);
            else //Norādita kura kategorija bija norādīta
                echo form_dropdown('category', $categories_drop, $defult_category);
            ?>

        </p>

        <div id="images_add">
            <div id='preview1'>
            </div>   
            <div id='preview2'>
            </div>  
            <div id='preview3'>
            </div>  
            <div id='preview4'>
            </div>  
            <div id='preview5'>
            </div>  
            <div id='preview6'>
            </div>  
            <div id='preview7'>
            </div>  
        </div>




        <?php
        $data = array(
            'name' => 'save',
            'class' => 'submit',
            'value' => 'pievienot',
            'id' => 'submit_img'
        );


        echo form_submit($data);
        echo form_close();
        ?>

        <p> <?php echo '<span>' . form_label('Pievienot bildes', 'picture') . '</span>'; ?>
        <form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo base_url('/more_results/ajax_pic'); ?>'>
            <input type="file" name="photoimg" id="photoimg" />

            </p> 
        </form>




    </div>
</div>
