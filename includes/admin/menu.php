<?php
/*
* Register menu
*/

function yacht_manager_add_menu_page() {
    add_menu_page(
        'Yacht Manager',
        'Yacht Manager',
        'manage_options',
        'yacht-manager',
        'yacht_manager_dashboard_menu',
        'dashicons-admin-tools',
        99                        
    );

    // Add a Submenu Page under "Yacht Manager"
    add_submenu_page(
        'yacht-manager',
        'Color Settings',
        'Color Settings',
        'manage_options',
        'color-settings',
        'yacht_manager_myplugin_settings_page'
    );

    // Add a Submenu Page under "Yacht Manager"
    add_submenu_page(
        'yacht-manager',
        'Run Fetch',
        'Run Fetch',
        'manage_options',
        'run-fetch',
        'yacht_manager_run_fetch_page'
    );
}
add_action('admin_menu', 'yacht_manager_add_menu_page');


// yacht manager mennu options
function yacht_manager_dashboard_menu() { 
    $company_uri = get_option('yacht_manager_company_uri'); 
    $key_id = get_option('yacht_manager_key_id'); 
    $key_file_name = get_option('yacht_key_file_name', 'No file uploaded'); 

    $keys_dir = __DIR__ . '/../api/keys';
    $key_file_path = $keys_dir . '/private_key.pem';

    // return false if /keys directory not found
    $pkey_file = 'no';
    if ( is_dir($keys_dir) && file_exists($key_file_path) ) {
        $pkey_file = 'yes';
    } ?>

    <div class="yacht-manager-wrap">
        <div class="yacht-manager-content">
            <h1>Welcome to Yacht Manager</h1>
            <h3><?php printf(__('Enter API Credentials', 'yacht-manager')); ?></h3>
            <p>Get the details from here: <a href="https://ankorradar.productfruits.help/en/article/api-authentification-with-company-url-and-api-keys#1.-obtaining-your-api-client-credentials" target="blank">Ankor Software</a></p>
            
            <div class="yacht-manager-form-wrap">
                <form id="yacht-manager-form" class="yacht-manager-form">
                    <div class="form-row">
                        <label for="yacht-company-uri"><?php printf( __( 'Company uri:', 'yacht-manager' )); ?></label>
                        <input type="text" id="yacht-company-uri" name="yacht_company_uri" value="<?php echo esc_attr($company_uri); ?>" required>
                    </div>
                    <div class="form-row">
                        <label for="yacht-key-id"><?php printf( __( 'Key id:', 'yacht-manager' )); ?></label>
                        <input type="text" id="yacht-key-id" name="yacht_key_id" value="<?php echo esc_attr($key_id); ?>" required>
                    </div>
                    <div class="form-row">
                        <div class="key-uploaded <?php echo ($pkey_file=='no') ? 'wrap-hide' : ''; ?>">
                            <p class="key-text">Private key file</p>
                            <div class="key-file-wrap">
                                <span class="key-file-name"><?php echo esc_html($key_file_name); ?></span>
                                <span class="key-file-edit">Change</span>
                            </div>
                        </div>
                        <div class="key-upload-wrap <?php echo ($pkey_file=='yes') ? 'wrap-hide' : ''; ?>">
                            <label for="yacht-private-key-upload"><?php printf( __( 'Upload Private Key (.pem):', 'yacht-manager' )); ?></label>
                            <input type="file" id="yacht-private-key-upload" name="yacht_private_key_file" accept=".pem">
                        </div>
                    </div>
                    <input type="hidden" id="yacht-key-file-uploaded" value="<?php echo esc_attr($pkey_file); ?>">
                    <div class="form-row yacht-confirm-btn">
                        <div class="yacht-btn">
                            <button class="button button-primary yacht-manager-save-btn" id="yacht-manager-save-btn"><?php printf( __( 'Save', 'yacht-manager' )); ?></button>
                        </div>
                        <div class="yacht-loading-loader">
                            <div class="yacht-loading-dialog">
                                <div class="yacht-loader-wrap">
                                    <span class="yacht-loader"></span>
                                </div>
                                <div class="yacht-dialog-wrap">
                                    <p>Verifying admin credentials</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 

<?php 
}


// color setting options
function yacht_manager_myplugin_register_settings() {
    add_option('ytm_primary_color', '#b9eaff');
    register_setting('ytm_setting_color', 'ytm_primary_color');
}
add_action('admin_init', 'yacht_manager_myplugin_register_settings');


function yacht_manager_myplugin_settings_page() { ?>
    <div class="wrap">
        <h2>Color Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('ytm_setting_color'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Primary Color:</th>
                    <td>
                        <input type="text" id="ytm_primary_color" name="ytm_primary_color" value="<?php echo esc_attr(get_option('ytm_primary_color')); ?>" class="ytm-color-picker" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


function yacht_manager_run_fetch_page() {
    if (isset($_POST['run_fetch'])) {
        // Run the function when form is submitted
        yacht_manager_insert_update_yacht_post_type();
    
        // Display admin notice
        add_action('admin_notices', function() {
            echo '<div class="updated notice is-dismissible"><p>Fetch process has been completed.</p></div>';
        });
    } ?>
    <div class="wrap">
        <h2>Run Fetch</h2>
        <p>Here you can run the fetch process.</p>
        <form method="post" action="">
            <input type="submit" name="run_fetch" value="Run Fetch" class="button button-primary" />
        </form>
    </div>
<?php }