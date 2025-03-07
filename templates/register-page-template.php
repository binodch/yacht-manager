<?php
/* Load the single yacht post template */
function mu_yacht_template($single) {
    global $post;
    if ($post->post_type == 'yacht') {
        return plugin_dir_path(__FILE__) . 'single-yacht.php';
    }

    return $single;
}
add_filter('single_template', 'mu_yacht_template');