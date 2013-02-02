
<script type="text/javascript">      
   
    $(function() 
    { 
        $('.more').live("click",function() 
         
        {        
            var comment = $('#comment').val();
           
            var ID = $(this).attr("id");
            if(ID)
            {
                $("#more"+ID).html('<img id = "ajax_pic" src="/img/ajax-loader.gif" />');

                $.ajax({
                    type: "POST",
                    url: "/more_results/ajax_more",
                   
                    data: "lastmsg="+ ID+"&category_ID="+comment,
                    cache: false,
                    success: function(html){
                        $("div#updates").append(html);
                        $("#more"+ID).remove(); // removing old more button
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
  
    function DraugiemSay( title, url, titlePrefix ){
        window.open(
        'http://www.draugiem.lv/say/ext/add.php?title=' + encodeURIComponent( title ) +
            '&link=' + encodeURIComponent( url ) +
            ( titlePrefix ? '&titlePrefix=' + encodeURIComponent( titlePrefix ) : '' ),
        '',
        'location=1,status=1,scrollbars=0,resizable=0,width=530,height=400'
    );
        return false;
    }
    
</script>
<div id = 'content'>
    <div class="timeline" id="updates">





        <?php
        $last_ID = 0;
        //Ja nav norādīta kura sadaļa jāatver
        if ($category->category_ID == 0) {
            ?> <h3>Novēlējumu tēmas </h3><?php
        foreach ($all_categories as $one_category) {
                ?> <div> <?php echo anchor("regards/index/$one_category->url_title/$one_category->category_ID", $one_category->title);
                ?> </div> <?php }
            ?> <h3>Jaunākie novēlējumi</h3> <?php
        foreach ($regards as $regard) {
            echo "<div id ='poem_container'>" . $regard->poem;
            echo "<div id = 'poem_author'>" . $regard->author;
                ?>
            </div>
            <a href=" <?php echo base_url("/regards/view/$regard->regard_ID"); ?>">...</a>
            <iframe class ="sug_frype" height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=vēlējums&amp;url=<?php echo base_url("regards/view/$regard->regard_ID"); ?>  &amp;titlePrefix=Svētku dienai"></iframe>


        </div>
        <?php
        $last_ID = $regard->regard_ID;
    }
} else {//Ja norādīta kura sadaļa jāatver
    foreach ($category_regards as $regard) {
        echo "<div id ='poem_container'>" . $regard->poem;
        echo "<div id = 'poem_author'>" . $regard->author;
        ?>
        </div> 
        <a href=" <?php echo base_url("/regards/view/$regard->regard_ID"); ?>">...</a>
        <iframe class ="sug_frype" height="20" width="84" frameborder="0" src="http://www.draugiem.lv/say/ext/like.php?title=apsveikumi&amp;url=<?php echo base_url("regards/view/$regard->regard_ID"); ?> &amp;titlePrefix=Svētku dienai"></iframe>
        </div> <?php
        $last_ID = $regard->regard_ID;
    }
}

if (isset($regards) || ($category_regards)) {
    ?>

    </div>
    <input id ="comment" value="<?php echo $category->category_ID; ?>" type="hidden"></input>
    <div id="more<?php echo $last_ID; ?>" class="morebox">
        <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div>
        <?php } else {
        ?>
        <a href="<?php echo base_url('regards/add'); ?>">Pievienot jaunu</a> <?php } ?>
</div>

</div>
