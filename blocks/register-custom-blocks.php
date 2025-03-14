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
        'yacht-manager-featured-block-editor',
        plugin_dir_url(__FILE__) . 'featured-entity-list/featured-editor.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-featured-entity-block-styl',
        plugin_dir_url(__FILE__) . 'featured-entity-list/featured-block.css',
        [],
        YACHT_MANAGER_VERSION
    );
    /*
    wp_enqueue_script(
        'yacht-manager-featured-entity-block-editor',
        plugin_dir_url(__FILE__) . 'featured-entity-list/featured-block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        YACHT_MANAGER_VERSION
    );
    register_block_type('custom/featured-entity-block', array(
        'editor_script' => 'yacht-manager-featured-entity-block-editor',
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
    */
    
    // dropfilter block
    wp_enqueue_style(
        'yacht-manager-dropfilter-block-editor',
        plugin_dir_url(__FILE__) . 'dropfilter-option/dropfilter-editor.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-dropfilter-block-styl',
        plugin_dir_url(__FILE__) . 'dropfilter-option/dropfilter-block.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-dropfilter-block-filter-styl',
        plugin_dir_url(__FILE__) . 'dropfilter-option/dropfilter-section.css',
        [],
        YACHT_MANAGER_VERSION
    );
    /*
    wp_enqueue_script(
        'yacht-manager-dropfilter-block-editor',
        plugin_dir_url(__FILE__) . 'dropfilter-option/dropfilter-block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        YACHT_MANAGER_VERSION
    );
    register_block_type('custom/dropfilter-option-block', array(
        'editor_script' => 'yacht-manager-dropfilter-option-block',
        'render_callback' => 'render_dropfilter_block',
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
    */

    // grid search block
    wp_enqueue_style(
        'yacht-manager-gridsearch-block-editor',
        plugin_dir_url(__FILE__) . 'grid-search/grid-editor.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-gridsearch-block-search-filter-styl',
        plugin_dir_url(__FILE__) . 'grid-search/css/search-filter.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-gridsearch-block-filter-results-styl',
        plugin_dir_url(__FILE__) . 'grid-search/css/filter-results.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_style(
        'yacht-manager-gridsearch-block-advanced-filter-styl',
        plugin_dir_url(__FILE__) . 'grid-search/css/advanced-filter.css',
        [],
        YACHT_MANAGER_VERSION
    );
    wp_enqueue_script(
        'yacht-manager-gridsearch-block-editor',
        plugin_dir_url(__FILE__) . 'grid-search/grid-block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element'),
        YACHT_MANAGER_VERSION
    );
    register_block_type('custom/grid-search-block', array(
        'editor_script' => 'yacht-manager-grid-search-block',
        'render_callback' => 'render_grid_search_block',
        'attributes' => array(
            'title' => array(
                'type' => 'string',
                'default' => 'Enter title here...'
            ),
        ),
    ));

}
add_action('init', 'yacht_manager_register_custom_block');