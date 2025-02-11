<?php
/*
* Contains files for API
*/

// Include admin register yacht posttype
require_once plugin_dir_path(__FILE__) . 'includes/admin/yacht.php';

// Include admin register yacht posttype
require_once plugin_dir_path(__FILE__) . 'includes/admin/menu.php';

// Include enqueue style css
require_once plugin_dir_path(__FILE__) . 'resources/enqueue-scripts.php';

// Include GET jwt token
require_once plugin_dir_path(__FILE__) . 'includes/api/init/jwt-token.php';

// Include GET access token
require_once plugin_dir_path(__FILE__) . 'includes/api/init/access-token.php';

// Include admin setting form input ajax
require_once plugin_dir_path(__FILE__) . 'includes/ajax/admin-menu-input.php';