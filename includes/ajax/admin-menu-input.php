<?php
add_action('wp_ajax_admin_setting_input', 'yacht_manager_admin_setting_input');
function yacht_manager_admin_setting_input() {
    /* Verify nonce for security */
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax_nonce')) {
        die('Permission error');
    }

    $company_url = isset($_POST['company_url']) ? $_POST['company_url'] : '';
    $key_id = isset($_POST['key_id']) ? $_POST['key_id'] : '';
    $private_key = isset($_POST['private_key']) ? $_POST['private_key'] : '';

    if( $key_id || $company_url || $private_key ) {

        // action validate

        wp_send_json_success( array( 'message' => $company_url ) );

    } else {
        wp_send_json_error( array( 'message' => 'no' ) );

    }

}