<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?php wp_title(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="header">
        <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
        <a href="<?php echo home_url();?>" class="logos">
            <img id="logo" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/logo.png" alt="Logo du site">
            <img id="logo_alt" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/logo_alt.png" alt="Logo du site">
        </a>
    </header>
    <nav id="nav">
        <div class="presentation">
            <h2><?php bloginfo('description'); ?></h2>
            <h1><?php bloginfo('name'); ?></h1>
        </div>
        <ul>
            <?php
                wp_nav_menu( array(
                'theme_location' => 'header-menu',
                'menu_id'        => 'header-menu',
                'walker'         => new Custom_Walker_Nav_Menu(),
                'container'      => false,
                'items_wrap'     => '%3$s',
                ) );
            ?>
        </ul>
    </nav>
    <script>
        var hamburger = document.querySelector(".hamburger");
        var nav = document.querySelector("#nav");
        var header = document.querySelector("#header");
        hamburger.addEventListener("click", function() {
            hamburger.classList.toggle("is-active");
            nav.classList.toggle("is-active");
            header.classList.toggle("is-active");
        });
        window.addEventListener('scroll', function() {
            var pageHeight = document.body.scrollHeight;
            var scroll = window.scrollY;
            var header = document.getElementById('header');
            var newHeight = scroll * 100 / pageHeight + scroll - 50  + 'px';
            header.style.setProperty('--after-height', newHeight);
        });
    </script>
    <main>
    