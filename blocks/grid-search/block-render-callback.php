<?php
// Server-side Render Function
function render_grid_search_block($attributes) { 

    $title = esc_html($attributes['title']);
    
    $entity_per_page = 12;
    $current_page = 1;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $entity_content = '';
    
    $destination = $total_guests = $cabins = $selected_destination = '';
    $start_date = $end_date = $manufacture_from = $manufacture_to = '';
    $sleeps_query = $cabins_query = $yacht_type_query = [];

    $yacht_type_query = [];
    $yacht_region_query = [];
    $sleeps_query = [];
    $cabins_query = [];
    $tax_queries = [];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_destination = $_POST['destination'] ?? '';
        $total_guests = $_POST['totalGuests'] ?? '';
        $yachttype = $_POST['ytm_yacht_type'] ?? '';
        $cabins = $_POST['ytm_cabin'] ?? '';
        $manufacture_from = $_POST['ytm_manufacture_from'] ?? '';
        $manufacture_to = $_POST['ytm_manufacture_to'] ?? '';
        $current_page = $_POST['ytm_paginate'] ?? 1;

        // pr($_POST);

        // Taxonomy query for yacht-region
        if (!empty($selected_destination)) {
            $yacht_region_query = [
                [
                    'taxonomy' => 'yacht-region',
                    'field'    => 'slug',
                    'terms'    => $selected_destination,
                    'operator' => 'IN',
                ]
            ];
        }

        // Meta queries
        if (!empty($total_guests)) {
            $sleeps_query = ['key' => 'yacht_sleeps', 'value' => $total_guests, 'compare' => '='];
        }
        if (!empty($cabins)) {
            $cabins_query = ['key' => 'yacht_cabins', 'value' => $cabins, 'compare' => '='];
        }

        // Taxonomy query for yacht-type
        if (!empty($yachttype)) {
            $yacht_type_query = [
                [
                    'taxonomy' => 'yacht-type',
                    'field'    => 'term_id',
                    'terms'    => array_map('trim', explode(',', $yachttype)),
                    'operator' => 'IN',
                    ]
            ];
        }

        // Combine taxonomy queries if both exist
        $tax_queries = array_filter(array_merge($yacht_region_query, $yacht_type_query));
        
    }
    
    /* WP_Query Arguments */
    $entity_args = [
        'post_type'      => 'yacht',
        'post_status'    => 'publish',
        'posts_per_page' => $entity_per_page,
        'paged'          => $paged,
    ];
    
    if (!empty($tax_queries)) {
        $entity_args['tax_query'] = $tax_queries;
    }
    
    if ( (!empty($sleeps_query)) || (!empty($cabins_query))) {
        $entity_args['meta_query'] = array_filter([$sleeps_query, $cabins_query]);
    }
    
    /* Execute WP_Query */
    $entity_query = new WP_Query($entity_args);
    $total_entity = $entity_query->found_posts;
    
    $start_date = isset($_POST['start-date']) ? sanitize_text_field($_POST['start-date']) : '';
    $end_date = isset($_POST['end-date']) ? sanitize_text_field($_POST['end-date']) : '';
    
    $destinations = yacht_manager_get_assigned_yacht_region();
    $yacht_types = yacht_manager_curl_yacht_types();
    // $charter_types = yacht_manager_curl_charter_types();
    $charter_types = [];
    
    $entity_content .= '<div class="ytm-filter-main">
        <div class="container">
            <div class="ytm-filter-block">
                <div class="ytm-gridfilter-wrap">';

                    if( !empty($title) ) {
                        $entity_content .= '<div class="filter-title">
                            <h3 class="title">'. esc_html($title) .'</h3>
                        </div>';
                    }
                    $entity_content .= '<div class="row">
                        <div class="col-md-3">
                            <div class="filter-main">
                                <form id="ytm-filter-form" method="post" action="">
                                    <div class="ytm-filter-section">
                                        <div class="ytm-filter-sidebar">';

                                            $entity_content .= '<div class="ytm-filter-element sidebar-destination">
                                                <div class="ytm-element-item">
                                                    <span for="destination" class="form-label">Where</span>
                                                    <div class="dropdown form-element-destination">
                                                        <button class="btn input-text dropdown-toggle w-100" type="button" id="destinationDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
                                                            $selected_destination = $selected_destination ? ucwords(str_replace('-', ' ', $selected_destination)) : 'Search destinations';
                                                        $entity_content .= $selected_destination;
                                                        $entity_content .= '</button>';

                                                        if( $destinations && is_array($destinations) && count($destinations)>0 ) {
                                                            $entity_content .= '<ul class="dropdown-menu" aria-labelledby="destinationDropdown">
                                                            <div class="dropdown-text">Popular Destinations</div>';
                                                                foreach( $destinations as $slug=>$dest ) { 
                                                                    $active = ($selected_destination==$slug) ? 'active': '';
                                                                    $entity_content .= '<li>
                                                                        <a class="dropdown-item '. esc_attr($active) .'" data-region="'. esc_attr($slug) .'" href="#">'
                                                                            . esc_html($dest) .
                                                                        '</a>
                                                                    </li>';
                                                                }
                                                            $entity_content .= '</ul>';
                                                        }
                                                    $entity_content .= '</div>
                                                </div>
                                            </div>';

                                            $entity_content .= '<div class="ytm-filter-element sidebar-checkin">
                                                <div class="ytm-element-item">
                                                    <label for="start-date" class="form-label">Check in</label>
                                                    <input type="date" id="startDate" name="start-date" class="form-control input-text" placeholder="Add date">
                                                </div>
                                            </div>';

                                            $entity_content .= '<div class="ytm-filter-element sidebar-checkout">
                                                <div class="ytm-element-item">
                                                    <label for="end-date" class="form-label">Check out</label>
                                                    <input type="date" id="endDate" name="end-date" class="form-control input-text" placeholder="Add date">
                                                </div>
                                            </div>';

                                            $entity_content .= '<div class="ytm-filter-element sidebar-guest">
                                                <div class="ytm-element-item">
                                                    <span for="destination" class="form-label">Where</span>

                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button" id="customerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span id="customerCount" class="input-text">Add guests</span>
                                                        </button>
                                                        <ul class="dropdown-menu p-3" aria-labelledby="customerDropdown">
                                                            <li class="guest-dropdown">
                                                                <div class="guest-type">
                                                                    <span class="guest-type-title">Adults</span>
                                                                    <span class="guest-type-count">Ages 16 or above</span>
                                                                </div>
                                                                <div class="plus-minus-counter">
                                                                    <label>
                                                                        <button class="btn btn-sm btn-outline-danger me-2" id="decreaseAdultBtn" aria-label="Decrease adults">−</button>
                                                                        <span id="adultCount">0</span>
                                                                        <button class="btn btn-sm btn-outline-success ms-2" id="increaseAdultBtn" aria-label="Increase adults">+</button>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li class="guest-dropdown">
                                                                <div class="guest-type">
                                                                    <span class="guest-type-title">Children</span>
                                                                    <span class="guest-type-count">Ages 2 or above</span>
                                                                </div>
                                                                <div class="plus-minus-counter">
                                                                    <label>
                                                                        <button class="btn btn-sm btn-outline-danger me-2" id="decreaseChildBtn" aria-label="Decrease children">−</button>
                                                                        <span id="childCount">0</span>
                                                                        <button class="btn btn-sm btn-outline-success ms-2" id="increaseChildBtn" aria-label="Increase children">+</button>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li class="guest-dropdown">
                                                                <div class="guest-type">
                                                                    <span class="guest-type-title">Infants</span>
                                                                    <span class="guest-type-count">Ages 0 - 2</span>
                                                                </div>
                                                                <div class="plus-minus-counter">
                                                                    <label>
                                                                        <button class="btn btn-sm btn-outline-danger me-2" id="decreaseInfantBtn" aria-label="Decrease infants">−</button>
                                                                        <span id="infantCount">0</span>
                                                                        <button class="btn btn-sm btn-outline-success ms-2" id="increaseInfantBtn" aria-label="Increase infants">+</button>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>

                                                        <input type="hidden" name="totalGuests" id="totalGuestsInput" value="1">
                                                    </div>
                                                </div>
                                            </div>';
                                            
                                            if( !empty($yachttype) ) {
                                                $yacht_types_arr = array_map('trim', explode(',', $yachttype));
                                            } else {
                                                $yacht_types_arr = [];
                                            }

                                            $entity_content .= '<div class="ytm-filter-element sidebar-yacht">
                                                <div class="ytm-element-item">
                                                    <span for="yacht" class="form-label">Yacht type</span>
                                                    <div class="dropdown form-element-yacht">
                                                        <button class="btn dropdown-toggle input-text w-100 text-start" type="button" id="yachtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Select a yacht
                                                        </button>';

                                                        if( $yacht_types && is_array($yacht_types) && count($yacht_types) > 0 ) {
                                                            $entity_content .= '<ul class="dropdown-menu w-100" aria-labelledby="yachtDropdown">';
                                                                foreach( $yacht_types as $key => $ytype ) { 
                                                                    $checked = in_array($key, $yacht_types_arr) ? 'checked' : '';
                                                                    $entity_content .= '<li>
                                                                        <label class="dropdown-item">';
                                                                            $entity_content .= esc_html($ytype);
                                                                            $entity_content .= '<input type="checkbox" class="yacht-checkbox" data-ytype="'. absint($key) .'" value="'. esc_html($ytype) .'" '.$checked .'>
                                                                        </label>
                                                                    </li>';
                                                                }
                                                            $entity_content .= '</ul>';
                                                        }
                                                    $entity_content .= '</div>
                                                </div>
                                            </div>';
                                            
                                            $entity_content .= '<div class="ytm-filter-element advanced-filters">
                                                <div class="ytm-element-item input-text">
                                                    <button type="button" class="btn ytm-modal-popup" data-toggle="modal" data-target="#ytm-advanced-filter-modal">
                                                        Advanced filters
                                                    </button>
                                                </div>
                                            </div>';
                                            $entity_content .= '<input type="hidden" name="destination" id="banner-destination" value="">
                                            <input type="hidden" name="ytm_paginate" id="ytm-paginate" value="'. absint($current_page) .'">
                                            <input type="hidden" name="ytm_yacht_type" id="ytm-yacht-type" value="">
                                            <input type="hidden" name="ytm_cabin" id="ytm-cabin" value="">
                                            <input type="hidden" name="ytm_manufacture_from" id="ytm-manufacture-from" value="">
                                            <input type="hidden" name="ytm_manufacture_to" id="ytm-manufacture-to" value="">';

                                            $entity_content .= '<div class="button-wrap">
                                                <button type="submit" class="btn btn-primary">Find a charter</button>
                                            </div>';
                                        $entity_content .= '</div>
                                    </div>
                                </form>
                            </div>
                        </div>';
                        $entity_content .= '<div class="col-md-9">';
                            if ($entity_query->have_posts()) {
                                $entity_content .= '<div class="ytm-entity-result">
                                    <div class="ytm-entity-list">
                                        <div class="row">';

                                            while ($entity_query->have_posts()) {
                                                $entity_query->the_post();
                                                $yacht_id = get_the_ID();
                                                
                                                $thumbnail_id = get_post_thumbnail_id($yacht_id);
                                        
                                                $_refityear = get_post_meta($yacht_id, 'yacht_refitYear', true);
                                                $_built_year = get_post_meta($yacht_id, 'yacht_built_year', true); 
                                                $refityear = !empty($_refityear) ? $_refityear : '-';
                                                $built_year = !empty($_built_year) ? $_built_year : $refityear;
                                                
                                                $yacht_length = get_post_meta($yacht_id,'yacht_length', true);

                                                $yacht_cabins = get_post_meta($yacht_id,'yacht_cabins', true);
                                                $yacht_make = get_post_meta($yacht_id,'yacht_make', true);
                                        
                                                $weekPricingFrom = get_post_meta($yacht_id, 'yacht_weekPricingFrom', true); 
                                                $week_pricing_arr = json_decode($weekPricingFrom, true);
                                                $currency = !empty($week_pricing_arr['currency']) ? $week_pricing_arr['currency'] : '';
                                                $currency = yacht_manager_get_currency_symbol($currency);
                                                $price = !empty($week_pricing_arr['displayPrice']) ? $week_pricing_arr['displayPrice'] : '';
                                                $price = is_numeric($price) ? number_format(floatval($price), 2) : '';
                                                $unit = !empty($week_pricing_arr['unit']) ? $week_pricing_arr['unit'] : '';

                                                $entity_content .= '<div class="col-md-6">
                                                    <div class="ytm-list-item">
                                                        <div class="ytm-item-single">';
                                                            $thumb_class = $thumbnail_id ? '' : 'noimage';
                                                            $entity_content .= '<div class="ytm-item-image '. $thumb_class .'">
                                                                <a href="'. get_permalink() .'">';
                                                                    if( $thumbnail_id ) {
                                                                        $entity_content .= wp_get_attachment_image($thumbnail_id, 'medium_large'); 
                                                                    }
                                                                $entity_content .= '</a>
                                                            </div>';
                                                            $entity_content .= '<div class="ytm-item-content">';
                                                                $entity_content .= '<div class="ytm-item-name">
                                                                    <h3>
                                                                        <a class="ytm-item-entity" href="'. get_permalink() .'">';
                                                                            $entity_content .= esc_html(ucwords(strtolower(get_the_title($yacht_id))));
                                                                        $entity_content .= '</a>
                                                                    </h3>
                                                                </div>';
                                                                if( $currency && $unit && $price ) {
                                                                    $entity_content .= '<div class="ytm-item-cost">
                                                                        <p>'. ucfirst(strtolower($unit)) .': <span>From '. $currency . $price .'</span></p>
                                                                    </div>';
                                                                }
                                                                $entity_content .= '<div class="ytm-item-meta">';
                                                                    if( $built_year ) {
                                                                        $entity_content .= '<div class="ytm-meta-item meta-builtyear">
                                                                            <span>'. $built_year .'</span>
                                                                        </div>';
                                                                    }
                                                                    if( $yacht_length ) { 
                                                                        $unit_ft = $yacht_length ? $yacht_length : '-';
                                                                        $unit_m = $yacht_length ? round($unit_ft/3.281, 2) : '';
                                                                        $unit_length = $unit_m ? $unit_m.'m' . ' (' . $unit_ft . 'ft)' : '-';
                                                                        $entity_content .= '<div class="ytm-meta-item meta-length">
                                                                            <span>'. $unit_length .'</span>
                                                                        </div>';
                                                                    }
                                                                    if( $yacht_cabins ) {
                                                                        $entity_content .= '<div class="ytm-meta-item meta-cabins">
                                                                            <span><'. $yacht_cabins .'</span>
                                                                        </div>';
                                                                    }
                                                                    if( $yacht_make ) {
                                                                        $entity_content .= '<div class="ytm-meta-item meta-make">
                                                                            <span>'. $yacht_make .'</span>
                                                                        </div>';
                                                                    }
                                                                $entity_content .= '</div>';
                                                            $entity_content .= '</div>
                                                        </div>
                                                    </div>
                                                </div>';

                                            } wp_reset_postdata();

                                        $entity_content .= '</div>
                                    </div>';
                                    
                                    if( $total_entity > $entity_per_page ) {
                                        $entity_content .= '<div class="ytm-entity-pagination">';
                                            $entity_content .= paginate_links([
                                                'total'   => $entity_query->max_num_pages,
                                                'current' => max(1, get_query_var('paged')),
                                                'prev_text' => '<span class="icon prev-icon"></span>',
                                                'next_text' => '<span class="icon next-icon"></span>',
                                            ]);
                                        $entity_content .= '</div>';
                                    }
                                $entity_content .= '</div>';
                            
                            } else {
                                $entity_content .= '<div class="ytm-entity-result">
                                    <div class="ytm-entity-list">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="ytm-no-entities">
                                                    No entities found
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        $entity_content .= '</div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    
   $entity_content .= ' <div class="modal ytm-advanced-filter-modal fade" id="ytm-advanced-filter-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Advanced Filters</h5>
                    <button type="button" class="close" data-dismiss="ytm-advanced-filter-modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">';
                    if ($charter_types && is_array($charter_types) && count($charter_types) > 0) {
                        $entity_content .= '<div class="modal-option modal-charter-type">
                            <div class="ytm-filter-element">
                                <div class="ytm-element-item">
                                    <span class="form-label">Charter Type</span>
                                    <div class="form-element-yacht">
                                        <ul class="checkbox-list p-2">';
                                            foreach ($charter_types as $ctype) {
                                                $entity_content .= '<li class="checkbox-item">
                                                    <label>
                                                        <input type="checkbox" class="yacht-checkbox-ct" value="'. esc_attr($ctype) .'">';
                                                        $entity_content .= esc_html($ctype);
                                                    $entity_content .= '</label>
                                                </li>';
                                            }
                                        $entity_content .= '</ul>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    $entity_content .= '<div class="modal-option modal-cabin">
                        <div class="ytm-filter-element">
                            <div class="ytm-element-item">
                                <span class="form-label">Cabin</span>
                                <div class="form-element-range">
                                    <input type="range" id="yachtRange" class="form-range" min="1" max="20" step="1" value="0" oninput="ytmUpdateRangeValue(this.value)">
                                    <span id="rangeValue">0</span>
                                </div>
                            </div>
                        </div>
                    </div>';
                    $entity_content .= '<div class="modal-option modal-manufacture-year">
                        <div class="ytm-filter-element">
                            <div class="ytm-element-item">
                                <span class="form-label">Manufacture year</span>';
                                $manufacture_year = yacht_manager_manufacture_year();
                                $entity_content .= '<div class="form-element-dates">
                                    <div class="ytm-manufacture-from">
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <select class="form-select" name="yacht_manufacture_from" id="yacht-manufacture-from">
                                                    <option value="" disabled>Select year</option>';
                                                    if( $manufacture_year && is_array($manufacture_year) && count($manufacture_year) > 0 ) { 
                                                        foreach( $manufacture_year as $myear ) { 
                                                            $selected_attr = ($myear==$manufacture_from) ? 'selected' : '';
                                                            $entity_content .= '<option value="'. absint($myear) .'" '. $selected_attr .'>';
                                                            $entity_content .= esc_html($myear);
                                                            $entity_content .= '</option>';
                                                        } 
                                                    }
                                                $entity_content .= '</select>
                                            </div>
                                        </div>
                                    </div>';
                                    $entity_content .= '<div class="ytm-manufacture-to">
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <select class="form-select" name="yacht_manufacture_to" id="yacht-manufacture-to">
                                                    <option value="" disabled>Select year</option>';
                                                    if( $manufacture_year && is_array($manufacture_year) && count($manufacture_year) > 0 ) { 
                                                        foreach( $manufacture_year as $myear ) { 
                                                            $selected_attr = ($myear==$manufacture_to) ? 'selected' : '';
                                                            $entity_content .= '<option value="'. absint($myear) .'" '.$selected_attr .'>';
                                                                $entity_content .= esc_html($myear);
                                                            $entity_content .= '</option>';
                                                        } 
                                                    }
                                                $entity_content .= '</select>
                                            </div>
                                        </div>
                                    </div>';
                                $entity_content .= '</div>
                            </div>
                        </div>
                    </div>
                </div>';
                $entity_content .= '<div class="modal-footer">
                    <button type="button" class="btn ytm-advanced-btn-submit ytm-modal-close">Apply filter</button>
                </div>';
            $entity_content .= '</div>
        </div>
    </div>';

    return $entity_content;
}