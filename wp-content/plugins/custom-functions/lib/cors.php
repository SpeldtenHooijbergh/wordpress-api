<?php
add_filter( 'wp_headers', 'eg_send_cors_headers', 11, 1 );
function eg_send_cors_headers( $headers ) {

        $headers['Access-Control-Allow-Origin']      = 'http://avl.local';// Can't use wildcard origin for credentials requests, instead set it to the requesting origin
        $headers['Access-Control-Allow-Credentials'] = 'true';

        // Access-Control headers are received during OPTIONS requests
        if ( 'OPTIONS' == $_SERVER['REQUEST_METHOD'] ) {

            if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ) ) {
                $headers['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS';
            }

            if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ) ) {
                $headers['Access-Control-Allow-Headers'] = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
            }

        }

    return $headers;
}