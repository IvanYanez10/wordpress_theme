<?php
/**
 * theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage theme
 * @since theme-Two 1.0
 */
 if ( ! function_exists( 'subetuweb_support' ) ) :

 	/**
 	 * Sets up theme defaults and registers support for various WordPress features.
 	 *
 	 * @since Twenty Twenty-Two 1.0
 	 *
 	 * @return void
 	 */
 	function subetuweb_support() {

 		// Add support for block styles.
 		add_theme_support( 'wp-block-styles' );

 		// Enqueue editor styles.
 		add_editor_style( 'style.css' );

 	}

 endif;

 add_action( 'after_setup_theme', 'subetuweb_support' );
?>
