<?php
/*
* GET JWT token
*/

if( ! function_exists('yacht_manager_oath_jwt') ) {
    function yacht_manager_oath_jwt() {
        // OAuth2 token endpoint
        $url = "https://your-oauth-provider.com/token";

        // Client credentials
        $client_id = "your-client-id";
        $client_secret = "your-client-secret";

        // Request parameters
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ];

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        // Execute request and get response
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response
        $decodedResponse = json_decode($response, true);

        // Extract the JWT token from the response
        $jwtToken = $decodedResponse['access_token'];

        echo "JWT Token: " . $jwtToken;
    }
}