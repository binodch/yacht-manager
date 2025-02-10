<?php
/**
 * Enqueue frontend and admin styles
 */

// Frontend styles
function yacht_manager_enqueue_public_assets() {
    wp_enqueue_style(
        'yacht-manager-public',
        plugin_dir_url(__FILE__) . '../assets/public/style.min.css',
        [],
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'yacht_manager_enqueue_public_assets');