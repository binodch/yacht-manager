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
        $meta = get_page_template_slug(get_queried_object_id());
        if ($meta && $meta === 'find-yacht.php') {
            return plugin_dir_path(__FILE__) . 'find-yacht.php';
        }
    }
    return $template;
}

// Load the single yacht post template
function mu_yacht_template($single) {
    global $post;
    if ($post->post_type == 'yacht') {
        return plugin_dir_path(__FILE__) . 'single-yacht.php';
    }

    return $single;
}
add_filter('single_template', 'mu_yacht_template');