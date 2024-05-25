<!DOCTYPE html>
<html lang="fr">
<head <?php language_attributes(); ?>>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        if (is_single() || is_page()) {
            $meta_description = get_the_excerpt();
        } elseif (is_home() || is_front_page()) {
            $meta_description = get_bloginfo('description');
        } else {
            $meta_description = 'Description par défaut pour le site.';
        }
    ?>
    <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="header">
        <button class="hamburger hamburger--collapse" type="button" aria-label="Ouvrir le menu de navigation">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
        <a href="<?php echo home_url();?>" class="logos">
            <?php
                $main_logo = get_option('main_logo');
                if ($main_logo): 
            ?>
                <img id="logo" src="<?php echo $main_logo; ?>" alt="Logo du site 1">
            <?php endif; ?>
            <?php
                $secondary_logo = get_option('secondary_logo');
                if ($secondary_logo): 
            ?>
                <img id="logo_alt" src="<?php echo $secondary_logo; ?>" alt="Logo du site 2">
            <?php endif; ?>
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
            var pageHeight = document.documentElement.scrollHeight;
            var windowHeight = window.innerHeight;
            var scroll = window.scrollY;
            var header = document.getElementById('header');
            var newHeight = Math.min(scroll * 100 / (pageHeight - windowHeight), 100) + '%';
            header.style.setProperty('--after-height', newHeight);
        });
    </script>
    <main>
    