<?php
function change_event_labels( $labels ) {
    $new_labels = array(
        'name'                  => 'Événements',
        'singular_name'         => 'Événement',
        'add_new'               => 'Ajouter un événement',
        'add_new_item'          => 'Ajouter un événement',
        'edit_item'             => 'Modifier l\'événement',
        'new_item'              => 'Nouvel événement',
        'view_item'             => 'Voir l\'événement',
        'search_items'          => 'Rechercher des événements',
        'not_found'             => 'Aucun événement trouvé',
        'not_found_in_trash'    => 'Aucun événement trouvé dans la corbeille',
        'all_items'             => 'Tous les événements',
        'menu_name'             => 'Événements'
    );
    return $new_labels;
}
add_filter( 'post_type_labels_events', 'change_event_labels' );

// Déclaration du Custom Post Type pour les événements
function custom_post_type_events() {
    $args = array(
        'public' => true,
        'label'  => 'Événements',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_menu' => false,
    );
    register_post_type( 'events', $args );
}
add_action( 'init', 'custom_post_type_events' );

function add_event_creator_column( $columns ) {
    // Supprimer la colonne du créateur existante
    unset( $columns['author'] );

    // Insérer une nouvelle colonne pour le créateur après la colonne du titre
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;
        if ( 'title' === $key ) {
            $new_columns['event_creator'] = 'Créateur';
            $new_columns['post_status'] = 'Statut';
        }
    }
    return $new_columns;
}
add_filter( 'manage_events_posts_columns', 'add_event_creator_column' );

// Afficher le créateur de l'événement dans la colonne personnalisée
function display_event_creator_column( $column, $post_id ) {
    if ( 'event_creator' === $column ) {
        $event_creator_id = get_post_field( 'post_author', $post_id );
        $event_creator = get_userdata( $event_creator_id );
        echo $event_creator->display_name;
    }
    if ( 'post_status' === $column ) {
        echo get_post_status( $post_id );
    }
}
add_action( 'manage_events_posts_custom_column', 'display_event_creator_column', 10, 2 );
?>