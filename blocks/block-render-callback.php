<?php

// Server-side Render Function
function render_featured_entity_block($attributes) {
    $title = esc_html($attributes['title']);
    $description = esc_html($attributes['description']);

    $section_padding = 'mt-0';

    $featured_entity = '<section id="section-featured-entity" class="section section-blog-listing-extended'. $section_padding.'">';
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

        /*$blog_posts = array(); 
                
        if( $blog_posts && is_array($blog_posts) && count($blog_posts)>0 ) { ?>
            <div class="content-adventure-wrap">
                <?php 
                foreach( $blog_posts as $blog ) {
                    $count = 1;
                    $style = $blog['style'];
                    $post_blog = $blog['blog']; 
                    if( $post_blog && count($post_blog)>0 ) { ?>
                        
                        <div class="row">
                            <?php $image_size = 'medium_large';
                            foreach( $post_blog as $blg ) {
                                $col = 'col-md-6 col-lg-4 col-xl-3';
                                $image_large = 'image-fit';
                                if($style=='first' && $count==1) {
                                    $col = 'col-md-6 col-lg-4 col-xl-6';
                                    $image_size = 'full';
                                    $image_large = 'image-large';
                                } 
                                if($style=='last' && $count==3) {
                                    $col = 'col-md-6';
                                    $image_size = 'full';
                                    $image_large = 'image-large';
                                } ?>
                                <div class="<?php echo esc_attr($col); ?>">
                                    <div class="adventures-list">
                                        <?php if( $blg ) { ?>
                                            <div class="adventures-list__icon <?php echo esc_attr($image_large); ?>">
                                                <?php $url = get_the_post_thumbnail_url($blg, $image_size); 
                                                $imgurl = $url ? $url : AHOY_CLUB_IMAGES_DIR.'placeholder/blog-image.png'; ?>
                                                <img src="<?php echo esc_url($imgurl); ?>" alt="i" />
                                            </div>
                                        <?php } ?>
                                        <div class="adventures-list__content">
                                            <div class="adventures-list__content-title">
                                                <?php echo get_the_title($blg); ?>
                                            </div>
                                            <div class="adventures-list__content-author">
                                                <?php $author_id = get_post_field( 'post_author', $blg ); 
                                                echo $author_profile = get_avatar( $author_id, 36); ?>
                                                <span class="author-name">
                                                    <?php echo get_the_author_meta('display_name', $author_id); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $count++;
                            } ?>
                        </div>

                    <?php 
                    }
                } ?>
            </div>
        <?php
        } ?>

        */

    $featured_entity .= '</div>';
    $featured_entity .= '</section>';
    
    return $featured_entity;
}