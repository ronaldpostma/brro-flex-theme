<?php
/**
 * Default page template — used for all Pages unless a more specific template exists.
 *
 * @package Brro_Flex_Theme
 */

get_header();
?>
<div class="brro-flex-page">
    <h1 id="page-title" class="offscreen"><?php echo esc_html( get_the_title() ); ?></h1>

    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper">
                <?php // Page content (ACF, sections, template-parts) — add per project. ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
