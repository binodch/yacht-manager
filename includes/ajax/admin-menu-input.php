<?php
add_action('wp_ajax_admin_setting_input', 'yacht_manager_admin_setting_input');
function yacht_manager_admin_setting_input() {
    /* Verify nonce for security */
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax_nonce')) {
        die('Permission error');
    }

    $company_uri = isset($_POST['company_uri']) ? $_POST['company_uri'] : '';
    $key_id = isset($_POST['key_id']) ? $_POST['key_id'] : '';

    if( $key_id || $company_uri || $private_key ) {
		update_option('yacht_manager_company_uri', $company_uri, true);
		update_option('yacht_manager_key_id', $key_id, true);

        // Handle file upload if provided
        if (!empty($_FILES['private_key_file']['name'])) {
            $file = $_FILES['private_key_file'];

            // Validate file type
            $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
            if ($fileType !== 'pem') {
                wp_send_json_error(['message' => __('Invalid file type. Only .pem files are allowed.', 'yacht-manager')]);
            }

            // Define storage directory inside the plugin folder
            $upload_dir = __DIR__ . '/../api/keys/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Define file path
            $file_path = $upload_dir . 'private_key.pem';

            // Move the uploaded file
            if (!move_uploaded_file($file['tmp_name'], $file_path)) {
                wp_send_json_error(['message' => __('Failed to save file.', 'yacht-manager')]);
            }

            // Read file content
            $private_key = file_get_contents($file_path);
        }

        // Save private key in a secure file
        file_put_contents(__DIR__ . '/../api/keys/private_key.pem', $private_key);

        wp_send_json_success( array( 'message' => $company_uri ) );

    } else {
        wp_send_json_error( array( 'message' => 'no' ) );

    }

}