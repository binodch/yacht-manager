<?php

// Server-side Render Function
function render_banner_filter_block($attributes) {
    $title = esc_html($attributes['title']);

    $section_padding = 'mt-0';

    $banner_filter = '<section id="" class="section ytm-section-banner d-flex flex-column justify-content-center p-medium ">';
		$banner_filter .= '<div class="container">
			<div class="section-heading text-center">';
                if( $banner_filter != '' ) {
                    $banner_filter .= '<h1 class="section-banner__title">
                        Paradise Awaits					
                    </h1>';
                }
                $banner_filter .= '<div class="section-heading__btn btn-wrapper d-flex justify-content-center">
                    <a href="#start" class="btn btn-primary">
                        Start your journey
                    </a>
                </div>';
            $banner_filter .= '</div>';
        $banner_filter .= '</div>';

        $banner_filter .= '<div class="background-image">
                <img fetchpriority="high" decoding="async" width="1396" height="854" src="' .plugin_dir_url(dirname(__FILE__, 2)) . 'assets/css/yacht.jpg' .'" class="attachment-background-image size-background-image" alt="" loading="eager">
            </div>';
		
		// filter section
		$banner_filter .= '<div class="ytm-filter-wrap">
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
                                        <img decoding="async" src="http://localhost:8888/ahoy-club-wp/wp-content/themes/ahoy-club/assets/images/feature3.jpg" alt="">
                                        Bahamas
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img decoding="async" src="http://localhost:8888/ahoy-club-wp/wp-content/themes/ahoy-club/assets/images/feature3.jpg" alt="">
                                        Caribbean
                                    </a>
                                </li><li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <img decoding="async" src="http://localhost:8888/ahoy-club-wp/wp-content/themes/ahoy-club/assets/images/feature3.jpg" alt="">
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
                        <input type="text" id="startDate" name="start-date" class="form-control flatpickr-input" placeholder="Add Dates" readonly="readonly">
                    </div>
                    <span class="vertical-line"></span>
                    <!-- End Date -->
                    <div class="filter-element">
                        <label for="end-date" class="form-label">Check out</label>
                        <input type="text" id="endDate" name="end-date" class="form-control flatpickr-input" placeholder="Add Dates" readonly="readonly">
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
                                        <span class="guest-type-count">Ages 0 – 2</span>
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
                            <input type="hidden" name="totalGuests" id="totalGuestsInput" value="0">
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
        </div>';

    $banner_filter .= '</section>';
    
    return $banner_filter;
}