<?php
function change_associations_labels( $labels ) {
    $new_labels = array(
        'name'                  => 'Associations',
        'singular_name'         => 'Association',
        'add_new'               => 'Ajouter une association',
        'add_new_item'          => 'Ajouter une association',
        'edit_item'             => 'Modifier l\'association',
        'new_item'              => 'Nouvelle association',
        'view_item'             => 'Voir l\'association',
        'search_items'          => 'Rechercher des associations',
        'not_found'             => 'Aucune association trouvée',
        'not_found_in_trash'    => 'Aucune association trouvée dans la corbeille',
        'all_items'             => 'Toutes les associations',
        'menu_name'             => 'Associations'
    );
    return $new_labels;
}
add_filter( 'post_type_labels_associations', 'change_associations_labels' );

// Changer le texte du champ de titre pour les associations
function change_associations_title_text( $title ) {
    $screen = get_current_screen();
    if ( $screen->post_type == 'associations' ) {
        $title = 'Saisissez le nom de l\'association';
    }
    return $title;
}
add_filter( 'enter_title_here', 'change_associations_title_text' );

// Déclaration du Custom Post Type pour les événements
function custom_post_type_associations() {
    $args = array(
        'public' => true,
        'label'  => 'Associations',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_menu' => false,
    );
    register_post_type( 'associations', $args );
}
add_action( 'init', 'custom_post_type_associations' );

function add_associations_creator_column( $columns ) {
    // Supprimer la colonne du créateur existante
    unset( $columns['author'] );

    // Insérer une nouvelle colonne pour le créateur après la colonne du titre
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;
        if ( 'title' === $key ) {
            $new_columns['associations_creator'] = 'Créateur';
            $new_columns['post_status'] = 'Statut';
        }
    }
    return $new_columns;
}
add_filter( 'manage_associations_posts_columns', 'add_associations_creator_column' );

// Afficher le créateur de l'événement dans la colonne personnalisée
function display_associations_creator_column( $column, $post_id ) {
    if ( 'associations_creator' === $column ) {
        $event_creator_id = get_post_field( 'post_author', $post_id );
        $event_creator = get_userdata( $event_creator_id );
        echo $event_creator->display_name;
    }
    if ( 'post_status' === $column ) {
        echo get_post_status( $post_id );
    }
}
add_action( 'manage_associations_posts_custom_column', 'display_associations_creator_column', 10, 2 );
?>