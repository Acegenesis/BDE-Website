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

require_once( get_template_directory() . '/postType/associations/associations-custom-post-type.php' );
require_once( get_template_directory() . '/postType/associations/associations-meta-boxes.php' );
require_once( get_template_directory() . '/postType/associations/associations-sidebar-menu.php' );

require_once( get_template_directory() . '/postType/news/news-custom-post-type.php' );
require_once( get_template_directory() . '/postType/news/news-meta-boxes.php' );
require_once( get_template_directory() . '/postType/news/news-sidebar-menu.php' );

// Ajouter un modèle de page personnalisé pour les événements
function custom_template( $template ) {
  if ( is_singular( 'events' ) ) {
      $custom_template = locate_template( '/templates/single/single-events.php' );
      if ( ! empty( $custom_template ) ) {
          return $custom_template;
      }
  }
  else if ( is_singular( 'associations' ) ) {
      $custom_template = locate_template( '/templates/single/single-associations.php' );
      if ( ! empty( $custom_template ) ) {
          return $custom_template;
      }
  }
  else if ( is_singular( 'news' ) ) {
      $custom_template = locate_template( '/templates/single/single-news.php' );
      if ( ! empty( $custom_template ) ) {
          return $custom_template;
      }
  }
  else {
      return $template;
  }
}
add_filter( 'template_include', 'custom_template' );

// Fonction pour charger les événements supplémentaires via AJAX
add_action('wp_ajax_load_more_events', 'load_more_events');
add_action('wp_ajax_nopriv_load_more_events', 'load_more_events');
function load_more_events() {
    $page = $_POST['page']; // Numéro de page

    // Calculez le décalage pour exclure les événements déjà affichés
    $offset = ($page - 1) * 4;

    $args = array(
        'post_type'      => 'events',
        'posts_per_page' => 4, // Nombre d'événements par page
        'paged'          => $page, // Page actuelle
        'offset'         => $offset, // Exclure les événements déjà affichés
        'order'          => 'DESC', // Ordre décroissant (du plus récent au plus ancien)
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <h3><?php echo get_post_meta( get_the_ID(), 'event_date', true ); ?></h3>    
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <?php
                    $slider_image = get_post_meta(get_the_ID(), 'slider_image', true);
                    if ($slider_image) :
                    ?>
                        <img src="<?php echo esc_url($slider_image); ?>" alt="<?php the_title(); ?>" />
                    <?php endif; ?>
                    <div class="more">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                        </svg>
                    </div>
                </a>
            </article>
            <?php
        endwhile;
        if( $page == $query->max_num_pages && $query->found_posts % 2 != 0 ) :
          ?>
          <article>
          </article>
        <?php
        endif;
        wp_reset_postdata();
    endif;

    wp_die(); // Arrêter l'exécution de PHP
}

// Fonction pour charger les associations supplémentaires via AJAX
add_action('wp_ajax_load_more_associations', 'load_more_associations');
add_action('wp_ajax_nopriv_load_more_associations', 'load_more_associations');
function load_more_associations() {
    $page = $_POST['page']; // Numéro de page

    // Calculez le décalage pour exclure les associations déjà affichés
    $offset = ($page - 1) * 4;

    $args = array(
        'post_type'      => 'associations',
        'posts_per_page' => 4, // Nombre d'associations par page
        'paged'          => $page, // Page actuelle
        'offset'         => $offset, // Exclure les associations déjà affichés
        'order'          => 'DESC', // Ordre décroissant (du plus récent au plus ancien)
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <?php
                    $slider_image = get_post_meta(get_the_ID(), 'logo_image', true);
                    if ($slider_image) :
                    ?>
                        <img src="<?php echo esc_url($slider_image); ?>" alt="<?php the_title(); ?>" />
                    <?php endif; ?>
                    <div class="more">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                        </svg>
                    </div>
                </a>
            </article>
            <?php
        endwhile;
        if( $page == $query->max_num_pages && $query->found_posts % 2 != 0 ) :
          ?>
          <article>
          </article>
        <?php
        endif;
        wp_reset_postdata();
    endif;

    wp_die(); // Arrêter l'exécution de PHP
}

// Fonction pour charger les news supplémentaires via AJAX
add_action('wp_ajax_load_more_news', 'load_more_news');
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');
function load_more_news() {
    $page = $_POST['page']; // Numéro de page

    // Calculez le décalage pour exclure les news déjà affichés
    $offset = ($page - 1) * 4;

    $args = array(
        'post_type'      => 'news',
        'posts_per_page' => 4, // Nombre de news par page
        'paged'          => $page, // Page actuelle
        'offset'         => $offset, // Exclure les news déjà affichés
        'order'          => 'DESC', // Ordre décroissant (du plus récent au plus ancien)
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <?php
                    $slider_image = get_post_meta(get_the_ID(), 'slider_image', true);
                    if ($slider_image) :
                    ?>
                        <img src="<?php echo esc_url($slider_image); ?>" alt="<?php the_title(); ?>" />
                    <?php endif; ?>
                    <div class="more">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                        </svg>
                    </div>
                </a>
            </article>
            <?php
        endwhile;
        if( $page == $query->max_num_pages && $query->found_posts % 2 != 0 ) :
          ?>
          <article>
          </article>
        <?php
        endif;
        wp_reset_postdata();
    endif;

    wp_die(); // Arrêter l'exécution de PHP
}

?>