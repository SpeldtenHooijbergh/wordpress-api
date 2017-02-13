<?php

class JSON_API_Introspector {
  
  public function get_posts($query = false, $wp_posts = false) {
    global $post, $wp_query;
    $this->set_posts_query($query); // array('s' => $query, 'posts_per_page' => 25)
    $output = array();
    while (have_posts()) {
      the_post();
      if ($wp_posts) {
        $new_post = $post;
      } else {
        $new_post = new JSON_API_Post($post);
      }
      $output[] = $new_post;
    }
    return $output;
  }

  public function get_attachments($post_id) {
    $wp_attachments = get_children(array(
      'post_type' => 'attachment',
      'post_parent' => $post_id,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'suppress_filters' => false
    ));
    $attachments = array();
    if (!empty($wp_attachments)) {
      foreach ($wp_attachments as $wp_attachment) {
        $attachments[] = new JSON_API_Attachment($wp_attachment);
      }
    }
    return $attachments;
  }
  
  public function get_attachment($attachment_id) {
    global $wpdb;
    $wp_attachment = $wpdb->get_row(
      $wpdb->prepare("
        SELECT *
        FROM $wpdb->posts
        WHERE ID = %d
      ", $attachment_id)
    );
    return new JSON_API_Attachment($wp_attachment);
  }
  
  public function attach_child_posts(&$post) {
    $post->children = array();
    $wp_children = get_posts(array(
      'post_type' => $post->type,
      'post_parent' => $post->id,
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'numberposts' => -1,
      'suppress_filters' => false
    ));
    foreach ($wp_children as $wp_post) {
      $new_post = new JSON_API_Post($wp_post);
      $new_post->parent = $post->id;
      $post->children[] = $new_post;
    }
    foreach ($post->children as $child) {
      $this->attach_child_posts($child);
    }
  }
  
  protected function get_category_object($wp_category) {
    if (!$wp_category) {
      return null;
    }
    return new JSON_API_Category($wp_category);
  }
  
  protected function get_tag_object($wp_tag) {
    if (!$wp_tag) {
      return null;
    }
    return new JSON_API_Tag($wp_tag);
  }
  
  protected function is_active_author($author) {
    if (!isset($this->active_authors)) {
      $this->active_authors = explode(',', wp_list_authors(array(
        'html' => false,
        'echo' => false,
        'exclude_admin' => false
      )));
      $this->active_authors = array_map('trim', $this->active_authors);
    }
    return in_array($author->name, $this->active_authors);
  }
  
  protected function set_posts_query($query = false) {
    global $json_api, $wp_query;
    
    if (!$query) {
      $query = array();
    }
    
    $query = array_merge($query, $wp_query->query);
    
    if ($json_api->query->page) {
      $query['paged'] = $json_api->query->page;
    }
    
    if ($json_api->query->count) {
      $query['posts_per_page'] = $json_api->query->count;
    }
    
    if ($json_api->query->post_type) {
      $query['post_type'] = $json_api->query->post_type;
    }
    
    if (!empty($query)) {
      query_posts($query);
      do_action('json_api_query', $wp_query);
    }
  }
  
}

?>
