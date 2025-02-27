<?php
function yacht_manager_custom_cron_sydney_time($schedules) {
    $schedules['daily_2am_sydney'] = [
        'interval' => 86400, // Run every 24 hours
        'display'  => __('Once Daily at 2 AM Sydney Time')
    ];
    return $schedules;
}
add_filter('cron_schedules', 'yacht_manager_custom_cron_sydney_time');


function yacht_manager_schedule_custom_cron_sydney() {
    $timezone = 'Australia/Sydney';
    
    $dt = new DateTime('tomorrow 02:00:00', new DateTimeZone($timezone));
    $timestamp = $dt->getTimestamp();

    if (!wp_next_scheduled('yacht_manager_custom_cron_sydney_hook')) {
        wp_schedule_event($timestamp, 'daily_2am_sydney', 'yacht_manager_custom_cron_sydney_hook');
    }
}
add_action('wp', 'yacht_manager_schedule_custom_cron_sydney');


function custom_cron_sydney_function() {
    // Your task here
    error_log('Sydney 2 AM Cron Executed');
}
add_action('yacht_manager_custom_cron_sydney_hook', 'custom_cron_sydney_function');


function yacht_manager_clear_custom_cron_sydney() {
    $timestamp = wp_next_scheduled('yacht_manager_custom_cron_sydney_hook');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'yacht_manager_custom_cron_sydney_hook');
    }
}
register_deactivation_hook(__FILE__, 'yacht_manager_clear_custom_cron_sydney');

/* run manually */
// do_action('yacht_manager_custom_cron_sydney_hook');