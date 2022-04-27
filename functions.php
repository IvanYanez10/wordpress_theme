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
		// Migrate
		$this->migration();

		// Define theme constants.
		$this->subetuwebwp_constants();

		// Load required files.
		$this->subetuwebwp_has_setup();

		// Load framework classes.
		add_action( 'after_setup_theme', array( 'subetuwebWP_Theme_Class', 'classes' ), 4 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc.
		add_action( 'after_setup_theme', array( 'subetuwebWP_Theme_Class', 'theme_setup' ), 10 );

		// Setup theme => Generate the custom CSS file.
		add_action( 'admin_bar_init', array( 'subetuwebWP_Theme_Class', 'save_customizer_css_in_file' ), 9999 );

		// register sidebar widget areas.
		add_action( 'widgets_init', array( 'subetuwebWP_Theme_Class', 'register_sidebars' ) );

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

			// Load his file in last.
			add_action( 'wp_enqueue_scripts', array( 'subetuwebWP_Theme_Class', 'custom_style_css' ), 9999 );

			// Remove Customizer CSS script from Front-end.
			add_action( 'init', array( 'subetuwebWP_Theme_Class', 'remove_customizer_custom_css' ) );

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

			// Alter the search posts per page.
			add_action( 'pre_get_posts', array( 'subetuwebWP_Theme_Class', 'search_posts_per_page' ) );

			// Alter WP categories widget to display count inside a span.
			add_filter( 'wp_list_categories', array( 'subetuwebWP_Theme_Class', 'wp_list_categories_args' ) );

			// Add a responsive wrapper to the WordPress oembed output.
			add_filter( 'embed_oembed_html', array( 'subetuwebWP_Theme_Class', 'add_responsive_wrap_to_oembeds' ), 99, 4 );

			// Adds classes the post class.
			add_filter( 'post_class', array( 'subetuwebWP_Theme_Class', 'post_class' ) );

			// Add schema markup to the authors post link.
			add_filter( 'the_author_posts_link', array( 'subetuwebWP_Theme_Class', 'the_author_posts_link' ) );

			// Add support for Elementor Pro locations.
			add_action( 'elementor/theme/register_locations', array( 'subetuwebWP_Theme_Class', 'register_elementor_locations' ) );

			// Remove the default lightbox script for the beaver builder plugin.
			add_filter( 'fl_builder_override_lightbox', array( 'subetuwebWP_Theme_Class', 'remove_bb_lightbox' ) );

			add_filter( 'subetuweb_enqueue_generated_files', '__return_false' );
		}
	}

	/**
	 * Migration Functinality
	 *
	 * @since   1.0.0
	 */
	public static function migration() {
		if ( get_theme_mod( 'subetuweb_disable_emoji', false ) ) {
			set_theme_mod( 'subetuweb_performance_emoji', 'disabled' );
		}

		if ( get_theme_mod( 'subetuweb_disable_lightbox', false ) ) {
			set_theme_mod( 'subetuweb_performance_lightbox', 'disabled' );
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
		require_once $dir . 'subetuwebwp-svg.php';
		require_once $dir . 'subetuwebwp-theme-icons.php';
		require_once $dir . 'template-helpers.php';
		require_once $dir . 'customizer/controls/typography/webfonts.php';
		require_once $dir . 'walker/init.php';
		require_once $dir . 'walker/menu-walker.php';
		require_once $dir . 'third/class-elementor.php';
		require_once $dir . 'third/class-beaver-themer.php';
		require_once $dir . 'third/class-bbpress.php';
		require_once $dir . 'third/class-sensei.php';
		require_once $dir . 'third/class-amp.php';

		// Easy Digital Downloads.

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


		// Breadcrumbs class.
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

		// Declare WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add editor style.
		add_editor_style( 'assets/css/editor-style.min.css' );

		// Declare support for selective refreshing of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

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
		$dir           = subetuwebWP_CSS_DIR_URI;
		$theme_version = subetuwebWP_THEME_VERSION;

		// Remove font awesome style from plugins.
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'fontawesome' );

		// Enqueue font awesome style.
		if ( get_theme_mod( 'subetuweb_performance_fontawesome', 'enabled' ) === 'enabled' ) {
			wp_enqueue_style( 'font-awesome', subetuwebWP_THEME_URI . '/assets/fonts/fontawesome/css/all.min.css', false, '5.15.1' );
		}

		// Enqueue simple line icons style.
		if ( get_theme_mod( 'subetuweb_performance_simple_line_icons', 'enabled' ) === 'enabled' ) {
			wp_enqueue_style( 'simple-line-icons', $dir . 'third/simple-line-icons.min.css', false, '2.4.0' );
		}

		// Enqueue Main style.
		wp_enqueue_style( 'subetuwebwp-style', $dir . 'style.min.css', false, $theme_version );

		// Blog Header styles.
		if ( 'default' !== get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' )
			&& is_single() && 'post' === get_post_type() ) {
			wp_enqueue_style( 'subetuwebwp-blog-headers', $dir . 'blog/blog-post-headers.css', false, $theme_version );
		}

		// Register perfect-scrollbar plugin style.
		wp_register_style( 'ow-perfect-scrollbar', $dir . 'third/perfect-scrollbar.css', false, '1.5.0' );

		// Register hamburgers buttons to easily use them.
		wp_register_style( 'subetuwebwp-hamburgers', $dir . 'third/hamburgers/hamburgers.min.css', false, $theme_version );
		// Register hamburgers buttons styles.
		$hamburgers = subetuwebwp_hamburgers_styles();
		foreach ( $hamburgers as $class => $name ) {
			wp_register_style( 'subetuwebwp-' . $class . '', $dir . 'third/hamburgers/types/' . $class . '.css', false, $theme_version );
		}

		// Get mobile menu icon style.
		$mobile_menu = get_theme_mod( 'subetuweb_mobile_menu_open_hamburger', 'default' );
		// Enqueue mobile menu icon style.
		if ( ! empty( $mobile_menu ) && 'default' !== $mobile_menu ) {
			wp_enqueue_style( 'subetuwebwp-hamburgers' );
			wp_enqueue_style( 'subetuwebwp-' . $mobile_menu . '' );
		}

		// If Vertical header style.
		if ( 'vertical' === subetuwebwp_header_style() ) {
			wp_enqueue_style( 'subetuwebwp-hamburgers' );
			wp_enqueue_style( 'subetuwebwp-spin' );
			wp_enqueue_style( 'ow-perfect-scrollbar' );
		}
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

		// Get localized array.
		$localize_array = self::localize_array();

		// Main script dependencies.
		$main_script_dependencies = array( 'jquery' );

		// Comment reply.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Add images loaded.
		wp_enqueue_script( 'imagesloaded' );

		/**
		 * Load Venors Scripts.
		 */

		// Isotop.
		wp_register_script( 'ow-isotop', $dir . 'vendors/isotope.pkgd.min.js', array(), '3.0.6', true );

		// Flickity.
		wp_register_script( 'ow-flickity', $dir . 'vendors/flickity.pkgd.min.js', array(), $theme_version, true );

		// Magnific Popup.
		wp_register_script( 'ow-magnific-popup', $dir . 'vendors/magnific-popup.min.js', array( 'jquery' ), $theme_version, true );

		// Sidr Mobile Menu.
		wp_register_script( 'ow-sidr', $dir . 'vendors/sidr.js', array(), $theme_version, true );

		// Perfect Scrollbar.
		wp_register_script( 'ow-perfect-scrollbar', $dir . 'vendors/perfect-scrollbar.min.js', array(), $theme_version, true );

		// Smooth Scroll.
		wp_register_script( 'ow-smoothscroll', $dir . 'vendors/smoothscroll.min.js', array(), $theme_version, false );

		/**
		 * Load Theme Scripts.
		 */

		// Theme script.
		wp_enqueue_script( 'subetuwebwp-main', $dir . 'theme.min.js', $main_script_dependencies, $theme_version, true );
		wp_localize_script( 'subetuwebwp-main', 'subetuwebwpLocalize', $localize_array );
		array_push( $main_script_dependencies, 'subetuwebwp-main' );

		// Blog Masonry script.
		if ( 'masonry' === subetuwebwp_blog_grid_style() ) {
			array_push( $main_script_dependencies, 'ow-isotop' );
			wp_enqueue_script( 'ow-isotop' );
			wp_enqueue_script( 'subetuwebwp-blog-masonry', $dir . 'blog-masonry.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Menu script.
		switch ( subetuwebwp_header_style() ) {
			case 'full_screen':
				wp_enqueue_script( 'subetuwebwp-full-screen-menu', $dir . 'full-screen-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'vertical':
				array_push( $main_script_dependencies, 'ow-perfect-scrollbar' );
				wp_enqueue_script( 'ow-perfect-scrollbar' );
				wp_enqueue_script( 'subetuwebwp-vertical-header', $dir . 'vertical-header.min.js', $main_script_dependencies, $theme_version, true );
				break;
		}

		// Mobile Menu script.
		switch ( subetuwebwp_mobile_menu_style() ) {
			case 'dropdown':
				wp_enqueue_script( 'subetuwebwp-drop-down-mobile-menu', $dir . 'drop-down-mobile-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'fullscreen':
				wp_enqueue_script( 'subetuwebwp-full-screen-mobile-menu', $dir . 'full-screen-mobile-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'sidebar':
				array_push( $main_script_dependencies, 'ow-sidr' );
				wp_enqueue_script( 'ow-sidr' );
				wp_enqueue_script( 'subetuwebwp-sidebar-mobile-menu', $dir . 'sidebar-mobile-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
		}

		// Search script.
		switch ( subetuwebwp_menu_search_style() ) {
			case 'drop_down':
				wp_enqueue_script( 'subetuwebwp-drop-down-search', $dir . 'drop-down-search.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'header_replace':
				wp_enqueue_script( 'subetuwebwp-header-replace-search', $dir . 'header-replace-search.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'overlay':
				wp_enqueue_script( 'subetuwebwp-overlay-search', $dir . 'overlay-search.min.js', $main_script_dependencies, $theme_version, true );
				break;
		}

		// Mobile Search Icon Style.
		if ( subetuwebwp_mobile_menu_search_style() !== 'disabled' ) {
			wp_enqueue_script( 'subetuwebwp-mobile-search-icon', $dir . 'mobile-search-icon.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Equal Height Elements script.
		if ( subetuwebwp_blog_entry_equal_heights() ) {
			wp_enqueue_script( 'subetuwebwp-equal-height-elements', $dir . 'equal-height-elements.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Lightbox script.
		if ( subetuwebwp_gallery_is_lightbox_enabled() || get_theme_mod( 'subetuweb_performance_lightbox', 'enabled' ) === 'enabled' ) {
			array_push( $main_script_dependencies, 'ow-magnific-popup' );
			wp_enqueue_script( 'ow-magnific-popup' );
			wp_enqueue_script( 'subetuwebwp-lightbox', $dir . 'ow-lightbox.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Slider script.
		array_push( $main_script_dependencies, 'ow-flickity' );
		wp_enqueue_script( 'ow-flickity' );
		wp_enqueue_script( 'subetuwebwp-slider', $dir . 'ow-slider.min.js', $main_script_dependencies, $theme_version, true );

		// Scroll Effect script.
		wp_enqueue_script( 'subetuwebwp-scroll-effect', $dir . 'scroll-effect.min.js', $main_script_dependencies, $theme_version, true );

		// Scroll to Top script.
		if ( subetuwebwp_display_scroll_up_button() ) {
			wp_enqueue_script( 'subetuwebwp-scroll-top', $dir . 'scroll-top.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Custom Select script.
		if ( get_theme_mod( 'subetuweb_performance_custom_select', 'enabled' ) === 'enabled' ) {
			wp_enqueue_script( 'subetuwebwp-select', $dir . 'select.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Infinite Scroll script.
		if ( 'infinite_scroll' === get_theme_mod( 'subetuweb_blog_pagination_style', 'standard' ) || 'infinite_scroll' === get_theme_mod( 'subetuweb_woo_pagination_style', 'standard' ) ) {
			wp_enqueue_script( 'subetuwebwp-infinite-scroll', $dir . 'ow-infinite-scroll.min.js', $main_script_dependencies, $theme_version, true );
		}

		// WooCommerce scripts.
		if ( subetuwebWP_WOOCOMMERCE_ACTIVE
		&& 'yes' !== get_theme_mod( 'subetuweb_woo_remove_custom_features', 'no' ) ) {
			wp_enqueue_script( 'subetuwebwp-woocommerce-custom-features', $dir . 'wp-plugins/woocommerce/woo-custom-features.min.js', array( 'jquery' ), $theme_version, true );
			wp_localize_script( 'subetuwebwp-woocommerce-custom-features', 'subetuwebwpLocalize', $localize_array );
		}

		// Register scripts for old addons.
		wp_register_script( 'nicescroll', $dir . 'vendors/support-old-subetuwebwp-addons/jquery.nicescroll.min.js', array( 'jquery' ), $theme_version, true );
	}

	/**
	 * Functions.js localize array
	 *
	 * @since 1.0.0
	 */
	public static function localize_array() {

		// Create array.
		$sidr_side   = get_theme_mod( 'subetuweb_mobile_menu_sidr_direction', 'left' );
		$sidr_side   = $sidr_side ? $sidr_side : 'left';
		$sidr_target = get_theme_mod( 'subetuweb_mobile_menu_sidr_dropdown_target', 'link' );
		$sidr_target = $sidr_target ? $sidr_target : 'link';
		$vh_target   = get_theme_mod( 'subetuweb_vertical_header_dropdown_target', 'link' );
		$vh_target   = $vh_target ? $vh_target : 'link';
		$array       = array(
			'nonce'                 => wp_create_nonce( 'subetuwebwp' ),
			'isRTL'                 => is_rtl(),
			'menuSearchStyle'       => subetuwebwp_menu_search_style(),
			'mobileMenuSearchStyle' => subetuwebwp_mobile_menu_search_style(),
			'sidrSource'            => subetuwebwp_sidr_menu_source(),
			'sidrDisplace'          => get_theme_mod( 'subetuweb_mobile_menu_sidr_displace', true ) ? true : false,
			'sidrSide'              => $sidr_side,
			'sidrDropdownTarget'    => $sidr_target,
			'verticalHeaderTarget'  => $vh_target,
			'customSelects'         => '.woocommerce-ordering .orderby, #dropdown_product_cat, .widget_categories select, .widget_archive select, .single-product .variations_form .variations select',
		);

		// WooCart.
		if ( subetuwebWP_WOOCOMMERCE_ACTIVE ) {
			$array['wooCartStyle'] = subetuwebwp_menu_cart_style();
		}

		// Apply filters and return array.
		return apply_filters( 'subetuweb_localize_array', $array );
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
	 * Registers sidebars
	 *
	 * @since   1.0.0
	 */
	public static function register_sidebars() {

		$heading = get_theme_mod( 'subetuweb_sidebar_widget_heading_tag', 'h4' );
		$heading = apply_filters( 'subetuweb_sidebar_widget_heading_tag', $heading );

		$foo_heading = get_theme_mod( 'subetuweb_footer_widget_heading_tag', 'h4' );
		$foo_heading = apply_filters( 'subetuweb_footer_widget_heading_tag', $foo_heading );

		// Default Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Default Sidebar', 'subetuwebwp' ),
				'id'            => 'sidebar',
				'description'   => esc_html__( 'Widgets in this area will be displayed in the left or right sidebar area if you choose the Left or Right Sidebar layout.', 'subetuwebwp' ),
				'before_widget' => '<div id="%1$s" class="sidebar-box %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $heading . ' class="widget-title">',
				'after_title'   => '</' . $heading . '>',
			)
		);

		// Left Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Left Sidebar', 'subetuwebwp' ),
				'id'            => 'sidebar-2',
				'description'   => esc_html__( 'Widgets in this area are used in the left sidebar region if you use the Both Sidebars layout.', 'subetuwebwp' ),
				'before_widget' => '<div id="%1$s" class="sidebar-box %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $heading . ' class="widget-title">',
				'after_title'   => '</' . $heading . '>',
			)
		);

		// Search Results Sidebar.
		if ( get_theme_mod( 'subetuweb_search_custom_sidebar', true ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Search Results Sidebar', 'subetuwebwp' ),
					'id'            => 'search_sidebar',
					'description'   => esc_html__( 'Widgets in this area are used in the search result page.', 'subetuwebwp' ),
					'before_widget' => '<div id="%1$s" class="sidebar-box %2$s clr">',
					'after_widget'  => '</div>',
					'before_title'  => '<' . $heading . ' class="widget-title">',
					'after_title'   => '</' . $heading . '>',
				)
			);
		}

		// Footer 1.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 1', 'subetuwebwp' ),
				'id'            => 'footer-one',
				'description'   => esc_html__( 'Widgets in this area are used in the first footer region.', 'subetuwebwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

		// Footer 2.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 2', 'subetuwebwp' ),
				'id'            => 'footer-two',
				'description'   => esc_html__( 'Widgets in this area are used in the second footer region.', 'subetuwebwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

		// Footer 3.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 3', 'subetuwebwp' ),
				'id'            => 'footer-three',
				'description'   => esc_html__( 'Widgets in this area are used in the third footer region.', 'subetuwebwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

		// Footer 4.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 4', 'subetuwebwp' ),
				'id'            => 'footer-four',
				'description'   => esc_html__( 'Widgets in this area are used in the fourth footer region.', 'subetuwebwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

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
	 * Save Customizer CSS in a file
	 *
	 * @param obj $output output value.
	 * @since 1.4.12
	 */
	public static function save_customizer_css_in_file( $output = null ) {

		// If Custom File is not selected.
		if ( 'file' !== get_theme_mod( 'subetuweb_customzer_styling', 'head' ) ) {
			return;
		}

		// Get all the customier css.
		$output = apply_filters( 'subetuweb_head_css', $output );

		// Get Custom Panel CSS.
		$output_custom_css = wp_get_custom_css();

		// Minified the Custom CSS.
		$output .= subetuwebwp_minify_css( $output_custom_css );

		// We will probably need to load this file.
		require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php';

		global $wp_filesystem;
		$upload_dir = wp_upload_dir(); // Grab uploads folder array.
		$dir        = trailingslashit( $upload_dir['basedir'] ) . 'subetuwebwp' . DIRECTORY_SEPARATOR; // Set storage directory path.

		WP_Filesystem(); // Initial WP file system.
		$wp_filesystem->mkdir( $dir ); // Make a new folder 'subetuwebwp' for storing our file if not created already.
		$wp_filesystem->put_contents( $dir . 'custom-style.css', $output, 0644 ); // Store in the file.

	}

	/**
	 * Include Custom CSS file if present.
	 *
	 * @param obj $output output value.
	 * @since 1.4.12
	 */
	public static function custom_style_css( $output = null ) {

		// If Custom File is not selected.
		if ( 'file' !== get_theme_mod( 'subetuweb_customzer_styling', 'head' ) ) {
			return;
		}

		global $wp_customize;
		$upload_dir = wp_upload_dir();

		// Get all the customier css.
		$output = apply_filters( 'subetuweb_head_css', $output );

		// Get Custom Panel CSS.
		$output_custom_css = wp_get_custom_css();

		// Minified the Custom CSS.
		$output .= subetuwebwp_minify_css( $output_custom_css );

		// Render CSS from the custom file.
		if ( ! isset( $wp_customize ) && file_exists( $upload_dir['basedir'] . '/subetuwebwp/custom-style.css' ) && ! empty( $output ) ) {
			wp_enqueue_style( 'subetuwebwp-custom', trailingslashit( $upload_dir['baseurl'] ) . 'subetuwebwp/custom-style.css', false, false );
		}
	}

	/**
	 * Remove Customizer style script from front-end
	 *
	 * @since 1.4.12
	 */
	public static function remove_customizer_custom_css() {

		// If Custom File is not selected.
		if ( 'file' !== get_theme_mod( 'subetuweb_customzer_styling', 'head' ) ) {
			return;
		}

		global $wp_customize;

		// Disable Custom CSS in the frontend head.
		remove_action( 'wp_head', 'wp_custom_css_cb', 11 );
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		// If custom CSS file exists and NOT in customizer screen.
		if ( isset( $wp_customize ) ) {
			add_action( 'wp_footer', 'wp_custom_css_cb', 9999 );
		}
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
	 * Alter the search posts per page
	 *
	 * @param obj $query query.
	 * @since 1.3.7
	 */
	public static function search_posts_per_page( $query ) {
		$posts_per_page = get_theme_mod( 'subetuweb_search_post_per_page', '8' );
		$posts_per_page = $posts_per_page ? $posts_per_page : '8';

		if ( $query->is_main_query() && is_search() ) {
			$query->set( 'posts_per_page', $posts_per_page );
		}
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

	/**
	 * Add support for Elementor Pro locations
	 *
	 * @param obj $elementor_theme_manager    Elementor Instance.
	 * @since 1.5.6
	 */
	public static function register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_all_core_location();
	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 1.1.5
	 */
	public static function remove_bb_lightbox() {
		return true;
	}

}

/**--------------------------------------------------------------------------------
#region Freemius - This logic will only be executed when subetuweb Extra is active and has the Freemius SDK
---------------------------------------------------------------------------------*/

if ( ! function_exists( 'owp_fs' ) ) {
	if ( class_exists( 'subetuweb_Extra' ) &&
			defined( 'OE_FILE_PATH' ) &&
			file_exists( dirname( OE_FILE_PATH ) . '/includes/freemius/start.php' )
	) {
		/**
		 * Create a helper function for easy SDK access.
		 */
		function owp_fs() {
			global $owp_fs;

			if ( ! isset( $owp_fs ) ) {
				// Include Freemius SDK.
				require_once dirname( OE_FILE_PATH ) . '/includes/freemius/start.php';

				$owp_fs = fs_dynamic_init(
					array(
						'id'                             => '3752',
						'bundle_id'                      => '3767',
						'slug'                           => 'subetuwebwp',
						'type'                           => 'theme',
						'public_key'                     => 'pk_043077b34f20f5e11334af3c12493',
						'bundle_public_key'              => 'pk_c334eb1ae413deac41e30bf00b9dc',
						'is_premium'                     => false,
						'has_addons'                     => true,
						'has_paid_plans'                 => true,
						'menu'                           => array(
							'slug'    => 'subetuwebwp-panel',
							'account' => true,
							'contact' => false,
							'support' => false,
						),
						'bundle_license_auto_activation' => true,
						'navigation'                     => 'menu',
						'is_org_compliant'               => true,
					)
				);
			}

			return $owp_fs;
		}

		// Init Freemius.
		owp_fs();
		// Signal that SDK was initiated.
		do_action( 'owp_fs_loaded' );
	}
}

// endregion

new subetuwebWP_Theme_Class();
