<?php
/**
 * The front-page template file, content is wrapped in <main> tag
 *
 * @package Brro_Flex_Theme
 */

get_header(); 

// Define variables
$plastic_soep_id = 89; // Plastic Soep
$uitjezorg_id = 123; // Uitjezorg
$nh_archief_id = 125; // Archief
$compostier_id = 127; // Compostier
$kosmos_id = 129; // Kosmos
$newfuture_id = 131; // NewFuture
$juttersgeluk_id = 133; // Juttersgeluk
$over_ons_id = 46; // Over ons
$allowed_orientations = array('ver', 'hor');
?>

<div class="brro-flex-page">   
    <!-- Page title -->
    <h1 id="page-title" class="offscreen"><?php echo esc_html( get_the_title() ); ?></h1>
    <!-- Hero: primary page intro -->
    <div id="hero" class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper flex row-wrap justify-end items-start">
                <?php
                $hero_tag = get_field( 'hero_tag' );
                if ( ! empty( $hero_tag ) ) {
                    // Prepare buttons and images for replacements
                    $replacements = array();
                    for ( $i = 1; $i <= 4; $i++ ) {
                        // Get related image URL and project ID
                        $img_url = get_field( 'slogan_img_' . $i );
                        $project_id = get_field( 'slogan_project_' . $i );
                        if ( ! empty( $img_url ) && ! empty( $project_id ) ) {
                            // Get button orientation
                            $project_gallery_orientation = get_field('project_gallery_orientation', $project_id);
                            $allowed_orientations = array('ver', 'hor');
                            $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                            // Build button HTML wrapping the image
                            $button_html  = '<span class="hero-slogan-button">';
                            $button_html .= '<img src="' . esc_url( $img_url ) . '" class="hero-button-img" alt="slogan image" />';
                            $button_html .= '<button pop_id="project_popup_' . esc_attr( $project_id ) . '" data-gallery-orientation="' . esc_attr( $project_gallery_orientation ) . '" tabindex="1" role="button" aria-label="Project popup" aria-pressed="false"></button>';
                            //$button_html .= '</span><span class="hero-slogan-button-space"></span>';
                            $button_html .= '</span>';
                            $replacements[] = $button_html;
                        } elseif ( ! empty( $img_url ) ) {
                            // No project, just image
                            $replacements[] = '<img src="' . esc_url( $img_url ) . '" alt="slogan image" />';
                        } else {
                            // Just blank if no image
                            $replacements[] = '';
                        }
                    }

                    // Replace *project* tokens with button/image html and wrap lines
                    $pattern = '/\*project\*/u';
                    $count = 0;
                    $replace_tokens = function( $subject ) use ( $pattern, &$count, $replacements ) {
                        return preg_replace_callback(
                            $pattern,
                            function( $matches ) use ( &$count, $replacements ) {
                                if ( isset( $replacements[ $count ] ) ) {
                                    return $replacements[ $count++ ];
                                }
                                $count++;
                                return '';
                            },
                            $subject
                        );
                    };

                    $lines = preg_split( '/<br\s*\/?>/i', $hero_tag );
                    if ( is_array( $lines ) && ! empty( $lines ) ) {
                        $output_parts = array();
                        foreach ( $lines as $line ) {
                            $line = $replace_tokens( trim( $line ) );
                            $output_parts[] = '<span class="slogan-line">' . $line . '</span>';
                        }
                        $output = implode( '', $output_parts );
                    } else {
                        $output = $replace_tokens( $hero_tag );
                    }

                    echo '<div class="hero-slogan hagrid-italic-201-158_4-100 acumin-226-165_5-200">' . $output . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Project highlights and intro texts -->
    <div class="outer-flex-wrapper">
        <div class="inner-flex-wrapper">
            <div class="content-wrapper project-highlights-wrapper flex row-wrap justify-start items-start">
                <div class="desk-left-column flex col-wrap justify-start items-start">
                    <!-- First project highlight // Plastic Soep -->
                    <div id="plasticsoep" class="project-highlight flex col-wrap justify-end items-start radius-20 tab:order-1">
                        <!-- Project image -->
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-afval-woordmerk-home.png" class="project-image" alt="Afval naar woordmerk">
                        <!-- Project button -->
                        <?php
                        // Get orientation radio field, default to 'hor' if not set or invalid
                        $project_gallery_orientation = get_field('project_gallery_orientation', $plastic_soep_id);
                        $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                        ?>
                        <button pop_id="project_popup_<?php echo esc_attr($plastic_soep_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="2" role="button" aria-label="Afval naar woordmerk" aria-pressed="false">
                            <span class="button-text">
                                <?php
                                $button_home = get_field('button_home', $plastic_soep_id);
                                if ( !empty($button_home) ) {
                                    echo wp_kses_post( $button_home );
                                }
                                ?>
                            </span>
                            <!-- Project button icon -->
                            <span class="button-icon min-hidden-width">
                                <?php echo brro_button_icon_oog_statisch(); ?>
                            </span>
                        </button>
                    </div>
                    <!-- Second project highlight // Uitjezorg -->
                    <div id="uitjezorg" class="project-highlight flex col-wrap justify-end items-end radius-20 tab:order-3">
                    <!-- Project image -->
                    <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-uitjezorg-max-home.png" class="project-image max-only" alt="Uitjezorg">
                    <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-uitjezorg-min-home.jpg" class="project-image min-only min" alt="Uitjezorg">
                    <!-- Project button -->
                    <?php
                    // Get orientation radio field, default to 'hor' if not set or invalid
                    $project_gallery_orientation = get_field('project_gallery_orientation', $uitjezorg_id);
                    $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                    ?>
                    <button pop_id="project_popup_<?php echo esc_attr($uitjezorg_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="3" role="button" aria-label="Uitjezorg" aria-pressed="false">
                        <span class="button-text">
                            <?php
                            $button_home = get_field('button_home', $uitjezorg_id);
                            if ( !empty($button_home) ) {
                                echo wp_kses_post( $button_home );
                            }
                            ?>
                        </span>
                    </button>
                    </div>
                    <!-- Second intro text -->
                    <div id="text-sm-2" class="tab:order-5">
                        <?php 
                        $intro_text_2 = get_field('text_sm_2');
                        if ( !empty($intro_text_2) ) {
                            echo '<div class="intro-text acumin size-37-49">' . wp_kses_post( $intro_text_2 ) . '</div>';
                        }
                        ?>
                    </div>
                    <!-- Over ons CTA // Over ons -->
                    <div id="cta_overons" class="project-highlight over-ons-cta flex col-wrap justify-end items-start tab:order-7">
                        <!-- Over ons image -->
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-overons-min-home.jpg" class="project-image min radius-20" alt="Over ons">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-overons-max-home.png" class="project-image over-ons-effect effect-1 max-only" alt="Over ons">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-overons-max-home.png" class="project-image over-ons-effect effect-2 max-only" alt="Over ons">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-overons-max-home.png" class="project-image over-ons-effect effect-3 max-only" alt="Over ons">
                        <!-- Over ons button -->
                        <button id="over-ons-btn" role="button" tabindex="6" aria-label="Over ons" aria-pressed="false">
                            <span class="button-text">
                                <?php
                                $button_home = get_field('button_cta_1');
                                if ( !empty($button_home) ) {
                                    echo wp_kses_post( $button_home );
                                }
                                ?>
                            </span>
                        </button>
                    </div>
                    <!-- Sixth project highlight // NewFuture -->
                    <div id="newfuture" class="project-highlight flex col-wrap justify-end items-start radius-20 tab:order-10">
                    <!-- Project image -->
                    <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-newfuture-max-home.svg" class="project-image max-only" alt="NewFuture">
                    <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-newfuture-min-home.jpg" class="project-image min-only min" alt="NewFuture">
                    <!-- Project button -->
                    <?php
                    // Get orientation radio field, default to 'hor' if not set or invalid
                    $project_gallery_orientation = get_field('project_gallery_orientation', $newfuture_id);
                    $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                    ?>
                    <button pop_id="project_popup_<?php echo esc_attr($newfuture_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="9" role="button" aria-label="NewFuture" aria-pressed="false">
                        <span class="button-text">
                            <?php
                            $button_home = get_field('button_home', $newfuture_id);
                            if ( !empty($button_home) ) {
                                echo wp_kses_post( $button_home );
                            }
                            ?>
                        </span>
                        <!-- Project button icon -->
                        <span class="button-icon min-hidden-width">
                            <?php echo brro_folder(); ?>
                        </span>
                    </button>
                    </div>
                </div>
                <div class="desk-right-column flex col-wrap justify-start items-start">
                    <!-- First intro text -->
                    <div id="text-sm-1" class="tab:order-2">
                        <?php 
                        $intro_text = get_field('text_sm_1');
                        if ( !empty($intro_text) ) {
                            echo '<div class="intro-text acumin size-37-49">' . wp_kses_post( $intro_text ) . '</div>';
                        }
                        ?>
                    </div>
                    <!-- Third project highlight // Archief -->
                    <div id="nharchief" class="project-highlight flex col-wrap justify-end items-start radius-20 tab:order-4">
                        <!-- Project image -->
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-archivaris-max-home.png" class="project-image max-only" alt="Archief">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-archivaris-min-home.png" class="project-image min-only min" alt="Archief">
                        <!-- Project button -->
                        <?php
                        // Get orientation radio field, default to 'hor' if not set or invalid
                        $project_gallery_orientation = get_field('project_gallery_orientation', $nh_archief_id);
                        $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                        ?>
                        <button pop_id="project_popup_<?php echo esc_attr($nh_archief_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="4" role="button" aria-label="Archief" aria-pressed="false">
                            <span class="button-text">
                                <?php
                                $button_home = get_field('button_home', $nh_archief_id);
                                if ( !empty($button_home) ) {
                                    echo wp_kses_post( $button_home );
                                }
                                ?>
                            </span>
                            <!-- Project button icon -->
                            <span class="button-icon min-hidden-width">
                                <?php echo brro_button_icon_oog_stuiter(); ?>
                            </span>
                        </button>
                    </div>
                    <!-- Fourth project highlight // Compostier -->
                    <div id="compostier" class="project-highlight flex col-wrap justify-end items-start radius-20 tab:order-6">
                        <!-- Project image -->
                        <span class="comp-rectangle max-only rectangle-4"></span>
                        <span class="comp-rectangle max-only rectangle-3"></span>
                        <span class="comp-rectangle max-only rectangle-2"></span>
                        <span class="comp-rectangle max-only rectangle-1"></span>
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-compostier-max-home.png" class="project-image max-only" alt="Compostier">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-compostier-min-home.png" class="project-image min-only min" alt="Compostier">
                        <!-- Project button -->
                        <?php
                        // Get orientation radio field, default to 'hor' if not set or invalid
                        $project_gallery_orientation = get_field('project_gallery_orientation', $compostier_id);
                        $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                        ?>
                        <button pop_id="project_popup_<?php echo esc_attr($compostier_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="5" role="button" aria-label="Compostier" aria-pressed="false">
                            <span class="button-text">
                                <?php
                                $button_home = get_field('button_home', $compostier_id);
                                if ( !empty($button_home) ) {
                                    echo wp_kses_post( $button_home );
                                }
                                ?>
                            </span>
                        </button>
                    </div>
                    <!-- Fifth project highlight // Kosmos -->
                    <div id="kosmos" class="project-highlight flex col-wrap justify-end items-start radius-20 tab:order-8">
                        <!-- Project image -->
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-polygon.svg" class="kosm-polygon polygon-5 max-only">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-polygon.svg" class="kosm-polygon polygon-4 max-only">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-polygon.svg" class="kosm-polygon polygon-3 max-only">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-polygon.svg" class="kosm-polygon polygon-2 max-only">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-polygon.svg" class="kosm-polygon polygon-1 max-only">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-max-home.png" class="project-image max-only" alt="Kosmos">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-vulcan-min-home.png" class="project-image min-only min" alt="Kosmos">
                        <!-- Project button -->
                        <?php
                        // Get orientation radio field, default to 'hor' if not set or invalid
                        $project_gallery_orientation = get_field('project_gallery_orientation', $kosmos_id);
                        $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                        ?>
                        <button pop_id="project_popup_<?php echo esc_attr($kosmos_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="7" role="button" aria-label="Kosmos" aria-pressed="false">
                            <span class="button-text">
                                <?php
                                $button_home = get_field('button_home', $kosmos_id);
                                if ( !empty($button_home) ) {
                                    echo wp_kses_post( $button_home );
                                }
                                ?>
                            </span>
                        </button>
                    </div>
                    <!-- Seventh project highlight // Juttersgeluk -->
                    <div id="juttersgeluk" class="project-highlight flex col-wrap justify-end items-start radius-20 tab:order-9">
                        <!-- Project image -->
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-juttersgeluk-1-max-home.jpg" class="project-image juttersgeluk-1 max-only" alt="Juttersgeluk">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-juttersgeluk-2-max-home.jpg" class="project-image juttersgeluk-2 max-only" alt="Juttersgeluk">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-juttersgeluk-3-max-home.jpg" class="project-image juttersgeluk-3 max-only" alt="Juttersgeluk">
                        <img src="/wp-content/themes/brro-flex-theme/assets/images/projects-home/brrbrr-juttersgeluk-min-home.jpg" class="project-image min-only min" alt="Juttersgeluk">
                        <!-- Project button -->
                        <?php
                        // Get orientation radio field, default to 'hor' if not set or invalid
                        $project_gallery_orientation = get_field('project_gallery_orientation', $juttersgeluk_id);
                        $project_gallery_orientation = (in_array($project_gallery_orientation, $allowed_orientations, true)) ? $project_gallery_orientation : 'hor';
                        ?>
                        <button pop_id="project_popup_<?php echo esc_attr($juttersgeluk_id); ?>" data-gallery-orientation="<?php echo esc_attr( $project_gallery_orientation ); ?>" tabindex="8" role="button" aria-label="Juttersgeluk" aria-pressed="false">
                            <span class="button-text">
                                <?php
                                $button_home = get_field('button_home', $juttersgeluk_id);
                                if ( !empty($button_home) ) {
                                    echo wp_kses_post( $button_home );
                                }
                                ?>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Project popup -->
<div id="project-popup" data-no-defer="1">
    <div id="project-popup-content" class="project-popup-content">
        <!-- Content here -->
    </div>
</div>
<?php get_footer(); ?>