<?php
/*
* curl to register entity
*/
function yacht_manager_curl_register_entity($uri) {
    $get_token = yacht_manager_generate_access_token();
    
    if ($get_token && isset($get_token['success']) && $get_token['success'] && isset($get_token['token'])) {
        $access_token = $get_token['token'];

        $endpoint = 'https://api.ankor.io/website/register';
        $endpoint_url = $endpoint . '/' . $uri;
        
        // Extract unique ID using regex
        preg_match('/c::([0-9]+)::vessel/', $uri, $matches);
        $unique_id = $matches[1] ?? null;
        $company_website = "https://companywebsite.com/vessels/" . $unique_id;

        if ($unique_id) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $endpoint_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, true); // Using CURLOPT_POST instead of CURLOPT_CUSTOMREQUEST
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["link" => $company_website]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token
            ));

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200 && $response) {
                // On success, call get entity
                $entity_response = yacht_manager_curl_get_entity($uri);
                if ($entity_response) {
                    return json_decode($entity_response, true);
                }
            }
        }
    }
    return false;
}