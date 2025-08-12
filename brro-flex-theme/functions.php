<?php
/**
 * Brro Flex Theme Functions
 * 
 * @package Brro_Flex_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
add_action('after_setup_theme', 'brro_flex_theme_setup');
function brro_flex_theme_setup() {
    // Automatic <title> tag
    add_theme_support('title-tag');
    
    // Post thumbnails
    add_theme_support('post-thumbnails');
    
    // HTML5 markup
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Custom logo support allows themes to add a custom logo to their site, which can be set in the WordPress admin panel.
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true
    ]);
    
    // Menu registration (add/edit per project which locations are needed)
    register_nav_menus([
        'primary' => __('Primary Menu', 'brro-flex-theme'),
        'footer'  => __('Footer Menu', 'brro-flex-theme')
    ]);
}


/**
 * Enqueue Styles & Scripts
 * The filemtime() function is a version control technique that automatically updates the version number whenever you modify * a file with UNIX timestamp.
 */
add_action('wp_enqueue_scripts', 'brro_flex_theme_enqueue_assets');
function brro_flex_theme_enqueue_assets() {
    // Utility classes (load first)
    wp_enqueue_style(
        'brro-utilities',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        filemtime(get_template_directory() . '/assets/css/main.css')
    );
    // Main theme styles (load second to override utilities if needed)
    wp_enqueue_style(
        'brro-style',
        get_stylesheet_uri(),
        ['brro-utilities'],
        filemtime(get_template_directory() . '/style.css')
    );
    // JavaScript
    wp_enqueue_script(
        'brro-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['jquery'],
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
    // Localize script for AJAX
    wp_localize_script('brro-main', 'brro_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('brro_nonce')
    ]);
}

/**
 * Security: Remove unnecessary meta tags
 */
remove_action('wp_head', 'wp_generator'); //Remove WordPress version from head
remove_action('wp_head', 'wlwmanifest_link'); // Remove Windows Live Writer manifest link
remove_action('wp_head', 'rsd_link'); // Remove Really Simple Discovery link
remove_action('wp_head', 'wp_shortlink_wp_head'); // Remove shortlink for the page
remove_action('wp_head', 'wp_resource_hints', 2); // Remove resource hints for DNS prefetching
remove_action('wp_head', 'rest_output_link_wp_head'); // Remove REST API link tag
remove_action('wp_head', 'wp_oembed_add_discovery_links'); // Remove oEmbed discovery links
remove_action('wp_head', 'wp_oembed_add_host_js'); // Remove oEmbed-specific JavaScript
