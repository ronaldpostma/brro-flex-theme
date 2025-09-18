<?php
/**
 * The search template file, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header(); ?>

<div>This is the content for the search page, wrapped in 'main' tag</div>
<section class="search-results">
    <?php if (have_posts()) : ?>
        <h1 class="search-title">
            <?php
            /* translators: %s: search query. */
            printf(esc_html__('Search Results for: %s', 'brro-flex-theme'), '<span>' . get_search_query() . '</span>');
            ?>
        </h1>
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
        <h1 class="search-title">
            <?php esc_html_e('Nothing Found', 'brro-flex-theme'); ?>
        </h1>
        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'brro-flex-theme'); ?></p>
        <?php get_search_form(); ?>
    <?php endif; ?>
</section>


<?php get_footer(); ?>