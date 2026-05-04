<?php
/**
 * The front-page template, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header();
?>
<div class="brro-flex-page">
    <h1 id="page-title" class="offscreen"><?php echo esc_html( get_the_title() ); ?></h1>

    <div id="hero" class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper">
                <?php // Hero content. ?>
            </div>
        </div>
    </div>

    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper">
                <?php // Section content. ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
