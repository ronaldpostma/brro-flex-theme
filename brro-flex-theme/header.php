<?php
/**
 * The header template
 *
 * @package Brro_Flex_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?><?php /* Add brro-fx--smoothscroll="on" here when Lenis smooth scroll is confirmed for the project. */ ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php /* Project font links (Google Fonts / Adobe Typekit) go here. */ ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page-top"></div>
<?php
// Conditional header loading.
$main_header_path      = get_template_directory() . '/templates/main-header.php';
$secondary_header_path = get_template_directory() . '/templates/secondary-header.php';
$header_class          = '';

if ( file_exists( $main_header_path ) && is_front_page() ) {
    $header_class = ' main-header';
    $header_file  = $main_header_path;
} elseif ( file_exists( $secondary_header_path ) && is_page( 'confirmed-slug' ) ) { // Replace 'confirmed-slug' per project (see 00-project-setup.mdc).
    $header_class = ' secondary-header';
    $header_file  = $secondary_header_path;
} else {
    $header_file = '';
}
?>
<header class="brro-fx--header<?php echo esc_attr( $header_class ); ?>">
    <?php
    if ( ! empty( $header_file ) ) {
        include $header_file;
    } else {
        // Fallback navigation when no header template matched.
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
        ] );
    }
    ?>
</header>
<main>
