<?php

// Server-side Render Function
function render_featured_entity_block($attributes) {
    $title = esc_html($attributes['title']);
    $description = esc_html($attributes['description']);

    $section_padding = 'mt-0';

    $featured_entity = '<section id="section-featured-entity" class="section ytm-section-featured-entity '. $section_padding.'">';
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
                $col = ( ($count == 1) || ($count == 6) ) ? 'col-md-6 col-lg-4 col-xl-6' : 'col-md-6 col-lg-4 col-xl-3';
                $img_class = ( ($count == 1) || ($count == 6) ) ? 'image-large' : 'image-fit';
                $featured_entity .= '<div class="' . $col . '">';
                $featured_entity .= '<div class="ytm-entity-item">';
                $featured_entity .= '<div class="ytm-entity-list">';
                $featured_entity .= '<div class="ytm-entity-image '. $img_class .'">';
                $featured_entity .= '<img decoding="async" src="'. plugin_dir_url(dirname(__FILE__, 2)) . 'assets/css/yacht.jpg' .'" alt="p">';
                $featured_entity .= '</div>';
                
                $featured_entity .= '<div class="ytm-entity-content">';

                    if( isset($entity['symbol']) ) {
                        $featured_entity .= '<div class="ytm-item-symbol">
                            Molo 63
                        </div>';
                    }

                    if( isset($entity['name']) ) {
                        $featured_entity .= '<div class="ytm-item-name">
                            <h3>' . esc_html($entity['name']) . '</h3>
                        </div>';
                    }

                    if( isset($entity['cost']) ) {
                        $featured_entity .= '<div class="ytm-item-cost">
                            <p>Day: <span>From $2,500</span></p>
                            <p>Week: <span>From $15,000</span></p>
                        </div>';
                    }

                    $featured_entity .= '<div class="ytm-item-meta">';

                    if( isset($entity['builtYear']) ) {
                        $built_year = $entity['builtYear'] ? $entity['builtYear'] : '-';
                        $featured_entity .= '<div class="ytm-meta-item meta-builtyear">
                            <span>' . $built_year . '</span>
                        </div>';
                    }

                    if( isset($entity['length']) ) {
                        $unit_ft = $entity['length'] ? $entity['length'] : '-';
                        $unit_m = $entity['length'] ? round($unit_ft/3.281, 2) : '';
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