<?php
/**
 * Plugin Name: Yacht Manager 
 * Description: The Yacht Manager plugin developers.
 * Version: 1.0
 * Author: Ebpearls
 */
 
if (!defined('ABSPATH')) {
	exit;
}

// Plugin version
if ( ! defined( 'YACHT_MANAGER_VERSION' ) ) {
	define( 'YACHT_MANAGER_VERSION', '1.0' );
}

// Include admin register yacht posttype
require_once plugin_dir_path(__FILE__) . 'includes/admin/yacht.php';

// Include enqueue style css
require_once plugin_dir_path(__FILE__) . 'resources/enqueue-scripts.php';

// Include require files api
require_once plugin_dir_path(__FILE__) . 'includes/api/requires.php';

// Activation Hook
function yacht_manager_activate() {
	yacht_manager_register_post_type();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'yacht_manager_activate');

// Deactivation Hook
function yacht_manager_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'yacht_manager_deactivate'); 