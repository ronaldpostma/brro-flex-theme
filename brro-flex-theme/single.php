<?php
/**
 * Single post template, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_title( '<h1 class="entry-title">', '</h1>' );
		the_content();
	}
}

get_footer();