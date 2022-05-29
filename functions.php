<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core Constants.
define( 'subetuwebWP_THEME_DIR', get_template_directory() );
define( 'subetuwebWP_THEME_URI', get_template_directory_uri() );

/**
 * subetuwebWP theme class
 */
final class subetuwebWP_Theme_Class {

	/**
	 * Main Theme Class Constructor
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Define theme constants.
		$this->subetuwebwp_constants();

		// Load required files.
		$this->subetuwebwp_has_setup();

		// Load framework classes.
		add_action( 'after_setup_theme', array( 'subetuwebWP_Theme_Class', 'classes' ), 4 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc.
		add_action( 'after_setup_theme', array( 'subetuwebWP_Theme_Class', 'theme_setup' ), 10 );
		
		// Registers theme_mod strings into Polylang.
		if ( class_exists( 'Polylang' ) ) {
			add_action( 'after_setup_theme', array( 'subetuwebWP_Theme_Class', 'polylang_register_string' ) );
		}

		/** Admin only actions */
		if ( is_admin() ) {

			// Load scripts in the WP admin.
			add_action( 'admin_enqueue_scripts', array( 'subetuwebWP_Theme_Class', 'admin_scripts' ) );

			// Outputs custom CSS for the admin.
			add_action( 'admin_head', array( 'subetuwebWP_Theme_Class', 'admin_inline_css' ) );

			/** Non Admin actions */
		} else {
			// Load theme js.
			add_action( 'wp_enqueue_scripts', array( 'subetuwebWP_Theme_Class', 'theme_js' ) );

			// Load theme CSS.
			add_action( 'wp_enqueue_scripts', array( 'subetuwebWP_Theme_Class', 'theme_css' ) );

			// Add a pingback url auto-discovery header for singularly identifiable articles.
			add_action( 'wp_head', array( 'subetuwebWP_Theme_Class', 'pingback_header' ), 1 );

			// Add meta viewport tag to header.
			add_action( 'wp_head', array( 'subetuwebWP_Theme_Class', 'meta_viewport' ), 1 );

			// Add an X-UA-Compatible header.
			add_filter( 'wp_headers', array( 'subetuwebWP_Theme_Class', 'x_ua_compatible_headers' ) );

			// Loads html5 shiv script.
			add_action( 'wp_head', array( 'subetuwebWP_Theme_Class', 'html5_shiv' ) );

			// Outputs custom CSS to the head.
			add_action( 'wp_head', array( 'subetuwebWP_Theme_Class', 'custom_css' ), 9999 );

			// Minify the WP custom CSS because WordPress doesn't do it by default.
			add_filter( 'wp_get_custom_css', array( 'subetuwebWP_Theme_Class', 'minify_custom_css' ) );

			// Alter WP categories widget to display count inside a span.
			add_filter( 'wp_list_categories', array( 'subetuwebWP_Theme_Class', 'wp_list_categories_args' ) );

			// Add a responsive wrapper to the WordPress oembed output.
			add_filter( 'embed_oembed_html', array( 'subetuwebWP_Theme_Class', 'add_responsive_wrap_to_oembeds' ), 99, 4 );

			// Adds classes the post class.
			add_filter( 'post_class', array( 'subetuwebWP_Theme_Class', 'post_class' ) );

			// Add schema markup to the authors post link.
			add_filter( 'the_author_posts_link', array( 'subetuwebWP_Theme_Class', 'the_author_posts_link' ) );

			add_filter( 'subetuweb_enqueue_generated_files', '__return_false' );
		}
	}

	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public static function subetuwebwp_constants() {

		$version = self::theme_version();

		// Theme version.
		define( 'subetuwebWP_THEME_VERSION', $version );

		// Javascript and CSS Paths.
		define( 'subetuwebWP_JS_DIR_URI', subetuwebWP_THEME_URI . '/assets/js/' );
		define( 'subetuwebWP_CSS_DIR_URI', subetuwebWP_THEME_URI . '/assets/css/' );

		// Include Paths.
		define( 'subetuwebWP_INC_DIR', subetuwebWP_THEME_DIR . '/inc/' );
		define( 'subetuwebWP_INC_DIR_URI', subetuwebWP_THEME_URI . '/inc/' );

		// Check if plugins are active.
		define( 'subetuweb_EXTRA_ACTIVE', class_exists( 'subetuweb_Extra' ) );
		define( 'subetuwebWP_ELEMENTOR_ACTIVE', class_exists( 'Elementor\Plugin' ) );
		define( 'subetuwebWP_BEAVER_BUILDER_ACTIVE', class_exists( 'FLBuilder' ) );
		define( 'subetuwebWP_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
		define( 'subetuwebWP_EDD_ACTIVE', class_exists( 'Easy_Digital_Downloads' ) );
		define( 'subetuwebWP_LIFTERLMS_ACTIVE', class_exists( 'LifterLMS' ) );
		define( 'subetuwebWP_ALNP_ACTIVE', class_exists( 'Auto_Load_Next_Post' ) );
		define( 'subetuwebWP_LEARNDASH_ACTIVE', class_exists( 'SFWD_LMS' ) );
	}

	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0subetuwebwp_has_setup
	 */
	public static function subetuwebwp_has_setup() {

		$dir = subetuwebWP_INC_DIR;

		require_once $dir . 'helpers.php';
		require_once $dir . 'header-content.php';
		require_once $dir . 'subetuwebwp-strings.php';
		//require_once $dir . 'subetuwebwp-svg.php';
		require_once $dir . 'subetuwebwp-theme-icons.php';
		require_once $dir . 'template-helpers.php';
		require_once $dir . 'customizer/controls/typography/webfonts.php';
	}

	/**
	 * Returns current theme version
	 *
	 * @since   1.0.0
	 */
	public static function theme_version() {

		// Get theme data.
		$theme = wp_get_theme();

		// Return theme version.
		return $theme->get( 'Version' );

	}

	/**
	 * Compare WordPress version
	 *
	 * @access public
	 * @since 1.8.3
	 * @param  string $version - A WordPress version to compare against current version.
	 * @return boolean
	 */
	public static function is_wp_version( $version = '5.4' ) {

		global $wp_version;

		// WordPress version.
		return version_compare( strtolower( $wp_version ), strtolower( $version ), '>=' );

	}


	/**
	 * Check for AMP endpoint
	 *
	 * @return bool
	 * @since 1.8.7
	 */
	public static function subetuwebwp_is_amp() {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}

	/**
	 * Load theme classes
	 *
	 * @since   1.0.0
	 */
	public static function classes() {

		require_once subetuwebWP_INC_DIR . 'breadcrumbs.php';

		// Customizer class.
		require_once subetuwebWP_INC_DIR . 'customizer/library/customizer-custom-controls/functions.php';
		require_once subetuwebWP_INC_DIR . 'customizer/customizer.php';

	}

	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public static function theme_setup() {

		// Load text domain.
		load_theme_textdomain( 'subetuwebwp', subetuwebWP_THEME_DIR . '/languages' );

		// Get globals.
		global $content_width;

		// Set content width based on theme's default design.
		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}

		// Register navigation menus.
		register_nav_menus(
			array(
				'topbar_menu' => esc_html__( 'Top Bar', 'subetuwebwp' ),
				'main_menu'   => esc_html__( 'Main', 'subetuwebwp' ),
				'footer_menu' => esc_html__( 'Footer', 'subetuwebwp' ),
				'mobile_menu' => esc_html__( 'Mobile (optional)', 'subetuwebwp' ),
			)
		);

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );

		// Enable support for <title> tag.
		add_theme_support( 'title-tag' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for header image
		 */
		add_theme_support(
			'custom-header',
			apply_filters(
				'subetuweb_custom_header_args',
				array(
					'width'       => 2000,
					'height'      => 1200,
					'flex-height' => true,
					'video'       => true,
				)
			)
		);

		/**
		 * Enable support for site logo
		 */
		add_theme_support(
			'custom-logo',
			apply_filters(
				'subetuweb_custom_logo_args',
				array(
					'height'      => 45,
					'width'       => 164,
					'flex-height' => true,
					'flex-width'  => true,
				)
			)
		);

		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'widgets',
			)
		);

		// Add editor style.
		add_editor_style( 'assets/css/editor-style.css' );

	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.1.0
	 */
	public static function pingback_header() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}

	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.0.0
	 */
	public static function meta_viewport() {

		// Meta viewport.
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';

		// Apply filters for child theme tweaking.
		echo apply_filters( 'subetuweb_meta_viewport', $viewport ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_scripts() {
		global $pagenow;
		if ( 'nav-menus.php' === $pagenow ) {
			wp_enqueue_style( 'subetuwebwp-menus', subetuwebWP_INC_DIR_URI . 'walker/assets/menus.css', false, subetuwebWP_THEME_VERSION );
		}
	}

	/**
	 * Load front-end scripts
	 *
	 * @since   1.0.0
	 */
	public static function theme_css() {

		// Define dir.
		$dir = subetuwebWP_CSS_DIR_URI;
		$theme_version = subetuwebWP_THEME_VERSION;

		// Remove font awesome style from plugins.
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'fontawesome' );

		// Enqueue Main style.
		wp_enqueue_style( 'subetuwebwp-style', $dir . 'style.css', false, $theme_version );

		// TODO: just display in blog page
		wp_enqueue_style( 'subetuwebwp-blog', $dir . 'blog-style.css', false, $theme_version );

	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.0.0
	 */
	public static function theme_js() {

		if ( self::subetuwebwp_is_amp() ) {
			return;
		}

		// Get js directory uri.
		$dir = subetuwebWP_JS_DIR_URI;

		// Get current theme version.
		$theme_version = subetuwebWP_THEME_VERSION;

		// Main script dependencies.
		$main_script_dependencies = array( 'jquery' );

		// Comment reply.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		/**
		 * Load Theme Scripts.
		 */

		// Theme script.
		//wp_enqueue_script( 'subetuwebwp-main', $dir . 'theme.min.js', $main_script_dependencies, $theme_version, true );
		wp_localize_script( 'subetuwebwp-main', 'subetuwebwpLocalize', $localize_array );
		array_push( $main_script_dependencies, 'subetuwebwp-main' );

		// Register scripts for old addons.
		wp_register_script( 'nicescroll', $dir . 'vendors/support-old-subetuwebwp-addons/jquery.nicescroll.min.js', array( 'jquery' ), $theme_version, true );

	}

	/**
	 * Add headers for IE to override IE's Compatibility View Settings
	 *
	 * @param obj $headers   header settings.
	 * @since 1.0.0
	 */
	public static function x_ua_compatible_headers( $headers ) {
		$headers['X-UA-Compatible'] = 'IE=edge';
		return $headers;
	}

	/**
	 * Load HTML5 dependencies for IE8
	 *
	 * @since 1.0.0
	 */
	public static function html5_shiv() {
		wp_register_script( 'html5shiv', subetuwebWP_JS_DIR_URI . 'third/html5.min.js', array(), subetuwebWP_THEME_VERSION, false );
		wp_enqueue_script( 'html5shiv' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	}

	/**
	 * Registers theme_mod strings into Polylang.
	 *
	 * @since 1.1.4
	 */
	public static function polylang_register_string() {

		if ( function_exists( 'pll_register_string' ) && $strings = subetuwebwp_register_tm_strings() ) {
			foreach ( $strings as $string => $default ) {
				pll_register_string( $string, get_theme_mod( $string, $default ), 'Theme Mod', true );
			}
		}

	}

	/**
	 * All theme functions hook into the subetuwebwp_head_css filter for this function.
	 *
	 * @param obj $output output value.
	 * @since 1.0.0
	 */
	public static function custom_css( $output = null ) {

		// Add filter for adding custom css via other functions.
		$output = apply_filters( 'subetuweb_head_css', $output );

		// If Custom File is selected.
		if ( 'file' === get_theme_mod( 'subetuweb_customzer_styling', 'head' ) ) {

			global $wp_customize;
			$upload_dir = wp_upload_dir();

			// Render CSS in the head.
			if ( isset( $wp_customize ) || ! file_exists( $upload_dir['basedir'] . '/subetuwebwp/custom-style.css' ) ) {

				// Minify and output CSS in the wp_head.
				if ( ! empty( $output ) ) {
					echo "<!-- subetuwebWP CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( subetuwebwp_minify_css( $output ) ) . "\n</style>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		} else {

			// Minify and output CSS in the wp_head.
			if ( ! empty( $output ) ) {
				echo "<!-- subetuwebWP CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( subetuwebwp_minify_css( $output ) ) . "\n</style>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

	}

	/**
	 * Minify the WP custom CSS because WordPress doesn't do it by default.
	 *
	 * @param obj $css minify css.
	 * @since 1.1.9
	 */
	public static function minify_custom_css( $css ) {

		return subetuwebwp_minify_css( $css );

	}

	/**
	 * Adds inline CSS for the admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_inline_css() {
		echo '<style>div#setting-error-tgmpa{display:block;}</style>';
	}

	/**
	 * Alter wp list categories arguments.
	 * Adds a span around the counter for easier styling.
	 *
	 * @param obj $links link.
	 * @since 1.0.0
	 */
	public static function wp_list_categories_args( $links ) {
		$links = str_replace( '</a> (', '</a> <span class="cat-count-span">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}

	/**
	 * Alters the default oembed output.
	 * Adds special classes for responsive oembeds via CSS.
	 *
	 * @param obj $cache     cache.
	 * @param url $url       url.
	 * @param obj $attr      attributes.
	 * @param obj $post_ID   post id.
	 * @since 1.0.0
	 */
	public static function add_responsive_wrap_to_oembeds( $cache, $url, $attr, $post_ID ) {

		// Supported video embeds.
		$hosts = apply_filters(
			'subetuweb_oembed_responsive_hosts',
			array(
				'vimeo.com',
				'youtube.com',
				'youtu.be',
				'blip.tv',
				'money.cnn.com',
				'dailymotion.com',
				'flickr.com',
				'hulu.com',
				'kickstarter.com',
				'vine.co',
				'soundcloud.com',
				'#http://((m|www)\.)?youtube\.com/watch.*#i',
				'#https://((m|www)\.)?youtube\.com/watch.*#i',
				'#http://((m|www)\.)?youtube\.com/playlist.*#i',
				'#https://((m|www)\.)?youtube\.com/playlist.*#i',
				'#http://youtu\.be/.*#i',
				'#https://youtu\.be/.*#i',
				'#https?://(.+\.)?vimeo\.com/.*#i',
				'#https?://(www\.)?dailymotion\.com/.*#i',
				'#https?://dai\.ly/*#i',
				'#https?://(www\.)?hulu\.com/watch/.*#i',
				'#https?://wordpress\.tv/.*#i',
				'#https?://(www\.)?funnyordie\.com/videos/.*#i',
				'#https?://vine\.co/v/.*#i',
				'#https?://(www\.)?collegehumor\.com/video/.*#i',
				'#https?://(www\.|embed\.)?ted\.com/talks/.*#i',
			)
		);

		// Supports responsive.
		$supports_responsive = false;

		// Check if responsive wrap should be added.
		foreach ( $hosts as $host ) {
			if ( strpos( $url, $host ) !== false ) {
				$supports_responsive = true;
				break; // no need to loop further.
			}
		}

		// Output code.
		if ( $supports_responsive ) {
			return '<p class="responsive-video-wrap clr">' . $cache . '</p>';
		} else {
			return '<div class="subetuwebwp-oembed-wrap clr">' . $cache . '</div>';
		}

	}

	/**
	 * Adds extra classes to the post_class() output
	 *
	 * @param obj $classes   Return classes.
	 * @since 1.0.0
	 */
	public static function post_class( $classes ) {

		// Get post.
		global $post;

		// Add entry class.
		$classes[] = 'entry';

		// Add has media class.
		if ( has_post_thumbnail()
			|| get_post_meta( $post->ID, 'subetuweb_post_oembed', true )
			|| get_post_meta( $post->ID, 'subetuweb_post_self_hosted_media', true )
			|| get_post_meta( $post->ID, 'subetuweb_post_video_embed', true )
		) {
			$classes[] = 'has-media';
		}

		// Return classes.
		return $classes;

	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @param obj $link   Author link.
	 * @since 1.0.0
	 */
	public static function the_author_posts_link( $link ) {

		// Add schema markup.
		$schema = subetuwebwp_get_schema_markup( 'author_link' );
		if ( $schema ) {
			$link = str_replace( 'rel="author"', 'rel="author" ' . $schema, $link );
		}

		// Return link.
		return $link;

	}

}

function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function add_menu_link_class($classes, $item, $args) {
    if(isset($args->link_class)) {
        $classes[] = $args->link_class;
    }
    return $classes;
}

add_filter( 'nav_menu_css_class', 'add_menu_link_class', 1, 3 );

new subetuwebWP_Theme_Class();
