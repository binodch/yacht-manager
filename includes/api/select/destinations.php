<?php
// yacht destinations - API supported destinations
function yacht_manager_curl_destinations() {
    $destinations = array('Antarctica', 'Arabian Gulf', 'Australasia & South Pacific', 'Bahamas', 'Caribbean', 'Indian Ocean & South East Asia', 'East Mediterranean', 'West Mediterranean');
    return $destinations;
}

function yacht_manager_get_assigned_yacht_region() {
    $region_slug = [];
    $yacht_regions = get_terms([
        'taxonomy'   => 'yacht-region',
        'hide_empty' => true,
    ]);

    if (!empty($yacht_regions) && !is_wp_error($yacht_regions)) {
        foreach ($yacht_regions as $region) {
            $region_slug[$region->slug] = $region->name;
        }
        return $region_slug;
    }
    return;
}