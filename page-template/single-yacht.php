<?php
// single yacht post
get_header(); ?>

<section class="single-yacht">
    <div class='container'>
        <div class="yacht-single-banner">
            <div clas="yacht-single-heading">
                <?php the_title('<h1>', '</h1>'); ?>
                <div class="yacht-heading-main">
                    <div clas="yacht-heading-builts">
                        <div class="builts-length">150'8 / 40m</div>
                        <div class="builts-material">Golden Yachts</div>
                        <div class="builts-year">2020</div>
                    </div>
                    <div clas="yacht-heading-region">
                        <span>Turkey</span>
                        <span>Greece</span>
                        <span>East Mediterranean</span>
                        <span>Aegan Sea</span>
                    </div>
                    <div clas="yacht-heading-pricing">
                        From $115,000 / Week
                    </div>
                    <div clas="yacht-heading-link">
                        <a href="#book-now" class="btn btn-primary">Book now</a>
                    </div>
                </div>
            </div>
            <div clas="yacht-single-image">
                <div clas="yacht-single-thumb">
                    <img decoding="async" src="<?php echo plugin_dir_url(dirname(__FILE__, 1)) . 'assets/css/yacht.jpg' ?> .'" alt="p">
                </div>
                <div class="yacht-single-blueprint">
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-type">
                            <div class="yacht-type-item">
                                <div class="yacht-type-label">Yacht Type</div>
                                <div class="yacht-type-value">Motor</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-length">
                            <div class="yacht-length-item">
                                <div class="yacht-length-label">Length</div>
                                <div class="yacht-length-value">40m</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-cabins">
                            <div class="yacht-cabins-item">
                                <div class="yacht-cabins-label">Cabins</div>
                                <div class="yacht-cabins-value">6</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-guests">
                            <div class="yacht-guests-item">
                                <div class="yacht-guests-label">Guests</div>
                                <div class="yacht-guests-value">12</div>
                            </div>
                        </div>
                    </div>
                    <div class="yacht-blueprint-item">
                        <div class="blueprint-yacht-crew">
                            <div class="yacht-crew-item">
                                <div class="yacht-crew-label">Crew</div>
                                <div class="yacht-crew-value">5</div>
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
                                something...
                            </div>
                        </div>
                        <div class="description-amenities">
                            <h2>Amenities and Entertainment</h2>
                            <div class="about-text">
                                something...
                            </div>
                        </div>
                        <div class="description-gallery">
                            <h2>Gallery</h2>
                            <div class="about-text">
                                something...
                            </div>
                        </div>
                        <div class="description-specs">
                            <h5>Specification</h5>
                            <div class="about-text">
                                something...
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