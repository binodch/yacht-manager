<?php
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if( ! function_exists('yacht_manager_generate_jwt_token') ) {
    function yacht_manager_generate_jwt_token() {
        $privateKey = "<PRIVATE_KEY>";

        $key_id = "<KEY_ID>";
        $company_uri = '<COMPANY_URL>';
        
        $issuedAt = time();
        $expireAt = $issuedAt + 3600; // 1 hour expiration

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
            "iat" => $issuedAt,
            "exp" => $expireAt
        ];

        // Generate JWT Token
        $jwt = JWT::encode($payload, $privateKey, 'RS256', $key_id); // RS256 encryption

        return $jwt;
    }
}