<?php 

function csmp_customize_register($wp_customize) {

    $wp_customize->add_section('csmp_footer_section', array(
        'title'    => __('Footer Settings', 'csmp'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('csmp_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('csmp_footer_text_control', array(
        'label'    => __('Footer Text', 'csmp'),
        'section'  => 'csmp_footer_section',
        'settings' => 'csmp_footer_text',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('csmp_footer_bg_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'csmp_footer_bg_color_control', array(
        'label'    => __('Footer Background Color', 'csmp'),
        'section'  => 'csmp_footer_section',
        'settings' => 'csmp_footer_bg_color',
    )));

    $wp_customize->add_setting('csmp_footer_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'csmp_footer_text_color_control', array(
        'label'    => __('Footer Text Color', 'csmp'),
        'section'  => 'csmp_footer_section',
        'settings' => 'csmp_footer_text_color',
    )));
}

add_action('customize_register', 'csmp_customize_register');
?>