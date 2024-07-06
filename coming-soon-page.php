<?php
/*
Plugin Name: Coming Soon Page
Description: Show a coming soon page on specific pages and disable it for selected users.
Version: 1.2
Author: Your Name
*/

// Enqueue styles
function csp_enqueue_styles() {
    wp_enqueue_style('csp-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'csp_enqueue_styles');

// Function to show the coming soon page
function csp_show_coming_soon() {
    $page_ids = get_option('csp_page_ids', array()); // Get the page IDs from the settings
    $allowed_users = get_option('csp_allowed_users', array()); // Get allowed users from settings

    // Get the current user
    $current_user = wp_get_current_user();

    // Check if the current page is in the specified pages and the user is not in the allowed users list
    if (is_page($page_ids) && !in_array($current_user->ID, $allowed_users)) {
        // Display the coming soon page content
        echo '<div class="coming-soon">Coming Soon</div>';
        exit; // Stop further execution to prevent the actual page from loading
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
    register_setting('csp_settings_group', 'csp_page_ids');
    register_setting('csp_settings_group', 'csp_allowed_users');
}
add_action('admin_init', 'csp_register_settings');

// Settings page content
function csp_settings_page() {
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
                    <th scope="row">Select Pages</th>
                    <td>
                        <select name="csp_page_ids[]" multiple>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->ID; ?>" <?php echo in_array($page->ID, get_option('csp_page_ids', array())) ? 'selected' : ''; ?>>
                                    <?php echo $page->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Hold down the Ctrl (windows) / Command (Mac) button to select multiple pages.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Allow Users</th>
                    <td>
                        <?php foreach ($users as $user): ?>
                            <label>
                                <input type="checkbox" name="csp_allowed_users[]" value="<?php echo $user->ID; ?>" <?php echo in_array($user->ID, get_option('csp_allowed_users', array())) ? 'checked' : ''; ?>>
                                <?php echo $user->display_name; ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
