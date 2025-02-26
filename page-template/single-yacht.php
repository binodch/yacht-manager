<?php
// single yacht post
get_header();

$yacht_id = get_the_ID(); 

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
$yacht_model = get_post_meta($yacht_id, 'yacht_model', true);
$yacht_interiorDesigner = get_post_meta($yacht_id, 'yacht_interiorDesigner', true);
?>

<section class="single-yacht">
    <div class="yacht-single-banner">
        <div class="yacht-single-heading">
            <div class="single-about">
                Yachts for Charter
            </div>
            <h1 class="single-heading"><?php the_title(); ?></h1>
            <div class="yacht-heading-main">
                <div class="yacht-heading-builts">
                    <div class="builts-length"><?php echo $yacht_length_in; ?> / <?php echo $yacht_length_m; ?></div>
                    <span class="single-border"></span>
                    <div class="builts-material"><?php echo $yacht_built_year; ?></div>
                    <span class="single-border"></span>
                    <div class="builts-year"><?php echo $yacht_make; ?></div>
                </div>
                <div class="yacht-heading-region">
                    <span>Turkey</span>
                    <span>Greece</span>
                    <span>East Mediterranean</span>
                    <span>Aegan Sea</span>
                </div>
                <?php if( !empty($yacht_weekPricingFrom) ) { 
                    $week_pricing_arr = json_decode($yacht_weekPricingFrom, true);
                    $currency = !empty($week_pricing_arr['currency']) ? $week_pricing_arr['currency'] : '-';
                    $currency = yacht_manager_get_currency_symbol($currency);
                    $price = !empty($week_pricing_arr['displayPrice']) ? $week_pricing_arr['displayPrice'] : '-';
                    $price = number_format($price);
                    $unit = !empty($week_pricing_arr['unit']) ? $week_pricing_arr['unit'] : '-'; ?>
                    <div class="yacht-heading-pricing">
                        From <?php echo $currency; ?><?php echo $price; ?> / <?php echo $unit; ?>
                    </div>
                <?php } ?>
                <div class="yacht-heading-link">
                    <a href="#ytm-content-enquire" class="btn">Book now</a>
                </div>
            </div>
        </div>
        <div class="yacht-single-image">
            <div class="yacht-single-thumb">
                <img decoding="async" src="<?php echo plugin_dir_url(dirname(__FILE__, 1)) . 'assets/css/yacht.jpg' ?> .'" alt="p">
            </div>
            <div class="yacht-single-blueprint">
                <div class="yacht-blueprint-item">
                    <div class="blueprint-yacht-type">
                        <div class="yacht-type-item">
                            <div class="blueprint-label yacht-type-label">Yacht Type</div>
                            <div class="blueprint-value yacht-type-value"><?php echo esc_html($yacht_model); ?></div>
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
        </div>
    </div>
    <div class="yacht-single-content">
        <div class="yacht-content-info">
            <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="content-description">
                        <div class="description-about">
                            <h2>About</h2>
                            <div class="about-text">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <?php 
                        if( !empty($yacht_amenities) ) { ?>
                            <div class="description-amenities">
                                <h2>Amenities and Entertainment</h2>
                                <div class="amenities-list">
                                    <div class="row">
                                        <?php $amenities_arr = json_decode($yacht_amenities, true);
                                        if( $amenities_arr && is_array($amenities_arr) && count($amenities_arr)>0 ) {
                                            foreach( $amenities_arr as $amenities ) { 
                                                if( !empty($amenities['label']) ) { ?>
                                                    <div class="col-md-4">
                                                        <div class="amenitites-item">
                                                            <span class="amenities-label"><?php echo esc_html($amenities['label']); ?></span>
                                                        </div>
                                                    </div>
                                                <?php 
                                                }
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        } ?>
                        <div class="description-gallery">
                            <h2>Gallery</h2>
                            <div class="gallery-list">
                                <div class="yacht-swiper-container">
                                    <div class="yacht-swiper-gradient gradient-left"></div>
                                    <div class="yacht-swiper-gradient gradient-right"></div>
                                    <div class="swiper-wrapper">
                                        <?php for( $i=0; $i<6; $i++ ) { ?>
                                        <div class="swiper-slide"><img src="<?php echo plugin_dir_url(dirname(__FILE__, 1)) . 'assets/css/yacht.jpg' ?>" alt="Image 1"></div>
                                        <?php } ?>
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
                        <div class="description-specs">
                            <h5>Specification</h5>
                            <div class="specs-list">
                                <?php if( !empty($yacht_cabinLayout) ) { 
                                    $cabin_layout = json_decode($yacht_cabinLayout, true); 
                                    if( $cabin_layout && is_array($cabin_layout) && count($cabin_layout)>0 ) { ?>
                                        <div class="specs-list-item">
                                            <div class="specs-label">
                                                Cabin Configuration   
                                            </div>
                                            <div class="specs-item">
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
                                    <div class="specs-label">
                                        Length   
                                    </div>
                                    <div class="specs-item">
                                        <span><?php echo $yacht_length_in .' / '. $yacht_length_m; ?></span> 
                                    </div>
                                </div>
                                <?php 
                                if( !empty($yacht_beam) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Beam   
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_beam; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } 
                                if( !empty($yacht_draft) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Draft   
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_draft; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } 
                                if( !empty($yacht_tonnage) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Gross Tonnage   
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_tonnage; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_cruiseSpeed) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Cruising Speed   
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_cruiseSpeed; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_built_year) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Build
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_built_year; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_architect) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Builder
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_architect; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_model) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Model
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_model; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } 
                                if( !empty($yacht_built_year) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Built
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_built_year; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                }
                                if( !empty($yacht_interiorDesigner) ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Interior Designer
                                        </div>
                                        <div class="specs-item">
                                            <span><?php echo $yacht_interiorDesigner; ?></span> 
                                        </div>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="ytm-content-enquire" class="content-enquire">
                        Enquire
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();