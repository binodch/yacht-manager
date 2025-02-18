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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_page = isset($_POST['ytm_paginate']) ? $_POST['ytm_paginate'] : 1;
}

$yacht_item = '';

if( $entity_list && is_array($entity_list) && (count($entity_list)>0) ) {
    $total_entity = count($entity_list);
    $count = 0;
    foreach( $entity_list as $elist ) {
        if( ($total_entity>$count) && ($count>8) ) {
            break;
        }

        $yacht_item .= '
        <div class="col-md-4">
            <div class="ytm-list-item">
                <div class="ytm-item-image">
                </div>
                <div class="ytm-item-content">';

                    if( isset($elist['subname']) ) {
                        $yacht_item .= '<div class="ytm-item-name">
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
                                            <span for="destination" class="form-label">Where</span>
                                            <div class="dropdown form-element-destination">
                                                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="destinationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Search destination
                                                </button>
                                                <ul class="dropdown-menu w-100" aria-labelledby="destinationDropdown">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                                            Bahamas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                                            Caribbean
                                                        </a>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                                            california
                                                        </a>
                                                    </li>
                                                </ul>
                                                <input type="hidden" name="destination" id="destination" value="">
                                            </div>
                                        </div>
                                        <span class="vertical-line"></span>
                                        <!-- Start Date -->
                                        <div class="filter-element">
                                            <label for="start-date" class="form-label">Check in</label>
                                            <input type="date" id="startDate" name="start-date" class="form-control" placeholder="Add Dates">
                                        </div>
                                        <span class="vertical-line"></span>
                                        <!-- End Date -->
                                        <div class="filter-element">
                                            <label for="end-date" class="form-label">Check out</label>
                                            <input type="date" id="endDate" name="end-date" class="form-control" placeholder="Add Dates">
                                        </div>
                                        <span class="vertical-line"></span>
                                        <!-- Number of Guests -->
                                        <div class="filter-element">
                                            <span for="destination" class="form-label">Where</span>
                                            <!-- Bootstrap Dropdown -->
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="customerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span id="customerCount">Add guest</span>
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
                                        <span class="vertical-line"></span>
                                        <!-- Select Yacht -->
                                        <div class="filter-element">
                                            <span for="yacht" class="form-label">Yacht type</span>
                                            <div class="dropdown form-element-yacht">
                                                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" id="yachtDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Select a yacht
                                                </button>
                                                <ul class="dropdown-menu w-100 p-2" aria-labelledby="yachtDropdown">
                                                    <li>
                                                        <label class="dropdown-item">
                                                            Yacht 1 <input type="checkbox" class="yacht-checkbox" value="Yacht 1">
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item">
                                                            Yacht 2 <input type="checkbox" class="yacht-checkbox" value="Yacht 2">
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item">
                                                            Yacht 3 <input type="checkbox" class="yacht-checkbox" value="Yacht 3">
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item">
                                                            Yacht 4 <input type="checkbox" class="yacht-checkbox" value="Yacht 4">
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item">
                                                            Yacht 5 <input type="checkbox" class="yacht-checkbox" value="Yacht 5">
                                                        </label>
                                                    </li>
                                                </ul>
                                                <input type="hidden" name="ytm_paginate" id="ytm-paginate" value="<?php echo absint($current_page); ?>">
                                            </div>
                                        </div>
                                        <span class="vertical-line"></span>
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

<?php get_footer();