<?php

function yacht_manager_filter_select() {
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_name'])) {
        $user_name = sanitize_text_field($_POST['user_name']);
        $message = '<p>Hello, ' . esc_html($user_name) . '! Welcome.</p>';
    }

    return '<form method="post">
                <input type="text" name="user_name" placeholder="Enter your name">
                <button type="submit">Submit</button>
            </form>' . $message;
}
add_shortcode('yacht_manager_filter_search', 'yacht_manager_filter_select');