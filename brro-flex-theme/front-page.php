<?php
/**
 * The front-page template file, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header(); 

?>

<div class="brro-flex-page">   
    <!-- Page title -->
    <h1 id="page-title" class="offscreen"><?php echo esc_html( get_the_title() ); ?></h1>
    <!-- Section 'Hero' -->
    <div id="hero" class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper flex row-wrap justify-start items-start">
            
            </div>
        </div>
    </div>
    <!-- Section -->
    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper flex row-wrap justify-start items-start">
                
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>