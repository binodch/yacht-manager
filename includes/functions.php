<?php

// return if page template is assigned to any page or not
function yacht_manager_template_assigned($template_file) {
    $query = new WP_Query([
        'post_type'  => 'page',
        'meta_key'   => '_wp_page_template',
        'meta_value' => $template_file,
        'posts_per_page' => 1, // Get only one page
    ]);

    if ($query->have_posts()) {
        $query->the_post();
        $url = get_permalink();
        wp_reset_postdata();
        return $url;
    }

    return false;
}

function yacht_manager_get_yacht_id($yacht_uri) {
    $entity_id = [];
    $args = [
        'post_type'      => 'yacht',
        'meta_query'     => [
            [
                'key'     => 'yacht_uri',
                'value'   => $yacht_uri,
                'compare' => '='
            ]
        ],
        'posts_per_page' => -1,
        'fields'         => 'ids'
    ];
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $entity_id[] = get_the_ID();
        } wp_reset_postdata();
    }
    return $entity_id;
}

function yacht_manager_get_first_taxnomy_term($yacht_id) {
    $taxonomy = 'yacht-type'; 
    $terms = wp_get_post_terms($yacht_id, $taxonomy);
    if (!empty($terms) && !is_wp_error($terms)) {
        if( isset($terms[0]) ) {
            $yacht_type = $terms[0]->name;
            return esc_html($yacht_type);
        }
    }
    return;
}

function yacht_manager_convert_feet_into_inches($feet) {
    $whole_feet = floor($feet);
    $remaining_inches = ($feet - $whole_feet) * 12;
    return "{$whole_feet}' " . round($remaining_inches, 1) . '"';
}

function yacht_manager_get_currency_symbol($currency) {
    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'AUD' => 'A$',
        'CAD' => 'C$',
        'CHF' => 'CHF',
        'CNY' => '¥',
        'INR' => '₹'
    ];

    return $symbols[$currency] ?? $currency;
}

function yacht_manager_entity_media_imageVariant($index=2) {
    $image_variant = array('320w', '640w', '960w', '1280w', '2560w');
    return $image_variant[$index];
}


function yacht_manager_display_downloaded_images($yacht_id) {
    $dir_path = 'api/media/downloads/'. $yacht_id .'/';
    $downloads_dir = plugin_dir_path(__FILE__) . $dir_path;

    if (!file_exists($downloads_dir)) {
        wp_mkdir_p($downloads_dir);
    }

    $images = glob($downloads_dir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

    if (!empty($images)) { ?>
        <div class="description-gallery">
            <h2 class="primary-text">Gallery</h2>
            <div class="gallery-list">
                <div class="yacht-swiper-container">
                    <div class="yacht-swiper-gradient gradient-left"></div>
                    <div class="yacht-swiper-gradient gradient-right"></div>
                        <div class='swiper-wrapper'>
                            <?php 
                            foreach ($images as $img) {
                                $img_url = plugin_dir_url(__FILE__) . $dir_path . basename($img);
                                echo "
                                    <div class='swiper-slide'>
                                        <img src='{$img_url}' width='100%' alt='img' />
                                    </div>
                                ";
                            } ?>
                        </div>
                        
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    <?php
    }
    return;
}

/* convert hex color to rgba */
function yacht_manager_hexToRgba($hex, $alpha = 1.0) {
    $hex = ltrim($hex, '#');

    if (strlen($hex) == 3) {
        $hex = str_repeat($hex[0], 2) . str_repeat($hex[1], 2) . str_repeat($hex[2], 2);
    }

    list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");

    $alpha = max(0, min(1, $alpha));

    return "rgba($r, $g, $b, $alpha)";
}


// ["/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf52cc0-b323-11ef-ba7c-5fb9d4fe812b/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf776b0-b323-11ef-928f-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cff17d0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfb6e50-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d03d2c0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cff8d00-b323-11ef-9d88-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfdb840-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfc0a91-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfa0ec0-b323-11ef-ba7c-5fb9d4fe812b/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfd9130-b323-11ef-a303-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d0420e0-b323-11ef-9d89-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cff65f0-b323-11ef-9d89-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf7ebe0-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d07f170-b323-11ef-a304-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d04bd20-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfddf50-b323-11ef-9d87-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfa35d0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfaf920-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf9c0a0-b323-11ef-928f-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf776b0-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf7ebe0-b323-11ef-ba7c-5fb9d4fe812b/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d0447f0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfd6a20-b323-11ef-9d87-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d08dbd0-b323-11ef-a304-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d09c630-b323-11ef-a304-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d055960-b323-11ef-a303-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cffdb20-b323-11ef-9d87-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d05ce90-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d09c631-b323-11ef-a304-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8fdec2b0-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::48811b70-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::48572540-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d01d6f0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d0643c0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfddf50-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d088db0-b323-11ef-a303-3758702531fb/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf812f0-b323-11ef-928f-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cff8d00-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfbe380-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfec9b0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf99990-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfbbc70-b323-11ef-ba7c-5fb9d4fe812b/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfad210-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d0113a0-b323-11ef-9d89-d352867703fe/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d00ec90-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf6da70-b323-11ef-928f-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cfc0a90-b323-11ef-b3fc-556ce3cbf4af/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8d0161c0-b323-11ef-9290-7388572c4abf/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8cf776b0-b323-11ef-ba7c-5fb9d4fe812b/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::9009ca50-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8fe24520-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cb9f4e0-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::901dc780-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::902149f0-b324-11ef-afd2-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8ff41f70-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::903e20c0-b324-11ef-a3ac-89059d7ed795/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::901cb610-b324-11ef-afd2-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::901fc350-b324-11ef-afd2-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::901bf2c0-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::4842b2e0-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cb97fb0-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cb8e370-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cbab830-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::8ffb2450-b324-11ef-afd1-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::48661960-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::48548d30-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::486d9370-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cbb2d61-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cbd0220-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::4870c7c0-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cb86e40-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::5cb82020-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::4841c880-b324-11ef-baef-b337a84289be/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::902122e0-b324-11ef-afd2-8d31a9349e5a/{imageVariant}","/media/media::image::a::vessel::156ed2f0-b31e-11ef-9263-5385f90779b2::assets::3e9552b0-b325-11ef-a928-9339e39931f3/{imageVariant}"]