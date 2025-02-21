<?php
/*
* curl to get featured entity lists
*/
function yacht_manager_curl_featured_entity_list() {
    $get_token = yacht_manager_generate_access_token();
    if( $get_token && isset($get_token['success']) && $get_token['success'] && isset($get_token['token']) ) {
        $access_token = $get_token['token'];

        $endpoint = 'https://api.ankor.io/website/search';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Authorization: Bearer ' . $access_token
            ),
        ));

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        
        if( $http_code == 200 ) {
            $response_data = json_decode($response, true);
            if( $response_data && isset($response_data['hits']) ) {
                $first_six_entity = array_slice($response_data['hits'], 0, 6);
                return $first_six_entity;
            }
        }
        return false;
    }
}