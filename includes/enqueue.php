<?php

// Enqueue styles and scripts
function csp_enqueue_styles_scripts() {
    wp_enqueue_style('csp-style', CSP_PLUGIN_URL . 'assets/style.css');
    wp_enqueue_script('csp-script', CSP_PLUGIN_URL . 'assets/script.js', array('jquery'), false, true);

    if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Plugin')) {
        wp_enqueue_style('elementor-frontend');
    }
}
add_action('wp_enqueue_scripts', 'csp_enqueue_styles_scripts');
add_action('admin_enqueue_scripts', 'csp_enqueue_styles_scripts');
