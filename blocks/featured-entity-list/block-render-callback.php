<?php

// Server-side Render Function
function render_featured_entity_block($attributes) {
    $title = esc_html($attributes['title']);
    $description = esc_html($attributes['description']);

    $section_padding = 'mt-0';

    $featured_entity = '<section id="section-featured-entity" class="section section-blog-listing-extended '. $section_padding.'">';
    $featured_entity .= '<div class="container">';
        if ( !empty($title) ||  !empty($description) ) {
            $featured_entity .= '<div class="section-col-content">';
                if ($title != '') {
                    $featured_entity .= '<h2 class="section-col-content__title">' . $title . '</h2>';
                }
                if( $description != '' ) {
                    $featured_entity .= '<div class="section-heading-desc mb-md-0">'. wp_kses_post(nl2br($description)) . '</div>';
                }
            $featured_entity .= '</div>';
        }

        $entity_list = yacht_manager_curl_featured_dentity_list();

        if( $entity_list && is_array($entity_list) && count($entity_list)>0 ) {
            $count = 1;

            $featured_entity .= '<div class="content-adventure-wrap">';

            $featured_entity .= '<div class="row">';

            foreach ($entity_list as $entity) {
                $col = ( ($count == 1) || ($count == 6) ) ? 'col-md-6 col-lg-4 col-xl-6' : 'col-md-6 col-lg-4 col-xl-3';
                $featured_entity .= '<div class="' . $col . '">';
                $featured_entity .= '<div class="adventures-list">';
                $featured_entity .= '<div class="adventures-list__icon image-large">';
                $featured_entity .= '<img decoding="async" src="http://localhost:8888/ahoy-club-wp/wp-content/uploads/2023/10/Rectangle-24.png" alt="'. $entity['title'] .'">';
                $featured_entity .= '</div>';
                $featured_entity .= '<div class="adventures-list__content">';
                $featured_entity .= '<div class="adventures-list__content-title">Name</div>';
                $featured_entity .= '<div class="adventures-list__content-author">';
                $featured_entity .= '<img alt="" src="https://secure.gravatar.com/avatar/07a9e4d240766a1c3cabc4b0f27203e8?s=36&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/07a9e4d240766a1c3cabc4b0f27203e8?s=72&amp;d=mm&amp;r=g 2x" srcset="'. $entity['author']['avatar'] .'" class="avatar avatar-36 photo" height="36" width="36">';
                $featured_entity .= '<span class="author-name">admin</span>';
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