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

    // Navigation: no default. Add register_nav_menus() only when this project uses WordPress menus (see 00-project-setup.mdc).
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

    // Project CSS belongs in style.css (section banners) — not extra stylesheets by default.
    // Page-specific JS only when needed (conditional enqueue, same filemtime pattern).

    // Main JavaScript (jQuery is provided by brro-core, declare as dep only)
    $main_script = '/assets/js/main.js';
    wp_enqueue_script(
        'brro-main',
        get_template_directory_uri() . $main_script,
        [ 'jquery' ],
        filemtime( get_template_directory() . $main_script ),
        true
    );

    // Swiper v11 — site-wide JS + shared init (see .cursor/rules/09-swiper.mdc).
    wp_enqueue_script(
        'brro-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11',
        true
    );
    wp_add_inline_script( 'brro-swiper', brro_get_swiper_init_script(), 'after' );
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
 * Theme function files — one require per inc/ file; add new files as the project grows.
 *
 * global-functions.php = small shared helpers only.
 * Other inc/ files = one feature or integration each (see comments in each file).
 */
require_once get_template_directory() . '/inc/global-functions.php';
require_once get_template_directory() . '/inc/swiper-init.php';
require_once get_template_directory() . '/inc/search-functions.php';
require_once get_template_directory() . '/inc/homepage-functions.php';
// Add more require_once lines here when you create new inc/ files for the project.

/**
 * Admin-only functionality
 */
if ( is_admin() ) {
    require_once get_template_directory() . '/inc/admin/wp-admin-brro-ux.php';
}
