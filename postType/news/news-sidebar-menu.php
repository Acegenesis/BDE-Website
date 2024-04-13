<?php 
// Ajouter le menu "News" dans la sidebar
function custom_sidebar_menu_news() {
    add_menu_page(
        'News',
        'News',
        'manage_options',
        'edit.php?post_type=news',
        '',
        'dashicons-megaphone',
        2
    );
    add_submenu_page(
        'edit.php?post_type=infos',
        'Toutes les news',
        'Toutes les news',
        'manage_options',
        'edit.php?post_type=news'
    );
    add_submenu_page(
        'edit.php?post_type=news',
        'Ajouter une news',
        'Ajouter une news',
        'manage_options',
        'post-new.php?post_type=news'
    );
}
add_action( 'admin_menu', 'custom_sidebar_menu_news' );
?>