<?php
/*
* curl to register entity
*/
function yacht_manager_curl_register_entity($uri) {
    $get_token = yacht_manager_generate_access_token();
    if( $get_token && isset($get_token['success']) && $get_token['success'] && isset($get_token['token']) ) {
        $access_token = $get_token['token'];

        $endpoint = 'https://api.ankor.io/website/register';
        $endpoint_url = $endpoint .'/'. $uri;
        
        $uri_parts = explode("::", $uri); 
        $unique_id = $uri_parts[1] ?? null;
        $company_website = "https://companywebsite.com/vessels/". $unique_id;
        
        if( $unique_id ) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "link": "' . $company_website . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token),
            ));

            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);
            
            if( $http_code == 200 ) {
                if( $response ) {
                    // on success call get entity
                    $entity_response = yacht_manager_curl_get_entity($uri);
                    if( $entity_response ) {
                        $response_arr = json_decode($entity_response, true);
                        return $response_arr;
                    }
                }
            }
        }
    }
    return false;
}