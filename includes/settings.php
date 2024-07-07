<?php
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
    register_setting('csp_settings_group', 'csp_disable_header');
    register_setting('csp_settings_group', 'csp_disable_footer');
}
add_action('admin_init', 'csp_register_settings');

// Settings page content
function csp_settings_page() {
    $is_active = get_option('csp_is_active', false);
    $page_ids = get_option('csp_page_ids', array());
    $allowed_users = get_option('csp_allowed_users', array());
    $coming_soon_page_id = get_option('csp_coming_soon_page_id');
    $disable_header = get_option('csp_disable_header', false);
    $disable_footer = get_option('csp_disable_footer', false);

    $page_ids = is_array($page_ids) ? $page_ids : explode(',', $page_ids);
    $allowed_users = is_array($allowed_users) ? $allowed_users : explode(',', $allowed_users);

    $users = get_users();
    $pages = get_pages();
    ?>
    <div class="wrap">
        <h1>Maintenance Page Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('csp_settings_group'); ?>
            <?php do_settings_sections('csp_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Activate Maintenance Page</th>
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
                    <th scope="row">Disable Maintenance Page for Users</th>
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
                    <th scope="row">Select Maintenance Page</th>
                    <td>
                        <select name="csp_coming_soon_page_id">
                            <option value="">Select a maintenance page</option>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->ID; ?>" <?php selected($page->ID, $coming_soon_page_id); ?>>
                                    <?php echo $page->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top" class="csp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Disable Header</th>
                    <td>
                        <input type="checkbox" id="csp_disable_header" name="csp_disable_header" value="1" <?php checked(1, $disable_header); ?> />
                    </td>
                </tr>
                <tr valign="top" class="csp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Disable Footer</th>
                    <td>
                        <input type="checkbox" id="csp_disable_footer" name="csp_disable_footer" value="1" <?php checked(1, $disable_footer); ?> />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
