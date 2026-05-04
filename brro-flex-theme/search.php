<?php
/**
 * The search results template, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header();
?>
<div class="brro-flex-page">
    <h1 id="page-title" class="offscreen">
        <?php
        /* translators: %s: search query. */
        printf( esc_html__( 'Search Results for: %s', 'brro-flex-theme' ), esc_html( get_search_query() ) );
        ?>
    </h1>

    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail( 'thumbnail' ); ?>
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
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'brro-flex-theme' ); ?></p>
                    <?php get_search_form(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
