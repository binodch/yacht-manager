<?php

if( ! function_exists('yacht_manager_generate_access_token') ) {
    function yacht_manager_generate_access_token() {

        // Your JWT token
        $jwt_token = yacht_manager_generate_jwt_token();

        if( ! $jwt_token ) {
            return array(
                'success' => false,
                'error' => "Private key not found",
            );
        }
        
        // API endpoint
        $url = "https://api.ankor.io/iam/oauth/token";

        // POST data
        $data = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt_token
        ]);

        // Initialize cURL
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Execute request and get response
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

         // Check for errors
         if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);

            return array(
                'success' => false,
                'error' => "cURL error: $error",
            );
        }

        curl_close($ch);

        if( $response && $httpCode==200 ) {
            $response_arr = json_decode($response, true);

            if (isset($response_arr['access_token'])) {
                return array(
                    'success' => true,
                    'token' => $response_arr['access_token'],
                );
            }
            
        } else {
            return array(
                'success' => false,
                'error' => $response,
            );
        }

    }
}

