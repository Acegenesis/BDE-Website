<?php 
// Ajouter le menu "Partenaires" dans la sidebar
function custom_sidebar_menu_partenaires() {
    add_menu_page(
        'Partenaires',
        'Partenaires',
        'manage_options',
        'edit.php?post_type=partenaires',
        '',
        'dashicons-groups',
        2
    );
    add_submenu_page(
        'edit.php?post_type=partenaires',
        'Toutes les partenaires',
        'Toutes les partenaires',
        'manage_options',
        'edit.php?post_type=partenaires'
    );
    add_submenu_page(
        'edit.php?post_type=partenaires',
        'Ajouter un partenaire',
        'Ajouter un partenaires',
        'manage_options',
        'post-new.php?post_type=partenaires'
    );
}
add_action( 'admin_menu', 'custom_sidebar_menu_partenaires' );
?>