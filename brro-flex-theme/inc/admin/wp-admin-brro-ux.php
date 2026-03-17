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
       SITE SPECIFIC CSS, FOR ALL USERS
       ======================================== */
    
    </style>
    <?php
    return ob_get_clean();
}

function brro_get_admin_css_for_editors() {
    ob_start();
    ?>
    <style>
    /* ========================================
       ADMIN MENU CUSTOMIZATION
       ======================================== */
    
    /* Brro separator menu labels (Dutch) */
    #toplevel_page_brro-separator-core .wp-menu-name:after {
        content: "Site kern" !important;
    }
    #toplevel_page_brro-separator-functionality .wp-menu-name:after {
        content: "Instellingen" !important;
    }
    #toplevel_page_brro-separator-content .wp-menu-name:after {
        content: "Inhoud" !important;
    }

    /* ========================================
       POST EDITOR CUSTOMIZATION
       ======================================== */

    /* Disable drag functionality for postboxes and widgets */
    /**/
    #screen-meta-links,
    .handle-actions {
        display: none!important;
    }
    .js .postbox .hndle, 
    .js .widget .widget-top {
        cursor: default !important;
        pointer-events: none !important;
    }
    /**/

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
    
    /* Projects - Featured image explanation */
    .post-type-post #postimagediv .inside:after {
        content: "Wordt getoond als beeld voor SEO.";
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
    /* Yoast elements */
    .yst-replacevar,
    #snippet-editor-field-3-slug,
    #yoast-google-preview-slug-metabox {
        opacity: 0.6;
        pointer-events: none;
    }
    #wpseo-section-social .yst-replacevar {
        opacity: 1!important;
        pointer-events:auto!important;
    }
    </style>
    <?php
    return ob_get_clean();
}