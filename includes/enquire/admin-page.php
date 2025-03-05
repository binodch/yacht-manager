<?php
// Add submenu to the admin menu
function yacht_manager_admin_menu() {
    add_submenu_page(
        'yacht-manager',             // Parent slug (top-level menu)
        'Yacht Enquiries',           // Page title
        'Yacht Enquiries',           // Menu title
        'manage_options',            // Capability required
        'enquire-form',              // Menu slug
        'yacht_manager_display_enquiries' // Callback function for displaying content
    );
}
add_action('admin_menu', 'yacht_manager_admin_menu');

create_yacht_manager_table();

// Display yacht enquiries in the admin panel
function yacht_manager_display_enquiries() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'yacht_manager_enquire';

    // Fetch the enquiries from the database
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    // Display the enquiries in a table
    echo '<div class="wrap">';
    echo '<h1>Yacht Enquiries</h1>';
    echo '<p>Here you can export yacht enquiries.</p>';
    echo '<form method="post" action="">
            <input type="hidden" name="export_csv" value="1">
            <input type="submit" name="run_export" class="button button-primary" value="Export CSV">
          </form>';
    echo '<table class="wp-list-table widefat fixed striped"><thead><tr>';
    echo '<th>ID</th><th>Yacht</th><th>Name</th><th>Phone</th><th>Email</th><th>Message</th><th>Date</th>';
    echo '</tr></thead><tbody>';

    $results = array_reverse($results);
    foreach ($results as $row) {
        echo "<tr>
                <td>{$row->id}</td>
                <td>{$row->yacht}</td>
                <td>{$row->name}</td>
                <td>{$row->phone}</td>
                <td>{$row->email}</td>
                <td>{$row->message}</td>
                <td>{$row->created_at}</td>
              </tr>";
    }

    echo '</tbody></table>';
    echo '</div>';

    // Handle CSV export
    if (isset($_POST['export_csv'])) {
        yacht_manager_export_csv();
    }
}