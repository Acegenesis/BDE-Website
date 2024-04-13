<?php
function change_news_labels( $labels ) {
    $new_labels = array(
        'name'                  => 'News',
        'singular_name'         => 'News',
        'add_new'               => 'Ajouter une news',
        'add_new_item'          => 'Ajouter une news',
        'edit_item'             => 'Modifier la news',
        'new_item'              => 'Nouvelle news',
        'view_item'             => 'Voir la news',
        'search_items'          => 'Rechercher des news',
        'not_found'             => 'Aucunne news trouvée',
        'not_found_in_trash'    => 'Aucunne news trouvée dans la corbeille',
        'all_items'             => 'Toutes les news',
        'menu_name'             => 'News'
    );
    return $new_labels;
}
add_filter( 'post_type_labels_news', 'change_news_labels' );

// Changer le texte du champ de titre pour les news
function change_news_title_text( $title ) {
    $screen = get_current_screen();
    if ( $screen->post_type == 'news' ) {
        $title = 'Saisissez le nom de la news';
    }
    return $title;
}
add_filter( 'enter_title_here', 'change_news_title_text' );

// Déclaration du Custom Post Type pour les news
function custom_post_type_news() {
    $args = array(
        'public' => true,
        'label'  => 'News',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_menu' => false,
    );
    register_post_type( 'news', $args );
}
add_action( 'init', 'custom_post_type_news' );

function add_news_creator_column( $columns ) {
    // Supprimer la colonne du créateur existante
    unset( $columns['author'] );

    // Insérer une nouvelle colonne pour le créateur après la colonne du titre
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;
        if ( 'title' === $key ) {
            $new_columns['news_creator'] = 'Créateur';
            $new_columns['post_status'] = 'Statut';
        }
    }
    return $new_columns;
}
add_filter( 'manage_news_posts_columns', 'add_news_creator_column' );

// Afficher le créateur de l'événement dans la colonne personnalisée
function display_news_creator_column( $column, $post_id ) {
    if ( 'news_creator' === $column ) {
        $news_creator_id = get_post_field( 'post_author', $post_id );
        $news_creator = get_userdata( $news_creator_id );
        echo $news_creator->display_name;
    }
    if ( 'post_status' === $column ) {
        echo get_post_status( $post_id );
    }
}
add_action( 'manage_news_posts_custom_column', 'display_news_creator_column', 10, 2 );
?>