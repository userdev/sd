<!DOCTYPE HTML>
<html>

    <head>
        <title><?php if (isset($title)) echo $title; ?></title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="<?php if (isset($search_words->search_words)) echo $search_words->search_words; ?>" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />       
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('/css/style.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('/css/jquery.lightbox-0.5.css'); ?>" />
        <script type="text/javascript" src="<?php echo base_url('/scripts/main.js'); ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo base_url('/scripts/jquery.js'); ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo base_url('/scripts/jquery.lightbox-0.5.js'); ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo base_url('/scripts/ddaccordion.js'); ?>"></script>
        <script type="text/javascript" src="http://www.draugiem.lv/api/api.js"></script>
        <link rel="icon" 
      type="image/png" 
      href="http://svetkudienai.lv/img/link.png" />
    </head>

    <body>
      
        <div id="main">
            <div id="header">
                <div id="logo">
                    <div id="logo_text">
                        <!-- class="logo_colour", allows you to change the colour of the text -->
                        <h1><a href="<?php echo base_url('/regards'); ?>" title ="Sākumlappa" >svētku<span class="logo_colour">dienai</span></a></h1>
                        <h2>Viss kas nepieciešams svētkos.</h2>
                    </div>
                </div>
                <div id="menubar">
                    <ul id="menu">
                        <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->

                        <?php if(!isset($head_active_page)) $head_active_page=''; ?>
                        <li  <?php if ($head_active_page == 'r') echo "class = 'selected'"; ?>><a href="<?php echo base_url('/regards'); ?>">Apsveikumi</a></li>
                        <li  <?php if ($head_active_page == 't') echo "class = 'selected'"; ?>><a href="<?php echo base_url('/toasts'); ?>">Tosti</a></li>
                        <li  <?php if ($head_active_page == 'g') echo "class = 'selected'"; ?>><a href="<?php echo base_url('/games'); ?>">Spēles/Rotaļas</a></li>
                        <li  <?php if ($head_active_page == 'e') echo "class = 'selected'"; ?>><a href="<?php echo base_url('/etiquettes'); ?>">Etiķete</a></li>
                        <!--
                        <li><a>Dziesmu vārdi</a></li>
                        <li><a>Spēles/Rotaļas</a></li>
                        -->
                    </ul>
                </div>
            </div>
               <div id="site_content">
  