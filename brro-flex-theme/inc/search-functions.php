<?php
//
// ******************************************************************************************************************************************************************** Search
// Index of Functions
//
// 1. brro_redirect_search_results
//      - Site uses no search results page, so we redirect to the home page with a search query.
//
// Search TITLE AND SUMMARY
add_action('template_redirect', 'brro_redirect_search_results');
function brro_redirect_search_results() {
    if (is_search()) {
        wp_redirect(home_url('/?s=' . urlencode(get_search_query())));
        exit;
    }
}