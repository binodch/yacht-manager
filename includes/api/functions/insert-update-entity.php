<?php
/**
 * function to fetch yacht data via API
 */
function yacht_manager_fetch_yacht_list() {
    $yacht_data = yacht_manager_curl_search_entity_list();
    
    $yacht_arr = $yacht_data;
    if( $yacht_arr && is_array($yacht_arr) && (count($yacht_arr)>0) ) {
        return $yacht_arr;
    }
    return false;
}

/**
 * function to save yacht post to yacht post type
 */
function yacht_manager_insert_update_yacht_post_type() {
    $yacht_arr = yacht_manager_fetch_yacht_list();
    if( $yacht_arr && is_array($yacht_arr) && (count($yacht_arr)>0) ) { $count = 0;
        foreach( $yacht_arr as $yarr ) { if( $count > 0 ) return; $count ++;
            $yacht_hash = yacht_manager_generate_hash_signature($yarr);

            $yacht_uri = isset($yarr['uri']) ? $yarr['uri'] : '';
            $yacht_name = isset($yarr['name']) ? $yarr['name'] : '';
            $yacht_cabins = isset($yarr['cabins']) ? $yarr['cabins'] : '';
            $yacht_length = isset($yarr['length']) ? $yarr['length'] : '';
            $yacht_sleeps = isset($yarr['sleeps']) ? $yarr['sleeps'] : '';
            $yacht_built_year = isset($yarr['builtYear']) ? $yarr['builtYear'] : '';
            $yacht_make = isset($yarr['make']) ? $yarr['make'] : '';

            $yacht_uri_exists = yacht_manager_check_if_yacht_uri_exists($yacht_uri, $yacht_hash, 'yacht_entity_search_hash');
            // $yacht_post_id is for update post field if new data come through API
            $yacht_post_id = '';
            
            if( $yacht_uri_exists && !empty($yacht_uri_exists['id']) ) {
                if( $yacht_uri_exists['post'] != 'skip' ) {
                    $yacht_post_id = $yacht_uri_exists['id'];
                }
                $yacht_postId = $yacht_uri_exists['id'];
                // $yacht_entity_id is for register/fetch entity/{uri}
                $yacht_entity_id = $yacht_postId;
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
                    $yacht_entity_id = $yacht_post_id;
                }
            }
            
            // update yacht post meta value
            if( $yacht_post_id ) {
                update_post_meta($yacht_post_id, 'yacht_entity_search_hash', $yacht_hash);
                update_post_meta($yacht_post_id, 'yacht_uri', $yacht_uri);
                update_post_meta($yacht_post_id, 'yacht_name', $yacht_name);
                update_post_meta($yacht_post_id, 'yacht_length', $yacht_length);
                update_post_meta($yacht_post_id, 'yacht_cabins', $yacht_cabins);
                update_post_meta($yacht_post_id, 'yacht_sleeps', $yacht_sleeps);
                update_post_meta($yacht_post_id, 'yacht_built_year', $yacht_built_year);
                update_post_meta($yacht_post_id, 'yacht_make', $yacht_make);
            }
            $yacht_entity_arr = yacht_manager_curl_register_entity($yacht_uri);
            pr($yacht_entity_arr);
            // update yacht post meta value from get entity API
            yacht_manager_update_yacht_post_meta($yacht_entity_arr, $yacht_entity_id);

        }
    }
}

/**
 * function to check create
 */
function yacht_manager_check_if_yacht_uri_exists($yacht_uri, $yacht_hash, $hash_field) {
    $result['post'] = 'insert';
    $result['id'] = '';
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
        $entity_id = get_the_ID();
        $stored_hash = get_post_meta($entity_id, $hash_field, true);
        if( $stored_hash != '' ) {
            if( $stored_hash == $yacht_hash ) {
                // skip update in case of match yacht_hash value
                $result['post'] = 'skip';
                $result['id'] = $entity_id;
            } else {
                $result['post'] = 'update';
                $result['id'] = $entity_id;
            }
        }
    }
    wp_reset_postdata();
    return $result;
}