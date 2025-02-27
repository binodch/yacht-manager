<?php
/* get entity media attachment */ 
if( ! function_exists('yacht_manager_curl_get_entity_attachment_image') ) {
    function yacht_manager_curl_get_entity_attachment_image($image_path, $image_variant, $yacht_id) {
        $base_ApiUrl = 'https://api.ankor.io';

        $upload_dir = __DIR__ . '/../media/downloads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $upload_yacht_dir = __DIR__ . '/../media/downloads/'.$yacht_id.'/';
        if (!file_exists($upload_yacht_dir)) {
            mkdir($upload_yacht_dir, 0755, true);
        }
    
        $imageUrl = $base_ApiUrl . str_replace("{imageVariant}", $image_variant, $image_path);
    
        $imageName = basename(str_replace("/{imageVariant}", "", $image_path)) . "_$image_variant.jpeg";
        $savePath = $upload_yacht_dir . $imageName;
    
        $ch = curl_init($imageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($httpCode == 200 && $imageData !== false) {
            file_put_contents($savePath, $imageData);
            return $savePath;
        } else {
            error_log("Failed to fetch image: $imageUrl (HTTP Code: $httpCode)");
            return false;
        }
    }
}

/* set featured image to entity */
function yacht_manager_set_entity_featured_image($image_path, $image_variant, $yacht_id) {
    $base_ApiUrl = 'https://api.ankor.io';

    $imageUrl = $base_ApiUrl . str_replace("{imageVariant}", $image_variant, $image_path);

    $imageName = basename(str_replace("/{imageVariant}", "", $image_path)) . "_$image_variant.jpeg"; 
    
    $ch = curl_init($imageUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200 && $imageData !== false) {
        return yacht_manager_upload_and_set_featured_image($imageData, $imageName, $yacht_id);
    } else {
        error_log("Failed to fetch image: $imageUrl (HTTP Code: $httpCode)");
        return false;
    }
}

/**
 * Uploads the image to WordPress Media Library & sets as Featured Image.
 */
function yacht_manager_upload_and_set_featured_image($imageData, $imageName, $yacht_id) {
    require_once(ABSPATH . 'wp-load.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['path'] . '/' . $imageName;

    // pr($file_path);

    // Save the image in WP uploads directory temporarily
    file_put_contents($file_path, $imageData);

    // Upload to WordPress Media Library
    $file_array = array(
        'name'     => $imageName,
        'tmp_name' => $file_path
    );

    $attach_id = media_handle_sideload($file_array, $yacht_id);

    // pr($attach_id);

    // Check if upload was successful
    if (is_wp_error($attach_id)) {
        error_log("Failed to upload image: " . $attach_id->get_error_message());
        return false;
    }

    // Set as Featured Image
    set_post_thumbnail($yacht_id, $attach_id);
    
    return $attach_id;
}
