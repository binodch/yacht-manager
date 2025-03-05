<?php
// Handle form submission for yacht enquiries
function handle_yacht_manager_submit_enquiry() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_enquiry'])) {
        // Verify the nonce for security
        if (!isset($_POST['yacht_manager_nonce']) || !wp_verify_nonce($_POST['yacht_manager_nonce'], 'yacht_manager_enquiry')) {
            wp_die('Nonce verification failed.');
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'yacht_manager_enquire';

        // Sanitize the input values
        $yacht = sanitize_text_field($_POST['yacht']);
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        // Validate the inputs
        if (empty($yacht) || empty($name) || empty($phone) || empty($email) || empty($message)) {
            wp_die('All fields are required.');
        }

        // Insert data into the database
        $wpdb->insert(
            $table_name,
            [
                'yacht'     => $yacht,
                'name'      => $name,
                'phone'     => $phone,
                'email'     => $email,
                'message'   => $message,
                'created_at'=> current_time('mysql'),
            ],
            ['%s', '%s', '%s', '%s', '%s']
        );

        // Redirect back to the page with a success message
        wp_redirect(add_query_arg('success', 'true', wp_get_referer()));
        exit;
    }
}
add_action('init', 'handle_yacht_manager_submit_enquiry');