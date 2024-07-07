<?php
// Function to show the coming soon page
function csmp_show_coming_soon() {
    $is_active = get_option('csmp_is_active', false);
    $page_ids = get_option('csmp_page_ids', array());
    $allowed_users = get_option('csmp_allowed_users', array());
    $coming_soon_page_id = get_option('csmp_coming_soon_page_id');
    $disable_header = get_option('csmp_disable_header', false);
    $disable_footer = get_option('csmp_disable_footer', false);

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
                if (!$disable_header) {
                    get_header();
                }
                the_content();
                if (!$disable_footer) {
                    get_footer();
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