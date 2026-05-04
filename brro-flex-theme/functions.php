<?php
/**
 * Brro Flex Theme Functions
 *
 * @package Brro_Flex_Theme
 * @version 1.2.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'brro_flex_theme_setup' );
function brro_flex_theme_setup() {
    // Automatic <title> tag
    add_theme_support( 'title-tag' );

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );

    // HTML5 markup (add other features per project as needed)
    add_theme_support( 'html5', [
        'search-form',
        'style',
        'script',
    ] );

    // Custom logo support (set dimensions per project)
    add_theme_support( 'custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Menu locations (add/remove per project)
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'brro-flex-theme' ),
        'footer'  => __( 'Footer Menu', 'brro-flex-theme' ),
    ] );
}

/**
 * Enqueue styles & scripts
 * filemtime() is used as the version arg so cache busts on file change.
 */
add_action( 'wp_enqueue_scripts', 'brro_flex_theme_enqueue_assets' );
function brro_flex_theme_enqueue_assets() {
    // Utility classes (load first, no deps)
    $utilities_style = '/assets/css/utilities.css';
    wp_enqueue_style(
        'brro-utilities',
        get_template_directory_uri() . $utilities_style,
        [],
        filemtime( get_template_directory() . $utilities_style )
    );

    // Main theme styles (depends on utilities so it can override)
    $main_style = '/style.css';
    wp_enqueue_style(
        'brro-style',
        get_template_directory_uri() . $main_style,
        [ 'brro-utilities' ],
        filemtime( get_template_directory() . $main_style )
    );

    // Page-specific CSS goes here (conditional on is_page() / is_page_template()).
    // Always declare 'brro-style' as a dependency so overrides cascade correctly.

    // Main JavaScript (jQuery is provided by brro-core, declare as dep only)
    $main_script = '/assets/js/main.js';
    wp_enqueue_script(
        'brro-main',
        get_template_directory_uri() . $main_script,
        [ 'jquery' ],
        filemtime( get_template_directory() . $main_script ),
        true
    );

    // Page-specific JS goes here (same conditional pattern as page-specific CSS).
}

/**
 * Security: remove unused wp_head noise
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/**
 * Theme function files
 */
require_once get_template_directory() . '/inc/global-functions.php';
require_once get_template_directory() . '/inc/search-functions.php';
require_once get_template_directory() . '/inc/homepage-functions.php';

/**
 * Admin-only functionality
 */
if ( is_admin() ) {
    require_once get_template_directory() . '/inc/admin/wp-admin-brro-ux.php';
}
