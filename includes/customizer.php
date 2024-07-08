<?php

function csmp_customize_register($wp_customize) {
    // Footer Section
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
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'csmp_footer_bg_color_control', array(
        'label'    => __('Footer Background Color', 'csmp'),
        'section'  => 'csmp_footer_section',
        'settings' => 'csmp_footer_bg_color',
    )));

    $wp_customize->add_setting('csmp_footer_text_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'csmp_footer_text_color_control', array(
        'label'    => __('Footer Text Color', 'csmp'),
        'section'  => 'csmp_footer_section',
        'settings' => 'csmp_footer_text_color',
    )));

    // Social Icons Section
    $wp_customize->add_section('csmp_social_icons_section', array(
        'title'    => __('Social Icons', 'csmp'),
        'priority' => 31,
    ));

    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting('csmp_social_icon_' . $i . '_image');
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'csmp_social_icon_' . $i . '_image_control', array(
            'label'    => __('Social Icon', 'csmp') . ' ' . $i . __(' Image', 'csmp'),
            'section'  => 'csmp_social_icons_section',
            'settings' => 'csmp_social_icon_' . $i . '_image',
        )));

        $wp_customize->add_setting('csmp_social_icon_' . $i . '_bg_color', array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'csmp_social_icon_' . $i . '_bg_color_control', array(
            'label'    => __('Social Icon', 'csmp') . ' ' . $i . __(' Background Color', 'csmp'),
            'section'  => 'csmp_social_icons_section',
            'settings' => 'csmp_social_icon_' . $i . '_bg_color',
        )));

        // Icon size for social icon
        $wp_customize->add_setting('csmp_social_icon_' . $i . '_size', array(
            'default'           => '24px',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('csmp_social_icon_' . $i . '_size_control', array(
            'label'    => __('Social Icon', 'csmp') . ' ' . $i . __(' Size', 'csmp'),
            'section'  => 'csmp_social_icons_section',
            'settings' => 'csmp_social_icon_' . $i . '_size',
            'type'     => 'text',
        ));

        // Link for social icon
        $wp_customize->add_setting('csmp_social_icon_' . $i . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('csmp_social_icon_' . $i . '_link_control', array(
            'label'    => __('Social Icon', 'csmp') . ' ' . $i . __(' Link', 'csmp'),
            'section'  => 'csmp_social_icons_section',
            'settings' => 'csmp_social_icon_' . $i . '_link',
            'type'     => 'text',
        ));
    }
}

add_action('customize_register', 'csmp_customize_register');
?>