<?php
/*
Plugin Name: Coming Soon and Maintenance Mode
Description: Show a coming soon / Maintenance Mode page on specific pages and disable it for selected users.
Version: 0.1
Author: Preprocessor Byte Team
*/

// Define plugin path constants
define('CSP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once CSP_PLUGIN_DIR . 'includes/enqueue.php';
require_once CSP_PLUGIN_DIR . 'includes/display.php';
require_once CSP_PLUGIN_DIR . 'includes/settings.php';

// Add settings link on plugin installer page
function csp_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=csp-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'csp_add_settings_link');
