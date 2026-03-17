<?php
/**
 * The header template
 *
 * @package Brro_Flex_Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="min-mode">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://use.typekit.net/emq7ubj.css">
    <script>
        (function() {
            console.log('localStorage.getItem("brro_load_transition"):', localStorage.getItem('brro_load_transition'));
            console.log('localStorage.getItem("brro_mode"):', localStorage.getItem('brro_mode'));
            // Load transition
            if (localStorage.getItem('brro_load_transition') === 'true') {
                document.documentElement.classList.add('start-load-transition');
                localStorage.removeItem('brro_load_transition');
                setTimeout(function() {
                    document.documentElement.classList.remove('start-load-transition');
                    document.documentElement.classList.add('finish-transition');
                }, 200);
                setTimeout(function() {
                    document.documentElement.classList.remove('finish-transition');
                }, 1600);
            }
            // Max or min mode
            const userMode = localStorage.getItem('brro_mode');
    		const html = document.documentElement;
    		if (userMode === 'max') {
        		html.classList.remove('min-mode');
        		html.classList.add('max-mode');
    		}
        })();
    </script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
// Outputs the wp_body_open action hook so plugins/analytics can inject code right after the opening body tag
wp_body_open();

// Background images on home page, absolutely positioned
if ( is_front_page() && !is_page('test') ) {
    ?>
        <div id="background-blur-pink" class="background-blur-wrapper">
            <div class="animate-layer">
                <img src="/wp-content/themes/brro-flex-theme/assets/images/brrbrr_achtergrondblur-roze.svg" alt="">
            </div>
        </div>
        <div id="background-blur-blue" class="background-blur-wrapper">
            <div class="animate-layer">
                <img src="/wp-content/themes/brro-flex-theme/assets/images/brrbrr_achtergrondblur-blauw.svg" alt="">
            </div>
        </div>
        <div id="background-blur-orange" class="background-blur-wrapper">
            <div class="animate-layer">
                <img src="/wp-content/themes/brro-flex-theme/assets/images/brrbrr_achtergrondblur-oranje.svg" alt="">
            </div>
        </div>
    <?php
}
// Load headers conditionally
$main_header_path = get_template_directory() . '/templates/main-header.php';
$secondary_header_path = get_template_directory() . '/templates/secondary-header.php';
$header_class = '';
$use_main_header = false;
$use_secondary_header = false;
if (file_exists($main_header_path) && is_front_page()) {
    $header_class = ' main-header';
    $use_main_header = true;
} else if (file_exists($secondary_header_path) && is_page('alle-info')) {
    $header_class = ' secondary-header mob:row-wrap mob:items-between';
    $use_secondary_header = true;
}

// Overlay for page transitions
?>
<div id="overlay"></div>
<div id="page-top"></div>
<header class="flex col-wrap justify-between items-start<?php echo $header_class; ?>">
    <div id="brro-header-probe" aria-hidden="true"></div>
    <?php
    if ($use_main_header) {
        include $main_header_path;
    } else if ($use_secondary_header) {
        include $secondary_header_path;
    } else {
        // Default header content (fallback)
        echo '<div>Notice: No header found</div>';
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false
        ]);
    }
    ?>
</header>
<main>
