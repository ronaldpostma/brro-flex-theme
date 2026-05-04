<?php
/**
 * The main template file - fallback only
 *
 * @package Brro_Flex_Theme
 */

get_header();
?>
<div class="brro-flex-page">
    <h1 id="page-title" class="offscreen"><?php bloginfo( 'name' ); ?></h1>

    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper">
                <p>
                    <?php
                    esc_html_e( 'Dit is het fallback-sjabloon. Als je dit ziet, maak dan een specifieke sjabloon voor dit paginatype, of neem contact op met de ontwikkelaar via', 'brro-flex-theme' );
                    ?>
                    <a href="mailto:support@brro.nl">support@brro.nl</a>.
                </p>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
