<?php
/**
 * The main template file - Fallback only
 *
 * @package Brro_Flex_Theme
 */

get_header(); ?>

<div>
    <div>
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php _e('Dit is het fallback-sjabloon. Als je dit ziet, maak dan een specifieke sjabloon voor dit paginatype, of neem contact op met de ontwikkelaar via', 'brro-flex-theme'); ?> <a href="mailto:support@brro.nl">support@brro.nl</a>.</p>
    </div>
</div>

<?php get_footer(); ?>
