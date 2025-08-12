<?php
/**
 * Theme Setup
 */
add_action('after_setup_theme', function() {
    // Automatic <title> tag
    add_theme_support('title-tag');

    // Menu registration
    register_nav_menus([
        'primary' => __('Primary Menu', 'brro-flex-theme')
    ]);
});

/**
 * Enqueue Styles & Scripts
 */
add_action('wp_enqueue_scripts', function() {
    // CSS
    wp_enqueue_style(
        'brro-flex-theme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        filemtime(get_template_directory() . '/assets/css/main.css')
    );

    // JS
    wp_enqueue_script(
        'brro-flex-theme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['jquery'],
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
});
