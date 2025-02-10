<?php
/**
 * Uninstall script for Yacht Manager
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete all yacht posts
$yacht_posts = get_posts(array(
    'post_type' => 'yacht',
    'numberposts' => -1
));

foreach ($yacht_posts as $post) {
    wp_delete_post($post->ID, true);
}