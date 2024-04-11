<?php
require_once ABSPATH . '/wp-admin/includes/taxonomy.php';

function enqueue_styles() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'hamburger-style', get_template_directory_uri() . '/assets/css/hamburger.min.css' );
}

function enqueue_swiper() {
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/assets/css/swiper.css' );
    wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/assets/js/swiper.js');
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_swiper' );


function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu' ),
        'footer-menu' => __( 'Footer Menu' )
      )
    );
  }

add_action( 'init', 'register_my_menus' );

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {}
    function end_lvl( &$output, $depth = 0, $args = null ) {}
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
      $output .= '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
    }
    function end_el( &$output, $item, $depth = 0, $args = null ) {}
  }

function add_google_fonts() {
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false );
}
add_action( 'wp_enqueue_scripts', 'add_google_fonts' );

function add_google_fonts_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action( 'wp_head', 'add_google_fonts_preconnect' );

function remove_default_post_type() {
  remove_menu_page( 'edit.php' ); // Masquer la page des articles
}
add_action( 'admin_menu', 'remove_default_post_type' );

require_once( get_template_directory() . '/postType/event/event-custom-post-type.php' );
require_once( get_template_directory() . '/postType/event/event-meta-boxes.php' );
require_once( get_template_directory() . '/postType/event/event-sidebar-menu.php' );

?>
