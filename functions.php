<?php
require_once ABSPATH . '/wp-admin/includes/taxonomy.php';

// -----------------------------------------------------------------------------
// Ajouter les librairies de style et de script dans le theme
function enqueue_styles() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'hamburger-style', get_template_directory_uri() . '/assets/css/hamburger.min.css' );
}

function enqueue_swiper() {
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/assets/css/swiper.css' );
    wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/assets/js/swiper.js');
}

function load_custom_wp_admin_style() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_style('admin-custom-css', get_template_directory_uri() . '/admin-style.css');
}
function add_google_fonts() {
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false );
}

function add_google_fonts_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}

add_action( 'wp_head', 'add_google_fonts_preconnect' );

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_swiper' );
add_action( 'wp_enqueue_scripts', 'add_google_fonts' );

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Ajouter des menus et les customiser
function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu' ),
        'footer-menu' => __( 'Footer Menu' )
      )
    );
}

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {}
    function end_lvl( &$output, $depth = 0, $args = null ) {}
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $output .= '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
    }
    function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

add_action( 'init', 'register_my_menus' );
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Supprimer le système de post basique de wordpress pour ajouter des customs
function remove_default_post_type() {
  remove_menu_page( 'edit.php' ); // Masquer la page des articles
}

add_action( 'admin_menu', 'remove_default_post_type' );
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Script pour ajourter dynamiquement tous les types disponibles dans le dossier
$post_types_dir = get_template_directory() . '/postType/';
$post_types = glob($post_types_dir . '*', GLOB_ONLYDIR);

foreach ($post_types as $post_type_dir) {
    // Inclure les fichiers dans chaque répertoire de type de post
    foreach (glob($post_type_dir . '/*.php') as $file) {
        require_once $file;
    }
}
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Ajouter les modèles de page personnalisé dynamiquement
function custom_template( $template ) {
    // Répertoire des modèles
    $template_directory = get_template_directory() . '/templates/single/';

    // Obtenir tous les fichiers single-*.php dans le répertoire des modèles
    $files = glob( $template_directory . 'single-*.php' );

    // Parcourir chaque fichier
    foreach ( $files as $file ) {
        // Extraire le nom du type de post à partir du nom de fichier
        $file_name = basename( $file );
        if ( preg_match( '/^single-(.+)\.php$/', $file_name, $matches ) ) {
            $post_type = $matches[1];

            // Vérifier si c'est un type de post singulier de ce type
            if ( is_singular( $post_type ) ) {
                return locate_template( "templates/single/{$file_name}" );
            }
        }
    }
    // Retourner le template par défaut si aucun modèle personnalisé n'est trouvé
    return $template;
}
add_filter( 'template_include', 'custom_template' );
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Fonction pour charger les événements supplémentaires via AJAX
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

add_action('wp_ajax_load_more_events', 'load_more_events');
add_action('wp_ajax_load_more_associations', 'load_more_associations');
add_action('wp_ajax_load_more_news', 'load_more_news');

add_action('wp_ajax_nopriv_load_more_events', 'load_more_events');
add_action('wp_ajax_nopriv_load_more_associations', 'load_more_associations');
add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Désactiver les commentaires sur les types de post
function disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Fermer les commentaires sur les articles existants
function disable_comments_status() {
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Masquer les sections de commentaires du tableau de bord
function disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

// Supprimer le menu des commentaires du tableau de bord
function disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Rediriger les utilisateurs essayant d'accéder aux pages des commentaires
function disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');
// -----------------------------------------------------------------------------

function my_theme_setup() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'my_theme_setup');


// Inclure les fichiers de personnalisation
require get_template_directory() . '/inc/customizer/customizer-settings.php';
require get_template_directory() . '/inc/customizer/customizer-page-general.php';
require get_template_directory() . '/inc/customizer/customizer-page-home.php';

// Ajouter la page de menu de personnalisation dans l'administration
function my_theme_customizer_menu() {
    add_menu_page(
        __('Paramètres theme', 'textdomain'), // Titre de la page
        __('Paramètres theme', 'textdomain'), // Titre du menu
        'manage_options', // Capacité requise
        'theme-customizer', // Slug de la page
        'my_theme_customizer_page', // Fonction de rappel
        'dashicons-admin-customizer', // Icône du menu
        61 // Position
    );

    add_submenu_page(
        'theme-customizer', // Slug du parent
        __('Général', 'textdomain'), // Titre de la page
        __('Général', 'textdomain'), // Titre du menu
        'manage_options', // Capacité requise
        'theme-customizer-general', // Slug de la page
        'my_theme_customizer_page' // Fonction de rappel
    );

    add_submenu_page(
        'theme-customizer', // Slug du parent
        __('Home', 'textdomain'), // Titre de la page
        __('Home', 'textdomain'), // Titre du menu
        'manage_options', // Capacité requise
        'theme-customizer-home', // Slug de la page
        'my_theme_customizer_page_home' // Fonction de rappel
    );
}
add_action('admin_menu', 'my_theme_customizer_menu');

function my_theme_remove_submenu() {
    remove_submenu_page('theme-customizer', 'theme-customizer');
}
add_action('admin_menu', 'my_theme_remove_submenu', 999);

// Vérifier les autorisations d'accès à la page de personnalisation du thème
function my_theme_customizer_capability_check() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.', 'textdomain'));
    }
}
add_action('admin_init', 'my_theme_customizer_capability_check');

function my_theme_customizer_enqueue() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'my_theme_customizer_enqueue');

?>