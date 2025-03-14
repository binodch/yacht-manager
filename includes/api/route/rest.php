<?php
/* Register rest route */
add_action('rest_api_init', function () {
    register_rest_route('entity/v1', '/data', array(
        'methods'  => 'GET',
        'callback' => 'custom_get_data',
        'permission_callback' => '__return_true'
    ));

    // register_rest_route('entity/v1', '/data', array(
    //     'methods'  => 'POST',
    //     'callback' => 'custom_post_data',
    //     'permission_callback' => function () {
    //         return current_user_can('edit_posts');
    //     }
    // ));
});

$data_store = [];

function custom_get_data(WP_REST_Request $request) {
    $post_id = $request->get_param('postId');
    $uri = $request->get_param('uri');
    
    return new WP_REST_Response(array(
        'postId' => $post_id,
        'uri' => $uri
    ), 200);
}


// function custom_post_data(WP_REST_Request $request) {
//     $params = $request->get_params();
//     return new WP_REST_Response(array('received' => $params), 200);
// }
