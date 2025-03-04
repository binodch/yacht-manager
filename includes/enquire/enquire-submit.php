<?php
function handle_yacht_manager_form() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_enquiry'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'yacht_manager_enquire';

        // Sanitize input
        $yacht = sanitize_text_field($_POST['yacht']);
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        if (empty($yacht) || empty($name) || empty($phone) || empty($email) || empty($message)) {
            wp_die('All fields are required.');
        }

        $wpdb->insert(
            $table_name,
            [
                'yacht'    => $yacht,
                'name'    => $name,
                'phone'   => $phone,
                'email'   => $email,
                'message' => $message,
                'created_at' => current_time('mysql')
            ],
            ['%s', '%s', '%s', '%s', '%s']
        );

        wp_redirect(add_query_arg('success', 'true', wp_get_referer()));
        exit;
    }
}
add_action('init', 'handle_yacht_manager_form');