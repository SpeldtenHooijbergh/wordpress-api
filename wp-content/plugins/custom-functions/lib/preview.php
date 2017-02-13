<?php

add_filter( 'preview_post_link', 'rewrite_url' );

function rewrite_url() {

    $slug = basename(get_permalink());
    $id = get_the_id(); 	

    $domain = "http://wijnemenjemee.nl"; // get_home_url();
    $dir = "/preview/";

    // drafts hebben nog geen slug .. guid = ?p=123456 .. dan alleen id doorsturen
    if (strpos($slug, '?p=') !== false) :

    	$newpurl = "$domain$dir$id";

    else : 

    	$newpurl = "$domain$dir$slug";

    endif; 

    return "$newpurl";

    


}


?>