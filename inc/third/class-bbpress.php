<?php
/**
 * bbPress class
 *
 * @package subetuwebWP WordPress theme
 */

// If bbPress plugins doesn't exist then return.
if ( ! class_exists( 'bbPress' ) ) {
	return;
}

if ( ! class_exists( 'subetuwebWP_bbPress' ) ) :

	class subetuwebWP_bbPress {

		/**
		 * Setup class.
		 *
		 * @since 1.4.0
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_css' ) );
		}

		/**
		 * Load custom CSS file
		 *
		 * @since 1.4.3
		 */
		public static function add_custom_css() {
			wp_enqueue_style( 'subetuwebwp-bbpress', subetuwebWP_CSS_DIR_URI .'third/bbpress.min.css' );
		}

	}

endif;

return new subetuwebWP_bbPress();