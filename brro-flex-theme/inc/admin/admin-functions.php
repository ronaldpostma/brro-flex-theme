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
   ADMIN STYLES AND SCRIPTS
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
    /* CSS for everybody in WP Admin */
    /* WP Sidebar */
    #adminmenu {
        opacity: 0;
        transition: opacity 150ms ease-in-out;
    }

    /* Content editor */
    @media (min-width: 1700px) {
        #poststuff #post-body.columns-2 {
            max-width: 1180px;
            margin-left: calc((100% - 1500px) / 2);
        }
    }

    /* Hide items by default */
    li#collapse-menu,
    li.wp-menu-separator {
        display: none!important;
    }

    /* Brro Separators */
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
    #toplevel_page_brro-separator-core .wp-menu-name:after {content:"Core";}
    #toplevel_page_brro-separator-functionality .wp-menu-name:after {content:"Functions";}
    #toplevel_page_brro-separator-content .wp-menu-name:after {content:"Content";}

    /* Uitleg bij featured image */
    #postimagediv h2:after {
        margin-left: 6px;
    }
    #postimagediv h2 {
        justify-content: start;
    }

    /* Tekst uitleg bij 'samenvatting */
    textarea#excerpt + p:not(.cust-excerpt) {
        font-size: 0px !important;
    }

    /* link select ACF */
    body:not(.post-type-locateandfiltermap) .select2-container .select2-selection--single {
        width: auto !important;
        height: auto !important;
    }

    /* :before character length ACF */
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
    /* Display > none 
    * Hide all links in top menu and page attributes */ 
    #wpadminbar li, .wp-admin #wpfooter,
    /* Notices */
    .e-notice, div.notice:not(#user_switching):not(.error), .updated.woocommerce-message,
    /*attributes*/
    p.page-template-label-wrapper, #page_template {
        display:none!important;
    }

    /* Display > reset initial
    * Show Admin top menu */
    #wpadminbar li#wp-admin-bar-site-name, #wpadminbar li#wp-admin-bar-my-account, #wpadminbar li#wp-admin-bar-logout {
        display:inherit!important;
    }

    /* Customize media page */
    .upload-php .row-actions .edit,
    .upload-php .row-actions .delete,
    .upload-php .bulkactions,
    .media-new-php a.edit-attachment {
        display:none!important;
    }
    .upload-php .filename {
        font-weight:bold;
        font-size:14px;
    }
                
    /* Hide publishing actions in pages and posts */
    #misc-publishing-actions > div:not(.curtime):not(.misc-pub-post-status), 
    #minor-publishing-actions {
        visibility:hidden;
        height:2px;
        overflow:hidden;
        padding:0;
    }

    /* Custom dashboard */
    .index-php .wrap h1,
    .index-php #dashboard-widgets-wrap {
        visibility:hidden;
    }
    .index-php #dashboard-widgets-wrap:before {
        visibility: visible;
        margin-bottom:64px;
        margin-top:68px;
        display:block;
    }
    /* ========================================
    ADMIN MENU CUSTOMIZATION
    ======================================== */

    /* Admin Menu Brro separator titles */
    #toplevel_page_brro-separator-core .wp-menu-name:after {
        content: "Site instellingen" !important;
    }
    #toplevel_page_brro-separator-functionality .wp-menu-name:after {
        content: "Webshop & Instellingen" !important;
    }
    #toplevel_page_brro-separator-content .wp-menu-name:after {
        content: "Inhoud" !important;
    }

    /* ========================================
    ELEMENT HIDING & DISPLAY CONTROL
    ======================================== */

    /* Hide specific elements */
    li#specific-admin-menu,
    /* Hide private pages */
    tr.status-private {
        display: none;
    }

    /* Disable drag postboxes & Meta links */
    #screen-meta-links,
    .handle-actions {
        /**/display: none!important;/**/
    }

    /* Disable drag functionality for postboxes and widgets */
    .js .postbox .hndle, 
    .js .widget .widget-top {
        /**/cursor: default !important;
        pointer-events: none !important;/**/
    }

    /* ========================================
    YOAST SEO PREMIUM BADGES
    ======================================== */

    /* Hide Yoast premium badges and upsell elements */
    [class*="yoast"][class*="product"],
    [class*="yoast"][class*="upsell"],
    [class*="yoast"][class*="premium"],
    [class*="yst"][class*="product"],
    [class*="yst"][class*="upsell"],
    [class*="yst"][class*="premium"] {
        display: none !important;
    }

    /* ========================================
    CUSTOM DASHBOARD
    ======================================== */

    /* Custom dashboard logo */
    .index-php #dashboard-widgets-wrap:before {
        content: url(https://www.brro-client-website.nl/wp-content/uploads/logo.svg);
        margin-left: calc(50% - 327px); /* 50% - half the width */
        filter: invert(.7); /* if needed */
    }

    /* ========================================
    FORM ELEMENT STYLING
    ======================================== */

    /* General styling of instruction elements */
    #excerpt {
        height: 8em !important;
    }

    .acf-field-message h2 {
        padding: 0px !important;
        font-size: 16px !important;
        font-weight: 500 !important;
    }

    /* ========================================
    INSTRUCTION ELEMENTS STYLING
    ======================================== */

    /* Base styling for all instruction elements */
    .tablenav.top:before,
    /* Explanation for featured image */
    #postimagediv .inside:after,
    /* Explanation for summary */
    textarea#excerpt + p,
    /* Explanation for native WordPress content editor */
    #wp-content-editor-tools:before,
    /* Explanation for title edit */
    #titlewrap:after,
    /* ACF info block */
    .acf-field-message {
        font-size: 13px;
        font-weight: 500;
        background-color: rgba(0, 125, 62, .07);
    }

    /* ========================================
    CONTENT-SPECIFIC INSTRUCTIONS
    ======================================== */

    /* 
    * Instruction simple content with :after 
    */

    /* Blog / single post - Featured image explanation */
    .post-type-post #postimagediv .inside:after {
        content: "Wordt getoond als beeld naast de titel, en in het berichtenoverzicht.";
    }

    /* Specific page - Content editor explanation */
    .post-id-368 #wp-content-editor-tools:before {
        content: "Dit is de tekst onder de titel(s) en na de lead intro tekst.";
    }

    /* Custom post - Content editor explanation */
    .post-type-custom-post #wp-content-editor-tools:before {
        content: "Omschrijving en details van het evenement onder de titel + afbeelding sectie."
    }
    </style>
    <?php
    return ob_get_clean();
}