<?php 

function cache_post($post_id) {

    global $json_api;

    $post = get_post($post_id);
    $type = get_post_type($post_id);

    if ($post_id == '28771') {
    
        $postobject = new JSON_API_Post($post);
        setup_postdata($post);
        $rij = 0;
        $vis = [];
        $test = false;

        $startdatum = get_field('startdatum');
        $einddatum = get_field('einddatum');

        if (have_rows('items')) : 

            $item = 0;

            while (have_rows('items')) : the_row();

                $test = true; 

                $vis[$item]['name'] = get_sub_field('name');
                $vis[$item]['desc'] = get_sub_field('desc');
                $vis[$item]['start'] = get_sub_field('start');
                $vis[$item]['startType'] = get_sub_field('harde_startdatum');
                $vis[$item]['end'] = get_sub_field('end');
                $vis[$item]['endType'] = get_sub_field('harde_einddatum');
                $vis[$item]['rij'] = get_sub_field('rij');
                // $vis[$item]['location'] = get_sub_field('locatie');
                $vis[$item]['cat'] = get_sub_field('colour');
                // $vis[$item]['labelPosition'] = get_sub_field('labelpositie');
                // $vis[$item]['reference'] = get_sub_field('referentie_bericht');
                $item++;
            endwhile;   
        endif;

        $uniquelanes = [];
        $phase = 0;

        foreach ($vis as &$phase) {
                    
            if (in_array($phase['rij'],$uniquelanes)==0) {

                $lane = [];
                $lane['id'] = $phase['rij'];
                array_push($lanes,$lane);
                array_push($uniquelanes,$phase['rij']);
            }
        }

        unset($phase);

        $payload =  array( 
            'pageId' => $pageId,
            'startdatum' => $startdatum,
            'einddatum' => $einddatum,
            'items' => $vis,
            'nr_rij' => $rij,
            'nr_items' => $item,
            'lanes' => $uniquelanes
        );

        $ch = curl_init('http://avl.speldtenhooijbergh.nl/api/planning');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
    }

    else if ($type == 'post' OR $type == 'interview') { 

        $postObject = new JSON_API_Post($post);
    
        $ch = curl_init('http://avl.speldtenhooijbergh.nl/api/news/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postObject));
        $response = curl_exec($ch);
        curl_close($ch);

    } else if ($type == 'page') { 

        $postObject = new JSON_API_Post($post);
        
        $ch = curl_init('http://avl.speldtenhooijbergh.nl/api/page/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postObject));
        $response = curl_exec($ch);
        curl_close($ch);

    } else if ($type == 'locatie' OR $type == 'activiteit') {  

        $posts = get_posts(array('post_type' => 'locatie', 'posts_per_page' => -1));
        foreach($posts as &$post) {
        
            $locaties[] = new JSON_API_Location($post);
        }
        $posts = get_posts(array('post_type' => 'activiteit', 'posts_per_page' => -1));
        foreach($posts as &$post) {
            $activiteiten[] = new JSON_API_Activity($post);
        }
        $postObject =  array( 
            'locaties' => $locaties,
            'activiteiten' => $activiteiten
        );

        $ch = curl_init('http://avl.speldtenhooijbergh.nl/api/activities/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postObject));
        $response = curl_exec($ch);
        curl_close($ch);
    }
}

function cache_comments() {

    global $json_api;

    $comments = get_comments(); 

    $ch = curl_init('http://avl.speldtenhooijbergh.nl/api/comments/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($comments));
    $response = curl_exec($ch);
    curl_close($ch);
}

add_action( 'save_post', 'cache_post', 30); // 7 sec 
// add_action( 'save_post', 'cache_nieuws', 70); // 23 sec 
// add_action( 'save_post', 'prerender', 120); // 7 sec

// add_action( 'comment_post', 'cache_comments', 30); 
// add_action( 'delete_comment', 'cache_comments', 30); 
// add_action( 'comment_post', 'cache_comment', 70); 
// add_action( 'comment_post', 'cache_comment_tag', 100);

// add_action( 'edit_comment', 'cache_comments', 30);
// add_action( 'edit_comment', 'cache_comment', 70);
// add_action( 'edit_comment', 'cache_comment_tag', 100); 


// add_action( 'delete_comment', 'cache_comment', 70); 
// add_action( 'delete_comment', 'cache_comment_tag', 100);


/* scp -rp root@37.46.136.132:/var/www/manon/wordpress/cache/*  wordpress/cache/ 
*/ 




