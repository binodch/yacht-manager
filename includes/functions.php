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