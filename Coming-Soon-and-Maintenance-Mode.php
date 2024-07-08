<?php
/*
Plugin Name: Coming Soon and Maintenance Mode
Description: Show a coming soon / Maintenance Mode page on specific pages and disable it for selected users.
Version: 0.1
Author: Preprocessor Byte Team
*/

// Define plugin path constants
define('csmp_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('csmp_PLUGIN_URL', plugin_dir_url(__FILE__));
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include required files
require_once csmp_PLUGIN_DIR . 'includes/enqueue.php';
require_once csmp_PLUGIN_DIR . 'includes/display.php';
require_once csmp_PLUGIN_DIR . 'includes/settings.php';
require_once csmp_PLUGIN_DIR . 'includes/customizer.php';


// Show admin notice when maintenance mode is active
function csmp_admin_notice() {
    $is_active = get_option('csmp_is_active', false);
    if ($is_active) {
        echo '<div class="notice notice-warning is-dismissible">
            <p><strong>Maintenance Mode </strong></p>
        </div>';
    }
}
add_action('admin_notices', 'csmp_admin_notice');

// Add a menu item in the admin bar when maintenance mode is active
function csmp_admin_bar_menu($wp_admin_bar) {
    $is_active = get_option('csmp_is_active', false);
    if ($is_active) {
        $wp_admin_bar->add_node(array(
            'id'    => 'csmp-maintenance-mode',
            'title' => 'Maintenance Mode Active',
            'href'  => admin_url('options-general.php?page=csmp-settings'),
            'meta'  => array('class' => 'csmp-maintenance-mode')
        ));
    }
}
add_action('admin_bar_menu', 'csmp_admin_bar_menu', 100);

// Add settings link on plugin installer page
// Add settings link on plugin installer page
function csmp_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=csmp-settings">Settings</a>';
    $customize_link = '<a href="' . admin_url('customize.php?return=' . urlencode(admin_url('options-general.php?page=csmp-settings'))) . '">Customize</a>';
    
    array_unshift($links, $settings_link, $customize_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'csmp_add_settings_link');

?>