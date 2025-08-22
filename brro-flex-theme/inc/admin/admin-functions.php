<?php
/**
 * Admin-specific functions for brro-flex-theme
 * Project-specific admin customizations
 * 
 * @package Brro_Flex_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/* ========================================
   ADMIN STYLES AND SCRIPTS
   ======================================== */

add_action('admin_enqueue_scripts', 'brro_admin_enqueue_assets');
function brro_admin_enqueue_assets($hook) {
    // Only load on specific admin pages if needed
    // if (!in_array($hook, ['post.php', 'post-new.php'])) return;
    
    // Admin styles
    $admin_style = '/assets/css/admin-style.css';
    if (file_exists(get_template_directory() . $admin_style)) {
        wp_enqueue_style(
            'brro-admin-style',
            get_template_directory_uri() . $admin_style,
            [],
            filemtime(get_template_directory() . $admin_style)
        );
    }
    
    // Admin scripts
    $admin_script = '/assets/js/admin-script.js';
    if (file_exists(get_template_directory() . $admin_script)) {
        wp_enqueue_script(
            'brro-admin-script',
            get_template_directory_uri() . $admin_script,
            ['jquery'],
            filemtime(get_template_directory() . $admin_script),
            true
        );
    }
}

/* ========================================
   ADMIN MENU CUSTOMIZATION
   ======================================== */

// Example: Change admin menu labels
add_action('admin_menu', 'brro_customize_admin_menu', 999);
function brro_customize_admin_menu() {
    global $menu;
    
    // Example: Change "Posts" to "Articles"
    // foreach ($menu as $key => $item) {
    //     if ($item[2] === 'edit.php') {
    //         $menu[$key][0] = 'Articles';
    //         break;
    //     }
    // }
}

/* ========================================
   ADMIN DASHBOARD CUSTOMIZATION
   ======================================== */

// Example: Add custom dashboard widgets
add_action('wp_dashboard_setup', 'brro_add_dashboard_widgets');
function brro_add_dashboard_widgets() {
    // Example: Add custom dashboard widget
    // wp_add_dashboard_widget(
    //     'brro_custom_widget',
    //     'Project Information',
    //     'brro_custom_dashboard_widget_callback'
    // );
}

/* ========================================
   ADMIN NOTICES
   ======================================== */

// Example: Add admin notices
add_action('admin_notices', 'brro_admin_notices');
function brro_admin_notices() {
    // Example: Show notice for specific conditions
    // if (current_user_can('manage_options')) {
    //     echo '<div class="notice notice-info"><p>Project-specific admin notice</p></div>';
    // }
}

/* ========================================
   CUSTOM POST TYPE ADMIN
   ======================================== */

// Example: Customize post type admin columns
// add_filter('manage_post_posts_columns', 'brro_custom_post_columns');
// function brro_custom_post_columns($columns) {
//     // Add custom columns
//     return $columns;
// }

/* ========================================
   ADMIN BAR CUSTOMIZATION
   ======================================== */

// Example: Customize admin bar
add_action('admin_bar_menu', 'brro_customize_admin_bar', 999);
function brro_customize_admin_bar($wp_admin_bar) {
    // Example: Add custom admin bar items
    // $wp_admin_bar->add_node([
    //     'id' => 'brro-custom-item',
    //     'title' => 'Custom Item',
    //     'href' => '#'
    // ]);
}
