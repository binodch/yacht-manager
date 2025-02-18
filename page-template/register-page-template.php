<?php
// Hook to register the template
add_filter('theme_page_templates', 'yacht_manager_custom_page_template');
function yacht_manager_custom_page_template($templates) {
    $templates['find-yacht.php'] = 'Find a Yacht';
    return $templates;
}

// Load the template when selected
add_filter('template_include', 'yacht_manager_load_page_template');
function yacht_manager_load_page_template($template) {
    if (is_page()) {
        global $post;
        $selected_template = get_post_meta($post->ID, '_wp_page_template', true);
        if ($selected_template === 'find-yacht.php') {
            return plugin_dir_path(__FILE__) . 'find-yacht.php';
        }
    }
    return $template;
}