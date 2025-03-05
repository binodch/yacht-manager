<?php 
function yacht_manager_export_csv() {
    if (!isset($_POST['export_csv'])) {
        return; // Stop execution if not triggered by form submission
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'yacht_manager_enquire';

    // Get the data
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC", ARRAY_A);

    if (empty($results)) {
        wp_die('No data found to export.');
    }

    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="yacht_enquiries.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Open output buffer
    $output = fopen('php://output', 'w');

    // Output column headers
    fputcsv($output, ['ID', 'Yacht', 'Name', 'Phone', 'Email', 'Message', 'Date']);

    // Output data rows
    foreach ($results as $row) {
        fputcsv($output, $row);
    }

    // Close stream and exit
    fclose($output);
    exit;
}

// Ensure CSV export runs before rendering HTML
add_action('admin_init', 'yacht_manager_export_csv');