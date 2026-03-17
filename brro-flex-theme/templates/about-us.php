<?php
/**
 * Template Name: About Us
 * Template Post Type: page
 * @package Brro_Flex_Theme
 */

get_header(); ?>

<div class="brro-flex-page">
    <h1 id="page-title" class="offscreen"><?php echo esc_html( get_the_title() ); ?></h1>
    <!-- Over ons -->
    <div id="over-ons-section" class="outer-flex-wrapper">
        <div class="inner-flex-wrapper flex col-wrap justify-center">
            <div class="content-wrapper flex col-wrap justify-end items-end tab:items-start mob:self-center wide-width-mob">
                <h2 class="fullwidth hagrid size-80-80 lime"><?php echo wp_kses_post( get_field( 'title_aboutus' ) ); ?></h2>
                <?php
                $img_aboutus = get_field( 'img_aboutus' );
                if ( ! empty( $img_aboutus ) ) {
                    echo '<img class="radius-20" src="' . esc_url( $img_aboutus ) . '" alt="" />';
                }
                $text_aboutus = get_field( 'text_aboutus' );
                if ( ! empty( $text_aboutus ) ) {
                    echo '<div id="over-ons" class="aboutus-wysiwyg acumin regular white size-26-36">' . wp_kses_post( $text_aboutus ) . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Klanten -->
    <div id="klanten" class="outer-flex-wrapper">
        <div class="inner-flex-wrapper flex col-wrap justify-center">
            <div class="content-wrapper flex col-wrap justify-end items-end tab:items-start mob:self-center wide-width-mob">
                <h2 class="fullwidth hagrid size-80-80 lime"><?php echo wp_kses_post( get_field( 'title_clients' ) ); ?></h2>
                <?php
                $img_clients = get_field( 'img_clients' );
                if ( ! empty( $img_clients ) && is_array( $img_clients ) ) : ?>
                    <div class="clients-gallery">
                        <?php foreach ( $img_clients as $client_img ) :
                            $img_url = isset( $client_img['url'] ) ? esc_url( $client_img['url'] ) : '';
                            $img_alt = isset( $client_img['alt'] ) ? esc_attr( $client_img['alt'] ) : '';
                            if ( $img_url ) : ?>
                                <div class="client-image">
                                    <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" />
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Contact -->
    <div id="contact" class="outer-flex-wrapper">
        <div class="inner-flex-wrapper flex col-wrap justify-center">
            <div class="content-wrapper flex col-wrap justify-end items-end tab:items-start mob:self-center wide-width-mob">
                <h2 class="fullwidth hagrid size-80-80 lime"><?php echo wp_kses_post( get_field( 'title_contact' ) ); ?></h2>
                <div class="contact-details flex col-wrap justify-start items-start acumin extra-light size-50-60--1 white self-start">
                    <a class="white underline hover-lime" href="mailto:<?php echo esc_attr( get_field( 'contact_mail' ) ); ?>"><?php echo esc_html( get_field( 'contact_mail' ) ); ?></a>
                    <?php
                    $tel_bas_raw = get_field( 'tel_bas' );
                    $tel_bas_href = esc_attr( $tel_bas_raw );
                    // Format: 0031642216748 -> +31 6 422 167 48
                    $tel_bas_display = '';
                    if ( preg_match( '/^0031(\d{1})(\d{3})(\d{3})(\d{2})$/', $tel_bas_raw, $matches ) ) {
                        $tel_bas_display = '+31 ' . $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
                    } else {
                        $tel_bas_display = '+'. esc_html( $tel_bas_raw );
                    }
                    ?>
                    <a class="white underline hover-lime" href="tel:<?php echo $tel_bas_href; ?>">B &gt; <?php echo $tel_bas_display; ?></a>
                    <?php
                    $tel_rene_raw = get_field( 'tel_rene' );
                    $tel_rene_href = esc_attr( $tel_rene_raw );
                    // Format: 0031642216748 -> +31 6 422 167 48
                    $tel_rene_display = '';
                    if ( preg_match( '/^0031(\d{1})(\d{3})(\d{3})(\d{2})$/', $tel_rene_raw, $matches ) ) {
                        $tel_rene_display = '+31 ' . $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
                    } else {
                        $tel_rene_display = '+'. esc_html( $tel_rene_raw );
                    }
                    ?>
                    <a class="white underline hover-lime" href="tel:<?php echo $tel_rene_href; ?>">R &gt; <?php echo $tel_rene_display; ?></a>
                    <a class="fullwidth contact_address white underline hover-lime" href="<?php echo esc_url( get_field( 'contact_address_map' ) ); ?>" target="_blank"><?php echo wp_kses_post( get_field( 'contact_address' ) ); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

