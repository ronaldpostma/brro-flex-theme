<?php
/**
 * The 404 template, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header();
?>
<div class="brro-flex-page">
    <h1 id="page-title" class="offscreen"><?php esc_html_e( 'Pagina niet gevonden', 'brro-flex-theme' ); ?></h1>

    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper">
                <?php // 404 content. ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
