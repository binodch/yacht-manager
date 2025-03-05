<?php
/*
* Contains files for API
*/

// Include admin register yacht posttype
require_once plugin_dir_path(__FILE__) . 'includes/admin/post-type-yacht.php';

// Include add menu submenu options
require_once plugin_dir_path(__FILE__) . 'includes/admin/settings/add-menu.php';

// Include credentials setting
require_once plugin_dir_path(__FILE__) . 'includes/admin/settings/credentials.php';

// Include credentials setting
require_once plugin_dir_path(__FILE__) . 'includes/admin/settings/colors.php';

// Include run fetch
require_once plugin_dir_path(__FILE__) . 'includes/admin/settings/run-fetch.php';

// Include enqueue style css
require_once plugin_dir_path(__FILE__) . 'resources/enqueue-scripts.php';

// Include admin setting form input ajax
require_once plugin_dir_path(__FILE__) . 'includes/ajax/admin-menu-input.php';

// Include GET jwt token
require_once plugin_dir_path(__FILE__) . 'includes/api/init/jwt-token.php';

// Include GET access token
require_once plugin_dir_path(__FILE__) . 'includes/api/init/access-token.php';

// Include curl entity list
require_once plugin_dir_path(__FILE__) . 'includes/api/search/entity-list.php';

// Include curl featured entity list
require_once plugin_dir_path(__FILE__) . 'includes/api/search/featured-entity-list.php';

// insert update entity
require_once plugin_dir_path(__FILE__) . 'includes/api/functions/insert-update-entity.php';

// update entity meta
require_once plugin_dir_path(__FILE__) . 'includes/api/functions/update-entity-meta.php';

// Include curl register uri
require_once plugin_dir_path(__FILE__) . 'includes/api/entity/register-uri.php';

// Include curl get entity
require_once plugin_dir_path(__FILE__) . 'includes/api/entity/get-entity.php';

// Include curl get entity attachment
require_once plugin_dir_path(__FILE__) . 'includes/api/media/image.php';

// signature
require_once plugin_dir_path(__FILE__) . 'includes/hash/signature.php';

// find yacht page template
require_once plugin_dir_path(__FILE__) . 'page-template/register-page-template.php';

// register custom block
require_once plugin_dir_path(__FILE__) . 'blocks/register-custom-blocks.php';

// render callback featured.entity.list block
require_once plugin_dir_path(__FILE__) . 'blocks/featured-entity-list/block-render-callback.php';

// render callback block.filter block
require_once plugin_dir_path(__FILE__) . 'blocks/banner-filter/block-render-callback.php';

// functions
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// yacht destinations
require_once plugin_dir_path(__FILE__) . 'includes/api/select/destinations.php';

// yacht types
require_once plugin_dir_path(__FILE__) . 'includes/api/select/yacht-types.php';

// charter types
require_once plugin_dir_path(__FILE__) . 'includes/api/select/charter-types.php';

// manufactuer year
require_once plugin_dir_path(__FILE__) . 'includes/api/select/manufacture-year.php';

// cron scheduler
require_once plugin_dir_path(__FILE__) . 'includes/api/cron/schedule.php';

// yacht enquire db
require_once plugin_dir_path(__FILE__) . 'includes/enquire/db.php';

// enquire form admin menu
require_once plugin_dir_path(__FILE__) . 'includes/enquire/admin-page.php';

// enquire form submit
require_once plugin_dir_path(__FILE__) . 'includes/enquire/enquire-submit.php'; 

// enquire form export
require_once plugin_dir_path(__FILE__) . 'includes/enquire/enquire-export.php';


if( !function_exists('pr') ) {
    function pr($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}