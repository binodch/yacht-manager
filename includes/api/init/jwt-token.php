<?php
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if( ! function_exists('yacht_manager_generate_jwt_token') ) {
    function yacht_manager_generate_jwt_token() {

        $company_uri = get_option('yacht_manager_company_uri'); 
        $key_id = get_option('yacht_manager_key_id'); 

        $keyPath = __DIR__ . '/../keys/private_key.pem';
        $private_key = file_get_contents($keyPath);

        $issued_at = time();
        $expires_at = $issued_at + 3600; // 1 hour expiration

        $header = [
            "alg" => "RS256",
            "typ" => "JWT",
            "kid" => $key_id
        ];

        $payload = [
            "scopes" => ["website:read:*"] ,
            "iss" => $company_uri,
            "aud" => "ankor.io",
            "sub" => $company_uri,
            "iat" => $issued_at,
            "exp" => $expires_at
        ];

        // Generate JWT Token
        $jwt = JWT::encode($payload, $private_key, 'RS256', $key_id); // RS256 encryption

        return $jwt;
    }
}