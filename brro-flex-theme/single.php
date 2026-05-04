<?php
/**
 * Single post template, content is wrapped in <main> tag
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
                <?php
                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        the_title( '<h2 class="entry-title">', '</h2>' );
                        the_content();
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
