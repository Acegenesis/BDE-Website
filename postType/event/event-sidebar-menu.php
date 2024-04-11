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
}
add_action( 'admin_menu', 'custom_sidebar_menu' );
?>