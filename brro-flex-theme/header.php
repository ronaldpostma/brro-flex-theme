<?php
/**
 * The header template
 *
 * @package Brro_Flex_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <?php
    // Load main header content if it exists
    $main_header = get_template_directory() . '/templates/main-header.php';
    if (file_exists($main_header)) {
        include $main_header;
    } else {
        // Default header content (fallback)
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false
        ]);
    }
    ?>
</header>
<main>
