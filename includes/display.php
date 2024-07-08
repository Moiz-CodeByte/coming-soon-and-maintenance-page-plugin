<?php
// Function to show the coming soon page
function csmp_show_coming_soon() {
    $is_active = get_option('csmp_is_active', false);
    $page_ids = get_option('csmp_page_ids', array());
    $allowed_users = get_option('csmp_allowed_users', array());
    $coming_soon_page_id = get_option('csmp_coming_soon_page_id');
    $disable_hf = get_option('csmp_disable_header_footer', false);
    $footer_text = get_theme_mod('csmp_footer_text', '');
    $footer_bg_color = get_theme_mod('csmp_footer_bg_color', '#ffffff');
    $footer_text_color = get_theme_mod('csmp_footer_text_color', '#000000');

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
        <html>
        <head>
            <title>Maintenance Mode</title>
            <style>
                
                footer {
                    background-color: <?php echo esc_attr($footer_bg_color); ?>;
                    color: <?php echo esc_attr($footer_text_color); ?>;
                    padding: 20px;
                    position: absolute;
                    bottom: 0;
                    width: 100%;
                    text-align: center;
                }
            </style>
        </head>
        </html>
                

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
                <p><?php echo esc_html($footer_text); ?></p>
            </footer>
                    <?php
                }

                wp_reset_postdata();
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
