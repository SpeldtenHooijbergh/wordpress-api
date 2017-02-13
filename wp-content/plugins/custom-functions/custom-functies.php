<?php
/*
Plugin Name: Custom WP Functies
Plugin URI: amstelveenlijn.nl
Description: functies uit functions.php in theme folder
Author: Joera
Author URI: amstelveenlijn.nl
Version: 0.1
*/
 
/* Disallow direct access to the plugin file */
 
	if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
		die('Sorry, but you cannot access this page directly.');
	}
	
	include 'lib/cors.php';
	include 'lib/publish_hooks.php';
	include 'lib/images.php';
	// include 'lib/fields-storytelling.php';
	//include 'lib/api-storytelling.php';
	// include 'lib/preview.php';


	function allow_br() {
	global $allowedtags;
	$allowedtags['p'] = array('class'=>array());
	}

	// Add WordPress hook to use the function
	add_action('init', 'allow_br');


?>