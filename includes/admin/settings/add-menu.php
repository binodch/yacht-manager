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