<?php
/**
 * Enqueue frontend and admin styles
 */

// Frontend style
function yacht_manager_enqueue_public_assets() {
    wp_enqueue_style(
        'yacht-manager-public',
        plugin_dir_url(__FILE__) . '../assets/css/style.min.css',
        [],
        YACHT_MANAGER_VERSION
    );
}
add_action('wp_enqueue_scripts', 'yacht_manager_enqueue_public_assets');

// Admin style || script
function yacht_manager_enqueue_admin_assets() {
    global $post_type;
    if (isset($_GET['page']) && $_GET['page'] === 'yacht-manager') {

        wp_enqueue_style(
            'yacht-manager-admin',
            plugin_dir_url(__FILE__) . '../assets/css/admin-style.css',
            [],
            YACHT_MANAGER_VERSION
        );

        wp_enqueue_script(
            'yacht-manager-admin-menu-input',
            plugin_dir_url(__FILE__) . '../assets/js/admin-menu-input.js',
            [],
            YACHT_MANAGER_VERSION
        );
        wp_localize_script('yacht-manager-admin-menu-input', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('ajax_nonce'),
        ));
    }
}
add_action('admin_enqueue_scripts', 'yacht_manager_enqueue_admin_assets');