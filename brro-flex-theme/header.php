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
// Header markup from templates/main-header.php when present (navigation is project-specific — see 00-project-setup.mdc).
$main_header_path = get_template_directory() . '/templates/main-header.php';
$header_class     = file_exists( $main_header_path ) ? 'brro-fx--header flex row-wrap items-center' : 'brro-fx--header';
$header_file      = file_exists( $main_header_path ) ? $main_header_path : '';
?>
<header class="<?php echo esc_attr( $header_class ); ?>">
    <?php
    if ( ! empty( $header_file ) ) {
        include $header_file;
    }
    ?>
</header>
<main>
