<?php

// Server-side Render Function
function render_featured_entity_block($attributes) {
    $title = esc_html($attributes['title']);
    $description = esc_html($attributes['description']);

    $featured_entity = '<section id="section-featured-entity" class="section ytm-section-featured-entity">';
    $featured_entity .= '<div class="container">';
        if ( !empty($title) ||  !empty($description) ) {
            $featured_entity .= '<div class="ytm-col-content">';
                if ($title != '') {
                    $featured_entity .= '<h2 class="ytm-content-title">' . $title . '</h2>';
                }
                if( $description != '' ) {
                    $featured_entity .= '<div class="ytm-content-desc">'. wp_kses_post(nl2br($description)) . '</div>';
                }
            $featured_entity .= '</div>';
        }

        $entity_list = yacht_manager_curl_featured_entity_list();

        if( $entity_list && is_array($entity_list) && count($entity_list)>0 ) {
            $count = 1;

            $featured_entity .= '<div class="ytm-featured-entity-wrap">';

            $featured_entity .= '<div class="row">';

            foreach ($entity_list as $entity) {
                $uri = $entity['uri'];
                $entity_arr = yacht_manager_check_if_yacht_uri_exists($uri, 'abcdefgh09', 'yacht_entity_search_hash');
                
                $yacht_id = !empty($entity_arr) ? $entity_arr['id'] : '';
                $thumbnail_id = get_post_thumbnail_id($yacht_id);

                $_refityear = get_post_meta($yacht_id, 'yacht_refitYear', true);
                $_built_year = get_post_meta($yacht_id, 'yacht_built_year', true); 
                $refityear = !empty($_refityear) ? $_refityear : '-';
                $built_year = !empty($_built_year) ? $_built_year : $refityear;

                $weekPricingFrom = get_post_meta($yacht_id, 'yacht_weekPricingFrom', true); 
                $week_pricing_arr = json_decode($weekPricingFrom, true);
                $currency = !empty($week_pricing_arr['currency']) ? $week_pricing_arr['currency'] : '';
                $currency = yacht_manager_get_currency_symbol($currency);
                $price = !empty($week_pricing_arr['displayPrice']) ? $week_pricing_arr['displayPrice'] : '';
                $price = is_numeric($price) ? number_format(floatval($price), 2) : '';
                $unit = !empty($week_pricing_arr['unit']) ? $week_pricing_arr['unit'] : '';

                $col = ( ($count == 1) || ($count == 6) ) ? 'col-md-6 col-lg-4 col-xl-6' : 'col-md-6 col-lg-4 col-xl-3';
                $img_class = ( ($count == 1) || ($count == 6) ) ? 'image-large' : 'image-fit';
                $featured_entity .= '<div class="' . $col . '">';
                $featured_entity .= '<div class="ytm-entity-item">';
                $featured_entity .= '<div class="ytm-entity-list">';
                $featured_entity .= '<div class="ytm-entity-image '. $img_class .'">';

                if( $thumbnail_id ) {
                    $featured_entity .= wp_get_attachment_image($thumbnail_id, 'large');
                }

                $featured_entity .= '</div>';
                
                $featured_entity .= '<div class="ytm-entity-content">';

                    if( isset($entity['symbol']) ) {
                        $featured_entity .= '<div class="ytm-item-symbol">
                            Molo 63
                        </div>';
                    }

                    if( isset($entity['name']) ) {
                        $featured_entity .= '<div class="ytm-item-name">
                            <h3>' . esc_html(ucwords(strtolower($entity['name']))) . '</h3>
                        </div>';
                    }

                    if( $currency && $unit && $price ) {
                        $featured_entity .= '<div class="ytm-item-cost">
                            <p>'. ucfirst(strtolower($unit)) .': <span>From '. $currency . $price .'</span></p>
                        </div>';
                    }

                    $featured_entity .= '<div class="ytm-item-meta">';

                    if( $built_year ) {
                        $featured_entity .= '<div class="ytm-meta-item meta-builtyear">
                            <span>' . $built_year . '</span>
                        </div>';
                    }

                    if( isset($entity['length']) ) {
                        $unit_ft = $entity['length'] ? $entity['length'] : '-';
                        $unit_m = $unit_ft ? round($unit_ft/3.281, 2) : '';
                        $unit_length = $unit_m ? $unit_m.'m' . ' (' . $unit_ft . 'ft)' : '-';
                        $featured_entity .= '<div class="ytm-meta-item meta-length">
                            <span>' . $unit_length . '</span>
                        </div>';
                    }

                    if( isset($entity['cabins']) ) {
                        $cabins = $entity['cabins'] ? $entity['cabins'] : '-';
                        $featured_entity .= '<div class="ytm-meta-item meta-cabins">
                            <span>' . $cabins . '</span>
                        </div>';
                    }

                    if( isset($entity['make']) ) {
                        $make = $entity['make'] ? $entity['make'] : '-';
                        $featured_entity .= '<div class="ytm-meta-item meta-make">
                            <span>' . $make . '</span>
                        </div>';
                    }
                        
                    $featured_entity .= '</div>';

                $featured_entity .= '</div>';

                $featured_entity .= '</div>';
                $featured_entity .= '</div>';
                $featured_entity .= '</div>';
                $count++;
            }

            $featured_entity .= '</div>';

            $featured_entity .= '</div>';
        
        }

    $featured_entity .= '</div>';
    $featured_entity .= '</section>';
    
    return $featured_entity;
}