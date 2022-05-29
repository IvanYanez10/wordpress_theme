<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package subetuwebWP WordPress theme
 */

	get_header(); 

	//wp_body_open(); 

	do_action( 'subetuwebwp_body_content' );

	get_footer(); 
	
?>