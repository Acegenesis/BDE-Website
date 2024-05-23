<?php
function change_partenaires_labels( $labels ) {
    $new_labels = array(
        'name'                  => 'Partenaires',
        'singular_name'         => 'Partenaire',
        'add_new'               => 'Ajouter un partenaire',
        'add_new_item'          => 'Ajouter un partenaire',
        'edit_item'             => 'Modifier le partenaire',
        'new_item'              => 'Nouveau partenaire',
        'view_item'             => 'Voir le partenaire',
        'search_items'          => 'Rechercher des partenaires',
        'not_found'             => 'Aucune partenaire trouvé',
        'not_found_in_trash'    => 'Aucune partenaire trouvé dans la corbeille',
        'all_items'             => 'Toutes les partenaires',
        'menu_name'             => 'Partenaire'
    );
    return $new_labels;
}
add_filter( 'post_type_labels_partenaires', 'change_partenaires_labels' );

// Changer le texte du champ de titre pour les partenaires
function change_partenaires_title_text( $title ) {
    $screen = get_current_screen();
    if ( $screen->post_type == 'partenaires' ) {
        $title = 'Saisissez le nom du partenaire';
    }
    return $title;
}
add_filter( 'enter_title_here', 'change_partenaires_title_text' );

// Déclaration du Custom Post Type pour les partenaires
function custom_post_type_partenaires() {
    $args = array(
        'public' => true,
        'publicly_queryable' => false,  // Ne pas rendre accessible via URL
        'label'  => 'Partenaires',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_menu' => false,
    );
    register_post_type( 'partenaires', $args );
}
add_action( 'init', 'custom_post_type_partenaires' );

function add_partenaires_creator_column( $columns ) {
    // Supprimer la colonne du créateur existante
    unset( $columns['author'] );

    // Insérer une nouvelle colonne pour le créateur après la colonne du titre
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;
        if ( 'title' === $key ) {
            $new_columns['partenaires_creator'] = 'Créateur';
            $new_columns['post_status'] = 'Statut';
        }
    }
    return $new_columns;
}
add_filter( 'manage_partenaires_posts_columns', 'add_partenaires_creator_column' );

// Afficher le créateur de l'événement dans la colonne personnalisée
function display_partenaires_creator_column( $column, $post_id ) {
    if ( 'partenaires_creator' === $column ) {
        $partenaires_creator_id = get_post_field( 'post_author', $post_id );
        $partenaires_creator = get_userdata( $partenaires_creator_id );
        echo $partenaires_creator->display_name;
    }
    if ( 'post_status' === $column ) {
        echo get_post_status( $post_id );
    }
}
add_action( 'manage_partenaires_posts_custom_column', 'display_partenaires_creator_column', 10, 2 );
?>