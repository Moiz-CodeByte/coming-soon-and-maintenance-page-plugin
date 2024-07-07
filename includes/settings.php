<?php
// Add settings page to admin menu
function csmp_add_admin_menu() {
    add_options_page(
        'Maintenance Page Settings',
        'Maintenance Page',
        'manage_options',
        'csmp-settings',
        'csmp_settings_page'
    );
}
add_action('admin_menu', 'csmp_add_admin_menu');

// Register settings
function csmp_register_settings() {
    register_setting('csmp_settings_group', 'csmp_is_active');
    register_setting('csmp_settings_group', 'csmp_page_ids');
    register_setting('csmp_settings_group', 'csmp_allowed_users');
    register_setting('csmp_settings_group', 'csmp_coming_soon_page_id');
    register_setting('csmp_settings_group', 'csmp_disable_header');
    register_setting('csmp_settings_group', 'csmp_disable_footer');
}
add_action('admin_init', 'csmp_register_settings');

// Settings page content
function csmp_settings_page() {
    $is_active = get_option('csmp_is_active', false);
    $page_ids = get_option('csmp_page_ids', array());
    $allowed_users = get_option('csmp_allowed_users', array());
    $coming_soon_page_id = get_option('csmp_coming_soon_page_id');
    $disable_header = get_option('csmp_disable_header', false);
    $disable_footer = get_option('csmp_disable_footer', false);

    $page_ids = is_array($page_ids) ? $page_ids : explode(',', $page_ids);
    $allowed_users = is_array($allowed_users) ? $allowed_users : explode(',', $allowed_users);

    $users = get_users();
    $pages = get_pages();
    ?>
    <div class="wrap">
        <h1>Maintenance Page Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('csmp_settings_group'); ?>
            <?php do_settings_sections('csmp_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Activate Maintenance Page</th>
                    <td>
                        <input type="checkbox" id="csmp_is_active" name="csmp_is_active" value="1" <?php checked(1, $is_active); ?> />
                    </td>
                </tr>
                <tr valign="top" class="csmp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Select Pages</th>
                    <td>
                        <select name="csmp_page_ids[]" multiple>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->ID; ?>" <?php selected(in_array($page->ID, $page_ids)); ?>>
                                    <?php echo $page->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Hold down the Ctrl (windows) / Command (Mac) button to select multiple pages.</p>
                    </td>
                </tr>
                <tr valign="top" class="csmp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Disable Maintenance Page for Users</th>
                    <td>
                        <?php foreach ($users as $user): ?>
                            <label>
                                <input type="checkbox" name="csmp_allowed_users[]" value="<?php echo $user->ID; ?>" <?php checked(in_array($user->ID, $allowed_users)); ?>>
                                <?php echo $user->display_name; ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr valign="top" class="csmp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Select Maintenance Page</th>
                    <td>
                        <select name="csmp_coming_soon_page_id">
                            <option value="">Select a maintenance page</option>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?php echo $page->ID; ?>" <?php selected($page->ID, $coming_soon_page_id); ?>>
                                    <?php echo $page->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top" class="csmp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Disable Header</th>
                    <td>
                        <input type="checkbox" id="csmp_disable_header" name="csmp_disable_header" value="1" <?php checked(1, $disable_header); ?> />
                    </td>
                </tr>
                <tr valign="top" class="csmp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Disable Footer</th>
                    <td>
                        <input type="checkbox" id="csmp_disable_footer" name="csmp_disable_footer" value="1" <?php checked(1, $disable_footer); ?> />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>