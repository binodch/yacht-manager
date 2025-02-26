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

function yacht_manager_get_first_taxnomy_term($yacht_id) {
    $taxonomy = 'yacht-type'; 
    $terms = wp_get_post_terms($yacht_id, $taxonomy);
    if (!empty($terms) && !is_wp_error($terms)) {
        if( isset($terms[0]) ) {
            $yacht_type = $terms[0]->name;
            return esc_html($yacht_type);
        }
    }
    return;
}

function yacht_manager_convert_feet_into_inches($feet) {
    $whole_feet = floor($feet);
    $remaining_inches = ($feet - $whole_feet) * 12;
    return "{$whole_feet}' " . round($remaining_inches, 1) . '"';
}

function yacht_manager_get_currency_symbol($currency) {
    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'AUD' => 'A$',
        'CAD' => 'C$',
        'CHF' => 'CHF',
        'CNY' => '¥',
        'INR' => '₹'
    ];

    return $symbols[$currency] ?? $currency;
}