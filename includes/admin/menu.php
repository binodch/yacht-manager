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
        'yacht_manager_dashboard',
        'dashicons-admin-tools',
        99                        
    );
}
add_action('admin_menu', 'yacht_manager_add_menu_page');

function yacht_manager_dashboard() { ?>
    <div class="yacht-manager-wrap">
        <h1>Welcome to Yacht Manager</h1>
            
        <div class="yacht-manager-content">
            <h3><?php printf(__('Enter API Credentials', 'yacht-manager')); ?></h3>
            <p>Get the details from here: <a href="https://ankorradar.productfruits.help/en/article/api-authentification-with-company-url-and-api-keys#1.-obtaining-your-api-client-credentials" target="blank">Ankor Software</a></p>
            
            <?php printf(__('&nbsp;', 'yacht-manager')); ?>
            
            <div class="yacht-manager-form-wrap">
                <form id="yacht-manager-form">
                    <div class="form-row">
                        <label for="yacht-company-url"><?php printf( __( 'Company url:', 'yacht-manager' )); ?></label>
                        <input type="text" id="yacht-company-url" name="yacht_company_url" placeholder="" required>
                    </div>
                    <div class="form-row">
                        <label for="yacht-key-id"><?php printf( __( 'Key id:', 'yacht-manager' )); ?></label>
                        <input type="text" id="yacht-key-id" name="yacht_key_id" placeholder="" required>
                    </div>
                    <div class="form-row">
                        <label for="yacht-private-key"><?php printf( __( 'Private key:', 'yacht-manager' )); ?></label>
                        <input type="text" id="yacht-private-key" name="yacht_private_key" placeholder="" required>
                    </div>
                    <div class="form-row">
                        <button class="button button-primary" id="yacht-manager-save-btn"><?php printf( __( 'Save', 'yacht-manager' )); ?></button>
                    </div>
                </form>
            </div>
            
        </div>
        
        <!-- Loader -->
        <!-- <div class="yacht-manager-dialog"></div> -->
    </div> 

<?php 
}