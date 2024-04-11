<?php 
// Ajouter le menu "Événements" dans la sidebar
function custom_sidebar_menu() {
    add_menu_page(
        'Événements',
        'Événements',
        'manage_options',
        'edit.php?post_type=events',
        '',
        'dashicons-calendar-alt',
        2
    );
    add_submenu_page(
        'edit.php?post_type=events',
        'Tous les événements',
        'Tous les événements',
        'manage_options',
        'edit.php?post_type=events'
    );
    add_submenu_page(
        'edit.php?post_type=events',
        'Ajouter un événement',
        'Ajouter un événement',
        'manage_options',
        'post-new.php?post_type=events'
    );
}
add_action( 'admin_menu', 'custom_sidebar_menu' );
?>