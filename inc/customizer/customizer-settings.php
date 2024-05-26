<?php
function my_theme_customize_register($wp_customize) {
    // Ajouter une section pour les paramètres du site
    $wp_customize->add_section('my_theme_site_identity', array(
        'title'       => __('Identité du site', 'textdomain'),
        'priority'    => 30,
    ));

    // Titre du site
    $wp_customize->add_setting('blogname', array(
        'default'           => get_option('blogname'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('blogname', array(
        'label'    => __('Titre du site', 'textdomain'),
        'section'  => 'my_theme_site_identity',
        'settings' => 'blogname',
        'type'     => 'text',
    ));

    // Description du site
    $wp_customize->add_setting('blogdescription', array(
        'default'           => get_option('blogdescription'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('blogdescription', array(
        'label'    => __('Description du site', 'textdomain'),
        'section'  => 'my_theme_site_identity',
        'settings' => 'blogdescription',
        'type'     => 'text',
    ));

    // Logo principal
    $wp_customize->add_setting('main_logo', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'main_logo', array(
        'label'    => __('Logo principal', 'textdomain'),
        'section'  => 'my_theme_site_identity',
        'settings' => 'main_logo',
    )));

    // Logo secondaire
    $wp_customize->add_setting('secondary_logo', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'secondary_logo', array(
        'label'    => __('Logo secondaire', 'textdomain'),
        'section'  => 'my_theme_site_identity',
        'settings' => 'secondary_logo',
    )));

    // Texte slider
    $wp_customize->add_setting('textslider', array(
        'default'           => get_option('textslider'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('textslider', array(
        'label'    => __('Texte slider', 'textdomain'),
        'section'  => 'my_theme_site_identity',
        'settings' => 'textslider',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'my_theme_customize_register');

// Enregistrer les paramètres pour la page "Général"
function my_theme_register_general_settings() {
    register_setting('general-customizer-group', 'blogname');
    register_setting('general-customizer-group', 'blogdescription');
    register_setting('general-customizer-group', 'main_logo');
    register_setting('general-customizer-group', 'secondary_logo');
}
add_action('admin_init', 'my_theme_register_general_settings');

// Enregistrer les paramètres pour la page "Home"
function my_theme_register_home_settings() {
    register_setting('home-customizer-group', 'textslider');
    register_setting('home-customizer-group', 'dynamic_entries');
}
add_action('admin_init', 'my_theme_register_home_settings');

?>
