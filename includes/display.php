<?php
// Function to show the coming soon page
function csp_show_coming_soon() {
    $is_active = get_option('csp_is_active', false);
    $page_ids = get_option('csp_page_ids', array());
    $allowed_users = get_option('csp_allowed_users', array());
    $coming_soon_page_id = get_option('csp_coming_soon_page_id');
    $disable_header = get_option('csp_disable_header', false);
    $disable_footer = get_option('csp_disable_footer', false);

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
add_action('template_redirect', 'csp_show_coming_soon');
?>
