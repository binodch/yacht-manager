<?php
/**
 * Uninstall script for Yacht Manager
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/* Delete all yacht posts */
$yacht_posts = get_posts(array(
    'post_type' => 'yacht',
    'numberposts' => -1
));

if( $yacht_posts ) {
    foreach ($yacht_posts as $post) {
        wp_delete_post($post->ID, true);
    }
}

/* Drop table after uninstall the plugin */
global $wpdb;

$table_name = $wpdb->prefix . 'yacht_manager_enquire';

$wpdb->query("DROP TABLE IF EXISTS $table_name");