<?php
//
// ******************************************************************************************************************************************************************** Site Global
//
// Index of Functions
//
// 1. brro_translate_strings
//		- Translates with the 'gettext' filter specific strings to replace predefined English strings with Dutch translations.
// 2. brro_additional_wp_css_body_class
//    	- Add additional body classes if needed
//
// Translate string
//add_filter( 'gettext', 'brro_translate_strings', 20, 3 );
function brro_translate_strings( $translated_text, $text, $domain ) {
	// Regardless of plugins
	$translated_text = str_ireplace( 'This field is required.',  'Niet of verkeerd ingevuld.',  $translated_text );
	$translated_text = str_ireplace( 'Search Results for: %s',  'Zoekresultaten voor: %s',  $translated_text );
	$translated_text = str_ireplace( 'The field accepts only numbers and phone characters (#, -, *, etc).', 'Vul een geldig telefoonnummer in (alleen cijfers en #, -, *, etc).',  $translated_text );
	$translated_text = str_ireplace( 'The Captcha field cannot be blank. Please enter a value.',  'Deze veiligheidscheck is verplicht. Vink het vakje aan.',  $translated_text );
	$translated_text = str_ireplace( 'No file was uploaded.',  'Upload een bestand.',  $translated_text );
	$translated_text = str_ireplace( 'This file type is not allowed.',  'Dit documenttype is niet toegestaan.',  $translated_text );
    return $translated_text;
}
//
// Additional body classes
//add_filter( 'body_class', 'brro_additional_wp_css_body_class' );
function brro_additional_wp_css_body_class( $classes ){
	// 'guest', 'webeditor', 'webadmin', 'parent', 'child', 'featuredimg-set' already added
	$classes[] = 'max-mode';
	return $classes;
}

// Get the footer navigation menu
function brro_secondary_navigation_menu() {
    // Get the info page ID
    $info_page_id = 46;
    // Get the current page ID
    $current_page_id = get_the_ID();
    // Check if the current page is the info page
    $is_info_page = $current_page_id === $info_page_id;
    ob_start();
    ?>
    <nav class="secondary-nav">
        <ul class="flex col-wrap acumin extra-light size-50-50--1">
            <li><a class="white hover-underline hover-lime" href="<?php echo $is_info_page ? '#over-ons' : '/alle-info/#over-ons'; ?>">Over ons</a></li>
            <li><a class="white hover-underline hover-lime" href="<?php echo $is_info_page ? '#klanten' : '/alle-info/#klanten'; ?>">Klanten</a></li>
            <li><a class="white hover-underline hover-lime" href="<?php echo $is_info_page ? '#contact' : '/alle-info/#contact'; ?>">Contact</a></li>
        </ul>
    </nav>
    <?php
    return ob_get_clean();
}

// Redirect post url's to homepage with parameter 'project'
add_action('template_redirect', 'brro_redirect_post_url_to_homepage_with_project_parameter');
function brro_redirect_post_url_to_homepage_with_project_parameter() {
    if (is_singular('post')) {
        wp_redirect(home_url('/?project=' . get_the_ID() . '&orientation=' . get_field('project_gallery_orientation', get_the_ID())));
        exit;
    }
}
add_action('wp_head', function() {
    ?>
    <!--
    /**
    * @license
    * MyFonts Webfont Build ID 309301
    *
    * The fonts listed in this notice are subject to the End User License
    * Agreement(s) entered into by the website owner. All other parties are
    * explicitly restricted from using the Licensed Webfonts(s).
    *
    * You may obtain a valid license from one of MyFonts official sites.
    * http://www.fonts.com
    * http://www.myfonts.com
    * http://www.linotype.com
    *
    */
    -->
    <?php
}, 11); // run after core head actions

/**
 * Custom 301 Redirects for Old URLs
 *
 * This function hooks into the 'template_redirect' action, which runs early in the WordPress loading
 * process, before the template is loaded. It checks the current requested URL against a predefined
 * map of old URLs and executes a permanent (301) redirect to the new target URL if a match is found.
 *
 */
// Attach the function to the template_redirect action
add_action('template_redirect', 'brro_custom_seo_redirects');
function brro_custom_seo_redirects() {
    // Define the list of old (relative) URLs and their corresponding new (relative) URLs.
    // The keys are the old URLs to redirect from.
    // The values are the new URLs to redirect to.
    // Use '/' for the homepage.
    $redirect_map = array(
        '/about-us/'                                        => '/alle-info/',
        '/portfolio-bericht/'                               => '/',
        '/werk/'                                            => '/',
        '/project/hit/'                                     => '/',
        '/project/theaterhaarlem/'                          => '/',
        '/project/plasticsoep/'                             => '/plastic-soep/',
        '/project/vishal/'                                  => '/',
        '/project/swov/'                                    => '/',
        '/project/juttersgeluk/'                            => '/juttersgeluk/',
        '/project/gemeente-haarlem-festivalmaatje/'         => '/',
        '/project/stappenplan-voor-jongeren-met-schulden/'  => '/newfuture/',
        '/project/historische-routes-door-haarlem/'         => '/',
        '/project/het-einde-van-vulcan/'                    => '/kosmos/',
        '/project/compostier/'                              => '/compostier/',
        '/project/schalkwijkaanzet/'                        => '/',
        '/project/vormgeven-aan-de-stad/'                   => '/',
        '/project/het-archief-opent-zich/'                  => '/archief/',
        '/project/uitjezorgijmond/'                         => '/uitjezorg/',
        '/project/docwerk/'                                 => '/',
        '/review/leonie-kinds-stadsschouwburg-haarlem/'     => '/',
        '/review/leonie-ouders-stadsschouwburg-leiden/'      => '/',
        '/review/suzanne-klaassen-juttersgeluk/'            => '/',
        '/review/margaret-boer-staatsbosbeheer/'            => '/',
        '/review/bianca-galesloot-gemeente-haarlem/'        => '/',
        '/review/anja-francissen-gemeente-haarlem/'         => '/',
    );

    // Get the current request path. We normalize it to always include a leading slash.
    // REQUEST_URI includes the query string, which we need to strip for accurate comparison.
    $request_uri = $_SERVER['REQUEST_URI'];
    $current_path = strtok($request_uri, '?');

    // Ensure the path is normalized (e.g., handles non-pretty permalinks, though unlikely here)
    if (empty($current_path) || $current_path === '/index.php') {
        $current_path = '/';
    }

    // Check if the current path exists in our redirect map
    if (array_key_exists($current_path, $redirect_map)) {
        $new_url_path = $redirect_map[$current_path];

        // Construct the full target URL using the WordPress site URL function
        $target_url = home_url($new_url_path);

        // Perform the 301 redirect (Moved Permanently)
        wp_redirect($target_url, 301);
        exit; // Important: terminate execution after the redirect
    }
}