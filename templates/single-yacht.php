<?php
// single yacht post
get_header();

$yacht_id = get_the_ID(); 

$yacht_name = get_the_title($yacht_id);
$_yacht_type = yacht_manager_get_first_taxnomy_term($yacht_id);
$yacht_type = $_yacht_type ?? '-';
$yacht_type = !empty($_yacht_type) ? $_yacht_type : '-';

$yacht_length_ft = get_post_meta($yacht_id, 'yacht_length', true); 
$yacht_length_m = $yacht_length_ft ? round($yacht_length_ft/3.281, 2).'m' : '-';
$yacht_length_in = $yacht_length_ft ? yacht_manager_convert_feet_into_inches($yacht_length_ft) : '-';

$_yacht_cabins = get_post_meta($yacht_id, 'yacht_cabins', true); 
$yacht_cabins = !empty($_yacht_cabins) ? $_yacht_cabins : '-';

$_yacht_sleeps = get_post_meta($yacht_id, 'yacht_sleeps', true); 
$yacht_sleeps = !empty($_yacht_sleeps) ? $_yacht_sleeps : '-';

$_yacht_maxcrew = get_post_meta($yacht_id, 'yacht_maxCrew', true); 
$yacht_maxcrew = !empty($_yacht_maxcrew) ? $_yacht_maxcrew : '-';

$_yacht_refityear = get_post_meta($yacht_id, 'yacht_refitYear', true);
$_yacht_built_year = get_post_meta($yacht_id, 'yacht_built_year', true); 
$yacht_refityear = !empty($_yacht_refityear) ? $_yacht_refityear : '-';
$yacht_built_year = !empty($_yacht_built_year) ? $_yacht_built_year : $yacht_refityear;

$_yacht_make = get_post_meta($yacht_id, 'yacht_make', true); 
$yacht_make = !empty($_yacht_make) ? $_yacht_make : '-';

$yacht_amenities = get_post_meta($yacht_id, 'yacht_amenities', true); 
$yacht_weekPricingFrom = get_post_meta($yacht_id, 'yacht_weekPricingFrom', true); 

$yacht_cabinLayout = get_post_meta($yacht_id, 'yacht_cabinLayout', true);

$yacht_beam = get_post_meta($yacht_id, 'yacht_beam', true);
$yacht_draft = get_post_meta($yacht_id, 'yacht_draft', true);
$yacht_tonnage = get_post_meta($yacht_id, 'yacht_tonnage', true);
$yacht_cruiseSpeed = get_post_meta($yacht_id, 'yacht_cruiseSpeed', true);
$yacht_architect = get_post_meta($yacht_id, 'yacht_architect', true);
$yacht_model = get_post_meta($yacht_id, 'yacht_model', true); // used as yacht_type
$yacht_interiorDesigner = get_post_meta($yacht_id, 'yacht_interiorDesigner', true); 
$yacht_zones = get_post_meta($yacht_id, 'yacht_zones', true); 

$thumbnail_id = get_post_thumbnail_id($yacht_id); ?>

<section class="single-yacht primary-bg">
    <div class="yacht-single-banner">
        <div class="yacht-single-heading">
            <div class="yacht-heading-main">
                <div class="yacht-heading-main-info d-flex flex-row flex-lg-column">
                    <div class="yacht-heading-builts d-flex flex-column primary-text">
                        <div class="single-about secondary-text">
                            Yachts for Charter
                        </div>
                        <h1 class="single-heading primary-text"><?php echo esc_html(ucwords(strtolower($yacht_name))); ?></h1>
                        <div class="built-items">
                            <div class="builts-length"><?php echo $yacht_length_in; ?> / <?php echo $yacht_length_m; ?></div>
                            <span class="single-border"></span>
                            <div class="builts-make"><?php echo $yacht_make; ?></div>
                            <span class="single-border"></span>
                            <div class="builts-year"><?php echo $yacht_built_year; ?></div>
                        </div>
                    </div>
                    <?php 
                    if($yacht_zones) { ?>
                        <div class="yacht-heading-region">
                            <?php
                            $zone_arr = json_decode($yacht_zones, true); 
                            foreach( $zone_arr as $zone ) { ?>
                                <span><?php echo esc_html($zone); ?></span>
                            <?php 
                            } ?>
                        </div>
                    <?php } ?>


                </div>
                    <?php
                
                    if( !empty($yacht_weekPricingFrom) ) { 
                        $week_pricing_arr = json_decode($yacht_weekPricingFrom, true);
                        $currency = !empty($week_pricing_arr['currency']) ? $week_pricing_arr['currency'] : '';
                        $currency = yacht_manager_get_currency_symbol($currency);
                        $price = !empty($week_pricing_arr['displayPrice']) ? $week_pricing_arr['displayPrice'] : '';
                        $price = is_numeric($price) ? number_format(floatval($price), 0) : '';
                        $unit = !empty($week_pricing_arr['unit']) ? $week_pricing_arr['unit'] : ''; 
                        
                        if( $currency && $price && $unit ) { ?>
                            <div class="yacht-heading-pricing primary-text">
                                From <?php echo $currency; ?><?php echo $price; ?> / <?php echo ucfirst(strtolower($unit)); ?>
                            </div>
                        <?php 
                        }
                    } ?>
                 <div class="yacht-single-blueprint">
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-type">
                            <div class="yacht-type-item">
                                <div class="blueprint-label yacht-type-label">Yacht Type</div>
                                <div class="blueprint-value yacht-type-value"><?php echo esc_html($yacht_type); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-length">
                            <div class="yacht-length-item">
                                <div class="blueprint-label yacht-length-label">Length</div>
                                <div class="blueprint-value yacht-length-value"><?php echo esc_html($yacht_length_m); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-cabins">
                            <div class="yacht-cabins-item">
                                <div class="blueprint-label yacht-cabins-label">Cabins</div>
                                <div class="blueprint-value yacht-cabins-value"><?php echo esc_html($yacht_cabins); ?>6</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-guests">
                            <div class="yacht-guests-item">
                                <div class="blueprint-label yacht-guests-label">Guests</div>
                                <div class="blueprint-value yacht-guests-value"><?php echo esc_html($yacht_sleeps); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-crew">
                            <div class="yacht-crew-item">
                                <div class="blueprint-label yacht-crew-label">Crew</div>
                                <div class="blueprint-value yacht-crew-value"><?php echo esc_html($yacht_maxcrew); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="yacht-heading-link">
                    <a href="#ytm-content-enquire" class="btn">Book now</a>
                </div>
            </div>
        </div>
        <div class="yacht-single-image">
            <div class="yacht-single-thumb">
                <?php 
                if( $thumbnail_id ) {
                    echo wp_get_attachment_image($thumbnail_id, 'full');
                } ?>
            </div>
            
        </div>
    </div>
    <div class="yacht-single-content">
        <div class="yacht-content-info">
            <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-description">
                        <?php if( !empty(get_the_content()) ) { ?>
                            <div class="description-about">
                                <h2 class="primary-text">About</h2>
                                <div id="yacht-about" class="yacht-about-text yacht-full-content body-text">
                                    <?php the_content(); ?>
                                </div>
                                <button class="see-more-btn" id="about-see-more">Read More</button>
                            </div>
                        <?php 
                        }
                        
                        if( !empty($yacht_amenities) ) { ?>
                            <div class="description-amenities">
                                <h2 class="primary-text">Amenities and Entertainment</h2>
                                <div id="yacht-amenities" class="yacht-amenities-list yacht-full-content amenities-list secondary-text">
                                    <div class="row">
                                        <?php $amenities_arr = json_decode($yacht_amenities, true);
                                        if( $amenities_arr && is_array($amenities_arr) && count($amenities_arr)>0 ) {
                                            $count = 1;
                                            foreach( $amenities_arr as $amenities ) { 
                                                if( !empty($amenities['label']) ) { 
                                                    $count = ($count % 4) ?: 4; ?>
                                                    <div class="col-6 col-md-4">
                                                        <div class="amenitites-item">
                                                            <span class="amenities-label amenities-<?php echo absint($count); ?>">
                                                                <?php echo esc_html($amenities['label']); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php $count++;
                                                }
                                            }
                                        } ?>
                                    </div>
                                </div>
                                <button class="see-more-btn" id="amenities-see-more">View More</button>
                            </div>
                        <?php 
                        }
                        
                        yacht_manager_display_downloaded_images($yacht_id); ?>

                        <div class="description-specs">
                            <h5 class="primary-text">Specification</h5>
                            <div class="specs-list">
                                <?php if( !empty($yacht_cabinLayout) ) { 
                                    $cabin_layout = json_decode($yacht_cabinLayout, true); 
                                    if( $cabin_layout && is_array($cabin_layout) && count($cabin_layout)>0 ) { ?>
                                        <div class="specs-list-item">
                                            <div class="specs-label secondary-text">
                                                Cabin Configuration   
                                            </div>
                                            <div class="specs-item primary-text">
                                                <?php
                                                foreach($cabin_layout as $clayout) { ?>
                                                    <span><?php echo $clayout['value'].$clayout['label']; ?></span>  
                                                <?php 
                                                } ?>
                                            </div>
                                        </div>
                                    <?php 
                                    }
                                } ?>
                                <div class="specs-list-item">
                                    <div class="specs-label secondary-text">
                                        Length   
                                    </div>
                                    <div class="specs-item primary-text">
                                        <span><?php echo $yacht_length_in .' / '. $yacht_length_m; ?></span> 
                                    </div>
                                </div>
                                <?php 
                                if( !empty($yacht_beam) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Beam   
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_beam; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } 
                                if( !empty($yacht_draft) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Draft   
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_draft; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } 
                                if( !empty($yacht_tonnage) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Gross Tonnage   
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_tonnage; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_cruiseSpeed) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Cruising Speed   
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_cruiseSpeed; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_built_year) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Built
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_built_year; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_architect) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Builder
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_architect; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_model) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Model
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_model; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_interiorDesigner) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label secondary-text">
                                            Interior Designer
                                        </div>
                                        <div class="specs-item primary-text">
                                            <span><?php echo $yacht_interiorDesigner; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="ytm-content-enquire" class="content-enquire secondary-bg">
                        <div class="enquire-form primary-bg">
                            <div class="form-title primary-text">
                                Enquire
                            </div>
                            <div class="form-description secondary-text">
                                You are welcome to ask us anything regarding 2004 CRN Ancona CRN 128 ARIELA for charter. Our team of specialists are here to help.
                            </div>
                            <div class="form-field">
                                <form action="" class="form-enquire" method="POST" onsubmit="return validateForm()">
                                    <?php wp_nonce_field('yacht_manager_enquiry', 'yacht_manager_nonce'); ?>
                                    <input type="hidden" name="yacht" value="<?php echo esc_attr(ucwords(strtolower($yacht_name))); ?>">
                                    
                                    <div class="field-name field-input">
                                        <input type="text" class="form-input primary-color" id="single-input-name" name="name" placeholder="Name">
                                        <span class="error" id="error-name"></span>
                                    </div>
                                    
                                    <div class="field-phone field-input">
                                        <input type="text" class="form-input" name="phone" id="single-input-phone" placeholder="Phone">
                                        <span class="error" id="error-phone"></span>
                                    </div>
                                    
                                    <div class="field-email field-input">
                                        <input type="text" class="form-input" name="email" id="single-input-email" placeholder="Email">
                                        <span class="error" id="error-email"></span>
                                    </div>
                                    
                                    <div class="field-message field-input">
                                        <textarea rows="4" class="form-input" name="message" id="single-input-message" placeholder="Message"></textarea>
                                        <span class="error" id="error-message"></span>
                                    </div>
                                    
                                    <div class="field-button">
                                        <button type="submit" name="submit_enquiry" class="btn cta-text cta-color">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<script>
    function validateForm() {
        var name = document.getElementById("single-input-name").value.trim();
        var phone = document.getElementById("single-input-phone").value.trim();
        var email = document.getElementById("single-input-email").value.trim();
        var message = document.getElementById("single-input-message").value.trim();

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email validation pattern
        var phonePattern = /^[0-9]+$/; // Only allows numbers

        var isValid = true;

        // Clear previous error messages
        document.getElementById("error-name").innerText = "";
        document.getElementById("error-phone").innerText = "";
        document.getElementById("error-email").innerText = "";
        document.getElementById("error-message").innerText = "";

        if (name === "") {
            document.getElementById("error-name").innerText = "Name is required.";
            isValid = false;
        }

        if (phone === "") {
            document.getElementById("error-phone").innerText = "Phone number is required.";
            isValid = false;
        } else if (!phonePattern.test(phone)) {
            document.getElementById("error-phone").innerText = "Phone number must contain only numbers.";
            isValid = false;
        }

        if (email === "") {
            document.getElementById("error-email").innerText = "Email is required.";
            isValid = false;
        } else if (!emailPattern.test(email)) {
            document.getElementById("error-email").innerText = "Please enter a valid email address.";
            isValid = false;
        }

        if (message === "") {
            document.getElementById("error-message").innerText = "Message is required.";
            isValid = false;
        }

        return isValid; // Submit the form only if all validations pass
    }
</script>

<?php get_footer();