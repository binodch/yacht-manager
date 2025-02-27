<?php
/*
Template Name: Find Yacht
*/

get_header(); 

// pr($_POST);

$total_entity = 0;
$paginate = 1;
$entity_per_page = 12;
$current_page = 1;

$destination = $total_guests = $cabins = $start_date = $end_date = $manufacture_from = $manufacture_to = '';
$sleeps_query = $cabins_query = $yacht_type_query = [];
$region_list_arr = [];

if( isset($_POST['entity_banner_filter']) ) {
    $selected_destination = $_POST['destination'] ?? '';
    $total_guests = $_POST['totalGuests'] ?? '';
    $manufacture_from = $_POST['ytm_manufacture_from'] ?? '';
    $manufacture_to = $_POST['ytm_manufacture_to'] ?? '';
    $yachttype = $_POST['ytm_yacht_type'] ?? '';

    // Fetch region list if destination is provided
    if (!empty($selected_destination)) {
        $search_arr = json_encode(['region' => $selected_destination]);
        $search_region = yacht_manager_curl_search_entity_list($search_arr);
        
        if (!empty($search_region) && is_array($search_region)) {
            foreach ($search_region as $region) {
                if (!empty($region['uri'])) {
                    $entity_id = yacht_manager_get_yacht_id($region['uri']);
                    if (!empty($entity_id)) {
                        $region_list_arr = array_merge($region_list_arr, (array) $entity_id);
                    }
                }
            }
        }
    }

    // Meta queries
    if (!empty($total_guests)) {
        $sleeps_query = ['key' => 'yacht_sleeps', 'value' => $total_guests, 'compare' => '='];
    }
    if (!empty($cabins)) {
        $cabins_query = ['key' => 'yacht_cabins', 'value' => $cabins, 'compare' => '='];
    }

    // Taxonomy Query
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

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_destination = $_POST['destination'] ?? '';
    $total_guests = $_POST['totalGuests'] ?? '';
    $yachttype = $_POST['ytm_yacht_type'] ?? '';
    $cabins = $_POST['ytm_cabin'] ?? '';
    $manufacture_from = $_POST['ytm_manufacture_from'] ?? '';
    $manufacture_to = $_POST['ytm_manufacture_to'] ?? '';

    // Fetch region list if destination is provided
    if (!empty($selected_destination)) {
        $search_arr = json_encode(['region' => $selected_destination]);
        $search_region = yacht_manager_curl_search_entity_list($search_arr);
        
        if (!empty($search_region) && is_array($search_region)) {
            foreach ($search_region as $region) {
                if (!empty($region['uri'])) {
                    $entity_id = yacht_manager_get_yacht_id($region['uri']);
                    if (!empty($entity_id)) {
                        $region_list_arr = array_merge($region_list_arr, (array) $entity_id);
                    }
                }
            }
        }
    }

    // Meta queries
    if (!empty($total_guests)) {
        $sleeps_query = ['key' => 'yacht_sleeps', 'value' => $total_guests, 'compare' => '='];
    }
    if (!empty($cabins)) {
        $cabins_query = ['key' => 'yacht_cabins', 'value' => $cabins, 'compare' => '='];
    }

    // Taxonomy Query
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
} else {
}

// WP_Query Arguments
$entity_args = [
    'post_type'      => 'yacht',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => array_filter([$sleeps_query, $cabins_query]),
];

if (!empty($region_list_arr)) {
    $entity_args['post__in'] = $region_list_arr;
}
if (!empty($yacht_type_query)) {
    $entity_args['tax_query'] = $yacht_type_query;
}

// pr($entity_args);

$entity_query = new WP_Query($entity_args);
$entity_list = [];

if ($entity_query->have_posts()) {
    while ($entity_query->have_posts()) {
        $entity_query->the_post();
        $yacht_id = get_the_ID();
        
        $entity_list[] = [
            'name'      => get_the_title(),
            'uri'      => get_post_meta($yacht_id,'yacht_uri', true),
            'cost'      => get_post_meta($yacht_id,'yacht_cost', true),
            'builtYear' => get_post_meta($yacht_id,'yacht_built_year', true),
            'length'    => get_post_meta($yacht_id,'yacht_length', true),
            'cabins'    => get_post_meta($yacht_id,'yacht_cabins', true),
            'make'      => get_post_meta($yacht_id,'yacht_make', true),
        ];
    }
    wp_reset_postdata();
}

$selected_destination = isset($_POST['destination']) ? sanitize_text_field($_POST['destination']) : '';
$start_date = isset($_POST['start-date']) ? sanitize_text_field($_POST['start-date']) : '';
$end_date = isset($_POST['end-date']) ? sanitize_text_field($_POST['end-date']) : '';
$total_guests = isset($_POST['totalGuests']) ? sanitize_text_field($_POST['totalGuests']) : '';

$yacht_item = '';

$count = 0;
$destinations = yacht_manager_curl_destinations();
$yacht_types = yacht_manager_curl_yacht_types();
// $charter_types = yacht_manager_curl_charter_types();
$charter_types = [];
if( $entity_list && is_array($entity_list) && (count($entity_list)>0) ) {
    $total_entity = count($entity_list);

    $entity_from = ($current_page - 1) * $entity_per_page;

    $entity_range_list = array_slice($entity_list, $entity_from, $entity_per_page, true);

    foreach( $entity_range_list as $elist ) {
        if( ($total_entity>$count) && ($count>($entity_per_page-1)) ) {
            break;
        }

        $uri = $elist['uri'];
        $entity_arr = yacht_manager_check_if_yacht_uri_exists($uri, 'abcdefgh09', 'yacht_entity_search_hash');
        
        $yacht_id = !empty($entity_arr) ? $entity_arr['id'] : '';
        $thumbnail_id = get_post_thumbnail_id($yacht_id);

        $_refityear = get_post_meta($yacht_id, 'yacht_refitYear', true);
        $_built_year = get_post_meta($yacht_id, 'yacht_built_year', true); 
        $refityear = !empty($_refityear) ? $_refityear : '-';
        $built_year = !empty($_built_year) ? $_built_year : $refityear;

        $weekPricingFrom = get_post_meta($yacht_id, 'yacht_weekPricingFrom', true); 
        $week_pricing_arr = json_decode($weekPricingFrom, true);
        $currency = !empty($week_pricing_arr['currency']) ? $week_pricing_arr['currency'] : '';
        $currency = yacht_manager_get_currency_symbol($currency);
        $price = !empty($week_pricing_arr['displayPrice']) ? $week_pricing_arr['displayPrice'] : '';
        $price = is_numeric($price) ? number_format(floatval($price), 2) : '';
        $unit = !empty($week_pricing_arr['unit']) ? $week_pricing_arr['unit'] : '';

        $yacht_item .= '
        <div class="col-md-4">
            <div class="ytm-list-item">
                <div class="ytm-item-single">
                    <div class="ytm-item-image">';

                        if( $thumbnail_id ) {
                            $yacht_item .= wp_get_attachment_image($thumbnail_id, 'medium_large');
                        }
                    
                    $yacht_item .= '</div>
                    <div class="ytm-item-content">';

                        if( isset($elist['subname']) ) {
                            $yacht_item .= '<div class="ytm-item-symbol">
                                Molo 63
                            </div>';
                        }

                        if( isset($elist['name']) ) {
                            $yacht_item .= '<div class="ytm-item-name">
                                <h3>' . esc_html(ucwords(strtolower($elist['name']))) . '</h3>
                            </div>';
                        }

                        if( $currency && $unit && $price ) {
                            $yacht_item .= '<div class="ytm-item-cost">
                                <p>'. ucfirst(strtolower($unit)) .': <span>From '. $currency . $price .'</span></p>
                            </div>';
                        }

                        $yacht_item .= '<div class="ytm-item-meta">';

                        if( $built_year ) {
                            $yacht_item .= '<div class="ytm-meta-item meta-builtyear">
                                <span>' . $built_year . '</span>
                            </div>';
                        }

                        if( isset($elist['length']) ) {
                            $unit_ft = $elist['length'] ? $elist['length'] : '-';
                            $unit_m = $elist['length'] ? round($unit_ft/3.281, 2) : '';
                            $unit_length = $unit_m ? $unit_m.'m' . ' (' . $unit_ft . 'ft)' : '-';
                            $yacht_item .= '<div class="ytm-meta-item meta-length">
                                <span>' . $unit_length . '</span>
                            </div>';
                        }

                        if( isset($elist['cabins']) ) {
                            $cabins = $elist['cabins'] ? $elist['cabins'] : '-';
                            $yacht_item .= '<div class="ytm-meta-item meta-cabins">
                                <span>' . $cabins . '</span>
                            </div>';
                        }

                        if( isset($elist['sleeps']) ) {
                            $cabins = $elist['sleeps'] ? $elist['sleeps'] : '-';
                            $yacht_item .= '<div class="ytm-meta-item meta-cabins">
                                <span>' . $cabins . '..</span>
                            </div>';
                        }

                        if( isset($elist['make']) ) {
                            $make = $elist['make'] ? $elist['make'] : '-';
                            $yacht_item .= '<div class="ytm-meta-item meta-make">
                                <span>' . $make . '</span>
                            </div>';
                        }
                            
                        $yacht_item .= '</div>
                    </div>
                </div>
            </div>
        </div>';

        $count += 1;
    }
} else {
    $yacht_item .= '<div class="col-md-12">
        <div class="ytm-no-entities">
            No entities found
        </div>
    </div>';
} ?>

<div class="ytm-filter-main">
    <div class="container">
        <div class="ytm-filter-block">
            <div class="ytm-filter-wrap">
                <div class="filter-title">
                    <h3>Choose Yacht</h3>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="filter-main">
                            <form id="ytm-filter-form" method="post" action="">
                                <div class="ytm-filter-section">
                                    <div class="ytm-filter-sidebar">
                                        <!-- Destination -->
                                        <div class="ytm-filter-element sidebar-destination">
                                            <div class="ytm-element-item">
                                                <span for="destination" class="form-label">Where</span>
                                                <div class="dropdown form-element-destination">
                                                    <button class="btn input-text dropdown-toggle w-100" type="button" id="destinationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <?php echo $selected_destination ? $selected_destination : 'Search destinations'; ?>
                                                    </button>
                                                    <?php 
                                                    if( $destinations && is_array($destinations) && count($destinations)>0 ) { ?>
                                                        <ul class="dropdown-menu" aria-labelledby="destinationDropdown">
                                                        <div class="dropdown-text">Popular Destinations</div>
                                                            <?php 
                                                            foreach( $destinations as $dest ) { ?>
                                                                <li <?php echo ($selected_destination==$dest) ? 'class="dropdown-active"': ''; ?>>
                                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                                        <?php echo esc_html($dest); ?>
                                                                    </a>
                                                                </li>
                                                            <?php 
                                                            } ?>
                                                        </ul>
                                                    <?php 
                                                    } ?>
                                                    <input type="hidden" name="destination" id="destination" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Start Date -->
                                        <div class="ytm-filter-element sidebar-checkin">
                                            <div class="ytm-element-item">
                                                <label for="start-date" class="form-label">Check in</label>
                                                <input type="date" id="startDate" name="start-date" class="form-control input-text" placeholder="Add date">
                                            </div>
                                        </div>
                                        <!-- End Date -->
                                        <div class="ytm-filter-element sidebar-checkout">
                                            <div class="ytm-element-item">
                                                <label for="end-date" class="form-label">Check out</label>
                                                <input type="date" id="endDate" name="end-date" class="form-control input-text" placeholder="Add date">
                                            </div>
                                        </div>
                                        <!-- Number of Guests -->
                                        <div class="ytm-filter-element sidebar-guest">
                                            <div class="ytm-element-item">
                                                <span for="destination" class="form-label">Where</span>
                                                <!-- Bootstrap Dropdown -->
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
                                                    <!-- Single hidden input for total number of guests -->
                                                    <input type="hidden" name="totalGuests" id="totalGuestsInput" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Select Yacht -->
                                        <?php
                                        if( !empty($yachttype) ) {
                                            $yacht_types_arr = array_map('trim', explode(',', $yachttype));
                                        } else {
                                            $yacht_types_arr = [];
                                        } ?>
                                        <div class="ytm-filter-element sidebar-yacht">
                                            <div class="ytm-element-item">
                                                <span for="yacht" class="form-label">Yacht type</span>
                                                <div class="dropdown form-element-yacht">
                                                    <button class="btn dropdown-toggle input-text w-100 text-start" type="button" id="yachtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Select a yacht
                                                    </button>
                                                    <?php 
                                                    if( $yacht_types && is_array($yacht_types) && count($yacht_types) > 0 ) { ?>
                                                        <ul class="dropdown-menu w-100" aria-labelledby="yachtDropdown">
                                                            <?php 
                                                            foreach( $yacht_types as $key => $ytype ) { 
                                                                $checked = in_array($key, $yacht_types_arr) ? 'checked' : ''; ?>
                                                                <li>
                                                                    <label class="dropdown-item">
                                                                        <?php echo esc_html($ytype); ?> 
                                                                        <input type="checkbox" class="yacht-checkbox" data-ytype="<?php echo absint($key); ?>" value="<?php echo esc_html($ytype); ?>" <?php echo $checked; ?>>
                                                                    </label>
                                                                </li>
                                                            <?php 
                                                            } ?>
                                                        </ul>
                                                    <?php 
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- advanced filter -->
                                        <div class="ytm-filter-element advanced-filters">
                                            <div class="ytm-element-item input-text">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn ytm-modal-popup" data-toggle="modal" data-target="#ytm-advanced-filter-modal">
                                                    Advanced filters
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ytm_paginate" id="ytm-paginate" value="<?php echo absint($current_page); ?>">
                                        <input type="hidden" name="ytm_yacht_type" id="ytm-yacht-type" value="">
                                        <!-- <input type="hidden" name="ytm_charter_type[]" id="ytm-charter-type" value=""> -->
                                        <input type="hidden" name="ytm_cabin" id="ytm-cabin" value="0">
                                        <input type="hidden" name="ytm_manufacture_from" id="ytm-manufacture-from" value="">
                                        <input type="hidden" name="ytm_manufacture_to" id="ytm-manufacture-to" value="">
                                        <!-- Submit Button -->
                                        <div class="button-wrap">
                                            <button type="submit" class="btn btn-primary">Find a charter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="ytm-entity-result">
                            <div class="ytm-entity-list">
                                <div class="row">
                                    <?php echo $yacht_item; ?>
                                </div>
                            </div>
                            <?php 
                            if( $total_entity > $count ) { ?>
                                <div class="ytm-entity-pagination">
                                    <ul>
                                        <li class="paginate-list-prev" onclick="yachtManagerSubmitForm('<?php echo ($current_page==1) ? 1 : $current_page-1; ?>')"><span class="paginate-prev"></span></li>
                                        <?php $pages = ceil($total_entity/$entity_per_page);
                                        for($ii=1; $ii<=$pages; $ii++) { 
                                            $active = ($current_page==$ii) ? 'active' : ''; ?>
                                            <li class="paginate-list <?php echo esc_html($active); ?>" onclick="yachtManagerSubmitForm('<?php echo $ii; ?>')"><?php echo $ii; ?></li>
                                            <?php 
                                        } ?>
                                        <li class="paginate-list-next" onclick="yachtManagerSubmitForm('<?php echo ($current_page==$pages) ? $pages : $current_page+1; ?>')"><span class="paginate-next"></span></li>
                                    </ul>
                                </div>
                            <?php 
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal ytm-advanced-filter-modal fade" id="ytm-advanced-filter-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Advanced Filters</h5>
                <button type="button" class="close" data-dismiss="ytm-advanced-filter-modal" aria-label="Close">
                <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <?php 
                if ($charter_types && is_array($charter_types) && count($charter_types) > 0) { ?>
                    <div class="modal-option modal-charter-type">
                        <div class="ytm-filter-element">
                            <div class="ytm-element-item">
                                <span class="form-label">Charter Type</span>
                                <div class="form-element-yacht">
                                    <ul class="checkbox-list p-2">
                                        <?php 
                                        foreach ($charter_types as $ctype) { ?>
                                            <li class="checkbox-item">
                                                <label>
                                                    <input type="checkbox" class="yacht-checkbox-ct" value="<?php echo esc_attr($ctype); ?>">
                                                    <?php echo esc_html($ctype); ?>
                                                </label>
                                            </li>
                                        <?php 
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                } ?>
                <div class="modal-option modal-cabin">
                    <div class="ytm-filter-element">
                        <div class="ytm-element-item">
                            <span class="form-label">Cabin</span>
                            <div class="form-element-range">
                                <input type="range" id="yachtRange" class="form-range" min="1" max="20" step="1" value="0" oninput="ytmUpdateRangeValue(this.value)">
                                <span id="rangeValue">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <span class="border-line"></span> -->
                <div class="modal-option modal-manufacture-year">
                    <div class="ytm-filter-element">
                        <div class="ytm-element-item">
                            <span class="form-label">Manufacture year</span>
                            <?php $manufacture_year = yacht_manager_manufacture_year(); ?>
                            <div class="form-element-dates">
                                <div class="ytm-manufacture-from">
                                    <div class="ytm-filter-element">
                                        <div class="ytm-element-item">
                                            <select class="form-select" name="yacht_manufacture_from" id="yacht-manufacture-from">
                                                <option value="" disabled>Select year</option>
                                                <?php if( $manufacture_year && is_array($manufacture_year) && count($manufacture_year) > 0 ) { 
                                                    foreach( $manufacture_year as $myear ) { 
                                                        $selected_attr = ($myear==$manufacture_from) ? 'selected' : ''; ?>
                                                        <option value="<?php echo absint($myear); ?>" <?php echo $selected_attr; ?>>
                                                            <?php echo esc_html($myear); ?>
                                                        </option>
                                                    <?php 
                                                    } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="ytm-manufacture-to">
                                    <div class="ytm-filter-element">
                                        <div class="ytm-element-item">
                                            <select class="form-select" name="yacht_manufacture_to" id="yacht-manufacture-to">
                                                <option value="" disabled>Select year</option>
                                                <?php if( $manufacture_year && is_array($manufacture_year) && count($manufacture_year) > 0 ) { 
                                                    foreach( $manufacture_year as $myear ) { 
                                                        $selected_attr = ($myear==$manufacture_to) ? 'selected' : ''; ?>
                                                    <option value="<?php echo absint($myear); ?>" <?php echo $selected_attr; ?>>
                                                        <?php echo esc_html($myear); ?>
                                                    </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ytm-advanced-btn-submit ytm-modal-close">Apply filter</button>
            </div>
        </div>
    </div>
</div>

<?php get_footer();