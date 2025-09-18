<?php
/**
 * The home (posts for when no home-page is set) template file, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header(); ?>

<div>This is the content for the home page (posts for when no home-page is set), wrapped in 'main' tag</div>

<section class="posts-loop">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    <?php endif; ?>
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h2>
                </header>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'brro-flex-theme'); ?></p>
    <?php endif; ?>
</section>




<?php get_footer(); ?>