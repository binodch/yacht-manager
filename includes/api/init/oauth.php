<?php

if( ! function_exists('yacht_manager_oauth_token') ) {
    function yacht_manager_oauth_token() {

        // Your JWT token
        $jwtToken = "241583"; 

        // API endpoint
        $url = "https://api.ankor.io/iam/oauth/token";

        // POST data
        $data = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwtToken
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
            echo "cURL error: " . curl_error($ch);
        } else {
            echo "Response Code: $httpCode\n";
            echo "Response: $response";
        }

        // Close cURL session
        curl_close($ch);

    }
}

