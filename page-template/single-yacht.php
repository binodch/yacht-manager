<?php
// single yacht post
get_header(); ?>

<section class="single-yacht">
    <div class='container'>
        <div class="yacht-single-banner">
            <div class="yacht-single-heading">
                <div class="single-about">
                    Yachts for Charter
                </div>
                <h1 class="single-heading"><?php the_title(); ?></h1>
                <div class="yacht-heading-main">
                    <div class="yacht-heading-builts">
                        <div class="builts-length">150'8 / 40m</div>
                        <span class="single-border"></span>
                        <div class="builts-material">Golden Yachts</div>
                        <span class="single-border"></span>
                        <div class="builts-year">2020</div>
                    </div>
                    <div class="yacht-heading-region">
                        <span>Turkey</span>
                        <span>Greece</span>
                        <span>East Mediterranean</span>
                        <span>Aegan Sea</span>
                    </div>
                    <div class="yacht-heading-pricing">
                        From $115,000 / Week
                    </div>
                    <div class="yacht-heading-link">
                        <a href="#book-now" class="btn">Book now</a>
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
                                <div class="blueprint-value yacht-type-value">Motor</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-length">
                            <div class="yacht-length-item">
                                <div class="blueprint-label yacht-length-label">Length</div>
                                <div class="blueprint-value yacht-length-value">40m</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-cabins">
                            <div class="yacht-cabins-item">
                                <div class="blueprint-label yacht-cabins-label">Cabins</div>
                                <div class="blueprint-value yacht-cabins-value">6</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-guests">
                            <div class="yacht-guests-item">
                                <div class="blueprint-label yacht-guests-label">Guests</div>
                                <div class="blueprint-value yacht-guests-value">12</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-crew">
                            <div class="yacht-crew-item">
                                <div class="blueprint-label yacht-crew-label">Crew</div>
                                <div class="blueprint-value yacht-crew-value">5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="yacht-single-content">
            <div class="yacht-content-info">
                <div class="row">
                <div class="col-md-8">
                    <div class="content-description">
                        <div class="description-about">
                            <h2>About</h2>
                            <div class="about-text">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="description-amenities">
                            <h2>Amenities and Entertainment</h2>
                            <div class="amenities-list">
                                <div class="row">
                                    <?php 
                                    for($i=0; $i<12; $i++) { ?>
                                        <div class="col-md-4">
                                            <div class="amenitites-item">
                                                <span class="amenities-label">Onsite Cafe</span>
                                            </div>
                                        </div>
                                    <?php 
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="description-gallery">
                            <h2>Gallery</h2>
                            <div class="gallery-list">
                                something...
                            </div>
                        </div>
                        <div class="description-specs">
                            <h5>Specification</h5>
                            <div class="specs-list">
                                <div class="specs-list-item">
                                    <div class="specs-label">
                                        Cabin Configuration   
                                    </div>
                                    <div class="specs-item">
                                        <span>1Master</span>  
                                        <span>1VIP</span>  
                                        <span>2Twin</span>  
                                        <span>1Single</span>  
                                    </div>
                                </div>
                                <?php 
                                for( $i=0; $i<8; $i++ ) { ?>
                                    <div class="specs-list-item">
                                        <div class="specs-label">
                                            Length   
                                        </div>
                                        <div class="specs-item">
                                            <span>150'8 / 40m</span> 
                                        </div>
                                    </div>
                                <?php 
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content-enquire">
                        Enquire
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();