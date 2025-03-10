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
        'yacht-manager-yacht-single-styl',
        plugin_dir_url(__FILE__) . '../assets/css/yacht-single/detail.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-yacht-color-styl',
        plugin_dir_url(__FILE__) . '../assets/css/color.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-single-swiper-styl',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        YACHT_MANAGER_VERSION   
    );
    wp_enqueue_style(
        'yacht-manager-yacht-gallery-styl',
        plugin_dir_url(__FILE__) . '../assets/css/yacht-single/gallery.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-yacht-viewmore-styl',
        plugin_dir_url(__FILE__) . '../assets/css/yacht-single/view-more.css',
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
        plugin_dir_url(__FILE__) . '../assets/js/form-banner-filter.js',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_script(
        'yacht-manager-advanced-filter-modal',
        plugin_dir_url(__FILE__) . '../assets/js/advanced-filter-modal.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-single-swiper-script',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-single-gallery',
        plugin_dir_url(__FILE__) . '../assets/js/single-gallery.js',
        [],
        YACHT_MANAGER_VERSION
    ); 
    wp_enqueue_script(
        'yacht-manager-single-viewmore',
        plugin_dir_url(__FILE__) . '../assets/js/view-more.js',
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
    $primary_text = get_option('ytm_primary_text', '#000000');
    $secondary_text = get_option('ytm_secondary_text', '#a8a8a8');
    $body_text = get_option('ytm_body_text', '#5e5e5e');
    $cta_text = get_option('ytm_cta_text', '#1d2b46');
    $primary_bg = get_option('ytm_primary_bg', '#f0f0f0');
    $secondary_bg = get_option('ytm_secondary_bg', '#f9f9f9');

    $primary_gradient = yacht_manager_hexToRgba($primary_bg, 0);
    $btn_gradient = yacht_manager_hexToRgba($primary_text, 0.2);
    $secondary_gradient = yacht_manager_hexToRgba($primary_bg, 0.9);
    $bg_gradient = yacht_manager_hexToRgba($primary_text, 0.1);

    $custom_css_content = "
        :root {
            --primary-text: ". $primary_text .";
            --secondary-text: ". $secondary_text .";
            --body-text: ". $body_text .";
            --cta-text: ". $cta_text .";
            --primary-bg: ". $primary_bg .";
            --secondary-bg: ". $secondary_bg .";
            --primary-gradient: ". $primary_gradient .";
            --secondary-gradient: ". $secondary_gradient .";
            --btn-gradient: ". $btn_gradient .";
            --bg-gradient: ". $bg_gradient .";
        }";
    wp_add_inline_style('wp-color-picker', $custom_css_content);
    wp_add_inline_style('yacht-manager-global', $custom_css_content);
}
add_action('admin_enqueue_scripts', 'yacht_manager_myplugin_dynamic_css');
add_action('wp_enqueue_scripts', 'yacht_manager_myplugin_dynamic_css');