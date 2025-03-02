<?php
/**
 * function to update yacht meta to yacht post type
 */
function yacht_manager_update_yacht_post_meta($yacht_entity_arr, $yacht_post_id) {
    if( $yacht_entity_arr && !empty($yacht_entity_arr) ) {
        $yarr = $yacht_entity_arr;
        $yacht_hash = yacht_manager_generate_hash_signature($yarr);
        
        $yacht_name = (isset($yarr['blueprint']) && isset($yarr['blueprint']['name'])) ? $yarr['blueprint']['name'] : '';
        $yacht_description = isset($yarr['description']) ? $yarr['description'] : '';
        
        $update_entity = array(
            'ID'           => $yacht_post_id,
            'post_title'   => $yacht_name,
            'post_content' => nl2br($yacht_description),
        );
        wp_update_post( $update_entity );
        
        $yacht_types = isset($yarr['yachtType']) ? $yarr['yachtType'] : '';

        $yacht_model = (isset($yarr['blueprint']) && isset($yarr['blueprint']['model'])) ? $yarr['blueprint']['model'] : '';
        $yacht_maxCrew = (isset($yarr['blueprint']) && isset($yarr['blueprint']['maxCrew'])) ? $yarr['blueprint']['maxCrew'] : '';
        $yacht_architect = (isset($yarr['blueprint']) && isset($yarr['blueprint']['architect'])) ? $yarr['blueprint']['architect'] : '';
        $yacht_interiorDesigner = (isset($yarr['blueprint']) && isset($yarr['blueprint']['interiorDesigner'])) ? $yarr['blueprint']['interiorDesigner'] : '';
        $yacht_refitYear = (isset($yarr['blueprint']) && isset($yarr['blueprint']['refitYear'])) ? $yarr['blueprint']['refitYear'] : '';

        $yacht_topSpeed = (isset($yarr['blueprint']) && isset($yarr['blueprint']['topSpeed'])) ? $yarr['blueprint']['topSpeed'] : '';
        $yacht_cruiseSpeed = (isset($yarr['blueprint']) && isset($yarr['blueprint']['cruiseSpeed'])) ? $yarr['blueprint']['cruiseSpeed'] : '';
        $yacht_fuelCapacity = (isset($yarr['blueprint']) && isset($yarr['blueprint']['fuelCapacity'])) ? $yarr['blueprint']['fuelCapacity'] : '';
        $yacht_cabinLayout = (isset($yarr['blueprint']) && isset($yarr['blueprint']['cabinLayout'])) ? json_encode($yarr['blueprint']['cabinLayout']) : '';
        $yacht_bathrooms = (isset($yarr['blueprint']) && isset($yarr['blueprint']['bathrooms'])) ? $yarr['blueprint']['bathrooms'] : '';

        $yacht_decks = (isset($yarr['blueprint']) && isset($yarr['blueprint']['decks'])) ? $yarr['blueprint']['decks'] : '';
        $yacht_beam = (isset($yarr['blueprint']) && isset($yarr['blueprint']['beam'])) ? $yarr['blueprint']['beam'] : '';
        $yacht_draft = (isset($yarr['blueprint']) && isset($yarr['blueprint']['draft'])) ? $yarr['blueprint']['draft'] : '';
        $yacht_hullType = (isset($yarr['blueprint']) && isset($yarr['blueprint']['hullType'])) ? $yarr['blueprint']['hullType'] : '';
        $yacht_hullConstruction = (isset($yarr['blueprint']) && isset($yarr['blueprint']['hullConstruction'])) ? $yarr['blueprint']['hullConstruction'] : '';
        $yacht_tonnage = (isset($yarr['blueprint']) && isset($yarr['blueprint']['tonnage'])) ? $yarr['blueprint']['tonnage'] : '';
        $yacht_amenities = (isset($yarr['blueprint']) && isset($yarr['blueprint']['amenities'])) ? json_encode($yarr['blueprint']['amenities']) : '';
        $yacht_images = (isset($yarr['blueprint']) && isset($yarr['blueprint']['images'])) ? json_encode($yarr['blueprint']['images']) : '';

        $yacht_weekPricingFrom = (isset($yarr['pricing']) && isset($yarr['pricing']['weekPricingFrom'])) ? json_encode($yarr['pricing']['weekPricingFrom']) : '';
        $yacht_weekPricingTo = (isset($yarr['pricing']) && isset($yarr['pricing']['weekPricingTo'])) ? json_encode($yarr['pricing']['weekPricingTo']) : '';
        
        $yacht_zones = [];
        if( isset($yarr['pricing']) && isset($yarr['pricing']['pricingInfo'])) {
            $yacht_pricingInfo = $yarr['pricing']['pricingInfo'];
            foreach( $yacht_pricingInfo as $pricingInfo ) {
                if( isset($pricingInfo['inclusionZones']) ) {
                    $inclusionZones = $pricingInfo['inclusionZones'];
                    foreach( $inclusionZones as $incl ) {
                        if( isset($incl['category']) ) {
                            $incl_zone = $incl['category'];
                            foreach( $incl_zone as $incz ) {
                                $zones[] = $incz;
                            }
                        }
                    }        
                }
            }
            $yacht_zones = array_values(array_unique($zones));
        }

        $yacht_uri_exists = yacht_manager_check_if_yacht_meta_field_exists($yacht_post_id, $yacht_hash, 'yacht_entity_uri_hash');
        $yacht_entity_id = $yacht_post_id;

        // update yacht post meta value
        if( $yacht_uri_exists ) {
            update_post_meta($yacht_entity_id, 'yacht_entity_uri_hash', $yacht_hash);
            update_post_meta($yacht_entity_id, 'yacht_model', $yacht_model);
            update_post_meta($yacht_entity_id, 'yacht_maxCrew', $yacht_maxCrew);
            update_post_meta($yacht_entity_id, 'yacht_architect', $yacht_architect);
            update_post_meta($yacht_entity_id, 'yacht_interiorDesigner', $yacht_interiorDesigner);
            update_post_meta($yacht_entity_id, 'yacht_refitYear', $yacht_refitYear);

            update_post_meta($yacht_entity_id, 'yacht_topSpeed', $yacht_topSpeed);
            update_post_meta($yacht_entity_id, 'yacht_cruiseSpeed', $yacht_cruiseSpeed);
            update_post_meta($yacht_entity_id, 'yacht_fuelCapacity', $yacht_fuelCapacity);
            update_post_meta($yacht_entity_id, 'yacht_cabinLayout', $yacht_cabinLayout);
            update_post_meta($yacht_entity_id, 'yacht_bathrooms', $yacht_bathrooms);

            update_post_meta($yacht_entity_id, 'yacht_decks', $yacht_decks);
            update_post_meta($yacht_entity_id, 'yacht_beam', $yacht_beam);
            update_post_meta($yacht_entity_id, 'yacht_draft', $yacht_draft);
            update_post_meta($yacht_entity_id, 'yacht_hullType', $yacht_hullType);
            update_post_meta($yacht_entity_id, 'yacht_hullConstruction', $yacht_hullConstruction);
            update_post_meta($yacht_entity_id, 'yacht_tonnage', $yacht_tonnage);
            update_post_meta($yacht_entity_id, 'yacht_amenities', $yacht_amenities);
            update_post_meta($yacht_entity_id, 'yacht_weekPricingFrom', $yacht_weekPricingFrom);
            update_post_meta($yacht_entity_id, 'yacht_weekPricingTo', $yacht_weekPricingTo);
            update_post_meta($yacht_entity_id, 'yacht_images', $yacht_images);

            update_post_meta($yacht_entity_id, 'yacht_zones', json_encode($yacht_zones));
            
            yacht_manager_assign_yacht_types($yacht_entity_id, $yacht_types);

            $yimages = json_decode($yacht_images, true);
            if( $yimages && count($yimages)>0 ) {
                $count = 0;
                foreach( $yimages as $yimg ) {
                    if( $count == 0 ) {
                        // set first image as featured image
                        $img_variant = yacht_manager_entity_media_imageVariant(3);
                        yacht_manager_set_entity_featured_image($yimg, $img_variant, $yacht_entity_id);
                    } else {
                        $img_variant = yacht_manager_entity_media_imageVariant(1);
                        yacht_manager_curl_get_entity_attachment_image($yimg, $img_variant, $yacht_entity_id);
                    }
                    $count++;
                }
            }

        }
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

/**
 * function to check update meta fields
 */
function yacht_manager_check_if_yacht_meta_field_exists($yacht_post_id, $yacht_hash, $hash_field) {
    $stored_hash = get_post_meta($yacht_post_id, $hash_field, true);
    if( $stored_hash == $yacht_hash ) {
        // skip update in case of match yacht_hash value
        return false;
    }
    return true;
}