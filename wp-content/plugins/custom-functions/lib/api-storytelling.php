<?php 

// class apistorytelling {

//   function __construct() {

//     wp_mail('joeramulders@gmail.com','pi','ddd');

//     add_action( 'json_api_import_wp_post',
//       array( $this, 'attach_secties' ),
//       10,
//       2 );
//   }

add_action( 'json_api_import_wp_post','attach_secties');


function attach_secties($JSON_API_Post, $wp_post) {

  // var $secties;
  // $this->set_secties();

    // $content = 

    global $json_api;
    $sectie = 0;
    if(have_rows('sectie')) : 
      while ( have_rows('sectie') ) : the_row();

        $type = get_row_layout();

        if( $type == 'paragraaf' ):
          $JSON_API_Post->secties->$sectie->type = 'paragraaf';
          $paragraaf = get_sub_field('paragraaf');
          $JSON_API_Post->secties->$sectie->tekst = $paragraaf;
        elseif( $type == 'quote' ):
          $JSON_API_Post->secties->$sectie->type = 'quote';
          $text = get_sub_field('text');
          $JSON_API_Post->secties->$sectie->tekst = $text;
          $auteur = get_sub_field('auteur');
          $JSON_API_Post->secties->$sectie->auteur = $auteur;
        elseif( $type == 'grote_foto' ):
          $JSON_API_Post->secties->$sectie->type = 'grote_foto';
          $afbeelding = get_sub_field('afbeelding');
          $JSON_API_Post->secties->$sectie->afbeelding = $afbeelding;
        elseif( $type == 'foto_links' ):
          $JSON_API_Post->secties->$sectie->type = 'foto_links';
          $afbeelding = get_sub_field('afbeelding');
          $JSON_API_Post->secties->$sectie->afbeelding = $afbeelding;
        elseif( $type == 'foto_rechts' ):
          $JSON_API_Post->secties->$sectie->type = 'foto_rechts';
          $afbeelding = get_sub_field('afbeelding');
          $JSON_API_Post->secties->$sectie->afbeelding = $afbeelding;
        elseif( $type == 'foto_combi' ):
          $JSON_API_Post->secties->$sectie->type = 'foto_combi';
          $afbeelding1 = get_sub_field('afbeelding1');
          $JSON_API_Post->secties->$sectie->afbeelding1 = $afbeelding1;
          $afbeelding2 = get_sub_field('afbeelding2');
          $JSON_API_Post->secties->$sectie->afbeelding2 = $afbeelding2;
        elseif( $type == 'foto_combi_2' ):
          $JSON_API_Post->secties->$sectie->type = 'foto_combi_2';
          $afbeelding1 = get_sub_field('afbeelding1');
          $JSON_API_Post->secties->$sectie->afbeelding1 = $afbeelding1;
          $afbeelding2 = get_sub_field('afbeelding2');
          $JSON_API_Post->secties->$sectie->afbeelding2 = $afbeelding2;
        elseif( $type == 'foto_combi_3' ):
          $JSON_API_Post->secties->$sectie->type = 'foto_combi_gelijk';
          $afbeelding1 = get_sub_field('afbeelding1');
          $JSON_API_Post->secties->$sectie->afbeelding1 = $afbeelding1;
          $afbeelding2 = get_sub_field('afbeelding2');
          $JSON_API_Post->secties->$sectie->afbeelding2 = $afbeelding2;
        // elseif( $type == 'video' ):
        //   $JSON_API_Post->secties->$sectie->type = 'video';
        //   $youtube_no = get_sub_field('youtube');
        //   $youtube_url = 'http://www.youtube.com/embed/' . $youtube_no . '/?autoplay=1';
        //   $JSON_API_Post->secties->$sectie->youtube_url = $youtube_url;
        //   $JSON_API_Post->secties->$sectie->youtube_id = $youtube_no;
        //   $vimeo_no = get_sub_field('vimeo');
        //   $vimeo_url = 'https://player.vimeo.com/video/' . $vimeo_no;
        //   $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $vimeo_no .'.php'));
        //   $JSON_API_Post->secties->$sectie->vimeo = $vimeo_url; 
        //   $JSON_API_Post->secties->$sectie->vimeo_id = $vimeo_no; 
        //   $JSON_API_Post->secties->$sectie->vimeo_meta = $hash;
          // $webcam = get_sub_field('webcam');
          // $JSON_API_Post->secties->$sectie->webcam = $webcam; 
          // $iframe = get_sub_field('iframe');
          // $JSON_API_Post->secties->$sectie->iframe = $iframe; 
        // elseif( $type == 'grafiek' ):
        //   $JSON_API_Post->secties->$sectie->type = 'grafiek';
        //   $file = get_sub_field('file');
        //   $path = substr($file, strpos($file,'wp-content') + 11);
        //   $pathtwo = preg_replace('/\.[^.]+$/','',$path);
        //   $JSON_API_Post->secties->$sectie->file = $pathtwo;
        //   $grafieksoort = get_sub_field('grafieksoort');
        //   $JSON_API_Post->secties->$sectie->grafieksoort = $grafieksoort; 
        //   $tekst = get_sub_field('tekst');
        //   $JSON_API_Post->secties->$sectie->tekst = $tekst;
        //   $taak = get_sub_field('taak');
        //   $JSON_API_Post->secties->$sectie->taak = $taak;
        //   $data_id = get_sub_field('data_id');
        //   $JSON_API_Post->secties->$sectie->data_id = $data_id;
        // elseif( $type == 'fotomorph' ):
        //   $JSON_API_Post->secties->$sectie->type = 'fotomorph';
        //   $foto_oud = get_sub_field('foto_oud');
        //   $JSON_API_Post->secties->$sectie->foto_oud = $foto_oud;
        //   $foto_nieuw = get_sub_field('foto_nieuw');
        //   $JSON_API_Post->secties->$sectie->foto_nieuw = $foto_nieuw;
        endif;
        $sectie++;
      endwhile;   
    endif;  

    return $JSON_API_Post; 

  }

// }

  //add_action('json_api_import_wp_post','attach_secties'); 

  

    