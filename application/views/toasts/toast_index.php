
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
                    url: "/more_results/toasts_more",
                   
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
            ?> <h3>Tosti</h3><?php
        foreach ($all_categories as $one_category) {
                ?> <div> <?php echo anchor("toasts/index/$one_category->url_title/$one_category->category_ID", $one_category->title);
                ?> </div> <?php }
            ?> <h3>Jaunākie tosti</h3> <?php
        foreach ($toasts as $toast) {
            echo "<div id ='poem_container'>" . $toast->toast;
            echo "<div id = 'poem_author'>";
                ?>
            </div>
            <a href=" <?php echo base_url("/toasts/view/$toast->toast_ID"); ?>">...</a>
           <iframe class ="sug_frype" height="20" width="84" frameborder="0" 
        src="http://www.draugiem.lv/say/ext/like.php?title=tosti&amp;url=<?php echo base_url("/toasts/view/$toast->toast_ID");?> &amp;titlePrefix=Svētku dienai"></iframe>



        </div>
        <?php
        $last_ID = $toast->toast_ID;
    }
} else {//Ja norādīta kura sadaļa jāatver
    foreach ($category_toasts as $toast) {
        echo "<div id ='poem_container'>" . $toast->toast;
       echo "<div id = 'poem_author'>";
        ?>
        </div> 
        <a href=" <?php echo base_url("/toasts/view/$toast->toast_ID"); ?>">...</a>
       <iframe class ="sug_frype" height="20" width="84" frameborder="0" 
        src="http://www.draugiem.lv/say/ext/like.php?title=tosti&amp;url=<?php echo base_url("/toasts/view/$toast->toast_ID");?> &amp;titlePrefix=Svētku dienai"></iframe>

</div> <?php
        $last_ID = $toast->toast_ID;
    }
}

if (isset($toasts) || ($category_toasts)) {
    ?>

    </div>
    <input id ="comment" value="<?php echo $category->category_ID; ?>" type="hidden"></input>
    <div id="more<?php echo $last_ID; ?>" class="morebox">
        <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div>
        <?php } else {
        ?>
        <a href="<?php echo base_url('toasts/add'); ?>">Pievienot jaunu</a> <?php } ?>
</div>

</div>
