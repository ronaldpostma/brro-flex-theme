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
	
    <!-- Adobe Fonts kit URL IF USED -->
    <link rel="stylesheet" href="https://use.typekit.net/kit-code.css"> 
    
    <script>
        (function() {
            console.log('Brro Flex Theme > Script in head.');
        })();
    </script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
// Outputs the wp_body_open action hook so plugins/analytics can inject code right after the opening body tag
wp_body_open();

// Load headers conditionally
$main_header_path = get_template_directory() . '/templates/main-header.php';
$secondary_header_path = get_template_directory() . '/templates/secondary-header.php';
$header_class = '';
$use_main_header = false;
$use_secondary_header = false;
if (file_exists($main_header_path) && is_front_page()) {
    $header_class = ' main-header';
    $use_main_header = true;
} else if (file_exists($secondary_header_path) && is_page(BRRO_FLEX_SOME_PAGE_SLUG)) {
    $header_class = ' secondary-header mob:row-wrap mob:items-between';
    $use_secondary_header = true;
}

// Main header HTML output
?>
<div id="page-top"></div>
<header class="flex col-wrap justify-between items-start<?php echo $header_class; ?>">
    <?php
    if ($use_main_header) {
        include $main_header_path;
    } else if ($use_secondary_header) {
        include $secondary_header_path;
    } else {
        // Default header content (fallback)
        echo '<div>Notice: No header found</div>';
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false
        ]);
    }
    ?>
</header>
<main>
