<?php

// return if page template is assigned to any page or not
function yacht_manager_template_assigned($template_file) {
    $query = new WP_Query([
        'post_type'  => 'page',
        'meta_key'   => '_wp_page_template',
        'meta_value' => $template_file,
        'posts_per_page' => 1, // Get only one page
    ]);

    if ($query->have_posts()) {
        $query->the_post();
        $url = get_permalink();
        wp_reset_postdata();
        return $url;
    }

    return false;
}