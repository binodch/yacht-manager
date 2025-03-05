<?php
/**
 * hash encode array value
 */
function yacht_manager_generate_hash_signature($input) {
    if( is_array($input) ) {
        $json_data = json_encode($input, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $signature = hash('sha256', $json_data);
        return $signature;
    } else {
        $signature = hash('sha256', $input);
        return $signature;
    }
}