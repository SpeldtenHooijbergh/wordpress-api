<?php 


if ( function_exists( 'add_theme_support' ) ) {  

  // add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );
  
  add_image_size('thumb_klein', 250, 250, true); 
  add_image_size('thumb_groot', 500, 500, true); 

  add_image_size('mini', 350); 
  add_image_size('klein', 768); 
  add_image_size('medium', 1280); 
  add_image_size('groot', 1750); 
  add_image_size('maxi', 2560); 

}     
