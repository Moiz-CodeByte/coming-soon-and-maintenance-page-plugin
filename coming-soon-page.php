<?php
/*
Plugin Name: Coming Soon Page
Description: Show a coming soon page on specific pages and disable it for selected users.
Version: 1.6
Author: Your Name
*/

// Enqueue styles and scripts
function csp_enqueue_styles_scripts() {
    // Enqueue plugin styles
    wp_enqueue_style('csp-style', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('csp-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), false, true);

    // Check if Elementor is active and enqueue its assets
    if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Plugin')) {
        $elementor = \Elementor\Plugin::$instance;

        // Enqueue Elementor styles
        $elementor->frontend->enqueue_styles();

        // Enqueue Elementor scripts
        $elementor->frontend->enqueue_scripts();
    }
}
add_action('wp_enqueue_scripts', 'csp_enqueue_styles_scripts');
add_action('admin_enqueue_scripts', 'csp_enqueue_styles_scripts');

// Function to show the coming soon page
function csp_show_coming_soon() {
    $is_active = get_option('csp_is_active', false);
    $page_ids = get_option('csp_page_ids', array()); // Get the page IDs from the settings
    $allowed_users = get_option('csp_allowed_users', array()); // Get allowed users from settings
    $coming_soon_page_id = get_option('csp_coming_soon_page_id'); // Get the Coming Soon page ID

    // Ensure options are arrays
    if (!is_array($page_ids)) {
        $page_ids = explode(',', $page_ids); // Convert comma-separated string to array
    }
    if (!is_array($allowed_users)) {
        $allowed_users = explode(',', $allowed_users); // Convert comma-separated string to array
    }

    // Get the current user
    $current_user = wp_get_current_user();

    // Check if the plugin is active, current page is in the specified pages, and the user is not in the allowed users list
    if ($is_active && is_page($page_ids) && !in_array($current_user->ID, $allowed_users)) {
        // Display the selected coming soon page content
        if ($coming_soon_page_id) {
            // Render the full page
            $coming_soon_page = get_post($coming_soon_page_id);
            if ($coming_soon_page) {
                global $post;
                $post = $coming_soon_page;
                setup_postdata($post);
                get_header();
                the_content();
                get_footer();
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

// Add settings page to admin menu
function csp_add_admin_menu() {
    add_options_page(
        'Coming Soon Page Settings',
        'Coming Soon Page',
        'manage_options',
        'csp-settings',
        'csp_settings_page'
    );
}
add_action('admin_menu', 'csp_add_admin_menu');

// Register settings
function csp_register_settings() {
    register_setting('csp_settings_group', 'csp_is_active');
    register_setting('csp_settings_group', 'csp_page_ids');
    register_setting('csp_settings_group', 'csp_allowed_users');
    register_setting('csp_settings_group', 'csp_coming_soon_page_id');
}
add_action('admin_init', 'csp_register_settings');

// Settings page content
function csp_settings_page() {
    $is_active = get_option('csp_is_active', false);
    $page_ids = get_option('csp_page_ids', array());
    $allowed_users = get_option('csp_allowed_users', array());
    $coming_soon_page_id = get_option('csp_coming_soon_page_id');

    // Ensure options are arrays
    if (!is_array($page_ids)) {
        $page_ids = explode(',', $page_ids); // Convert comma-separated string to array
    }
    if (!is_array($allowed_users)) {
        $allowed_users = explode(',', $allowed_users); // Convert comma-separated string to array
    }

    $users = get_users();
    $pages = get_pages();
    ?>
    <div class="wrap">
        <h1>Coming Soon Page Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('csp_settings_group'); ?>
            <?php do_settings_sections('csp_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Activate Coming Soon Page</th>
                    <td>
                        <input type="checkbox" id="csp_is_active" name="csp_is_active" value="1" <?php checked(1, $is_active); ?> />
                    </td>
                </tr>
                <tr valign="top" class="csp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Select Pages</th>
                    <td>
                        <select name="csp_page_ids[]" multiple>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->ID; ?>" <?php selected(in_array($page->ID, $page_ids)); ?>>
                                    <?php echo $page->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Hold down the Ctrl (windows) / Command (Mac) button to select multiple pages.</p>
                    </td>
                </tr>
                <tr valign="top" class="csp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Allow Users</th>
                    <td>
                        <?php foreach ($users as $user): ?>
                            <label>
                                <input type="checkbox" name="csp_allowed_users[]" value="<?php echo $user->ID; ?>" <?php checked(in_array($user->ID, $allowed_users)); ?>>
                                <?php echo $user->display_name; ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr valign="top" class="csp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Select Coming Soon Page</th>
                    <td>
                        <select name="csp_coming_soon_page_id">
                            <option value="">Select a page</option>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->ID; ?>" <?php selected($page->ID, $coming_soon_page_id); ?>>
                                    <?php echo $page->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add settings link on plugin installer page
function csp_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=csp-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'csp_add_settings_link');
?>
