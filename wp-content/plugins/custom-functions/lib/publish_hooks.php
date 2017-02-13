<?php 

function new_post($post_id) {

    global $json_api;

    $post = get_post($post_id);
    $type = get_post_type($post_id);

    if ($type == 'post') {

        // maakt post volgens model in json-api/models/post.php
        $postObject = new JSON_API_Post($post);

        // stuurt post naar node pi
        $ch = curl_init('http://zuidas.speldtenhooijbergh.nl/api/newpost/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postObject));
        $response = curl_exec($ch);
        curl_close($ch);
    }
}


add_action( 'save_post', 'new_post', 30);



