<?php
function yacht_manager_export_csv() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'yacht_manager_enquire';

    // Fetch data
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC", ARRAY_A);

    if (empty($results)) {
        wp_die('No data available for export.');
    }

    // Set CSV headers
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=yacht_enquiries.csv');

    // Open file pointer
    $output = fopen('php://output', 'w');

    // Add column headers
    fputcsv($output, array('ID', 'Name', 'Phone', 'Email', 'Message', 'Created At'));

    // Add rows
    foreach ($results as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}
