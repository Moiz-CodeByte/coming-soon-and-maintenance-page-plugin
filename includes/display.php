<?php
// Function to show the coming soon page
function csmp_show_coming_soon() {
    $is_active = get_option('csmp_is_active', false);
    $page_ids = get_option('csmp_page_ids', array());
    $allowed_users = get_option('csmp_allowed_users', array());
    $coming_soon_page_id = get_option('csmp_coming_soon_page_id');
    $disable_hf = get_option('csmp_disable_header_footer', false);

    $page_ids = is_array($page_ids) ? $page_ids : explode(',', $page_ids);
    $allowed_users = is_array($allowed_users) ? $allowed_users : explode(',', $allowed_users);

    $current_user = wp_get_current_user();

    if ($is_active && is_page($page_ids) && !in_array($current_user->ID, $allowed_users)) {
        if ($coming_soon_page_id) {
            $coming_soon_page = get_post($coming_soon_page_id);
            if ($coming_soon_page) {
                global $post;
                $post = $coming_soon_page;
                setup_postdata($post);
                ?>
                <!DOCTYPE html>
                <html <?php language_attributes(); ?>>
                <head>
                    <meta charset="<?php bloginfo('charset'); ?>">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Maintenance Mode</title>
                    <?php wp_head(); ?>
                    <style>
                        body, html {
                            margin: 0;
                            padding: 0;
                        }
                        footer {
                            background-color: <?php echo esc_attr(get_theme_mod('csmp_footer_bg_color', '#ffffff')); ?>;
                            color: <?php echo esc_attr(get_theme_mod('csmp_footer_text_color', '#000000')); ?>;
                            padding: 20px;
                            position: absolute;
                            bottom: 0;
                            width: 100%;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            overflow-x: hidden; /* Prevent horizontal scrolling */
                        }
                        .footer-text {
                            flex: 1; /* Take up remaining space */
                            text-align: left;
                            white-space: nowrap; /* Prevent line breaks */
                            overflow: hidden; /* Hide overflow text if needed */
                        }
                        .social-icons {
                            text-align: right;
                            white-space: nowrap; /* Prevent line breaks */
                        }
                        .social-icon {
                            display: inline-block;
                            margin-left: 10px; /* Adjust spacing between icons */
                        }
                        .social-icon img {
                            max-width: 100%;
                            height: auto; /* Maintain aspect ratio */
                            border-radius: 50%;
                        }
                    </style>
                </head>
                <body <?php body_class(); ?>>
                    <?php
                    if (!$disable_hf) {
                        get_header();
                    }
                    the_content();
                    if (!$disable_hf) {
                        get_footer();
                    } else {
                        ?>
                        <footer>
                            <span class="footer-text"><?php echo esc_html(get_theme_mod('csmp_footer_text', '')); ?></span>
                            <span class="social-icons">
                                <?php
                                // Loop through each social icon
                                for ($i = 1; $i <= 5; $i++) {
                                    $social_icon_image = get_theme_mod('csmp_social_icon_' . $i . '_image', '');
                                    $social_icon_bg_color = get_theme_mod('csmp_social_icon_' . $i . '_bg_color', '#ffffff');
                                    $social_icon_size = get_theme_mod('csmp_social_icon_' . $i . '_size', '24px');
                                    $social_icon_link = get_theme_mod('csmp_social_icon_' . $i . '_link', '');

                                    if (!empty($social_icon_image) && !empty($social_icon_link)) {
                                        ?>
                                        <span class="social-icon">
                                            <a href="<?php echo esc_url($social_icon_link); ?>" target="_blank" style="background-color: <?php echo esc_attr($social_icon_bg_color); ?>; display: inline-block; padding: 5px;">
                                                <img src="<?php echo esc_url($social_icon_image); ?>" alt="Social Icon" style="width: <?php echo esc_attr($social_icon_size); ?>;">
                                            </a>
                                        </span>
                                        <?php
                                    }
                                }
                                ?>
                            </span>
                        </footer>
                        <?php
                    }
                    wp_reset_postdata();
                    wp_footer();
                    ?>
                </body>
                </html>
                <?php
                exit;
            }
        } else {
            echo '<div class="coming-soon">Coming Soon</div>';
            exit;
        }
    }
}
add_action('template_redirect', 'csmp_show_coming_soon');

?>
