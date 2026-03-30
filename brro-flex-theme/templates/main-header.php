<?php
/**
 * The project specific main header template, already wrapped in <header> tag
 *
 * @package Brro_Flex_Theme
 */

$logo_svg = '
<?xml version="1.0" encoding="UTF-8"?>
<svg>
</svg>';
?>

<div class="flex outer-flex-wrapper row-wrap justify-start items-center">
    <div id="logo">
        <?php
        if ( is_front_page() ) {
            $logo_href = '#page-top';
            $logo_aria_label = __( 'Terug naar boven', 'brro-flex-theme' );
        } else {
            $logo_href = esc_url( home_url( '/' ) );
            /* translators: %s: site title */
            $logo_aria_label = sprintf( __( 'Naar homepage: %s', 'brro-flex-theme' ), get_bloginfo( 'name' ) );
        }
        ?>
        <a href="<?php echo esc_attr( $logo_href ); ?>" tabindex="1" role="button" aria-label="<?php echo esc_attr( $logo_aria_label ); ?>" aria-pressed="false">
            <?php echo $logo_svg; ?>	
        </a>
    </div>
</div>