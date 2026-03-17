<?php
/**
 * The project specific main header template, already wrapped in <footer> tag
 *
 * @package Brro_Flex_Theme
 */
?>
<div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper flex col-wrap justify-center mob:items-center">
            <div class="content-wrapper flex row-wrap justify-between items-center mob:col-wrap mob:justify-start mob:items-start def-width-mob">
                <div class="footer-navigation-wrapper">
                    <?php echo brro_secondary_navigation_menu(); ?>
                </div>
                <div class="footer-about-wrapper">
                        <?php
                        $footer_heading = get_field('footer_heading', 2);
                        if ( !empty($footer_heading) ) {
                            echo '<h3 class="acumin bold size-20-30 white">' . esc_html($footer_heading) . '</h3>';
                        }
                        $footer_wysiwyg = get_field('footer_textarea', 2);
                        if ( !empty($footer_wysiwyg) ) {
                            echo '<div class="acumin medium size-20-30 white footer-wysiwyg">';
                            echo apply_filters('the_content', $footer_wysiwyg);
                            echo '</div>';
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>