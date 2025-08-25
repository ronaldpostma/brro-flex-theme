<?php
/**
 * Admin-specific functions for brro-flex-theme
 * Project-specific admin customizations
 * 
 * Only active when brro-project plugin is not active
 * 
 * @package Brro_Flex_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/* ========================================
   ADD INLINE ADMIN STYLES AND SCRIPTS
   ======================================== */

add_action('admin_head', 'brro_admin_inline_styles');   
function brro_admin_inline_styles() {
	echo brro_get_admin_css_for_all_users();
	$user = get_current_user_id();
	$get_editors = get_option('brro_editors', '2,3,4,5');
	$editors = array_filter(array_map('intval', explode(',', $get_editors)), function($id) {
		return $id > 0;
	}); 
	if (in_array($user, $editors)) {
		echo brro_get_admin_css_for_editors();
	}
}
add_action('admin_print_footer_scripts', 'brro_admin_inline_scripts');
function brro_admin_inline_scripts() {
	echo brro_get_admin_jquery();
}


/* ========================================
   GET ADMIN STYLES AND SCRIPTS
   ======================================== */

   function brro_get_admin_jquery() {
    ob_start();
    ?>
    <script>
    jQuery(function($) {
        'use strict';
        
        console.log('Brro Flex Theme Admin loaded.');
       //
       //
       var body = $('body');
       var isSingle = body.hasClass('[class*="post-type-"]') && body.hasClass('post-new-php') || body.hasClass('post-php');
       var isRedirection = body.hasClass('tools_page_redirection');
       var isProfile = body.hasClass('user-edit-php') || body.hasClass('profile-php');
       //
       // Limit excerpt to 141 characters
       if (isSingle) {
             var maxLength = 141; // Set the maximum length for the excerpt
             var excerptText = $('#excerpt'); // Get the excerpt textarea element
             var excerptInfo = 'Wordt gebruikt als samenvatting en meta-beschrijving voor zoekmachines. Max ' + maxLength + ' karakters';
             // Add a class and text to the paragraph following the excerpt textarea
             $('textarea#excerpt + p').addClass('cust-excerpt').text(excerptInfo);
             excerptText.attr('maxlength', maxLength); // Set the maxlength attribute for the excerpt textarea
             // Add an input event listener to the excerpt textarea
             excerptText.on('input', function() {
                var text = excerptText.val(); // Get the current value of the textarea
                // If the text length exceeds the maximum length, trim it
                if (text.length > maxLength) {
                   excerptText.val(text.substring(0, maxLength));
                }
                // Update the paragraph text with the current character count
                $('textarea#excerpt + p').text(excerptInfo + ': ' + text.length + '/' + maxLength);
             });
       }
    });
    </script>
    <?php
    return ob_get_clean();
}

function brro_get_admin_css_for_all_users() {
    ob_start();
    ?>
    <style>
    /* ========================================
       ADMIN MENU CUSTOMIZATION
       ======================================== */
    
    /* Admin menu sidebar fade-in effect from brro-core-wp-admin-script.js */
    #adminmenu {
        opacity: 0;
        transition: opacity 150ms ease-in-out;
    }
    
    /* Hide default WordPress menu items */
    li#collapse-menu,
    li.wp-menu-separator {
        display: none!important;
    }
    
    /* Brro custom menu separators styling */
    .brro-separator .wp-menu-name {
        font-size: 0;
    }
    .brro-separator .wp-menu-name:after {
        font-size: 14px;
    }
    .brro-separator {
        background-color: rgba(143, 4, 86, .9);
        pointer-events: none;
    }
    .brro-separator.wp-has-current-submenu .wp-menu-image:before {
        transform: rotate(180deg);
    }
    .brro-separator:not(#toplevel_page_brro-separator-core) a {
        margin-top: 24px;
    }
    #toplevel_page_brro-help-link a {
        margin-bottom: 20px;
    }
    
    /* Brro separator menu labels */
    #toplevel_page_brro-separator-core .wp-menu-name:after {content:"Core";}
    #toplevel_page_brro-separator-functionality .wp-menu-name:after {content:"Functions";}
    #toplevel_page_brro-separator-content .wp-menu-name:after {content:"Content";}

    /* ========================================
       CONTENT EDITOR LAYOUT
       ======================================== */
    
    /* Center content editor on wide screens */
    @media (min-width: 1700px) {
        #poststuff #post-body.columns-2 {
            max-width: 1180px;
            margin-left: calc((100% - 1500px) / 2);
        }
    }

    /* ========================================
       FORM ELEMENTS & FIELDS
       ======================================== */
    
    /* Featured image section styling */
    #postimagediv h2:after {
        margin-left: 6px;
    }
    #postimagediv h2 {
        justify-content: start;
    }

    /* Hide default excerpt help text (replaced by custom) */
    textarea#excerpt + p:not(.cust-excerpt) {
        font-size: 0px !important;
    }

    /* ACF field styling */
    /* Fix select2 dropdown sizing (except for locateandfiltermap) */
    body:not(.post-type-locateandfiltermap) .select2-container .select2-selection--single {
        width: auto !important;
        height: auto !important;
    }

    /* ACF maxlength character counter display */
    div[brro-acf-data-maxlength]:before {
        content: 'Maximaal ' attr(brro-acf-data-maxlength) ' karakters';
        font-weight: 400;
        margin: 4px 0;
        font-style: italic;
    }
    </style>
    <?php
    return ob_get_clean();
}

function brro_get_admin_css_for_editors() {
    ob_start();
    ?>
    <style>
    /* ========================================
       ADMIN BAR & INTERFACE ELEMENTS
       ======================================== */
    
    /* Hide most admin bar items and footer */
    #wpadminbar li, .wp-admin #wpfooter {
        display:none!important;
    }
    
    /* Show essential admin bar items */
    #wpadminbar li#wp-admin-bar-site-name, 
    #wpadminbar li#wp-admin-bar-my-account, 
    #wpadminbar li#wp-admin-bar-logout {
        display:inherit!important;
    }
    
    /* Hide admin notices (except errors and user switching) */
    .e-notice, 
    div.notice:not(#user_switching):not(.error), 
    .updated.woocommerce-message {
        display:none!important;
    }

    /* ========================================
       ADMIN MENU CUSTOMIZATION
       ======================================== */
    
    /* Brro separator menu labels (Dutch) */
    #toplevel_page_brro-separator-core .wp-menu-name:after {
        content: "Site instellingen" !important;
    }
    #toplevel_page_brro-separator-functionality .wp-menu-name:after {
        content: "Functies" !important;
    }
    #toplevel_page_brro-separator-content .wp-menu-name:after {
        content: "Inhoud" !important;
    }

    /* ========================================
       DASHBOARD CUSTOMIZATION
       ======================================== */
    
    /* Hide default dashboard elements */
    .index-php .wrap h1,
    .index-php #dashboard-widgets-wrap {
        visibility:hidden;
    }
    
    /* Custom dashboard logo display */
    .index-php #dashboard-widgets-wrap:before {
        content: url(https://www.brro-client-website.nl/wp-content/uploads/logo.svg); /* replace with your logo */
        margin-left: calc(50% - 125px); /* 50% - half the width */
        height:250px; /* replace with your logo height */
        width:250px; /* replace with your logo width */
        filter: invert(.7); /* if needed */
        visibility: visible;
        margin-bottom:64px;
        margin-top:68px;
        display:block;
    }

    /* ========================================
       POST EDITOR CUSTOMIZATION
       ======================================== */
    
    /* Hide page template selector */
    p.page-template-label-wrapper, 
    #page_template {
        display:none!important;
    }
    
    /* Hide publishing actions (except current time and status) */
    #misc-publishing-actions > div:not(.curtime):not(.misc-pub-post-status), 
    #minor-publishing-actions {
        visibility:hidden;
        height:2px;
        overflow:hidden;
        padding:0;
    }
    
    /* Disable drag functionality for postboxes and widgets */
    #screen-meta-links,
    .handle-actions {
        display: none!important;
    }
    .js .postbox .hndle, 
    .js .widget .widget-top {
        cursor: default !important;
        pointer-events: none !important;
    }

    /* ========================================
       MEDIA LIBRARY CUSTOMIZATION
       ======================================== */
    
    /* Hide media edit/delete actions */
    .upload-php .row-actions .edit,
    .upload-php .row-actions .delete,
    .upload-php .bulkactions,
    .media-new-php a.edit-attachment {
        display:none!important;
    }
    
    /* Enhance media filename display */
    .upload-php .filename {
        font-weight:bold;
        font-size:14px;
    }

    /* ========================================
       CONTENT LISTING CUSTOMIZATION
       ======================================== */
    
    /* Hide specific admin menu items */
    li#specific-admin-menu {
        display: none;
    }
    
    /* Hide private pages from listings */
    tr.status-private {
        display: none;
    }

    /* ========================================
       FORM ELEMENTS & INSTRUCTIONS
       ======================================== */
    
    /* Excerpt field height */
    #excerpt {
        height: 8em !important;
    }
    
    /* ACF field message styling */
    .acf-field-message h2 {
        padding: 0px !important;
        font-size: 16px !important;
        font-weight: 500 !important;
    }
    
    /* Base styling for all instruction elements */
    /* Table navigation top */
    .tablenav.top:before,
    /* Featured image section */
    #postimagediv .inside:after,
    /* Excerpt field paragraph */
    textarea#excerpt + p,
    /* Content editor interface */
    #wp-content-editor-tools:before,
    /* Title section */
    #titlewrap:after,
    /* ACF field message */
    .acf-field-message {
        font-size: 13px;
        font-weight: 500;
        background-color: rgba(0, 125, 62, .07);
    }

    /* ========================================
       CONTENT-SPECIFIC INSTRUCTIONS
       ======================================== */
    
    /* Blog posts - Featured image explanation */
    .post-type-post #postimagediv .inside:after {
        content: "Wordt getoond als beeld naast de titel, en in het berichtenoverzicht.";
    }
    
    /* Specific page - Content editor explanation */
    .post-id-368 #wp-content-editor-tools:before {
        content: "Dit is de tekst onder de titel(s) en na de lead intro tekst.";
    }
    
    /* Custom post type - Content editor explanation */
    .post-type-custom-post #wp-content-editor-tools:before {
        content: "Omschrijving en details van het evenement onder de titel + afbeelding sectie."
    }

    /* ========================================
       PLUGIN ELEMENT HIDING
       ======================================== */
    
    /* Hide Yoast SEO premium badges and upsell elements */
    [class*="yoast"][class*="product"],
    [class*="yoast"][class*="upsell"],
    [class*="yoast"][class*="premium"],
    [class*="yst"][class*="product"],
    [class*="yst"][class*="upsell"],
    [class*="yst"][class*="premium"] {
        display: none !important;
    }
    </style>
    <?php
    return ob_get_clean();
}