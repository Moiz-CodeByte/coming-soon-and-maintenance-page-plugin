<?php
// Enqueue styles and scripts
function csmp_enqueue_styles_scripts() {
    wp_enqueue_style('csmp-style', csmp_PLUGIN_URL . 'assets/style.css');
    wp_enqueue_script('csmp-script', csmp_PLUGIN_URL . 'assets/script.js', array('jquery'), false, true);

    // Check if Elementor is active and enqueue its assets
    if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Plugin')) {
        wp_enqueue_style('elementor-frontend');
    }
}
add_action('wp_enqueue_scripts', 'csmp_enqueue_styles_scripts');

function csmp_enqueue_admin_styles() {
    wp_enqueue_style('csmp-admin-style', csmp_PLUGIN_URL . 'assets/admin-style.css');
}
add_action('admin_enqueue_scripts', 'csmp_enqueue_admin_styles');
?>