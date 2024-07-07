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

// Show admin notice when maintenance mode is active
function csp_admin_notice() {
    $is_active = get_option('csp_is_active', false);
    if ($is_active) {
        echo '<div class="notice notice-warning is-dismissible">
            <p><strong>Maintenance Mode is active.</strong></p>
        </div>';
    }
}
add_action('admin_notices', 'csp_admin_notice');

// Add a menu item in the admin bar when maintenance mode is active
function csp_admin_bar_menu($wp_admin_bar) {
    $is_active = get_option('csp_is_active', false);
    if ($is_active) {
        $wp_admin_bar->add_node(array(
            'id'    => 'csp-maintenance-mode',
            'title' => 'Maintenance Mode Active',
            'href'  => admin_url('options-general.php?page=csp-settings'),
            'meta'  => array('class' => 'csp-maintenance-mode')
        ));
    }
}
add_action('admin_bar_menu', 'csp_admin_bar_menu', 100);

// Add settings link on plugin installer page
function csp_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=csp-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'csp_add_settings_link');
?>
