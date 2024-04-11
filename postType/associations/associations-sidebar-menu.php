<?php 
// Ajouter le menu "Associations" dans la sidebar
function custom_sidebar_menu_associations() {
    add_menu_page(
        'Associations',
        'Associations',
        'manage_options',
        'edit.php?post_type=associations',
        '',
        'dashicons-groups',
        2
    );
    add_submenu_page(
        'edit.php?post_type=associations',
        'Toutes les associations',
        'Toutes les associations',
        'manage_options',
        'edit.php?post_type=associations'
    );
    add_submenu_page(
        'edit.php?post_type=associations',
        'Ajouter une association',
        'Ajouter une association',
        'manage_options',
        'post-new.php?post_type=associations'
    );
}
add_action( 'admin_menu', 'custom_sidebar_menu_associations' );
?>