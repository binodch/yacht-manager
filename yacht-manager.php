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
 

 // Include required files
 require_once plugin_dir_path(__FILE__) . 'includes/posttypes/yacht.php';
 require_once plugin_dir_path(__FILE__) . 'resources/enqueue-scripts.php';
 

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