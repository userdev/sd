<script type="text/javascript">
$(function() {
	$('a.game_gallery').lightBox({fixedNavigation:true});
});
</script>
</script>
<h3><?php echo $game->title; ?></h3>
<div class="game_container">
    <div id="game_description_one"> <?php echo $game->description; ?> </div>
    <iframe class ="sug_frype_one" height="20" width="84" frameborder="0" 
        src="http://www.draugiem.lv/say/ext/like.php?title=spēles svētkos&amp;url=<?php echo base_url("games/view/$game_ID"); ?> &amp;titlePrefix=Svētku dienai"></iframe>


<a href="https://twitter.com/share" class="twitter-share-button sug_twitter" data-url="<?php echo base_url("games/view/$game_ID"); ?>" data-text="Spēles svētkos" data-via="Svētkudienai.lv">Tweet</a>

</div>

<div id ="games_gallery">
<?php
foreach($pictures as $picture){
    ?> 
<a  class="game_gallery"  href="<?php echo $picture->link; ?>"><img src="<?php echo $picture->link; ?>" width="72" height="72" alt="Spēles bilde" /></a> 
<?php
}

?>
</div>