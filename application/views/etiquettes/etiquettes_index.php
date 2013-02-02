
<script type="text/javascript">   
    $(function() 
    { 
        $('.more').live("click",function() 
         
        {        
           
           
            var ID = $(this).attr("id");
            if(ID)
            {
                $("#more"+ID).html('<img id = "ajax_pic" src="/img/ajax-loader.gif" />');

                $.ajax({
                    type: "POST",
                    url: "/etiquettes/etiquettes_more_no_c",
                   
                    data: "lastmsg="+ ID,
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
</script>
<h3>Etiķetes</h3>
<div id = 'content'>
    <div class="timeline" id="updates">
<?php
foreach ($etiquettes as $etiquette) {
    if (!isset($etiquette->title)) {
       $flag = $etiquette->flag;
        continue;
    }
    ?> <div class="game_container"> <?php
    echo anchor("etiquettes/view/$etiquette->etiquette_ID", $etiquette->title, 'Skatīt rakstu');
    ?> 
        <div id="game_description_index"><?php echo mb_substr($etiquette->description,0,100,'UTF-8'); ?>... </div>
    </div> <?php
    $last_ID = $etiquette->etiquette_ID;
}
?>  
<?php 

if ($flag=='more') { ?>
        <div id="more<?php echo $last_ID; ?>" class="morebox">
            <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div></div>
        <?php } ?>
    
</div>
</div>
