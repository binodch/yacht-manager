<?php
// manufacture year
function yacht_manager_manufacture_year() {
    $current_year = date('Y');
    $years = range(1980, $current_year);
    return $years;
}
