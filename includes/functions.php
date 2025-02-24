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

function yacht_manager_get_yacht_id($yacht_uri) {
    $entity_id = [];
    $args = [
        'post_type'      => 'yacht',
        'meta_query'     => [
            [
                'key'     => 'yacht_uri',
                'value'   => $yacht_uri,
                'compare' => '='
            ]
        ],
        'posts_per_page' => -1,
        'fields'         => 'ids'
    ];
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $entity_id[] = get_the_ID();
        } wp_reset_postdata();
    }
    return $entity_id;
}