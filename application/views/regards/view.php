<div id = 'content'>

    <?php
   
    echo "<div id ='poem_container'>" . $regard->poem;
    echo "<div id = 'poem_author'>" . $regard->author;
    ?>
</div>
<iframe class ="sug_frype_one" height="20" width="84" frameborder="0" 
        src="http://www.draugiem.lv/say/ext/like.php?title=apsveikumi&amp;url=<?php echo base_url("regards/view/$regard_ID"); ?> &amp;titlePrefix=Svētku dienai"></iframe>


<a href="https://twitter.com/share" class="twitter-share-button sug_twitter" data-url="<?php echo base_url("regards/view/$regard_ID"); ?>" data-text="Apsveikums" data-via="Svētkudienai.lv">Tweet</a>

</div></div>