<?php
/*
Template Name: Find Yacht
*/

get_header(); 

$entity_list = yacht_manager_curl_search_entity_list();

$total_entity = 0;
$paginate = 1;
$entity_per_page = 12;
$current_page = 1;

$destination = isset($_POST['destination']) ? sanitize_text_field($_POST['destination']) : '';
$start_date = isset($_POST['start-date']) ? sanitize_text_field($_POST['start-date']) : '';
$end_date = isset($_POST['end-date']) ? sanitize_text_field($_POST['end-date']) : '';
$total_guests = isset($_POST['totalGuests']) ? sanitize_text_field($_POST['totalGuests']) : '';

$yacht_item = '';

if( $entity_list && is_array($entity_list) && (count($entity_list)>0) ) {
    $total_entity = count($entity_list);
    $count = 0;

    $entity_from = ($current_page - 1) * $entity_per_page;

    $entity_range_list = array_slice($entity_list, $entity_from, $entity_per_page, true);

    $destinations = yacht_manager_curl_destinations();
    $yacht_types = yacht_manager_curl_yacht_types();
    $charter_types = yacht_manager_curl_charter_types();

    foreach( $entity_range_list as $elist ) {
        if( ($total_entity>$count) && ($count>($entity_per_page-1)) ) {
            break;
        }

        $yacht_item .= '
        <div class="col-md-4">
            <div class="ytm-list-item">
                <div class="ytm-item-single">
                    <div class="ytm-item-image">
                        <img decoding="async" src="'. plugin_dir_url(dirname(__FILE__, 1)) . 'assets/css/yacht.jpg' .'" alt="p">
                    </div>
                    <div class="ytm-item-content">';

                        if( !isset($elist['subname']) ) {
                            $yacht_item .= '<div class="ytm-item-symbol">
                                Molo 63
                            </div>';
                        }

                        if( isset($elist['name']) ) {
                            $yacht_item .= '<div class="ytm-item-name">
                                <h3>' . esc_html($elist['name']) . '</h3>
                            </div>';
                        }

                        if( isset($elist['cost']) ) {
                            $yacht_item .= '<div class="ytm-item-cost">
                                <p>Day: <span>From $2,500</span></p>
                                <p>Week: <span>From $15,000</span></p>
                            </div>';
                        }

                        $yacht_item .= '<div class="ytm-item-meta">';

                        if( isset($elist['builtYear']) ) {
                            $built_year = $elist['builtYear'] ? $elist['builtYear'] : '-';
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

        $count++;
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
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <span for="destination" class="form-label">Where</span>
                                                <div class="dropdown form-element-destination">
                                                    <button class="btn input-text dropdown-toggle w-100" type="button" id="destinationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Search destinations
                                                    </button>
                                                    <?php 
                                                    if( $destinations && is_array($destinations) && count($destinations)>0 ) { ?>
                                                        <ul class="dropdown-menu w-100" aria-labelledby="destinationDropdown">
                                                            <?php 
                                                            foreach( $destinations as $dest ) { ?>
                                                                <li>
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
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <label for="start-date" class="form-label">Check in</label>
                                                <input type="date" id="startDate" name="start-date" class="form-control input-text" placeholder="Add date">
                                            </div>
                                        </div>
                                        <!-- End Date -->
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <label for="end-date" class="form-label">Check out</label>
                                                <input type="date" id="endDate" name="end-date" class="form-control input-text" placeholder="Add date">
                                            </div>
                                        </div>
                                        <!-- Number of Guests -->
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <span for="destination" class="form-label">Where</span>
                                                <!-- Bootstrap Dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle" type="button" id="customerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span id="customerCount" class="input-text">Add guests</span>
                                                    </button>
                                                    <ul class="dropdown-menu p-3" aria-labelledby="customerDropdown">
                                                        <li class="d-flex align-items-center">
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
                                                        <li class="d-flex align-items-center">
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
                                                        <li class="d-flex align-items-center">
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
                                        <div class="ytm-filter-element">
                                            <div class="ytm-element-item">
                                                <span for="yacht" class="form-label">Yacht type</span>
                                                <div class="dropdown form-element-yacht">
                                                    <button class="btn dropdown-toggle input-text w-100 text-start" type="button" id="yachtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Select a yacht
                                                    </button>
                                                    <?php
                                                    if( $yacht_types && is_array($yacht_types) && count($yacht_types)>0 ) { ?>
                                                        <ul class="dropdown-menu w-100 p-2" aria-labelledby="yachtDropdown">
                                                            <?php 
                                                            foreach( $yacht_types as $ytype ) { ?>
                                                                <li>
                                                                    <label class="dropdown-item">
                                                                        <?php echo esc_html($ytype); ?> <input type="checkbox" class="yacht-checkbox" value="<?php echo esc_html($ytype); ?>">
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
                            if( $total_entity ) { ?>
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
                <div class="modal-option modal-charter-type">
                    charty type
                </div>
                <span class="border-line"></span>
                <div class="modal-option modal-cabin">
                    cabin
                </div>
                <span class="border-line"></span>
                <div class="modal-option modal-manufacture-year">
                    manudfasdtu ryaise
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn ytm-modal-close" data-dismiss="ytm-advanced-filter-modal">Close</button> -->
                <button type="button" class="btn">Apply filter</button>
            </div>
        </div>
    </div>
</div>

<?php get_footer();