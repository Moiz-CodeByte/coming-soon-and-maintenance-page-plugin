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
    register_setting('csmp_settings_group', 'csmp_disable_header_footer');

}
add_action('admin_init', 'csmp_register_settings');

// Settings page content
function csmp_settings_page() {
    $is_active = get_option('csmp_is_active', false);
    $page_ids = get_option('csmp_page_ids', array());
    $allowed_users = get_option('csmp_allowed_users', array());
    $coming_soon_page_id = get_option('csmp_coming_soon_page_id');
    $disable_hf = get_option('csmp_disable_header_footer', false);


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
                    <th scope="row">Activate on specific Pages</th>
                    <td>
                        <select name="csmp_page_ids[]" multiple="multiple" class="csmp-page-select">
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
                    <th scope="row">Whitelist Specific Users</th>
                    <td>
                        <select name="csmp_allowed_users[]" multiple="multiple" class="csmp-users-select">
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user->ID; ?>" <?php selected(in_array($user->ID, $allowed_users)); ?>>
                                    <?php echo $user->display_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Hold down the Ctrl (windows) / Command (Mac) button to select multiple users.</p>
                    </td>
                </tr>
                <tr valign="top" class="csmp-settings-options" <?php if (!$is_active) echo 'style="display:none;"'; ?>>
                    <th scope="row">Select Maintenance Page</th>
                    <td>
                        <select name="csmp_coming_soon_page_id" class="csmp-coming-soon-page">
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
                    <th scope="row">Disable Header Footer</th>
                    <td>
                        <input type="checkbox" id="csmp_disable_header_footer" name="csmp_disable_header_footer" value="1" <?php checked(1, $disable_hf); ?> />
                    </td>
                </tr>
              
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
    jQuery(document).ready(function($) {
        // Initialize Select2 for pages and users
        $('.csmp-page-select').select2({
            width: '50%',
            placeholder: 'Select pages',
            allowClear: true // Option to clear selection
        });

        $('.csmp-users-select').select2({
            width: '50%',
            placeholder: 'Select users',
            allowClear: true 
        });

        $('.csmp-coming-soon-page').select2({
            width: '50%',
            placeholder: 'Select a maintenance page',
            allowClear: true
        });
    });
    </script>
    <?php
}

?>