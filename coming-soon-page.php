<?php
/*
Plugin Name: Coming Soon Page
Description: Show a coming soon page on a specific page and disable it for selected users.
Version: 1.0
Author: Your Name
*/

function csp_enqueue_styles() {
    wp_enqueue_style('csp-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'csp_enqueue_styles');

function csp_show_coming_soon() {
    // Specify the page ID where the coming soon page should be shown
    $page_id = 5; // Use the page ID you found

    // Get the current user
    $current_user = wp_get_current_user();

    // List of user IDs who can see the actual page instead of coming soon page
    $allowed_users = array( 2, 3); // Add user IDs who can bypass coming soon page

    // Check if the current page is the specified page and the user is not in the allowed users list
    if (is_page($page_id) && !in_array($current_user->ID, $allowed_users)) {
        // Display the coming soon page content
        echo '<div class="coming-soon">Coming Soon</div>';
        exit; // Stop further execution to prevent the actual page from loading
    }
}
add_action('template_redirect', 'csp_show_coming_soon');
?>
