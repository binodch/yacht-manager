<?php
/**
 * Enqueue frontend and admin styles
 */

// Frontend style
function yacht_manager_enqueue_public_assets() {
    wp_enqueue_style(
        'yacht-manager-global',
        plugin_dir_url(__FILE__) . '../assets/css/global.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-public',
        plugin_dir_url(__FILE__) . '../assets/css/style.min.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-search-filter',
        plugin_dir_url(__FILE__) . '../assets/css/search-filter.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-filter-results',
        plugin_dir_url(__FILE__) . '../assets/css/filter-results.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-btstap-styl',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-flatpickr-styl',
        'https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_script(
        'yacht-manager-btstap-script',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-flatpickr-script',
        'https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-datepicker',
        plugin_dir_url(__FILE__) . '../assets/js/datepicker.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-homepagefilter',
        plugin_dir_url(__FILE__) . '../assets/js/form-input-filter.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-filter-submit',
        plugin_dir_url(__FILE__) . '../assets/js/filter-submit.js',
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