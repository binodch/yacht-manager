<?php
function yacht_manager_admin_menu() {
    // add_menu_page(
    //     'Yacht Enquiries',
    //     'Yacht Enquiries',
    //     'manage_options',
    //     'yacht-manager-enquiries',
    //     'yacht_manager_display_enquiries',
    //     'dashicons-email',
    //     25
    // );

    add_submenu_page(
        'yacht-manager',
        'Yacht Enquiries',
        'Yacht Enquiries',
        'manage_options',
        'enquire-form',
        'yacht_manager_display_enquiries'
    );
}
add_action('admin_menu', 'yacht_manager_admin_menu');

function yacht_manager_display_enquiries() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'yacht_manager_enquire';

    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    echo '<div class="wrap"><h1>Yacht Enquiries</h1>';
    echo '<form method="post" action="">
            <input type="hidden" name="export_csv" value="1">
            <button type="submit" class="button button-primary">Export CSV</button>
          </form>';
    echo '<table class="wp-list-table widefat fixed striped"><thead><tr>';
    echo '<th>ID</th><th>Yacht</th><th>Name</th><th>Phone</th><th>Email</th><th>Message</th><th>Date</th>';
    echo '</tr></thead><tbody>';

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

    echo '</tbody></table></div>';

    if (isset($_POST['export_csv'])) {
        yacht_manager_export_csv();
    }
}
