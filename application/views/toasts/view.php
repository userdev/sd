<div id = 'content'>

    <?php
    echo "<div id ='poem_container'>" . $toast->toast;
    echo "<div id = 'poem_author'>";
    ?>
</div>
<iframe class ="sug_frype_one" height="20" width="84" frameborder="0" 
        src="http://www.draugiem.lv/say/ext/like.php?title=tosti&amp;url=<?php echo base_url("toasts/view/$toast_ID"); ?> &amp;titlePrefix=Svētku dienai"></iframe>


<a href="https://twitter.com/share" class="twitter-share-button sug_twitter" data-url="<?php echo base_url("toasts/view/$toast_ID"); ?>" data-text="Tosts svētkos" data-via="Svētkudienai.lv">Tweet</a>

</div></div>