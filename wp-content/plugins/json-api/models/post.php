<?php

class JSON_API_Post {
  
  // Note:
  //   JSON_API_Post objects must no longer be instantiated within The Loop.
  
  var $id;              // Integer
  var $type;            // String
  var $slug;            // String
  var $url;             // String
  var $status;          // String ("draft", "published", or "pending")
  var $title;           // String
  var $title_plain;     // String
  var $content;         // String (modified by read_more query var)
  var $excerpt;         // String
  var $date;            // String (modified by date_format query var)
  var $modified;        // String (modified by date_format query var)
  var $categories;      // Array of objects
  var $tags;            // Array of objects
  var $author;          // Object
  var $comments;        // Array of objects
  // var $attachments;     // Array of objects
  var $comment_count;   // Integer
  var $card_image;       // String
  // var $custom_fields;   // Object (included by using custom_fields query var)
  var $secties;         // JRM : flexible layout content
  var $cover;
  var $quote;
  // var $phases; // JRM : repeating content for planning
  
  function JSON_API_Post($wp_post = null) {
    if (!empty($wp_post)) {
      $this->import_wp_object($wp_post);
    }
    do_action("json_api_{$this->type}_constructor", $this);
  }
  
  function create($values = null) {
    unset($values['id']);
    if (empty($values) || empty($values['title'])) {
      $values = array(
        'title' => 'Untitled',
        'content' => ''
      );
    }
    return $this->save($values);
  }
  
  function update($values) {
    $values['id'] = $this->id;
    return $this->save($values);
  }
  
  function save($values = null) {
    global $json_api, $user_ID;
    
    $wp_values = array();
    
    if (!empty($values['id'])) {
      $wp_values['ID'] = $values['id'];
    }
    
    if (!empty($values['type'])) {
      $wp_values['post_type'] = $values['type'];
    }
    
    if (!empty($values['status'])) {
      $wp_values['post_status'] = $values['status'];
    }
    
    if (!empty($values['title'])) {
      $wp_values['post_title'] = $values['title'];
    }
    
    if (!empty($values['content'])) {
      $wp_values['post_content'] = $values['content'];
    }
    
    if (!empty($values['author'])) {
      $author = $json_api->introspector->get_author_by_login($values['author']);
      $wp_values['post_author'] = $author->id;
    }
    
    if (isset($values['categories'])) {
      $categories = explode(',', $values['categories']);
      foreach ($categories as $category_slug) {
        $category_slug = trim($category_slug);
        $category = $json_api->introspector->get_category_by_slug($category_slug);
        if (empty($wp_values['post_category'])) {
          $wp_values['post_category'] = array($category->id);
        } else {
          array_push($wp_values['post_category'], $category->id);
        }
      }
    }
    
    if (isset($values['tags'])) {
      $tags = explode(',', $values['tags']);
      foreach ($tags as $tag_slug) {
        $tag_slug = trim($tag_slug);
        if (empty($wp_values['tags_input'])) {
          $wp_values['tags_input'] = array($tag_slug);
        } else {
          array_push($wp_values['tags_input'], $tag_slug);
        }
      }
    }
    
    if (isset($wp_values['ID'])) {
      $this->id = wp_update_post($wp_values);
    } else {
      $this->id = wp_insert_post($wp_values);
    }
    
    if (!empty($_FILES['attachment'])) {
      include_once ABSPATH . '/wp-admin/includes/file.php';
      include_once ABSPATH . '/wp-admin/includes/media.php';
      include_once ABSPATH . '/wp-admin/includes/image.php';
      $attachment_id = media_handle_upload('attachment', $this->id);
      $this->attachments[] = new JSON_API_Attachment($attachment_id);
      unset($_FILES['attachment']);
    }
    
    $wp_post = get_post($this->id);
    $this->import_wp_object($wp_post);
    
    return $this->id;
  }
  
  function import_wp_object($wp_post) {
    global $json_api, $post;
    $date_format = $json_api->query->date_format;
    $this->id = (int) $wp_post->ID;
    setup_postdata($wp_post);
    $this->set_value('type', $wp_post->post_type);
    $this->set_value('slug', $wp_post->post_name);
    $this->set_value('url', get_permalink($this->id));
    $this->set_value('status', $wp_post->post_status);
    $this->set_value('title', get_the_title($this->id));
    $this->set_value('title_plain', strip_tags(@$this->title));
    $this->set_content_value();
    // $this->set_value('excerpt', apply_filters('the_excerpt', get_the_excerpt()));
    $this->set_value('date', get_the_time('c', $wp_post->ID)); // $this->id
    $this->set_value('modified', date($date_format, strtotime($wp_post->post_modified)));
    $this->set_categories_value();
    $this->set_tags_value();
    $this->set_author_value($wp_post->post_author);
    $this->set_comments_value();
    // $this->set_attachments_value();
    $this->set_value('comment_count', (int) $wp_post->comment_count);
    // $this->set_value('comment_status', $wp_post->comment_status);
    $this->set_card_image($wp_post->ID);
   // $this->set_custom_fields_value($wp_post->ID);
    $this->set_secties($wp_post->ID);
   // $this->set_phases();
    $this->set_custom_taxonomies($wp_post->post_type);
    $this->set_cover($wp_post->ID);
    $this->set_quote($wp_post->ID);
    $this->set_homecontent($wp_post->ID);
    do_action("json_api_import_wp_post", $this, $wp_post);
  }
  
  function set_value($key, $value) {
    global $json_api;
    if ($json_api->include_value($key)) {
      $this->$key = $value;
    } else {
      unset($this->$key);
    }
  }
    
  function set_content_value() {
    global $json_api;
    if ($json_api->include_value('content')) {
      $content = get_the_content($json_api->query->read_more);
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);
      $this->content = $content;
    } else {
      unset($this->content);
    }
  }
  
  function set_categories_value() {
    global $json_api;
    if ($json_api->include_value('categories')) {
      $this->categories = array();
      if ($wp_categories = get_the_category($this->id)) {
        foreach ($wp_categories as $wp_category) {
          $category = new JSON_API_Category($wp_category);
          if ($category->id == 1 && $category->slug == 'uncategorized') {
            // Skip the 'uncategorized' category
            continue;
          }
          $this->categories[] = $category;
        }
      }
    } else {
      unset($this->categories);
    }
  }
  
  function set_tags_value() {
    global $json_api;
    if ($json_api->include_value('tags')) {
      $this->tags = array();
      if ($wp_tags = get_the_tags($this->id)) {
        foreach ($wp_tags as $wp_tag) {
          $this->tags[] = new JSON_API_Tag($wp_tag);
        }
      }
    } else {
      unset($this->tags);
    }
  }
  
  function set_author_value($author_id) {
    global $json_api;
    if ($json_api->include_value('author')) {
      $this->author = new JSON_API_Author($author_id);
    } else {
      unset($this->author);
    }
  }
  
  function set_comments_value() {
    global $json_api;
    if ($json_api->include_value('comments')) {
      $this->comments = $json_api->introspector->get_comments($this->id);
    } else {
      unset($this->comments);
    }
  }
  
  // function set_attachments_value() {
  //   global $json_api;
  //   if ($json_api->include_value('attachments')) {
  //     $this->attachments = $json_api->introspector->get_attachments($this->id);
  //   } else {
  //     unset($this->attachments);
  //   }
  // }

  function set_cover($id) {
    global $json_api;
    $bannerId = get_field('banner',$id);
    $this->cover =  $json_api->introspector->get_attachment($bannerId);

  }

  function set_quote($id) {
    global $json_api;
    if (get_field('citaat',$id) ) { 
    
      $this->quote = strip_tags(get_field('citaat',$id));

    } else {

      $this->quote = ''; 
    }

  }
  
  function set_card_image($id) {
    global $json_api;
    // if (!$json_api->include_value('thumbnail') ||
    //     !function_exists('get_post_thumbnail_id')) {
    //   unset($this->thumbnail);
    //   return;
    // }
    $attachment_id = get_post_thumbnail_id($id);

    // if there is no featured image , use the first attachment
    if (!$attachment_id) {

      $attachments = $json_api->introspector->get_attachments($id);

      if ($attachments) {   
        $attachment_id = $attachments[0]->id; 
      }
    }
    if ($attachment_id) {  
      $this->card_image = $json_api->introspector->get_attachment($attachment_id);
    }
  }
  
  function set_secties($id) {
    global $json_api;
    $sectie = 0;
    $this->secties = new stdClass();
    if(have_rows('sectie',$id)) : 
      while ( have_rows('sectie',$id) ) : the_row();

        $type = get_row_layout();

        if( $type == 'paragraaf' ):
          $this->secties->$sectie->type = 'paragraaf';
          $paragraaf = get_sub_field('paragraaf');
          $this->secties->$sectie->tekst = $paragraaf;
        elseif( $type == 'hoofdstuk' ):
          $this->secties->$sectie->type = 'hoofdstuk';
          $titel = get_sub_field('titel');
          $this->secties->$sectie->titel = $titel;
          $this->secties->$sectie->slug = sanitize_title($titel);
        elseif( $type == 'grote_foto' ):
          $this->secties->$sectie->type = 'grote_foto';
          $afbeelding = get_sub_field('afbeelding');
          $this->secties->$sectie->afbeelding = $afbeelding;
        elseif( $type == 'foto_links' ):
          $this->secties->$sectie->type = 'foto_links';
          $afbeelding = get_sub_field('afbeelding');
         //  $this->secties->$sectie->afbeelding = $json_api->introspector->get_attachment($afbeelding->id);
          $this->secties->$sectie->afbeelding = $afbeelding;
        elseif( $type == 'foto_rechts' ):
          $this->secties->$sectie->type = 'foto_rechts';
          $afbeelding = get_sub_field('afbeelding');
          $this->secties->$sectie->afbeelding = $afbeelding;
        elseif( $type == 'foto_combi' ):
          $this->secties->$sectie->type = 'foto_combi';
          $afbeelding1 = get_sub_field('afbeelding1');
          $this->secties->$sectie->afbeelding1 = $afbeelding1;
          $afbeelding2 = get_sub_field('afbeelding2');
          $this->secties->$sectie->afbeelding2 = $afbeelding2;
        elseif( $type == 'foto_combi_2' ):
          $this->secties->$sectie->type = 'foto_combi_2';
          $afbeelding1 = get_sub_field('afbeelding1');
          $this->secties->$sectie->afbeelding1 = $afbeelding1;
          $afbeelding2 = get_sub_field('afbeelding2');
          $this->secties->$sectie->afbeelding2 = $afbeelding2;
        elseif( $type == 'foto_combi_3' ):
          $this->secties->$sectie->type = 'foto_combi_gelijk';
          $afbeelding1 = get_sub_field('afbeelding1');
          $this->secties->$sectie->afbeelding1 = $afbeelding1;
          $afbeelding2 = get_sub_field('afbeelding2');
          $this->secties->$sectie->afbeelding2 = $afbeelding2;
        elseif( $type == 'video' ):
          $this->secties->$sectie->type = 'video';
          $youtube_no = get_sub_field('youtube');
          $youtube_url = 'http://www.youtube.com/embed/' . $youtube_no . '/?autoplay=1';
          $this->secties->$sectie->youtube_url = $youtube_url;
          $this->secties->$sectie->youtube_id = $youtube_no;
          $vimeo_no = get_sub_field('vimeo');
          $vimeo_url = 'https://player.vimeo.com/video/' . $vimeo_no;
          $hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $vimeo_no .'.php'));
          $this->secties->$sectie->vimeo = $vimeo_url; 
          $this->secties->$sectie->vimeo_id = $vimeo_no; 
          $this->secties->$sectie->vimeo_meta = $hash;
          $webcam = get_sub_field('webcam');
          $this->secties->$sectie->webcam = $webcam; 
          $iframe = get_sub_field('iframe');
          $this->secties->$sectie->iframe = $iframe; 
        // elseif( $type == 'grafiek' ):
        //   $this->secties->$sectie->type = 'grafiek';
        //   $file = get_sub_field('file');
        //   $path = substr($file, strpos($file,'wp-content') + 11);
        //   $pathtwo = preg_replace('/\.[^.]+$/','',$path);
        //   $this->secties->$sectie->file = $pathtwo;
        //   $grafieksoort = get_sub_field('grafieksoort');
        //   $this->secties->$sectie->grafieksoort = $grafieksoort; 
        //   $tekst = get_sub_field('tekst');
        //   $this->secties->$sectie->tekst = $tekst;
        //   $taak = get_sub_field('taak');
        //   $this->secties->$sectie->taak = $taak;
        //   $data_id = get_sub_field('data_id');
        //   $this->secties->$sectie->data_id = $data_id;
        // elseif( $type == 'fotomorph' ):
        //   $this->secties->$sectie->type = 'fotomorph';
        //   $foto_oud = get_sub_field('foto_oud');
        //   $this->secties->$sectie->foto_oud = $foto_oud;
        //   $foto_nieuw = get_sub_field('foto_nieuw');
        //   $this->secties->$sectie->foto_nieuw = $foto_nieuw;


        endif;
        $sectie++;
      endwhile;   
    endif;  

  }
    
  function set_phases() {
    global $json_api;
    $phase = 0;
    if(have_rows('fase')) : 
      while ( have_rows('fase') ) : the_row();

        $title = get_sub_field('naam');
        $status = get_sub_field('status');
        $start = get_sub_field('startdatum');
        $end = get_sub_field('einddatum');
        $description = get_sub_field('omschrijving');
        $location = get_sub_field('locatie');
        $posts = [];
        $rij = get_sub_field('rij');
        $cat = get_sub_field('style');
        $labelPosition = get_sub_field('labelpositie');

        if(have_rows('nieuwsberichten')) : 

          while ( have_rows('nieuwsberichten') ) : the_row();

            $post = get_sub_field('bericht');

            $attached_post = [];

            $attached_post['title'] = $post->post_title; 
            $attached_post['author_id'] = $post->post_author;
            $attached_post['author'] = new JSON_API_Author($post->post_author);
            $attached_post['slug'] = $post->post_name;
            $attached_post['date'] = get_the_time('c', $post->ID);
            $attached_post['comment_count'] = $post->comment_count; 
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumb_klein' );
            $attached_post['thumbnail'] = $thumb['0']; 

            array_push($posts, $attached_post);

          endwhile;

        endif;

        $this->phases->$phase->title = $title; 
        $this->phases->$phase->status = $status;
        $this->phases->$phase->start = $start;
        $this->phases->$phase->end = $end;
        $this->phases->$phase->description = $description;
        $this->phases->$phase->location = $location;
        $this->phases->$phase->posts = $posts;
        $this->phases->$phase->rij = $rij;
        $this->phases->$phase->cat = $cat;
        $this->phases->$phase->labelPosition = $labelPosition;

        $phase++;

      endwhile;   
    endif; 

  }

  function set_homecontent($id) {
    global $json_api;

      $this->homecontent->beeld = get_field('beeld');
      $this->homecontent->aankeiler = get_field('aankeiler');
      $this->homecontent->seodescription = get_field('description_voor_google');


   }

  function set_custom_taxonomies($type) {
    global $json_api;
    $taxonomies = get_taxonomies(array(
      'object_type' => array($type),
      'public'   => true,
      '_builtin' => false
    ), 'objects');
    foreach ($taxonomies as $taxonomy_id => $taxonomy) {
      $taxonomy_key = "taxonomy_$taxonomy_id";
      if (!$json_api->include_value($taxonomy_key)) {
        continue;
      }
      $taxonomy_class = $taxonomy->hierarchical ? 'JSON_API_Category' : 'JSON_API_Tag';
      $terms = get_the_terms($this->id, $taxonomy_id);
      $this->$taxonomy_key = array();
      if (!empty($terms)) {
        $taxonomy_terms = array();
        foreach ($terms as $term) {
          $taxonomy_terms[] = new $taxonomy_class($term);
        }
        $this->$taxonomy_key = $taxonomy_terms;
      }
    }
  }
  
  function get_thumbnail_size() {
    global $json_api;
    if ($json_api->query->thumbnail_size) {
      return $json_api->query->thumbnail_size;
    } else if (function_exists('get_intermediate_image_sizes')) {
      $sizes = get_intermediate_image_sizes();
      if (in_array('post-thumbnail', $sizes)) {
        return 'post-thumbnail';
      }
    }
    return 'thumbnail';
  }
  
}

?>
