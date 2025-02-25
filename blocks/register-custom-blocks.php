<?php
/**
 * Register Custom Blocks
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// register block category
function yacht_manager_register_yacht_manager_block_category( $categories, $post ) {
    $new_widget = [
        [
            'slug'  => 'yacht-manager',
            'title' => __( 'Yacht Manager', 'yacht-manager' ),
            // 'icon'  => 'admin-site',
        ],
    ];
    return array_merge(
        $new_widget,
        $categories,
    );
}
add_filter( 'block_categories_all', 'yacht_manager_register_yacht_manager_block_category', 10, 2 );


// Register the block
function yacht_manager_register_custom_block() {
    // featured entity list block
    wp_enqueue_style(
        'yacht-maanger-featured-entity-block-styl',
        plugin_dir_url(__FILE__) . 'featured-entity-list/featured-block.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_script(
        'yacht-maanger-featured-entity-block-editor',
        plugin_dir_url(__FILE__) . 'featured-entity-list/featured-block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        YACHT_MANAGER_VERSION
    );
    register_block_type('custom/featured-entity-block', array(
        'editor_script' => 'yacht-maanger-featured-entity-block-editor',
        'render_callback' => 'render_featured_entity_block',
        'attributes' => array(
            'title' => array(
                'type' => 'string',
                'default' => 'Enter title here...'
            ),
            'description' => array(
                'type' => 'string',
                'default' => 'Enter description here...'
            ),
        ),
    ));
    
    // banner filter block
    wp_enqueue_style(
        'yacht-maanger-banner-filter-block-styl',
        plugin_dir_url(__FILE__) . 'banner-filter/banner-block.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-maanger-banner-filter-block-filter-styl',
        plugin_dir_url(__FILE__) . 'banner-filter/filter-section.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_script(
        'yacht-maanger-banner-filter-block-editor',
        plugin_dir_url(__FILE__) . 'banner-filter/banner-block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        YACHT_MANAGER_VERSION
    );
    register_block_type('custom/banner-filter-block', array(
        'editor_script' => 'yacht-maanger-banner-filter-block-editor',
        'render_callback' => 'render_banner_filter_block',
        'attributes' => array(
            'title' => array(
                'type' => 'string',
                'default' => 'Enter title here...'
            ),
            'description' => array(
                'type' => 'string',
                'default' => 'Enter description here...'
            ),
        ),
    ));
}
add_action('init', 'yacht_manager_register_custom_block');