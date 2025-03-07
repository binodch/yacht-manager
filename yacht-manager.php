<?php
/**
 * Plugin Name: Yacht Manager 
 * Description: The Yacht Manager plugin developers.
 * Version: 1.0
 * Author: Yacht Plugin
 */
 
if (!defined('ABSPATH')) {
	exit;
}

// Plugin version
if ( ! defined( 'YACHT_MANAGER_VERSION' ) ) {
	define( 'YACHT_MANAGER_VERSION', '1.0' );
}

// Include require files
require_once plugin_dir_path(__FILE__) . 'requires.php';

// Activation Hook
function yacht_manager_activate() {
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'yacht_manager_activate');

// Deactivation Hook
function yacht_manager_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'yacht_manager_deactivate'); 