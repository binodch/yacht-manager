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
        plugin_dir_url(__FILE__) . '../assets/css/filter-template/search-filter.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-filter-results',
        plugin_dir_url(__FILE__) . '../assets/css/filter-template/filter-results.css',
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
    wp_enqueue_style(
        'yacht-manager-advanced-filter-styl',
        plugin_dir_url(__FILE__) . '../assets/css/filter-template/advanced-filter.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-yacht-single-styl',
        plugin_dir_url(__FILE__) . '../assets/css/yacht-single/detail.css',
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
    wp_enqueue_script(
        'yacht-manager-advanced-filter-modal',
        plugin_dir_url(__FILE__) . '../assets/js/advanced-filter-modal.js',
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

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('yacht-manager-color-picker-script', 
    plugin_dir_url(__FILE__) . '../assets/js/color-picker.js',
        array('wp-color-picker'), 
        false, 
        true);

}
add_action('admin_enqueue_scripts', 'yacht_manager_enqueue_admin_assets');

// dynamic pull styles
function yacht_manager_myplugin_dynamic_css() {
    $primary_color = get_option('ytm_primary_color', '#b9eaff');
    $custom_css_content = "
        :root {
            --primary-color: ". $primary_color .";
        }";
    wp_add_inline_style('wp-color-picker', $custom_css_content);
    wp_add_inline_style('yacht-manager-global', $custom_css_content);
}
add_action('admin_enqueue_scripts', 'yacht_manager_myplugin_dynamic_css');
add_action('wp_enqueue_scripts', 'yacht_manager_myplugin_dynamic_css');