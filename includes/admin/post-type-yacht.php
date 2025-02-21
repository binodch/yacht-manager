<?php
/**
 * Register Custom Post Type: Yacht
 */
function yacht_manager_register_post_type() {
    if ( !post_type_exists('yacht') ) {
        $labels = array(
            'name'               => __('Yachts', 'yacht-manager'),
            'singular_name'      => __('Yacht', 'yacht-manager'),
            'menu_name'          => __('Yacht Manager', 'yacht-manager'),
            'add_new'            => __('Add New Yacht', 'yacht-manager'),
            'add_new_item'       => __('Add New Yacht', 'yacht-manager'),
            'edit_item'          => __('Edit Yacht', 'yacht-manager'),
            'new_item'           => __('New Yacht', 'yacht-manager'),
            'view_item'          => __('View Yacht', 'yacht-manager'),
            'search_items'       => __('Search Yachts', 'yacht-manager'),
            'not_found'          => __('No yachts found', 'yacht-manager'),
            'not_found_in_trash' => __('No yachts found in trash', 'yacht-manager'),
        );

        $args = array(
            'label'             => __('Yachts', 'yacht-manager'),
            'labels'            => $labels,
            'public'            => true,
            'has_archive'       => true,
            'show_in_menu'      => true,
            'menu_icon'         => 'dashicons-buddicons-forums',
            'supports'          => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'rewrite'           => array('slug' => 'yachts'),
        );

        register_post_type('yacht', $args);
        
        register_taxonomy(
            'yacht-type',
            'yacht',
            [
                'label'        => __('Yacht Types', 'yacht-manager'),
                'rewrite'      => ['slug' => 'yacht-type'],
                'hierarchical' => true,
            ]
        );
    }
}

add_action('init', 'yacht_manager_register_post_type');