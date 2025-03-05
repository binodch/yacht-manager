<?php 
function yacht_manager_export_csv() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'yacht_manager_enquire';

    // Get the data
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    // Set the headers to download the file as CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="yacht_enquiries.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Output the column headers
    fputcsv($output, ['ID', 'Yacht', 'Name', 'Phone', 'Email', 'Message', 'Date']);

    // Output the data rows
    foreach ($results as $row) {
        fputcsv($output, [
            $row->id,
            $row->yacht,
            $row->name,
            $row->phone,
            $row->email,
            $row->message,
            $row->created_at,
        ]);
    }

    // Close the file handle
    fclose($output);
    exit; // Terminate to stop further processing
}
