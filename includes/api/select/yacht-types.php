<?php
// yacht types
function yacht_manager_curl_yacht_types() {
    $terms = get_terms([
        'taxonomy'   => 'yacht-type',
        'hide_empty' => true,
    ]);
    
    $yacht_types = [];
    
    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $yacht_types[$term->term_id] = $term->name;
        }
    }
    
    return $yacht_types;
}
