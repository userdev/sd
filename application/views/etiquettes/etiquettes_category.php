
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
                    url: "/etiquettes/more_category_etiquettes",
                   
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
</script>

<h3> <?php echo $category->title; ?> </h3>
<div id = 'content'>
    <div class="timeline" id="updates">
<?php
foreach ($etiquettes as $etiquette) {
    if (!isset($etiquette->title)) {
       $flag = $etiquette->flag;
        continue;
    }
    ?> <div class="game_container"> <?php
    echo anchor("etiquettes/view/$etiquette->etiquette_ID", $etiquette->title, 'Skatīt spēli');
    ?> 
        <div id="game_description_index"><?php echo mb_substr($etiquette->description,0,100,'UTF-8'); ?>... </div>
    </div> <?php
    $last_ID = $etiquette->etiquette_ID;
}

?>  
        <input id ="comment" value="<?php echo $category->category_ID; ?>" type="hidden"></input>
<?php 

if ($flag=='more') { ?>
        <div id="more<?php echo $last_ID; ?>" class="morebox">
            <div  class="more" id="<?php echo $last_ID; ?>">Vairāk rezūltātus</div></div>
        <?php } ?>
    
</div>
</div>
