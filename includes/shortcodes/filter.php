<?php

function yacht_manager_filter_select() {
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        pr($_POST);
    }

    $yacht_args = array(
        'post_type' => 'yacht',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $yacht_query = new WP_Query($yacht_args);
    $yacht_posts = $yacht_query->found_posts;
    $$yacht_item = '';
    if( $yacht_query->have_posts() ) {
        while( $yacht_query->have_posts() ) { $yacht_query->the_post();
            $yacht_item .= '
            <div class="col-md-3">
                <div class="ytm-list-item">
                    <div class="ytm-item-image">
                    </div>
                    <div class="ytm-item-content">
                        <div class="ytm-item-name">
                            Molo 63
                        </div>
                        <div class="ytm-item-name">
                            <h3>' . get_the_title() . '</h3>
                        </div>
                        <div class="ytm-item-cost">
                            <p>Day: <span>From $2,500</span></p>
                            <p>Week: <span>From $15,000</span></p>
                        </div>
                        <div class="ytm-item-meta">
                            <div class="ytm-meta-item meta-make-year">
                                <span>2018</span>
                            </div>
                            <div class="ytm-meta-item meta-length">
                                <span>13m (43ft)</span>
                            </div>
                            <div class="ytm-meta-item meta-sleeps">
                                <span>1</span>
                            </div>
                            <div class="ytm-meta-item meta-charter-type">
                                <span>Eco Yachts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        } wp_reset_postdata();
    }

    $yacht_data = '
    <div class="generic-filter-block">
        <div class="filter-wrap">
            <div class="filter-title">
                <h3>Choose Yacht</h3>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="filter-main">
                        <form method="post" action="">
                            <div class="filter-section">
                                <div class="d-flex align-items-center filter-wrap">
                                    <!-- Destination -->
                                    <div class="filter-element">
                                        <span for="destination" class="form-label">Where</span>
                                        <div class="dropdown form-element-destination">
                                            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="destinationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                Search destination
                                            </button>
                                            <ul class="dropdown-menu w-100" aria-labelledby="destinationDropdown">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/feature3.jpg" alt="">
                                                        Bahamas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/feature3.jpg" alt="">
                                                        Caribbean
                                                    </a>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/feature3.jpg" alt="">
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
                                            <input type="hidden" name="yacht" id="yacht">
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
                    <div class="ytm-destination-result">
                        <div class="ytm-destination-list">
                            <div class="row">' 
                                . $yacht_item .
                            '</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';

    return $yacht_data;
}
add_shortcode('yacht_manager_filter_search', 'yacht_manager_filter_select');