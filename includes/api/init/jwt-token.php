<?php
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if( ! function_exists('yacht_manager_generate_jwt_token') ) {
    function yacht_manager_generate_jwt_token() {

        $company_uri = get_option('yacht_manager_company_uri'); 
        $key_id = get_option('yacht_manager_key_id'); 

        $keys_dir = __DIR__ . '/../keys';
        $key_file_path = $keys_dir . '/private_key.pem';

        // return false if /keys directory not found
        if (!is_dir($keys_dir)) {
            return false;
        }
        
        // return false if /.pem file not found
        if (!file_exists($key_file_path)) {
            return false;
        }

        // get file content of /.pem file
        $private_key = file_get_contents($key_file_path);

        $issued_at = time();
        $expires_at = $issued_at + 3600; // 1 hour expiration

        $payload = [
            "scopes" => ["website:read:*"] ,
            "iss" => $company_uri,
            "aud" => "ankor.io",
            "sub" => $company_uri,
            "iat" => $issued_at,
            "exp" => $expires_at
        ];

        try {
            // Generate JWT Token
            $jwt = JWT::encode($payload, $private_key, 'RS256', $key_id); 
            return $jwt;

        } catch (Exception $e) {
            error_log('JWT Generation Error: ' . $e->getMessage());
            return false;
        }
    }
}