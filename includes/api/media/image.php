<?php
// get entity media attachment 
if( ! function_exists('yacht_manager_curl_get_entity_attachment_image') ) {
    function yacht_manager_curl_get_entity_attachment_image($image_path, $image_variant, $yacht_id) {
        $base_ApiUrl = 'https://api.ankor.io';
        // $downloadDir = "downloads/"; // Store images in a specific folder

        $upload_dir = __DIR__ . '/../media/downloads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $upload_yacht_dir = __DIR__ . '/../media/downloads/'.$yacht_id.'/';
        if (!file_exists($upload_yacht_dir)) {
            mkdir($upload_yacht_dir, 0755, true);
        }
    
        // Replace {imageVariant} with the actual variant in the image path
        $imageUrl = $base_ApiUrl . str_replace("{imageVariant}", $image_variant, $image_path);
    
        // Get the filename without the placeholder
        $imageName = basename(str_replace("/{imageVariant}", "", $image_path)) . "_$image_variant.jpeg";
        $savePath = $upload_yacht_dir . $imageName; // Full path
    
        // Initialize cURL session
        $ch = curl_init($imageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        // Execute cURL request
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        // Check if the request was successful
        if ($httpCode == 200 && $imageData !== false) {
            file_put_contents($savePath, $imageData);
            return $savePath;
        } else {
            error_log("Failed to fetch image: $imageUrl (HTTP Code: $httpCode)");
            return false;
        }
    }
}