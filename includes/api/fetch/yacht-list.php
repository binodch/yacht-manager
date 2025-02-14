<?php

/**
 * function to fetch yacht data via API
 */
function yacht_manager_fetch_yacht_list() {

    ///////////////////////////////////
    // integrate API call
    ///////////////////////////////////
    $sample_yacht_file = dirname(__DIR__, 2) . '/data/sample-yachts.json';
    if (!file_exists($sample_yacht_file)) {
        return false;
    }
    $yacht_data = file_get_contents($sample_yacht_file);
    ///////////////////////////////////
    
    if( $yacht_data ) {
        $yacht_arr = json_decode($yacht_data, true);
        if( $yacht_arr && is_array($yacht_arr) && (count($yacht_arr)>0) ) {
            return $yacht_arr;
        }
    }
    return false;
}

/**
 * function to save yacht post to yacht post type
 */
function yacht_manager_insert_update_yacht_post_type() {
    $yacht_arr = yacht_manager_fetch_yacht_list();
    if( $yacht_arr && is_array($yacht_arr) && (count($yacht_arr)>0) ) {
        foreach( $yacht_arr as $yarr ) {
            $yacht_hash = yacht_manager_generate_hash_signature($yarr);
            $yacht_uri = isset($yarr['uri']) ? $yarr['uri'] : '';
            $yacht_name = isset($yarr['blueprint']) && ($yarr['blueprint']['name']) ? $yarr['blueprint']['name'] : '';
            $yacht_cruising_capacity = isset($yarr['blueprint']) && ($yarr['blueprint']['cruisingCapacity']) ? $yarr['blueprint']['cruisingCapacity'] : '';
            $yacht_length = isset($yarr['blueprint']) && ($yarr['blueprint']['length']) ? $yarr['blueprint']['length'] : '';
            $yacht_sleeps = isset($yarr['blueprint']) && ($yarr['blueprint']['sleeps']) ? $yarr['blueprint']['sleeps'] : '';
            $yacht_type = isset($yarr['yachtType']) ? $yarr['yachtType'] : [];

            $yacht_uri_exists = yacht_manager_check_if_yacht_uri_exists($yacht_uri, $yacht_hash);
            $yacht_post_id = '';

            if( $yacht_uri_exists ) {
                if( $yacht_uri_exists != 'skip' ) {
                    $yacht_post_id = $yacht_uri_exists;
                }

            } else {
                $yacht_data = array(
                    'post_type'     => 'yacht',
                    'post_status'   => 'publish',
                    'post_title'    => $yacht_name,
                    'post_name'    => $yacht_name,
                );
            
                // Insert the Yacht into the database
                $yacht_id = wp_insert_post($yacht_data);
                if( ! is_wp_error($yacht_id) ) {
                    $yacht_post_id = $yacht_id;
                }
            }
            
            // update yacht post meta value
            if( $yacht_post_id ) {
                update_field('yacht_hash', $yacht_hash, $yacht_post_id);
                update_field('yacht_uri', $yacht_uri, $yacht_post_id);
                update_field('yacht_name', $yacht_name, $yacht_post_id);
                update_field('yacht_cruising_capacity', $yacht_cruising_capacity, $yacht_post_id);
                update_field('yacht_length', $yacht_length, $yacht_post_id);
                update_field('yacht_sleeps', $yacht_sleeps, $yacht_post_id);
                yacht_manager_assign_yacht_types($yacht_post_id, $yacht_type);
            }
        }
    }
}

/**
 * function to check create || update yacht post
 */
function yacht_manager_check_if_yacht_uri_exists($yacht_uri, $yacht_hash) {
    $result = false;
    $args = [
        'post_type'      => 'yacht',
        'meta_query'     => [
            [
                'key'     => 'yacht_uri',
                'value'   => $yacht_uri,
                'compare' => '='
            ]
        ],
        'posts_per_page' => 1,
        'fields'         => 'ids'
    ];
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        $result = get_the_ID();
        $stored_hash = get_field('yacht_hash', $result);
        if( $stored_hash == $yacht_hash ) {
            // skip update in case of match yacht_hash value
            $result = 'skip';
        }
    }
    wp_reset_postdata();
    return $result;
}

/**
 * function to asign yacht-type to yacht
 */
function yacht_manager_assign_yacht_types($yacht_id, $yacht_types) {
    if (!empty($yacht_types) && is_array($yacht_types)) {
        wp_set_object_terms($yacht_id, $yacht_types, 'yacht-type');
    }
}