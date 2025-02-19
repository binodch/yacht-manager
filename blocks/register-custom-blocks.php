<?php
/**
 * Block: Title & Description Block
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Register the block
function yacht_manager_register_featured_entity_block() {
    wp_enqueue_script(
        'yacht-maanger-featured-entity-block-editor',
        plugin_dir_url(__FILE__) . 'featured-entity-list/block.js',
        array('wp-blocks', 'wp-editor', 'wp-components', 'wp-element')
    );

    register_block_type('custom/featured-entity-block', array(
        'editor_script' => 'featured-entity-block-editor',
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
}
add_action('init', 'yacht_manager_register_featured_entity_block');