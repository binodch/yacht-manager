<?php
/**
 * function to update yacht meta to yacht post type
 */
function yacht_manager_update_yacht_post_meta($yacht_entity_arr, $yacht_post_id) {
    if( $yacht_entity_arr && !empty($yacht_entity_arr) ) {
            $yarr = $yacht_entity_arr;
            $yacht_hash = yacht_manager_generate_hash_signature($yarr);

            $yacht_uri = isset($yarr['uri']) ? $yarr['uri'] : '';
            $yacht_name = (isset($yarr['blueprint']) && isset($yarr['blueprint']['name'])) ? $yarr['blueprint']['name'] : '';
            $yacht_description = isset($yarr['description']) ? $yarr['description'] : '';
            
            $my_post = array(
                'ID'           => $yacht_post_id,
                'post_title'   => $yacht_name,
                'post_content' => nl2br($yacht_description),
            );
            wp_update_post( $my_post );
            
            $yacht_types = isset($yarr['yachtType']) ? $yarr['yachtType'] : '';

            // pr($yarr['blueprint']['maxCrew']);
            $yacht_model = (isset($yarr['blueprint']) && isset($yarr['blueprint']['model'])) ? $yarr['blueprint']['model'] : '';
            $yacht_maxCrew = (isset($yarr['blueprint']) && isset($yarr['blueprint']['maxCrew'])) ? $yarr['blueprint']['maxCrew'] : '';
            $yacht_architect = (isset($yarr['blueprint']) && isset($yarr['blueprint']['architect'])) ? $yarr['blueprint']['architect'] : '';
            $yacht_interiorDesigner = (isset($yarr['blueprint']) && isset($yarr['blueprint']['interiorDesigner'])) ? $yarr['blueprint']['interiorDesigner'] : '';
            $yacht_refitYear = (isset($yarr['blueprint']) && isset($yarr['blueprint']['refitYear'])) ? $yarr['blueprint']['refitYear'] : '';
            $yacht_topSpeed = (isset($yarr['blueprint']) && isset($yarr['blueprint']['topSpeed'])) ? $yarr['blueprint']['topSpeed'] : '';
            $yacht_cruiseSpeed = (isset($yarr['blueprint']) && isset($yarr['blueprint']['cruiseSpeed'])) ? $yarr['blueprint']['cruiseSpeed'] : '';
            $yacht_fuelCapacity = (isset($yarr['blueprint']) && isset($yarr['blueprint']['fuelCapacity'])) ? $yarr['blueprint']['fuelCapacity'] : '';
            $yacht_bathrooms = (isset($yarr['blueprint']) && isset($yarr['blueprint']['bathrooms'])) ? $yarr['blueprint']['bathrooms'] : '';
            $yacht_decks = (isset($yarr['blueprint']) && isset($yarr['blueprint']['decks'])) ? $yarr['blueprint']['decks'] : '';
            $yacht_beam = (isset($yarr['blueprint']) && isset($yarr['blueprint']['beam'])) ? $yarr['blueprint']['beam'] : '';
            $yacht_draft = (isset($yarr['blueprint']) && isset($yarr['blueprint']['draft'])) ? $yarr['blueprint']['draft'] : '';
            $yacht_hullType = (isset($yarr['blueprint']) && isset($yarr['blueprint']['hullType'])) ? $yarr['blueprint']['hullType'] : '';
            $yacht_hullConstruction = (isset($yarr['blueprint']) && isset($yarr['blueprint']['hullConstruction'])) ? $yarr['blueprint']['hullConstruction'] : '';
            $yacht_tonnage = (isset($yarr['blueprint']) && isset($yarr['blueprint']['tonnage'])) ? $yarr['blueprint']['tonnage'] : '';
            $yacht_weekPricingFrom = (isset($yarr['pricing']) && isset($yarr['pricing']['weekPricingFrom'])) ? json_encode($yarr['blueprint']['weekPricingFrom']) : '';
            $yacht_weekPricingTo = (isset($yarr['pricing']) && isset($yarr['pricing']['weekPricingTo'])) ? json_encode($yarr['blueprint']['weekPricingTo']) : '';

            $yacht_uri_exists = yacht_manager_check_if_yacht_uri_exists($yacht_uri, $yacht_hash, 'yacht_entity_uri_hash');
            $yacht_entity_id = $yacht_uri_exists['id'];

            if( $yacht_uri_exists ) {
                if( $yacht_uri_exists['post'] != 'skip' ) {
                    $yacht_post_id = $yacht_uri_exists['id'];
                }
            }
            
            // update yacht post meta value
            if( $yacht_entity_id ) {
                update_field('yacht_entity_uri_hash', $yacht_hash, $yacht_entity_id);
                update_field('yacht_model', $yacht_model, $yacht_entity_id);
                update_field('yacht_maxCrew', $yacht_maxCrew, $yacht_entity_id);
                update_field('yacht_architect', $yacht_architect, $yacht_entity_id);
                update_field('yacht_interiorDesigner', $yacht_interiorDesigner, $yacht_entity_id);
                update_field('yacht_refitYear', $yacht_refitYear, $yacht_entity_id);
                update_field('yacht_topSpeed', $yacht_topSpeed, $yacht_entity_id);
                update_field('yacht_cruiseSpeed', $yacht_cruiseSpeed, $yacht_entity_id);
                update_field('yacht_fuelCapacity', $yacht_fuelCapacity, $yacht_entity_id);
                update_field('yacht_bathrooms', $yacht_bathrooms, $yacht_entity_id);

                update_field('yacht_decks', $yacht_decks, $yacht_entity_id);
                update_field('yacht_beam', $yacht_beam, $yacht_entity_id);
                update_field('yacht_draft', $yacht_draft, $yacht_entity_id);
                update_field('yacht_hullType', $yacht_hullType, $yacht_entity_id);
                update_field('yacht_hullConstruction', $yacht_hullConstruction, $yacht_entity_id);
                update_field('yacht_tonnage', $yacht_tonnage, $yacht_entity_id);
                update_field('yacht_weekPricingFrom', $yacht_weekPricingFrom, $yacht_entity_id);
                update_field('yacht_weekPricingTo', $yacht_weekPricingTo, $yacht_entity_id);
                yacht_manager_assign_yacht_types($yacht_entity_id, $yacht_types);

            }
        // }
    }
}

/**
 * function to asign yacht-type to yacht
 */
function yacht_manager_assign_yacht_types($yacht_id, $yacht_types) {
    if (!empty($yacht_types) && is_array($yacht_types)) {
        wp_set_object_terms($yacht_id, $yacht_types, 'yacht-type');
    }
}