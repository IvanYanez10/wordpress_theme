<?php
/**
 * This file includes helper functions used throughout the theme.
 *
 * @package subetuwebWP WordPress theme
 */

/*
-------------------------------------------------------------------------------*/
/*
 [ Table of contents ]
/*
-------------------------------------------------------------------------------*

	# General
	# Top Bar
	# Header
	# Page Header
	# Blog
	# Footer
	# WooCommerce
	# Other

/*
-------------------------------------------------------------------------------*/
/*
 [ General ]
/*-------------------------------------------------------------------------------*/


if ( ! function_exists( 'subetuwebwp_html_classes' ) ) {

	/**
	 * Adds classes to the html tag
	 *
	 * @since 1.0.0
	 */
	function subetuwebwp_html_classes() {

		// Setup classes array.
		$classes = array();

		// Main class.
		$classes[] = 'html';

		// Set keys equal to vals.
		$classes = array_combine( $classes, $classes );

		// Apply filters for child theming.
		$classes = apply_filters( 'subetuweb_html_classes', $classes );

		// Turn classes into space seperated string.
		$classes = implode( ' ', $classes );

		// Return classes.
		return $classes;

	}
}

if ( ! function_exists( 'subetuwebwp_body_classes' ) ) {

	/**
	 * Adds classes to the body tag
	 *
	 * @param obj $classes    body class.
	 * @since 1.0.0
	 */
	function subetuwebwp_body_classes( $classes ) {

		// Vars.
		$post_layout  = subetuwebwp_post_layout();
		$layout_style = get_theme_mod( 'subetuweb_main_layout_style', 'wide' );
		$post_id      = subetuwebwp_post_id();
		$mobile_style = subetuwebwp_mobile_menu_style();

		// Main class.
		$classes[] = 'subetuwebwp-theme';

		// Mobile menu style.
		$classes[] = $mobile_style . '-mobile';

		// Boxed layout.
		if ( 'boxed' == $layout_style ) {
			$classes[] = 'boxed-layout';

			if ( get_theme_mod( 'subetuweb_boxed_dropdshadow', true ) ) {
				$classes[] = 'wrap-boxshadow';
			}
		}

		// Separate layout.
		if ( 'separate' == $layout_style ) {
			$classes[] = 'separate-layout';
		}

		// If separate style nad blog page.
		if ( 'separate' == $layout_style
			&& ( is_home()
				|| is_category()
				|| is_tag()
				|| is_date()
				|| is_author() ) ) {
			$classes[] = 'separate-blog';
		}

		// If is not custom header created with Elementor Pro 2.0.
		if ( ! function_exists( 'elementor_location_exits' ) || ! elementor_location_exits( 'header', true ) ) {

			// Top menu header style to control the responsive.
			if ( 'top' == subetuwebwp_header_style() ) {
				$classes[] = 'top-header-style';
			}

			// Medium header style to control the responsive.
			if ( 'medium' == subetuwebwp_header_style() ) {
				$classes[] = 'medium-header-style';
			}

			// Vertical header style.
			if ( 'vertical' == subetuwebwp_header_style() ) {

				// Vertical header style to control the wrap margin left.
				$classes[] = 'vertical-header-style';

				// Header position.
				$position  = get_theme_mod( 'subetuweb_vertical_header_position', 'left-header' );
				$position  = $position ? $position : 'left-header';
				$classes[] = $position;

				// If default collapse.
				$vh_collapse_width = get_theme_mod( 'subetuweb_vertical_header_collapse_width', '1280' );
				if ( empty( $vh_collapse_width )
					|| '1280' == $vh_collapse_width ) {
					$classes[] = 'default-collapse';
				}
			}

			// Add transparent class for header styles.
			if ( 'transparent' == subetuwebwp_header_style()
				|| ( 'full_screen' == subetuwebwp_header_style() && true == get_theme_mod( 'subetuweb_full_screen_header_transparent', false ) )
				|| ( 'center' == subetuwebwp_header_style() && true == get_theme_mod( 'subetuweb_center_header_transparent', false ) )
				|| ( 'medium' == subetuwebwp_header_style() && true == get_theme_mod( 'subetuweb_medium_header_transparent', false ) ) ) {
				$classes[] = 'has-transparent-header';
			}

			// Add transparent class for the vertical header style.
			if ( 'vertical' == subetuwebwp_header_style()
				&& true == get_theme_mod( 'subetuweb_vertical_header_transparent', false ) ) {
				$classes[] = 'has-vh-transparent';
			}

			// If vertical header closed.
			if ( 'vertical' == subetuwebwp_header_style()
				&& true == get_theme_mod( 'subetuweb_vertical_header_closed', false ) ) {
				$classes[] = 'vh-closed';
			}
		}

		// If no header border bottom.
		if ( true != get_theme_mod( 'subetuweb_has_header_border_bottom', true ) ) {
			$classes[] = 'no-header-border';
		}

		// If no custom mobile breakpoint.
		if ( '959' == get_theme_mod( 'subetuweb_mobile_menu_breakpoints', '959' ) ) {
			$classes[] = 'default-breakpoint';
		}

		// Sidebar enabled.
		if ( 'left-sidebar' == $post_layout
			|| 'right-sidebar' == $post_layout
			|| 'both-sidebars' == $post_layout ) {
			$classes[] = 'has-sidebar';
		}

		// Mobile sidebar order.
		if ( 'sidebar-content' == subetuwebwp_sidebar_order() ) {
			$classes[] = 'sidebar-content';
		}

		// Content layout.
		if ( $post_layout ) {
			$classes[] = 'content-' . $post_layout;
		}

		// If full width and has content width.
		if ( 'full-width' == $post_layout
			&& '0' != get_theme_mod( 'subetuweb_blog_single_content_width', '700' ) ) {
			$classes[] = 'content-max-width';
		}

		// Both sidebars layout style.
		if ( 'both-sidebars' == $post_layout ) {
			$classes[] = subetuwebwp_both_sidebars_style();
		}

		// Single Post cagegories.
		if ( is_singular( 'post' ) ) {
			$cats = get_the_category( $post_id );
			foreach ( $cats as $cat ) {
				$classes[] = 'post-in-category-' . $cat->category_nicename;
			}
		}

		// If landing page template.
		if ( is_page_template( 'templates/landing.php' ) ) {
			$classes[] = 'landing-page';
		}

		// If sube page template.
		if ( is_page_template( 'templates/sube.php' ) ) {
			$classes[] = 'sube-page';
		}

		// Topbar.
		if ( subetuwebwp_display_topbar() ) {
			$classes[] = 'has-topbar';
		}

		// Title with Background Image.
		if ( 'background-image' == subetuwebwp_page_header_style() ) {
			$classes[] = 'page-with-background-title';
		}

		// Disabled header.
		if ( ! subetuwebwp_has_page_header() ) {
			$classes[] = 'page-header-disabled';
		}

		// Breadcrumbs.
		if ( subetuwebwp_has_breadcrumbs() ) {
			$classes[] = 'has-breadcrumbs';
		}

		// If blog grid style.
		if ( 'grid-entry' == get_theme_mod( 'subetuweb_blog_style', 'large-entry' ) ) {
			$classes[] = 'has-blog-grid';
		}

		// Fixed footer.
		if ( 'on' == get_theme_mod( 'subetuweb_fixed_footer', 'off' ) ) {
			$classes[] = 'has-fixed-footer';
		}

		// Parallax footer.
		if ( 'on' == get_theme_mod( 'subetuweb_parallax_footer', 'off' ) ) {
			$classes[] = 'has-parallax-footer';
		}

		// Pagination.
		$pagination_align = get_theme_mod( 'subetuweb_pagination_align', 'right' );
		if ( 'right' != $pagination_align ) {
			$classes[] = 'pagination-' . $pagination_align;
		}

		/**
		 * Performance Section
		 */
		if ( ! subetuwebwp_gallery_is_lightbox_enabled() && get_theme_mod( 'subetuweb_performance_lightbox', 'enabled' ) === 'disabled' ) {
			$classes[] = 'no-lightbox';
		}

		// Return classes.
		return $classes;

	}

	add_filter( 'body_class', 'subetuwebwp_body_classes' );

}

if ( get_theme_mod( 'subetuweb_performance_emoji', 'enabled' ) === 'disabled' ) {
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	call_user_func(
		'remove_action',
		'wp_print_styles',
		'print_emoji_styles'
	);

	call_user_func(
		'remove_action',
		'wp_head',
		'print_emoji_detection_script',
		7
	);

	call_user_func(
		'remove_action',
		'admin_print_scripts',
		'print_emoji_detection_script'
	);

	call_user_func(
		'remove_action',
		'admin_print_styles',
		'print_emoji_styles'
	);

	add_filter(
		'tiny_mce_plugins',
		function ( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
			} else {
				return array();
			}
		}
	);

	add_filter(
		'wp_resource_hints',
		function ( $urls, $relation_type ) {
			if ( 'dns-prefetch' === $relation_type ) {
				$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

				$urls = array_diff( $urls, array( $emoji_svg_url ) );
			}

			return $urls;
		},
		10,
		2
	);
}

/**
 * Backward compatibility
 *
 * @since 1.8.3
 */
if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}


if ( ! function_exists( 'subetuwebwp_post_id' ) ) {

	/**
	 * Store current post ID
	 *
	 * @since 1.0.0
	 */
	function subetuwebwp_post_id() {

		// Default value.
		$id = '';

		// If singular get_the_ID.
		if ( is_singular() ) {
			$id = get_the_ID();
		}

		// Posts page.
		elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
			$id = $page_for_posts;
		}

		// Apply filters.
		$id = apply_filters( 'subetuweb_post_id', $id );

		// Sanitize.
		$id = $id ? $id : '';

		// Return ID.
		return $id;

	}
}

/**
 * Get unique ID
 *
 * Based on the TwentyTwenty theme unique ID method: inc\template-tags.php
 *
 * @since 1.7.9
 */
if ( ! function_exists( 'subetuwebwp_unique_id' ) ) {
	function subetuwebwp_unique_id( $prefix = '' ) {
		static $id_counter = 0;
		if ( function_exists( 'wp_unique_id' ) ) {
			return wp_unique_id( $prefix );
		}
		return $prefix . (string) ++$id_counter;
	}
}

/**
 * Returns correct post layout
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_post_layout' ) ) {

	function subetuwebwp_post_layout() {

		// Define variables
		$class = 'right-sidebar';
		$meta  = get_post_meta( subetuwebwp_post_id(), 'subetuweb_post_layout', true );

		// Check meta first to override and return (prevents filters from overriding meta)
		if ( $meta ) {
			return $meta;
		}

		// Singular Page
		if ( is_page() ) {

			// Landing template
			if ( is_page_template( 'templates/landing.php' ) ) {
				$class = 'full-width';
			}

			// sube template
			if ( is_page_template( 'templates/sube.php' ) ) {
				$class = 'full-width';
			}

			// Attachment
			elseif ( is_attachment() ) {
				$class = 'full-width';
			}

			// All other pages
			else {
				$class = get_theme_mod( 'subetuweb_page_single_layout', 'right-sidebar' );
			}
		}

		// Home
		elseif ( is_home()
			|| is_category()
			|| is_tag()
			|| is_date()
			|| is_author() ) {
			$class = get_theme_mod( 'subetuweb_blog_archives_layout', 'right-sidebar' );
		}

		// Singular Post
		elseif ( is_singular( 'post' ) ) {
			$class = get_theme_mod( 'subetuweb_blog_single_layout', 'right-sidebar' );
		}

		// 404 page
		elseif ( is_404() ) {
			$class = get_theme_mod( 'subetuweb_error_page_layout', 'full-width' );
		}

		// All else
		else {
			$class = 'right-sidebar';
		}

		// Class should never be empty
		if ( empty( $class ) ) {
			$class = 'right-sidebar';
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_post_layout_class', $class );

	}
}

/**
 * Returns the correct classname for any specific column grid
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_grid_class' ) ) {

	function subetuwebwp_grid_class( $col = '4' ) {
		return esc_attr( apply_filters( 'subetuweb_grid_class', 'span_1_of_' . $col ) );
	}
}

/**
 * Removes the scheme of the passed URL to fit the current page.
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'subetuwebwp_correct_url_scheme' ) ) {

	function subetuwebwp_correct_url_scheme( $url ) {

		$url = str_replace( 'http://', '//', str_replace( 'https://', '//', $url ) );

		return $url;
	}
}

/**
 * Gets the attachment ID from the url
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'subetuwebwp_get_attachment_id_from_url' ) ) {

	function subetuwebwp_get_attachment_id_from_url( $attachment_url = '' ) {

		global $wpdb;
		$attachment_id = false;

		if ( '' == $attachment_url || ! is_string( $attachment_url ) ) {
			return '';
		}

		$upload_dir_paths         = wp_upload_dir();
		$upload_dir_paths_baseurl = $upload_dir_paths['baseurl'];

		if ( substr( $attachment_url, 0, 2 ) == '//' ) {
			$upload_dir_paths_baseurl = subetuwebwp_correct_url_scheme( $upload_dir_paths_baseurl );
		}

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
		if ( false !== strpos( $attachment_url, $upload_dir_paths_baseurl ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif|tiff|svg)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL.
			$attachment_url = str_replace( $upload_dir_paths_baseurl . '/', '', $attachment_url );

			// Run a custom database query to get the attachment ID from the modified attachment URL.
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
			$attachment_id = apply_filters( 'wpml_object_id', $attachment_id, 'attachment' );
		}

		return $attachment_id;

	}
}

/**
 * Gets the most important attachment data from the url
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'subetuwebwp_get_attachment_data_from_url' ) ) {

	function subetuwebwp_get_attachment_data_from_url( $attachment_url = '' ) {

		if ( '' == $attachment_url ) {
			return false;
		}

		$attachment_data['url'] = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
		$attachment_data['id']  = subetuwebwp_get_attachment_id_from_url( $attachment_data['url'] );

		if ( ! $attachment_data['id'] ) {
			return false;
		}

		preg_match( '/\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', $attachment_url, $matches );
		if ( count( $matches ) > 0 ) {
			$dimensions                = explode( 'x', $matches[0] );
			$attachment_data['width']  = $dimensions[0];
			$attachment_data['height'] = $dimensions[1];
		} else {
			$attachment_src            = wp_get_attachment_image_src( $attachment_data['id'], 'full' );
			$attachment_data['width']  = $attachment_src[1];
			$attachment_data['height'] = $attachment_src[2];
		}

		$attachment_data['alt']     = get_post_field( '_wp_attachment_image_alt', $attachment_data['id'] );
		$attachment_data['caption'] = get_post_field( 'post_excerpt', $attachment_data['id'] );
		$attachment_data['title']   = get_post_field( 'post_title', $attachment_data['id'] );

		return $attachment_data;
	}
}

/*
-------------------------------------------------------------------------------*/
/*
 [ Top Bar ]
/*-------------------------------------------------------------------------------*/

/**
 * Display top bar
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_display_topbar' ) ) {

	function subetuwebwp_display_topbar() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'subetuweb_top_bar', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_display_top_bar', $return );

	}
}

/**
 * Top bar template
 * I make a function to be able to remove it for the Beaver Themer plugin
 *
 * @since 1.2.5
 */
if ( ! function_exists( 'subetuwebwp_top_bar_template' ) ) {

	function subetuwebwp_top_bar_template() {

		// Return if no top bar
		if ( ! subetuwebwp_display_topbar() ) {
			return;
		}

		get_template_part( 'partials/topbar/layout' );

	}

	add_action( 'subetuweb_top_bar', 'subetuwebwp_top_bar_template' );

}

/**
 * Add classes to the top bar wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_topbar_classes' ) ) {

	function subetuwebwp_topbar_classes() {

		// Setup classes array
		$classes = array();

		// Clearfix class
		$classes[] = 'clr';

		// Visibility
		$visibility = get_theme_mod( 'subetuweb_top_bar_visibility', 'all-devices' );
		if ( 'all-devices' != $visibility ) {
			$classes[] = $visibility;
		}

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters for child theming
		$classes = apply_filters( 'subetuweb_topbar_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}
}

/**
 * Topbar style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_top_bar_style' ) ) {

	function subetuwebwp_top_bar_style() {
		$style = get_theme_mod( 'subetuweb_top_bar_style' );
		$style = $style ? $style : 'one';
		return apply_filters( 'subetuweb_top_bar_style', $style );
	}
}
/**
 * Topbar Content classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_topbar_content_classes' ) ) {

	function subetuwebwp_topbar_content_classes() {

		// Define classes
		$classes = array( 'clr' );

		// Check for content
		if ( get_theme_mod( 'subetuweb_top_bar_content' ) ) {
			$classes[] = 'has-content';
		}

		// Get topbar style
		$style = subetuwebwp_top_bar_style();

		// Top bar style
		if ( 'one' == $style ) {
			$classes[] = 'top-bar-left';
		} elseif ( 'two' == $style ) {
			$classes[] = 'top-bar-right';
		} elseif ( 'three' == $style ) {
			$classes[] = 'top-bar-centered';
		}

		// Apply filters for child theming
		$classes = apply_filters( 'subetuweb_top_bar_classes', $classes );

		// Turn classes array into space seperated string
		$classes = implode( ' ', $classes );

		// Return classes
		return esc_attr( $classes );

	}
}

/*
-------------------------------------------------------------------------------*/
/*
 [ Header ]
/*-------------------------------------------------------------------------------*/

/**
 * Display header
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_display_header' ) ) {

	function subetuwebwp_display_header() {

		// Return true by default
		$return = true;

		// Apply filters and return
		return apply_filters( 'subetuweb_display_header', $return );

	}
}

/**
 * Header template
 * I make a function to be able to remove it for the Beaver Themer plugin
 *
 * @since 1.2.5
 */
if ( ! function_exists( 'subetuwebwp_header_template' ) ) {

	function subetuwebwp_header_template() {

		// Return if no header
		if ( ! subetuwebwp_display_header() ) {
			return;
		}

		get_template_part( 'partials/header/layout' );

	}

	add_action( 'subetuweb_header', 'subetuwebwp_header_template' );

}

/**
 * Header style
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_header_style' ) ) {

	function subetuwebwp_header_style() {

		// Get style from customizer setting
		$style = get_theme_mod( 'subetuweb_header_style', 'minimal' );

		// Sanitize style to make sure it isn't empty
		$style = $style ? $style : 'minimal';

		// Apply filters and return
		return apply_filters( 'subetuweb_header_style', $style );

	}
}

/**
 * Custom header style template
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'subetuwebwp_custom_header_template' ) ) {

	function subetuwebwp_custom_header_template() {

		// Get template from customizer setting
		$template = get_theme_mod( 'subetuweb_header_template' );

		// Apply filters and return
		return apply_filters( 'subetuweb_custom_header_template', $template );

	}
}

/**
 * Add classes to the header wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_header_classes' ) ) {

	function subetuwebwp_header_classes() {

		// Header style
		$header_style = subetuwebwp_header_style();

		// Setup classes array
		$classes = array();

		// If is not custom header created with Elementor Pro 2.0
		if ( ! function_exists( 'elementor_location_exits' ) || ! elementor_location_exits( 'header', true ) ) {

			// Add header style class
			$classes[] = $header_style . '-header';

			// Add transparent class for header styles
			if ( ( 'full_screen' == $header_style && true == get_theme_mod( 'subetuweb_full_screen_header_transparent', false ) )
				|| ( 'center' == $header_style && true == get_theme_mod( 'subetuweb_center_header_transparent', false ) )
				|| ( 'medium' == $header_style && true == get_theme_mod( 'subetuweb_medium_header_transparent', false ) )
				|| ( 'vertical' == $header_style && true == get_theme_mod( 'subetuweb_vertical_header_transparent', false ) ) ) {
				$classes[] = 'is-transparent';
			}

			// Search overlay
			if ( 'overlay' == subetuwebwp_menu_search_style() ) {
				$classes[] = 'search-overlay';
			}

			// Add class if social menu is enabled to remove the negative right on the navigation
			if ( true == get_theme_mod( 'subetuweb_menu_social', false ) ) {
				$classes[] = 'has-social';
			}

			// Menu position
			if ( 'minimal' == $header_style || 'transparent' == $header_style ) {
				if ( 'left-menu' == get_theme_mod( 'subetuweb_menu_position', 'right-menu' ) ) {
					$classes[] = 'left-menu';
				} elseif ( 'center-menu' == get_theme_mod( 'subetuweb_menu_position', 'right-menu' ) ) {
					$classes[] = 'center-menu';
				}
			}

			// Medium header style menu hidden
			if ( 'medium' == $header_style
				&& true == get_theme_mod( 'subetuweb_medium_header_hidden_menu', true )
				&& true != get_theme_mod( 'subetuweb_medium_header_stick_menu', false ) ) {

				// Add hidden menu class
				$classes[] = 'hidden-menu';

			}

			// Vertical header style
			if ( 'vertical' == $header_style ) {

				// Header shadow
				if ( true == get_theme_mod( 'subetuweb_vertical_header_shadow', true ) ) {
					$classes[] = 'has-shadow';
				}

				// Logo position
				$logo_position = get_theme_mod( 'subetuweb_vertical_header_logo_position', 'center-logo' );
				$logo_position = $logo_position ? $logo_position : 'vh-center-logo';
				$classes[]     = 'vh-' . $logo_position;

			}

			// If the search header replace
			if ( 'header_replace' == subetuwebwp_menu_search_style() ) {
				$classes[] = 'header-replace';
			}

			// If has header media
			if ( has_header_image() ) {
				$classes[] = 'has-header-media';
			}

			// Mobile elements positionning
			if ( ( 'medium' != $header_style
					&& 'vertical' != $header_style
					&& 'top' != $header_style )
				&& 'one' != get_theme_mod( 'subetuweb_mobile_elements_positioning', 'one' ) ) {
				$classes[] = 'center-logo';
			}
		}

		// If menu links effect
		$link_effect = get_theme_mod( 'subetuweb_menu_links_effect', 'no' );
		if ( 'no' != $link_effect ) {
			$classes[] = 'effect-' . $link_effect;
		}

		// Clearfix class
		$classes[] = 'clr';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters for child theming
		$classes = apply_filters( 'subetuweb_header_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}
}

/**
 * Add classes to the top header style wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_top_header_classes' ) ) {

	function subetuwebwp_top_header_classes() {

		// Header style
		$header_style = subetuwebwp_header_style();

		// Return if is not the top header style
		if ( 'top' != $header_style ) {
			return;
		}

		// Setup classes array
		$classes = array();

		// Add classes
		$classes[] = 'header-top';

		// Clearfix class
		$classes[] = 'clr';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters for child theming
		$classes = apply_filters( 'subetuweb_top_header_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}
}

/**
 * Returns custom logo setting
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_header_logo_setting' ) ) {

	function subetuwebwp_header_logo_setting() {

		// Get setting
		$setting = get_theme_mod( 'custom_logo' );

		// Return setting
		return apply_filters( 'subetuweb_custom_logo', $setting );

	}
}

/**
 * Display content after header
 *
 * @since 1.5.0
 */
if ( ! function_exists( 'subetuwebwp_display_after_header_content' ) ) {

	function subetuwebwp_display_after_header_content() {

		// Header style
		$style = subetuwebwp_header_style();

		// Return false by default
		$return = false;

		// Get after header content
		$content = get_theme_mod( 'subetuweb_after_header_content' );
		$content = subetuwebwp_tm_translation( 'subetuweb_after_header_content', $content );

		// Display header content
		if ( ( 'minimal' == $style
				|| 'transparent' == $style )
			&& $content
			|| ( 'minimal' == $style
				|| 'transparent' == $style )
			&& is_customize_preview() ) {
			$return = true; ?>
			<div class="after-header-content">
				<div class="after-header-content-inner">
					<?php
					// Display top bar content
					echo do_shortcode( $content );
					?>
				</div>
			</div>
			<?php
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_display_after_header_content', $return );

	}

	add_action( 'subetuweb_before_nav', 'subetuwebwp_display_after_header_content', 999 );

}

/**
 * Display navigation
 *
 * @since 1.5.0
 */
if ( ! function_exists( 'subetuwebwp_display_navigation' ) ) {

	function subetuwebwp_display_navigation() {

		// Return true by default
		$return = true;

		// Apply filters and return
		return apply_filters( 'subetuweb_display_navigation', $return );

	}
}

/**
 * Custom nav template
 *
 * @since 1.4.7
 */
if ( ! function_exists( 'subetuwebwp_custom_nav_template' ) ) {

	function subetuwebwp_custom_nav_template() {

		// Get template from customizer setting
		$template = get_theme_mod( 'subetuweb_custom_nav_template' );

		// Apply filters and return
		return apply_filters( 'subetuweb_custom_nav_template', $template );

	}
}

/**
 * Returns header template content
 *
 * @since 1.4.7
 */
if ( ! function_exists( 'subetuwebwp_nav_template_content' ) ) {

	function subetuwebwp_nav_template_content() {

		// Get the template ID
		$content = subetuwebwp_custom_nav_template();

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'subetuwebwp_nav_template_content', $content );

	}
}

/**
 * Returns correct menu classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_header_menu_classes' ) ) {

	function subetuwebwp_header_menu_classes( $return ) {

		// Header style
		$header_style = subetuwebwp_header_style();

		// Medium header style menu position
		$menu_position = get_theme_mod( 'subetuweb_medium_header_menu_position', 'center-menu' );

		// Define classes array
		$classes = array();

		// Return wrapper classes
		if ( 'wrapper' == $return ) {

			// Add special class if the dropdown top border option in the admin is disabled
			if ( true != get_theme_mod( 'subetuweb_menu_dropdown_top_border', true ) ) {
				$classes[] = 'no-top-border';
			}

			// Add clearfix
			$classes[] = 'clr';

			// If medium header style and menu position
			if ( 'medium' == $header_style
				&& $menu_position ) {
				$classes[] = $menu_position;
			}

			// Set keys equal to vals
			$classes = array_combine( $classes, $classes );

			// Apply filters
			$classes = apply_filters( 'subetuweb_header_menu_wrap_classes', $classes );

		}

		// Inner Classes
		elseif ( 'inner' == $return ) {

			// Core
			$classes[] = 'navigation';
			$classes[] = 'main-navigation';
			$classes[] = 'clr';

			// Set keys equal to vals
			$classes = array_combine( $classes, $classes );

			// Apply filters
			$classes = apply_filters( 'subetuweb_header_menu_classes', $classes );

		}

		// Return
		if ( is_array( $classes ) ) {
			return implode( ' ', $classes );
		} else {
			return $return;
		}

	}
}

/**
 * Returns custom menu
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_header_custom_menu' ) ) {

	function subetuwebwp_header_custom_menu() {

		$menu = '';
		return apply_filters( 'subetuweb_custom_menu', $menu );

	}
}

/**
 * Header logo classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_header_logo_classes' ) ) {

	function subetuwebwp_header_logo_classes() {

		// Define classes array
		$classes = array( 'clr' );

		// If responsive logo
		if ( '' != get_theme_mod( 'subetuweb_responsive_logo' ) ) {
			$classes[] = 'has-responsive-logo';
		}

		// Get custom full screen logo
		if ( 'full_screen' == subetuwebwp_header_style()
			&& subetuwebwp_header_full_screen_logo() ) {
			$classes[] = 'has-full-screen-logo';
		}

		// Apply filters for child theming
		$classes = apply_filters( 'subetuweb_header_logo_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// Return classes
		return $classes;

	}
}

/**
 * Mobile menu style
 *
 * @since 1.3.0
 */
if ( ! function_exists( 'subetuwebwp_mobile_menu_style' ) ) {

	function subetuwebwp_mobile_menu_style() {

		// Get style from customizer setting
		$style = get_theme_mod( 'subetuweb_mobile_menu_style', 'dropdown' );

		// Sanitize style to make sure it isn't empty
		$style = $style ? $style : 'dropdown';

		// Apply filters and return
		return apply_filters( 'subetuweb_mobile_menu_style', $style );

	}
}

/*
-------------------------------------------------------------------------------*/
/*
 [ Page Header ]
/*-------------------------------------------------------------------------------*/

/**
 * Page header template
 * I make a function to be able to remove it for the Beaver Themer plugin
 *
 * @since 1.2.5
 */
if ( ! function_exists( 'subetuwebwp_page_header_template' ) ) {

	function subetuwebwp_page_header_template() {
		if ( is_singular( 'post' ) ) {
			get_template_part( subetuweb_single_post_header_template() );
		}
		else {
			get_template_part( 'partials/page-header' );
		}
	}

	add_action( 'subetuweb_page_header', 'subetuwebwp_page_header_template' );

}

/**
 * Checks if the page header is enabled
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_has_page_header' ) ) {

	function subetuwebwp_has_page_header() {

		// Define vars
		$return = true;
		$style  = subetuwebwp_page_header_style();

		// Check if page header
		if ( 'hide-all-devices' == get_theme_mod( 'subetuweb_page_header_visibility' )
			|| 'hidden' == $style
			|| is_page_template( 'templates/landing.php' ) ) {
			$return = false;
		}

		// Check if page header
		if ( 'hide-all-devices' == get_theme_mod( 'subetuweb_page_header_visibility' )
			|| 'hidden' == $style
			|| is_page_template( 'templates/sube.php' ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_display_page_header', $return );

	}
}

/**
 * Checks if the page header heading is enabled
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'subetuwebwp_has_page_header_heading' ) ) {

	function subetuwebwp_has_page_header_heading() {

		// Define vars
		$return = true;

		// Apply filters and return
		return apply_filters( 'subetuweb_display_page_header_heading', $return );

	}
}

/**
 * Returns page header style
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_page_header_style' ) ) {

	function subetuwebwp_page_header_style() {

		// Get default page header style defined in Customizer.
		$style = get_theme_mod( 'subetuweb_page_header_style' );

		// If featured image in page header.
		if ( true == get_theme_mod( 'subetuweb_blog_single_featured_image_title', false )
			&& is_singular( 'post' )
			&& has_post_thumbnail() ) {
			$style = 'background-image';
		}

		// Sanitize data.
		$style = ( 'default' == $style ) ? '' : $style;

		// Apply filters and return.
		return apply_filters( 'subetuweb_page_header_style', $style );

	}
}

/**
 * Return the title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_has_page_title' ) ) {

	function subetuwebwp_has_page_title() {

		// Default title is null
		$title = null;

		// Get post ID
		$post_id = subetuwebwp_post_id();

		// Homepage - display blog description if not a static page
		if ( is_front_page() && ! is_singular( 'page' ) ) {

			if ( get_bloginfo( 'description' ) ) {
				$title = get_bloginfo( 'description' );
			} else {
				$title = esc_html__( 'Recent Posts', 'subetuwebwp' );
			}

			// Homepage posts page
		} elseif ( is_home() && ! is_singular( 'page' ) ) {

			$title = get_the_title( get_option( 'page_for_posts', true ) );

		}

		// Search needs to go before archives
		elseif ( is_search() ) {
			global $wp_query;
			$title = '<span id="search-results-count">' . $wp_query->found_posts . '</span> ' . esc_html__( 'Search Results Found', 'subetuwebwp' );
		}

		// Archives
		elseif ( is_archive() ) {

			// Author
			if ( is_author() ) {
				$title = get_the_archive_title();
			}

			// Post Type archive title
			elseif ( is_post_type_archive() ) {
				$title = post_type_archive_title( '', false );
			}

			// Daily archive title
			elseif ( is_day() ) {
				$title = sprintf( esc_html__( 'Daily Archives: %s', 'subetuwebwp' ), get_the_date() );
			}

			// Monthly archive title
			elseif ( is_month() ) {
				$title = sprintf( esc_html__( 'Monthly Archives: %s', 'subetuwebwp' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'subetuwebwp' ) ) );
			}

			// Yearly archive title
			elseif ( is_year() ) {
				$title = sprintf( esc_html__( 'Yearly Archives: %s', 'subetuwebwp' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'subetuwebwp' ) ) );
			}

			// Categories/Tags/Other
			else {

				// Get term title
				$title = single_term_title( '', false );

				// Fix for plugins that are archives but use pages
				if ( ! $title ) {
					global $post;
					$title = get_the_title( $post_id );
				}
			}
		} // End is archive check

		// 404 Page
		elseif ( is_404() ) {

			$title = esc_html__( '404: Page Not Found', 'subetuwebwp' );

		}

		// Anything else with a post_id defined
		elseif ( $post_id ) {

			// Single Pages
			if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
				$title = get_the_title( $post_id );
			}

			// Single blog posts
			elseif ( is_singular( 'post' ) ) {

				if ( 'post-title' == get_theme_mod( 'subetuweb_blog_single_page_header_title', 'blog' ) ) {
					$title = get_the_title();
				} else {
					$title = esc_html__( 'Blog', 'subetuwebwp' );
				}
			}

			// Other posts
			else {

				$title = get_the_title( $post_id );

			}
		}

		// Last check if title is empty
		$title = $title ? $title : get_the_title();

		// Apply filters and return title
		return apply_filters( 'subetuweb_title', $title );

	}
}

/**
 * Returns page subheading
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_get_page_subheading' ) ) {

	function subetuwebwp_get_page_subheading() {

		// Subheading is NULL by default
		$subheading = null;

		// Search
		if ( is_search() ) {
			$subheading = esc_html__( 'You searched for:', 'subetuwebwp' ) . ' &quot;' . esc_html( get_search_query( false ) ) . '&quot;';
		}

		// Author
		elseif ( is_author() ) {
			$subheading = esc_html__( 'This author has written', 'subetuwebwp' ) . ' ' . get_the_author_posts() . ' ' . esc_html__( 'articles', 'subetuwebwp' );
		}

		// Archives
		elseif ( is_post_type_archive() ) {
			$subheading = get_the_archive_description();
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_post_subheading', $subheading );

	}
}

/**
 * Get taxonomy description
 *
 * @since 1.5.27
 */
if ( ! function_exists( 'subetuwebwp_get_tax_description' ) ) {

	function subetuwebwp_get_tax_description() {

		// Subheading is NULL by default
		$desc = null;

		// All other Taxonomies
		if ( is_category() || is_tag() ) {
			$desc = term_description();
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_tax_description', $desc );

	}
}

/**
 * Add taxonomy description
 *
 * @since 1.5.27
 */
if ( ! function_exists( 'subetuwebwp_tax_description' ) ) {

	function subetuwebwp_tax_description() {

		if ( $desc = subetuwebwp_get_tax_description() ) :
			?>

			<div class="clr tax-desc">
				<?php echo do_shortcode( $desc ); ?>
			</div>

			<?php
		endif;

	}

	add_action( 'subetuweb_before_content_inner', 'subetuwebwp_tax_description' );

}

/**
 * Display breadcrumbs
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_has_breadcrumbs' ) ) {

	function subetuwebwp_has_breadcrumbs() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'subetuweb_breadcrumbs', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_display_breadcrumbs', $return );

	}
}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_page_header_overlay' ) ) {

	function subetuwebwp_page_header_overlay() {

		// Define return
		$return = '';

		// Only needed for the background-image style so return otherwise
		if ( 'background-image' != subetuwebwp_page_header_style() ) {
			return;
		}

		// Return overlay element
		$return = '<span class="background-image-page-header-overlay"></span>';

		// Apply filters for child theming
		$return = apply_filters( 'subetuweb_page_header_overlay', $return );

		// Return
		echo wp_kses_post( $return );
	}
}

/**
 * Outputs Custom CSS for the page title overlay
 * Place this function before the page header css so the solid color setting works
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_page_header_overlay_css' ) ) {

	function subetuwebwp_page_header_overlay_css( $output ) {

		// Only needed for the background-image style so return otherwise
		if ( 'background-image' != subetuwebwp_page_header_style() ) {
			return;
		}

		// Global vars
		$opacity       = get_theme_mod( 'subetuweb_page_header_bg_image_overlay_opacity', '0.5' );
		$overlay_color = get_theme_mod( 'subetuweb_page_header_bg_image_overlay_color', '#000000' );

		if ( true == get_theme_mod( 'subetuweb_blog_single_featured_image_title', false )
			&& is_singular( 'post' ) ) {
			$opacity       = get_theme_mod( 'subetuweb_blog_single_title_bg_image_overlay_opacity', '0.5' );
			$overlay_color = get_theme_mod( 'subetuweb_blog_single_title_bg_image_overlay_color', '#000000' );
		}

		$opacity       = $opacity ? $opacity : '0.5';
		$opacity       = apply_filters( 'subetuweb_post_title_bg_overlay', $opacity );
		$overlay_color = $overlay_color ? $overlay_color : '#000000';
		$overlay_color = apply_filters( 'subetuweb_post_title_bg_overlay_color', $overlay_color );

		// Define css var
		$css = '';

		// Get page header overlayopacity
		if ( ! empty( $opacity ) && '0.5' != $opacity ) {
			$css .= 'opacity:' . $opacity . ';';
		}

		// Get page header overlay color
		if ( ! empty( $overlay_color ) && '#000000' != $overlay_color ) {
			$css .= 'background-color:' . $overlay_color . ';';
		}

		// Return CSS
		if ( ! empty( $css ) ) {
			$output .= '.background-image-page-header-overlay{' . $css . '}';
		}

		// Return output css
		return $output;

	}

	add_filter( 'subetuweb_head_css', 'subetuwebwp_page_header_overlay_css' );

}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_page_header_css' ) ) {

	function subetuwebwp_page_header_css( $output ) {

		// Return output if page header is disabled
		if ( ! subetuwebwp_has_page_header() ) {
			return $output;
		}

		// Define var
		$css = '';

		// Customize background color
		$bg_color = get_theme_mod( 'subetuweb_page_header_background', '#f5f5f5' );

		$bg_color = $bg_color ? $bg_color : '#f5f5f5';
		$bg_color = apply_filters( 'subetuweb_post_title_background_color', $bg_color );

		if ( ! empty( $bg_color ) && '#f5f5f5' != $bg_color ) {
			$css .= 'background-color: ' . $bg_color . ';';
		}

		// Background image Style
		if ( subetuwebwp_page_header_style() == 'background-image' ) {

			// Add background image
			$bg_img = get_theme_mod( 'subetuweb_page_header_bg_image' );

			if ( true == get_theme_mod( 'subetuweb_blog_single_featured_image_title', false )
				&& is_singular( 'post' )
				&& has_post_thumbnail() ) {
				$bg_img = get_the_post_thumbnail_url();
			}

			// Put the filter before generating the image url
			$bg_img = apply_filters( 'subetuweb_page_header_background_image', $bg_img );

			// Generate image URL if using ID
			if ( is_numeric( $bg_img ) ) {
				$bg_img = wp_get_attachment_image_src( $bg_img, 'full' );
				$bg_img = $bg_img[0];
			}

			$bg_img = $bg_img ? $bg_img : null;
			$bg_img = $bg_img;

			// Immage attrs
			$bg_img_position   = get_theme_mod( 'subetuweb_page_header_bg_image_position', 'top center' );
			$bg_img_attachment = get_theme_mod( 'subetuweb_page_header_bg_image_attachment', 'initial' );
			$bg_img_repeat     = get_theme_mod( 'subetuweb_page_header_bg_image_repeat', 'no-repeat' );
			$bg_img_size       = get_theme_mod( 'subetuweb_page_header_bg_image_size', 'cover' );

			// If image attrs from single post section
			if ( true == get_theme_mod( 'subetuweb_blog_single_featured_image_title', false )
				&& is_singular( 'post' ) ) {
				$bg_img_position   = get_theme_mod( 'subetuweb_blog_single_title_bg_image_position', 'top center' );
				$bg_img_attachment = get_theme_mod( 'subetuweb_blog_single_title_bg_image_attachment', 'initial' );
				$bg_img_repeat     = get_theme_mod( 'subetuweb_blog_single_title_bg_image_repeat', 'no-repeat' );
				$bg_img_size       = get_theme_mod( 'subetuweb_blog_single_title_bg_image_size', 'cover' );
			}

			$bg_img_position   = $bg_img_position ? $bg_img_position : 'top center';
			$bg_img_position   = apply_filters( 'subetuweb_post_title_bg_image_position', $bg_img_position );
			$bg_img_attachment = $bg_img_attachment ? $bg_img_attachment : 'initial';
			$bg_img_attachment = apply_filters( 'subetuweb_post_title_bg_image_attachment', $bg_img_attachment );
			$bg_img_repeat     = $bg_img_repeat ? $bg_img_repeat : 'no-repeat';
			$bg_img_repeat     = apply_filters( 'subetuweb_post_title_bg_image_repeat', $bg_img_repeat );
			$bg_img_size       = $bg_img_size ? $bg_img_size : 'cover';
			$bg_img_size       = apply_filters( 'subetuweb_post_title_bg_image_size', $bg_img_size );

			if ( $bg_img ) {

				// Add css for background image
				$css .= 'background-image: url( ' . $bg_img . ' ) !important;';

				// Background position
				if ( ! empty( $bg_img_position ) && 'top center' != $bg_img_position && 'initial' != $bg_img_position ) {
					$css .= 'background-position:' . $bg_img_position . ';';
				}

				// Background attachment
				if ( ! empty( $bg_img_attachment ) && 'initial' != $bg_img_attachment ) {
					$css .= 'background-attachment:' . $bg_img_attachment . ';';
				}

				// Background repeat
				if ( ! empty( $bg_img_repeat ) && 'no-repeat' != $bg_img_repeat && 'initial' != $bg_img_repeat ) {
					$css .= 'background-repeat:' . $bg_img_repeat . ';';
				}

				// Background size
				if ( ! empty( $bg_img_size ) && 'cover' != $bg_img_size && 'initial' != $bg_img_size ) {
					$css .= 'background-size:' . $bg_img_size . ';';
				}
			}

			// Custom height
			$title_height = get_theme_mod( 'subetuweb_page_header_bg_image_height', '400' );

			if ( true == get_theme_mod( 'subetuweb_blog_single_featured_image_title', false )
				&& is_singular( 'post' ) ) {
				$title_height = get_theme_mod( 'subetuweb_blog_single_title_bg_image_height', '400' );
			}

			$title_height = $title_height ? $title_height : '400';
			$title_height = apply_filters( 'subetuweb_post_title_height', $title_height );

			if ( ! empty( $title_height ) && '400' != $title_height ) {
				$css .= 'height:' . $title_height . 'px;';
			}
		}

		// Apply all css to the page-header class
		if ( ! empty( $css ) ) {
			$css = '.page-header { ' . $css . ' }';
		}

		// If css var isn't empty add to custom css output
		if ( ! empty( $css ) ) {
			$output .= $css;
		}

		// Return output
		return $output;

	}

	add_filter( 'subetuweb_head_css', 'subetuwebwp_page_header_css' );

}

/*
-------------------------------------------------------------------------------*/
/*
 [ Blog ]
/*-------------------------------------------------------------------------------*/

/**
 * Adds post classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_blog_wrap_classes' ) ) {

	function subetuwebwp_blog_wrap_classes( $classes = null ) {

		// Return custom class if set
		if ( $classes ) {
			return $classes;
		}

		// Admin defaults
		$style   = subetuwebwp_blog_entry_style();
		$classes = array( 'entries', 'clr' );

		// Isotope classes
		if ( $style == 'grid-entry' ) {
			$classes[] = 'subetuwebwp-row';
			if ( 'masonry' == subetuwebwp_blog_grid_style() ) {
				$classes[] = 'blog-masonry-grid';
			} else {
				$classes[] = 'blog-grid';
			}
		}

		// Equal heights
		if ( subetuwebwp_blog_entry_equal_heights() ) {
			$classes[] = 'blog-equal-heights';
		}

		// Infinite scroll class
		if ( 'infinite_scroll' == subetuwebwp_blog_pagination_style() ) {
			$classes[] = 'infinite-scroll-wrap';
		}

		// Add filter for child theming
		$classes = apply_filters( 'subetuweb_blog_wrap_classes', $classes );

		// Turn classes into space seperated string
		if ( is_array( $classes ) ) {
			$classes = implode( ' ', $classes );
		}

		// Echo classes
		echo esc_attr( $classes );

	}
}

/**
 * Adds entry classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_post_entry_classes' ) ) {

	function subetuwebwp_post_entry_classes() {

		// Define classes array
		$classes = array();

		// Entry Style
		$entry_style = subetuwebwp_blog_entry_style();

		// Core classes
		$classes[] = 'blog-entry';
		$classes[] = 'clr';

		// Masonry classes
		if ( 'masonry' == subetuwebwp_blog_grid_style() ) {
			$classes[] = 'isotope-entry';
		}

		// Add columns for grid style entries
		if ( $entry_style == 'grid-entry' ) {
			$classes[]     = 'col';
				$classes[] = subetuwebwp_grid_class( subetuwebwp_blog_entry_columns() );

			// Counter
			global $subetuwebwp_count;
			if ( $subetuwebwp_count ) {
				$classes[] = 'col-' . $subetuwebwp_count;
			}
		}

		// No Featured Image Class, don't add if oembed or self hosted meta are defined
		if ( ! has_post_thumbnail()
			&& '' == get_post_meta( get_the_ID(), 'subetuweb_post_self_hosted_shortcode', true )
			&& '' == get_post_meta( get_the_ID(), 'subetuweb_post_oembed', true ) ) {
			$classes[] = 'no-featured-image';
		}

		// Infinite scroll class
		if ( 'infinite_scroll' == subetuwebwp_blog_pagination_style() ) {
			$classes[] = 'item-entry';
		}

		// Blog entry style
		$classes[] = $entry_style;

		// Apply filters to entry post class for child theming
		$classes = apply_filters( 'subetuweb_blog_entry_classes', $classes );

		// Rturn classes array
		return $classes;

	}
}

/**
 * Returns correct style for the blog entry based on the customizer
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_style' ) ) {

	function subetuwebwp_blog_entry_style() {

		// Get default style from Customizer
		$style = get_theme_mod( 'subetuweb_blog_style', 'large-entry' );

		// Sanitize
		$style = $style ? $style : 'large-entry';

		// Apply filters for child theming
		$style = apply_filters( 'subetuweb_blog_entry_style', $style );

		// Return style
		return $style;

	}
}

/**
 * Returns correct images size
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_images_size' ) ) {

	function subetuwebwp_blog_entry_images_size() {

		// Get default size from Customizer
		$size = get_theme_mod( 'subetuweb_blog_grid_images_size', 'medium' );

		// Sanitize
		$size = $size ? $size : 'medium';

		// Apply filters for child theming
		$size = apply_filters( 'subetuweb_blog_entry_images_size', $size );

		// Return size
		return $size;

	}
}

/**
 * Returns the grid style
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_grid_style' ) ) {

	function subetuwebwp_blog_grid_style() {

		// Get default style from Customizer
		$style = get_theme_mod( 'subetuweb_blog_grid_style', 'fit-rows' );

		// Sanitize
		$style = $style ? $style : 'fit-rows';

		// Apply filters for child theming
		$style = apply_filters( 'subetuweb_blog_grid_style', $style );

		// Return style
		return $style;

	}
}

/**
 * Checks if it's a fit-rows style grid
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_fit_rows' ) ) {

	function subetuwebwp_blog_fit_rows() {

		// Return false by default
		$return = false;

		// Get current blog style
		if ( 'grid-entry' == subetuwebwp_blog_entry_style() ) {
			$return = true;
		} else {
			$return = false;
		}

		// Apply filters for child theming
		$return = apply_filters( 'subetuweb_blog_fit_rows', $return );

		// Return bool
		return $return;

	}
}

/**
 * Checks if the blog entries should have equal heights
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_equal_heights' ) ) {

	function subetuwebwp_blog_entry_equal_heights() {
		if ( ! get_theme_mod( 'subetuweb_blog_grid_equal_heights', false ) ) {
			return false;
		}
		$entry_style = subetuwebwp_blog_entry_style();
		if ( 'grid-entry' == $entry_style
			&& 'masonry' != subetuwebwp_blog_grid_style() ) {
			return true;
		}
	}
}

/**
 * Returns correct columns for the blog entries
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_columns' ) ) {

	function subetuwebwp_blog_entry_columns() {

		// Get columns from customizer setting
		$columns = get_theme_mod( 'subetuweb_blog_grid_columns', '2' );

		// Sanitize
		$columns = $columns ? $columns : '2';

		// Apply filters for child theming
		$columns = apply_filters( 'subetuweb_blog_entry_columns', $columns );

		// Return columns
		return $columns;

	}
}

/**
 * Check if the post has a gallery
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_post_has_gallery' ) ) {

	function subetuwebwp_post_has_gallery( $post_id = '' ) {

		$post_id = $post_id ? $post_id : get_the_ID();

		if ( get_post_meta( $post_id, 'subetuweb_gallery_id', true ) ) {
			return true;
		}

	}
}

/**
 * Retrieve attachment IDs
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_get_gallery_ids' ) ) {

	function subetuwebwp_get_gallery_ids( $post_id = '' ) {

		$post_id        = $post_id ? $post_id : get_the_ID();
		$attachment_ids = get_post_meta( $post_id, 'subetuweb_gallery_id', true );

		if ( $attachment_ids ) {
			return $attachment_ids;
		}

	}
}

/**
 * Retrieve attachment data
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_get_attachment' ) ) {

	function subetuwebwp_get_attachment( $id ) {

		$attachment = get_post( $id );

		return array(
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'     => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href'        => get_permalink( $attachment->ID ),
			'src'         => $attachment->guid,
			'title'       => $attachment->post_title,
		);

	}
}

/**
 * Return gallery count
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_gallery_count' ) ) {

	function subetuwebwp_gallery_count() {

		$ids = subetuwebwp_get_gallery_ids();
		return count( $ids );

	}
}

/**
 * Returns post media
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_get_post_media' ) ) {

	function subetuwebwp_get_post_media( $post_id = '' ) {

		// Define video variable
		$video = '';

		// Get correct ID
		$post_id = $post_id ? $post_id : get_the_ID();

		// Embed
		if ( $meta = get_post_meta( $post_id, 'subetuweb_post_video_embed', true ) ) {
			$video = $meta;
		}

		// Check for self-hosted first
		elseif ( $meta = get_post_meta( $post_id, 'subetuweb_post_self_hosted_media', true ) ) {
			$video = $meta;
		}

		// Check for post oembed
		elseif ( $meta = get_post_meta( $post_id, 'subetuweb_post_oembed', true ) ) {
			$video = $meta;
		}

		// Apply filters for child theming
		$video = apply_filters( 'subetuweb_get_post_video', $video );

		// Return data
		return $video;

	}
}

/**
 * Returns post video HTML
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_get_post_video_html' ) ) {

	function subetuwebwp_get_post_video_html( $video = '' ) {

		// Get video
		$video = $video ? $video : subetuwebwp_get_post_media();

		// Return if video is empty
		if ( empty( $video ) ) {
			return;
		}

		// Check post format for standard post type
		if ( 'post' == get_post_type() && 'video' != get_post_format() ) {
			return;
		}

		// Get oembed code and return
		if ( ! is_wp_error( $oembed = wp_oembed_get( $video ) ) && $oembed ) {
			return '<div class="responsive-video-wrap">' . $oembed . '</div>';
		}

		// Display using apply_filters if it's self-hosted
		else {

			$video = apply_filters( 'the_content', $video );

			// Add responsive video wrap for youtube/vimeo embeds
			if ( strpos( $video, 'youtube' ) || strpos( $video, 'vimeo' ) ) {
				return '<div class="responsive-video-wrap">' . $video . '</div>';
			}

			// Else return without responsive wrap
			else {
				return $video;
			}
		}

	}
}

/**
 * Returns post audio
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_get_post_audio_html' ) ) {

	function subetuwebwp_get_post_audio_html( $audio = '' ) {

		// Get audio
		$audio = $audio ? $audio : subetuwebwp_get_post_media();

		// Return if audio is empty
		if ( empty( $audio ) ) {
			return;
		}

		// Check post format for standard post type
		if ( 'post' == get_post_type() && 'audio' != get_post_format() ) {
			return;
		}

		// Get oembed code and return
		if ( ! is_wp_error( $oembed = wp_oembed_get( $audio ) ) && $oembed ) {
			return '<div class="responsive-video-wrap">' . $oembed . '</div>';
		}

		// Display using apply_filters if it's self-hosted
		else {

			$audio = apply_filters( 'the_content', $audio );

			// Add responsive audio wrap for youtube/vimeo embeds
			if ( strpos( $audio, 'youtube' ) || strpos( $audio, 'vimeo' ) ) {
				return '<div class="responsive-video-wrap">' . $audio . '</div>';
			}

			// Else return without responsive wrap
			else {
				return $audio;
			}
		}

	}
}

/**
 * Returns blog entry elements for the customizer
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_elements' ) ) {

	function subetuwebwp_blog_entry_elements() {

		// Default elements
		$elements = apply_filters(
			'subetuweb_blog_entry_elements',
			array(
				'featured_image' => esc_html__( 'Featured Image', 'subetuwebwp' ),
				'title'          => esc_html__( 'Title', 'subetuwebwp' ),
				'meta'           => esc_html__( 'Meta', 'subetuwebwp' ),
				'content'        => esc_html__( 'Content', 'subetuwebwp' ),
				'read_more'      => esc_html__( 'Read More', 'subetuwebwp' ),
			)
		);

		// Return elements
		return $elements;

	}
}

/**
 * Returns blog entry elements positioning
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_elements_positioning' ) ) {

	function subetuwebwp_blog_entry_elements_positioning() {

		// Default sections
		$sections = array( 'featured_image', 'title', 'meta', 'content', 'read_more' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'subetuweb_blog_entry_elements_positioning', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'subetuweb_blog_entry_elements_positioning', $sections );

		// Return sections
		return $sections;

	}
}

/**
 * Returns blog entry meta
 *
 * @since 1.0.5.1
 */
if ( ! function_exists( 'subetuwebwp_blog_entry_meta' ) ) {

	function subetuwebwp_blog_entry_meta() {

		// Default sections
		$sections = array( 'author', 'date', 'categories', 'comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'subetuweb_blog_entry_meta', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'subetuweb_blog_entry_meta', $sections );

		// Return sections
		return $sections;

	}
}

/**
 * Returns blog single elements for the customizer
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'subetuwebwp_blog_single_elements' ) ) {

	function subetuwebwp_blog_single_elements() {

		// Default elements
		$elements = apply_filters(
			'subetuweb_blog_single_elements',
			array(
				'featured_image'  => esc_html__( 'Featured Image', 'subetuwebwp' ),
				'title'           => esc_html__( 'Title', 'subetuwebwp' ),
				'meta'            => esc_html__( 'Meta', 'subetuwebwp' ),
				'content'         => esc_html__( 'Content', 'subetuwebwp' ),
				'tags'            => esc_html__( 'Tags', 'subetuwebwp' ),
				'social_share'    => esc_html__( 'Social Share', 'subetuwebwp' ),
				'next_prev'       => esc_html__( 'Next/Prev Links', 'subetuwebwp' ),
				'author_box'      => esc_html__( 'Author Box', 'subetuwebwp' ),
				'related_posts'   => esc_html__( 'Related Posts', 'subetuwebwp' ),
				'single_comments' => esc_html__( 'Comments', 'subetuwebwp' ),
			)
		);

		// Return elements
		return $elements;

	}
}

/**
 * Returns blog single elements positioning
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'subetuwebwp_blog_single_elements_positioning' ) ) {

	function subetuwebwp_blog_single_elements_positioning() {

		// Default sections
		$sections = array( 'featured_image', 'title', 'meta', 'content', 'tags', 'social_share', 'next_prev', 'author_box', 'related_posts', 'single_comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'subetuweb_blog_single_elements_positioning', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'subetuweb_blog_single_elements_positioning', $sections );

		// Return sections
		return $sections;

	}
}

/**
 * Returns blog single meta
 *
 * @since 1.0.5.1
 */
if ( ! function_exists( 'subetuwebwp_blog_single_meta' ) ) {

	function subetuwebwp_blog_single_meta() {

		// Default sections
		$sections = array( 'author', 'date', 'categories', 'comments' );

		// Get sections from Customizer
		$sections = get_theme_mod( 'subetuweb_blog_single_meta', $sections );

		// Turn into array if string
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		// Apply filters for easy modification
		$sections = apply_filters( 'subetuweb_blog_single_meta', $sections );

		// Return sections
		return $sections;

	}
}

/**
 * Returns reading time
 *
 * @since 1.8.4
*/
if ( ! function_exists( 'subetuweb_reading_time' ) ) {

	function subetuweb_reading_time() {

		global $post;

		$content      = get_post_field( 'post_content', $post->ID );
		$word_count   = str_word_count( $content );
		$reading_time = ceil( $word_count / 200 );

		$reading_time = apply_filters( 'subetuwebwp_post_reading_time', $reading_time );

		$owp_reading_time = printf(
			/* translators: 1: post reading time. */
			esc_html__( '%1$s mins read', 'subetuwebwp' ),
			number_format_i18n( $reading_time )
		);
	}
}

/**
 * Comments and pingbacks
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_comment' ) ) {

	function subetuwebwp_comment( $comment, $args, $depth ) {

		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.
				?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<article id="comment-<?php comment_ID(); ?>" class="comment-container">
				<p><?php esc_html_e( 'Pingback:', 'subetuwebwp' ); ?> <span <?php subetuwebwp_schema_markup( 'author_name' ); ?>><?php comment_author_link(); ?></span> <?php edit_comment_link( esc_html__( '(Edit)', 'subetuwebwp' ), '<span class="edit-link">', '</span>' ); ?></p>
			</article>

				<?php
				break;
			default:
				// Proceed with normal comments.
				global $post;
				?>

			<li id="comment-<?php comment_ID(); ?>" class="comment-container">

				<article <?php comment_class( 'comment-body' ); ?>>

				<?php echo get_avatar( $comment, apply_filters( 'subetuweb_comment_avatar_size', 150 ) ); ?>

					<div class="comment-content">
						<div class="comment-author">
							<span class="comment-link"><?php printf( esc_html__( '%s ', 'subetuwebwp' ), sprintf( '%s', get_comment_author_link() ) ); ?></span>

							<span class="comment-meta commentmetadata">
							<?php if ( ! is_rtl() ) { ?>
									<span class="comment-date"><?php comment_date( 'j M Y' ); ?></span>
								<?php } ?>

							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);
							?>

							<?php edit_comment_link( __( 'edit', 'subetuwebwp' ) ); ?>
							<?php subetuweb_delete_comment_link(); ?>

							<?php if ( is_rtl() ) { ?>
									<span class="comment-date"><?php comment_date( 'j M Y' ); ?></span>
								<?php } ?>
							</span>
						</div>

						<div class="clr"></div>

						<div class="comment-entry">
						<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'subetuwebwp' ); ?></p>
							<?php endif; ?>

							<div class="comment-content">
							<?php comment_text(); ?>
							</div>
						</div>
					</div>

				</article><!-- #comment-## -->

				<?php
				break;
		endswitch; // end comment_type check
	}
}

/**
 * Comment fields
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_modify_comment_form_fields' ) ) {

	function subetuwebwp_modify_comment_form_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );

		// Labels.
		if ( $req ) {
			$comment_name  = subetuwebwp_theme_strings( 'owp-string-comment-name-req', false, 'subetuwebwp' );
			$comment_email = subetuwebwp_theme_strings( 'owp-string-comment-email-req', false, 'subetuwebwp' );
		} else {
			$comment_name  = subetuwebwp_theme_strings( 'owp-string-comment-name', false, 'subetuwebwp' );
			$comment_email = subetuwebwp_theme_strings( 'owp-string-comment-email', false, 'subetuwebwp' );
		}

		$comment_site = subetuwebwp_theme_strings( 'owp-string-comment-website', false, 'subetuwebwp' );

		$fields['author'] = '<div class="comment-form-author"><label for="author" class="screen-reader-text">' . esc_html__( 'Enter your name or username to comment', 'subetuwebwp' ) . '</label><input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . $comment_name . '" size="22" tabindex="0"' . ( $req ? ' aria-required="true"' : '' ) . ' class="input-name" /></div>';

		$fields['email'] = '<div class="comment-form-email"><label for="email" class="screen-reader-text">' . esc_html__( 'Enter your email address to comment', 'subetuwebwp' ) . '</label><input type="text" name="email" id="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . $comment_email . '" size="22" tabindex="0"' . ( $req ? ' aria-required="true"' : '' ) . ' class="input-email" /></div>';

		$fields['url'] = '<div class="comment-form-url"><label for="url" class="screen-reader-text">' . esc_html__( 'Enter your website URL (optional)', 'subetuwebwp' ) . '</label><input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . $comment_site . '" size="22" tabindex="0" class="input-website" /></div>';

		return $fields;

	}

	add_filter( 'comment_form_default_fields', 'subetuwebwp_modify_comment_form_fields' );

}

/**
 * Numbered Pagination
 *
 * @since   1.0.0
 * @link    https://codex.wordpress.org/Function_Reference/paginate_links
 */
if ( ! function_exists( 'subetuwebwp_pagination' ) ) {

	function subetuwebwp_pagination( $query = '', $echo = true ) {

		// Arrows with RTL support
		if ( $echo ) {
			$prev_arrow = is_rtl() ? subetuwebwp_icon( 'angle_right', false ) : subetuwebwp_icon( 'angle_left', false );
			$next_arrow = is_rtl() ? subetuwebwp_icon( 'angle_left', false ) : subetuwebwp_icon( 'angle_right', false );
		} else {
			$prev_arrow = is_rtl() ? subetuwebwp_icon( 'angle_right' ) : subetuwebwp_icon( 'angle_left' );
			$next_arrow = is_rtl() ? subetuwebwp_icon( 'angle_left' ) : subetuwebwp_icon( 'angle_right' );
		}

		// Get global $query
		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set vars
		$total = $query->max_num_pages;
		$big   = 999999999;

		// Display pagination if total var is greater then 1 ( current query is paginated )
		if ( $total > 1 ) {

			// Get current page
			if ( $current_page = get_query_var( 'paged' ) ) {
				$current_page = $current_page;
			} elseif ( $current_page = get_query_var( 'page' ) ) {
				$current_page = $current_page;
			} else {
				$current_page = 1;
			}

			// Get permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				if ( is_page() ) {
					$format = 'page/%#%/';
				} else {
					$format = '/%#%/';
				}
			} else {
				$format = '&paged=%#%';
			}

			$args = apply_filters(
				'subetuweb_pagination_args',
				array(
					'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
					'format'    => $format,
					'current'   => max( 1, $current_page ),
					'total'     => $total,
					'mid_size'  => 3,
					'type'      => 'list',
					'prev_text' => '<span class="screen-reader-text">' . esc_attr__( 'Go to the previous page', 'subetuwebwp' ) . '</span>' . $prev_arrow,
					'next_text' => '<span class="screen-reader-text">' . esc_attr__( 'Go to the next page', 'subetuwebwp' ) . '</span>' . $next_arrow,
				)
			);

			// Output pagination
			if ( $echo ) {
				echo '<div class="subetuwebwp-pagination clr">' . paginate_links( $args ) . '</div>';
			} else {
				return '<div class="subetuwebwp-pagination clr">' . paginate_links( $args ) . '</div>';
			}
		}
	}
}

/**
 * Next and previous pagination
 *
 * @since   1.0.0
 */
if ( ! function_exists( 'subetuwebwp_pagejump' ) ) {

	function subetuwebwp_pagejump( $pages = '', $range = 4, $echo = true ) {

		// Vars
		global $wp_query;
		$output = '';

		// Display next/previous pagination
		if ( $wp_query->max_num_pages > 1 ) {

			$output         .= '<div class="page-jump clr">';
				$output     .= '<div class="alignleft newer-posts">';
					$output .= get_previous_posts_link( '<span aria-hidden="true">&larr;</span> ' . esc_attr__( 'Newer Posts', 'subetuwebwp' ) );
				$output     .= '</div>';
				$output     .= '<div class="alignright older-posts">';
					$output .= get_next_posts_link( esc_attr__( 'Older Posts', 'subetuwebwp' ) . ' <span aria-hidden="true">&rarr;</span>' );
				$output     .= '</div>';
			$output         .= '</div>';

			if ( $echo ) {
				echo wp_kses_post( $output );
			} else {
				return $output;
			}
		}

	}
}

/**
 * Blog Pagination
 * Used to load the correct pagination function for blog archives
 * Execute the correct pagination function based on the theme settings
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_blog_pagination' ) ) {

	function subetuwebwp_blog_pagination() {

		// Admin Options
		$blog_style       = get_theme_mod( 'subetuweb_blog_style', 'large-entry' );
		$pagination_style = get_theme_mod( 'subetuweb_blog_pagination_style', 'standard' );

		// Category based settings
		if ( is_category() ) {

			// Get taxonomy meta
			$term       = get_query_var( 'cat' );
			$term_data  = get_option( 'category_' . $term );
			$term_style = $term_pagination = '';

			if ( isset( $term_data['subetuwebwp_term_style'] ) ) {
				$term_style = '' != $term_data['subetuwebwp_term_style'] ? $term_data['subetuwebwp_term_style'] . '' : $term_style;
			}

			if ( isset( $term_data['subetuwebwp_term_pagination'] ) ) {
				$term_pagination = '' != $term_data['subetuwebwp_term_pagination'] ? $term_data['subetuwebwp_term_pagination'] . '' : '';
			}

			if ( $term_pagination ) {
				$pagination_style = $term_pagination;
			}
		}

		// Set default $type for infnite scroll
		if ( 'grid-entry' == $blog_style ) {
			$infinite_type = 'standard-grid';
		} else {
			$infinite_type = 'standard';
		}

		// Execute the correct pagination function
		if ( 'infinite_scroll' == $pagination_style ) {
			subetuwebwp_infinite_scroll( $infinite_type );
		} elseif ( $pagination_style == 'next_prev' ) {
			subetuwebwp_pagejump();
		} else {
			subetuwebwp_pagination();
		}

	}
}

/**
 * Returns the correct pagination style
 *
 * @since 1.0.4
 */
if ( ! function_exists( 'subetuwebwp_blog_pagination_style' ) ) {

	function subetuwebwp_blog_pagination_style() {

		// Get default style from Customizer
		$style = get_theme_mod( 'subetuweb_blog_pagination_style', 'standard' );

		// Apply filters for child theming
		$style = apply_filters( 'subetuweb_blog_pagination_style', $style );

		// Return style
		return $style;
	}
}

/**
 * Get excerpt
 *
 * @since 1.5.6
 */
if ( ! function_exists( 'subetuwebwp_excerpt' ) ) {

	function subetuwebwp_excerpt( $length = 30 ) {
		global $post;
		$output = '';

		// Check for custom excerpt
		if ( isset( $post->ID ) && has_excerpt( $post->ID ) ) {
			$output = $post->post_excerpt;
		}

		// No custom excerpt
		elseif ( isset( $post->post_content ) ) {

			// Check for more tag and return content if it exists
			if ( strpos( $post->post_content, '<!--more-->' ) ) {
				$output = apply_filters( 'the_content', get_the_content() );
			}

			// No more tag defined
			else {
				$output = wp_trim_words( strip_shortcodes( $post->post_content ), $length );
			}
		}

		$output = apply_filters( 'subetuwebwp_excerpt', $output );

		return $output;

	}
}

/*
-------------------------------------------------------------------------------*/
/*
 [ Footer ]
/*-------------------------------------------------------------------------------*/

/**
 * Display footer bottom
 *
 * @since 1.1.2
 */
if ( ! function_exists( 'subetuwebwp_display_footer_bottom' ) ) {

	function subetuwebwp_display_footer_bottom() {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'subetuweb_footer_bottom', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'subetuweb_display_footer_bottom', $return );

	}
}

/**
 * Footer template
 * I make a function to be able to remove it for the Beaver Themer plugin
 *
 * @since 1.2.5
 */
if ( ! function_exists( 'subetuwebwp_footer_template' ) ) {

	function subetuwebwp_footer_template() {

		if ( subetuwebwp_display_footer_bottom() ) {
			get_template_part( 'partials/footer/layout' );
		}

	}

	add_action( 'subetuweb_footer', 'subetuwebwp_footer_template' );

}

/**
 * Add classes to the footer wrap
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_footer_classes' ) ) {

	function subetuwebwp_footer_classes() {

		// Setup classes array
		$classes = array();

		// Default class
		$classes[] = 'site-footer';

		// Parallax footer
		if ( 'on' == get_theme_mod( 'subetuweb_parallax_footer', 'off' ) ) {
			$classes[] = 'parallax-footer';
		}

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters for child theming
		$classes = apply_filters( 'subetuweb_footer_classes', $classes );

		// Turn classes into space seperated string
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;

	}
}

/*
-------------------------------------------------------------------------------*/
/*
 [ Other ]
/*-------------------------------------------------------------------------------*/

/**
 * Return padding/margin values for customizer
 *
 * @since 1.4.9
 */
if ( ! function_exists( 'subetuwebwp_spacing_css' ) ) {

	function subetuwebwp_spacing_css( $top, $right, $bottom, $left ) {

		// Add px and 0 if no value
		$s_top    = ( isset( $top ) && '' !== $top ) ? intval( $top ) . 'px ' : '0px ';
		$s_right  = ( isset( $right ) && '' !== $right ) ? intval( $right ) . 'px ' : '0px ';
		$s_bottom = ( isset( $bottom ) && '' !== $bottom ) ? intval( $bottom ) . 'px ' : '0px ';
		$s_left   = ( isset( $left ) && '' !== $left ) ? intval( $left ) . 'px' : '0px';

		// Return one value if it is the same on every inputs
		if ( ( intval( $s_top ) === intval( $s_right ) )
			&& ( intval( $s_right ) === intval( $s_bottom ) )
			&& ( intval( $s_bottom ) === intval( $s_left ) ) ) {
			return $s_left;
		}

		// Return
		return $s_top . $s_right . $s_bottom . $s_left;
	}
}

/**
 * Translation support
 *
 * @since 1.3.7
 */
if ( ! function_exists( 'subetuwebwp_hamburgers_styles' ) ) {

	function subetuwebwp_hamburgers_styles() {

		// Styles
		$style = array(
			'default'     => esc_html__( 'Default Icon', 'subetuwebwp' ),
			'3dx'         => esc_html__( '3D X', 'subetuwebwp' ),
			'3dx-r'       => esc_html__( '3D X Reverse', 'subetuwebwp' ),
			'3dy'         => esc_html__( '3D Y', 'subetuwebwp' ),
			'3dy-r'       => esc_html__( '3D Y Reverse', 'subetuwebwp' ),
			'3dxy'        => esc_html__( '3D XY', 'subetuwebwp' ),
			'3dxy-r'      => esc_html__( '3D XY Reverse', 'subetuwebwp' ),
			'arrow'       => esc_html__( 'Arrow', 'subetuwebwp' ),
			'arrow-r'     => esc_html__( 'Arrow Reverse', 'subetuwebwp' ),
			'arrowalt'    => esc_html__( 'Arrowalt', 'subetuwebwp' ),
			'arrowalt-r'  => esc_html__( 'Arrowalt Reverse', 'subetuwebwp' ),
			'arrowturn'   => esc_html__( 'Arrowturn', 'subetuwebwp' ),
			'arrowturn-r' => esc_html__( 'Arrowturn Reverse', 'subetuwebwp' ),
			'boring'      => esc_html__( 'Boring', 'subetuwebwp' ),
			'collapse'    => esc_html__( 'Collapse', 'subetuwebwp' ),
			'collapse-r'  => esc_html__( 'Collapse Reverse', 'subetuwebwp' ),
			'elastic'     => esc_html__( 'Elastic', 'subetuwebwp' ),
			'elastic-r'   => esc_html__( 'Elastic Reverse', 'subetuwebwp' ),
			'minus'       => esc_html__( 'Minus', 'subetuwebwp' ),
			'slider'      => esc_html__( 'Slider', 'subetuwebwp' ),
			'slider-r'    => esc_html__( 'Slider Reverse', 'subetuwebwp' ),
			'spin'        => esc_html__( 'Spin', 'subetuwebwp' ),
			'spin-r'      => esc_html__( 'Spin Reverse', 'subetuwebwp' ),
			'spring'      => esc_html__( 'Spring', 'subetuwebwp' ),
			'spring-r'    => esc_html__( 'Spring Reverse', 'subetuwebwp' ),
			'stand'       => esc_html__( 'Stand', 'subetuwebwp' ),
			'stand-r'     => esc_html__( 'Stand Reverse', 'subetuwebwp' ),
			'squeeze'     => esc_html__( 'Squeeze', 'subetuwebwp' ),
			'vortex'      => esc_html__( 'Vortex', 'subetuwebwp' ),
			'vortex-r'    => esc_html__( 'Vortex Reverse', 'subetuwebwp' ),
		);

		// Apply filters for child theming
		$style = apply_filters( 'subetuweb_hamburgers_styles', $style );

		// Return
		return $style;

	}
}

/**
 * Translation support
 *
 * @since 1.1.4
 */
if ( ! function_exists( 'subetuwebwp_tm_translation' ) ) {

	function subetuwebwp_tm_translation( $id, $val = '' ) {

		// Translate theme mod val
		if ( $val ) {

			// Polylang Translation
			if ( function_exists( 'pll__' ) && $id ) {
				$val = pll__( $val );
			}

			// Return the value
			return $val;

		}

	}
}

/**
 * Register translation strings
 *
 * @since 1.1.4
 */
if ( ! function_exists( 'subetuwebwp_register_tm_strings' ) ) {

	function subetuwebwp_register_tm_strings() {

		return apply_filters(
			'subetuweb_register_tm_strings',
			array(
				'subetuweb_top_bar_content'                 => '',
				'subetuweb_after_header_content'            => '',
				'subetuweb_mobile_menu_text'                => esc_html__( 'Menu', 'subetuwebwp' ),
				'subetuweb_mobile_menu_close_text'          => esc_html__( 'Close', 'subetuwebwp' ),
				'subetuweb_mobile_menu_close_btn_text'      => esc_html__( 'Close Menu', 'subetuwebwp' ),
				'subetuweb_footer_copyright_text'           => esc_html__( 'Copyright [subetuwebwp_date] - subetuwebWP Theme by subetuwebWP', 'subetuwebwp' ),
				'subetuweb_blog_infinite_scroll_last_text'  => '',
				'subetuweb_blog_infinite_scroll_error_text' => '',
			)
		);

	}
}

/**
 * Returns array of Social Options
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_social_options' ) ) {

	function subetuwebwp_social_options() {
		return apply_filters(
			'subetuweb_social_options',
			array(
				'twitter'     => array(
					'label'      => esc_html__( 'Twitter', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'twitter', false ),
				),
				'facebook'    => array(
					'label'      => esc_html__( 'Facebook', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'facebook', false ),
				),
				'pinterest'   => array(
					'label'      => esc_html__( 'Pinterest', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'pinterest', false ),
				),
				'dribbble'    => array(
					'label'      => esc_html__( 'Dribbble', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'dribbble', false ),
				),
				'vk'          => array(
					'label'      => esc_html__( 'VK', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'vk', false ),
				),
				'instagram'   => array(
					'label'      => esc_html__( 'Instagram', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'instagram', false ),
				),
				'linkedin'    => array(
					'label'      => esc_html__( 'LinkedIn', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'linkedin', false ),
				),
				'tumblr'      => array(
					'label'      => esc_html__( 'Tumblr', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'tumblr', false ),
				),
				'github'      => array(
					'label'      => esc_html__( 'Github', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'github', false ),
				),
				'flickr'      => array(
					'label'      => esc_html__( 'Flickr', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'flickr', false ),
				),
				'skype'       => array(
					'label'      => esc_html__( 'Skype', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'skype', false ),
				),
				'youtube'     => array(
					'label'      => esc_html__( 'Youtube', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'youtube', false ),
				),
				'vimeo'       => array(
					'label'      => esc_html__( 'Vimeo', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'vimeo', false ),
				),
				'vine'        => array(
					'label'      => esc_html__( 'Vine', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'vine', false ),
				),
				'xing'        => array(
					'label'      => esc_html__( 'Xing', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'xing', false ),
				),
				'yelp'        => array(
					'label'      => esc_html__( 'Yelp', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'yelp', false ),
				),
				'tripadvisor' => array(
					'label'      => esc_html__( 'Tripadvisor', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'tripadvisor', false ),
				),
				'rss'         => array(
					'label'      => esc_html__( 'RSS', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'rss', false ),
				),
				'email'       => array(
					'label'      => esc_html__( 'Email', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'envelope', false ),
				),
				'tiktok'      => array(
					'label'      => esc_html__( 'TikTok', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'tiktok', false ),
				),
				'medium'      => array(
					'label'      => esc_html__( 'Medium', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'medium', false ),
				),
				'telegram'    => array(
					'label'      => esc_html__( 'Telegram', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'telegram', false ),
				),
				'twitch'      => array(
					'label'      => esc_html__( 'Twitch', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'twitch', false ),
				),
				'line'        => array(
					'label'      => esc_html__( 'Line', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'line', false ),
				),
				'qq'          => array(
					'label'      => esc_html__( 'QQ', 'subetuwebwp' ),
					'icon_class' => subetuwebwp_icon( 'qq', false ),
				),
			)
		);
	}
}

/**
 * Grid Columns
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_grid_columns' ) ) {

	function subetuwebwp_grid_columns() {
		return apply_filters(
			'subetuweb_grid_columns',
			array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
			)
		);
	}
}

/**
 * Minify CSS
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_minify_css' ) ) {

	function subetuwebwp_minify_css( $css = '' ) {

		// Return if no CSS
		if ( ! $css ) {
			return;
		}

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		// Return minified CSS
		return $css;
	}
}

/**
 * Returns header template content
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'subetuwebwp_header_template_content' ) ) {

	function subetuwebwp_header_template_content() {

		// Return false if custom header is not selected
		if ( 'custom' != subetuwebwp_header_style() ) {
			return false;
		}

		// Get the template ID
		$content = subetuwebwp_custom_header_template();

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'subetuweb_header_template_content', $content );

	}
}

/**
 * Custom footer style template
 *
 * @since 1.5.22
 */
if ( ! function_exists( 'subetuwebwp_custom_footer_template' ) ) {

	function subetuwebwp_custom_footer_template() {

		// Get template from customizer setting
		$template = get_theme_mod( 'subetuweb_footer_widgets_template' );

		// Apply filters and return
		return apply_filters( 'subetuweb_custom_footer_template', $template );

	}
}

/**
 * Returns footer template content
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'subetuwebwp_footer_template_content' ) ) {

	function subetuwebwp_footer_template_content() {

		// Return false if disabled via Customizer
		if ( true != get_theme_mod( 'subetuweb_footer_widgets', true ) ) {
			return null;
		}

		// Get template ID from Customizer
		$content = subetuwebwp_custom_footer_template();

		// Get Polylang Translation of template
		if ( function_exists( 'pll_get_post' ) ) {
			$content = pll_get_post( $content, pll_current_language() );
		}

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'subetuweb_footer_template_content', $content );

	}
}

/**
 * Returns topbar template content
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'subetuwebwp_topbar_template_content' ) ) {

	function subetuwebwp_topbar_template_content() {

		// Get the template ID
		$content = get_theme_mod( 'subetuweb_top_bar_template' );

		// Get Polylang Translation of template
		if ( function_exists( 'pll_get_post' ) ) {
			$content = pll_get_post( $content, pll_current_language() );
		}

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'subetuwebwp_topbar_template_content', $content );

	}
}

/**
 * Return correct schema markup
 *
 * @since 1.2.10
 */
if ( ! function_exists( 'subetuwebwp_get_schema_markup' ) ) {

	function subetuwebwp_get_schema_markup( $location ) {

		// Return if disable
		if ( ! get_theme_mod( 'subetuweb_schema_markup', true ) ) {
			return null;
		}

		// Default
		$schema = $itemprop = $itemtype = '';

		// HTML
		if ( 'html' == $location ) {
			if ( is_home() || is_front_page() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			} elseif ( is_category() || is_tag() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/Blog"';
			} elseif ( is_singular( 'post' ) ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/Article"';
			} elseif ( is_page() ) {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			} else {
				$schema = 'itemscope="itemscope" itemtype="https://schema.org/WebPage"';
			}

			return apply_filters( 'subetuwebwp_schema_location_html', $schema );
		}

		// Header
		elseif ( 'header' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPHeader"';
		}

		// Logo
		elseif ( 'logo' == $location ) {
			$schema = 'itemscope itemtype="https://schema.org/Brand"';
		}

		// Navigation
		elseif ( 'site_navigation' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement"';
		}

		// Main
		elseif ( 'main' == $location ) {
			$itemtype = 'https://schema.org/WebPageElement';
			$itemprop = 'mainContentOfPage';
		}

		// Footer widgets
		elseif ( 'footer' == $location ) {
			$schema = 'itemscope="itemscope" itemtype="https://schema.org/WPFooter"';
		}

		// Headings
		elseif ( 'headline' == $location ) {
			$schema = 'itemprop="headline"';
		}

		// Posts
		elseif ( 'entry_content' == $location ) {
			$schema = 'itemprop="text"';
		}

		// Publish date
		elseif ( 'publish_date' == $location ) {
			$schema = 'itemprop="datePublished"';
		}

		// Modified date
		elseif ( 'modified_date' == $location ) {
			$schema = 'itemprop="dateModified"';
		}

		// Author name
		elseif ( 'author_name' == $location ) {
			$schema = 'itemprop="name"';
		}

		// Author link
		elseif ( 'author_link' == $location ) {
			$schema = 'itemprop="author" itemscope="itemscope" itemtype="https://schema.org/Person"';
		}

		// Item
		elseif ( 'item' == $location ) {
			$schema = 'itemprop="item"';
		}

		// Url
		elseif ( 'url' == $location ) {
			$schema = 'itemprop="url"';
		}

		// Position
		elseif ( 'position' == $location ) {
			$schema = 'itemprop="position"';
		}

		// Image
		elseif ( 'image' == $location ) {
			$schema = 'itemprop="image"';
		}

		return ' ' . apply_filters( 'subetuweb_schema_markup', $schema );

	}
}

/**
 * Outputs correct schema markup
 *
 * @since 1.2.10
 */
if ( ! function_exists( 'subetuwebwp_schema_markup' ) ) {

	function subetuwebwp_schema_markup( $location ) {

		echo subetuwebwp_get_schema_markup( $location );

	}
}

/**
 * Returns error page template content
 *
 * @since 1.1.1
 */
if ( ! function_exists( 'subetuwebwp_error_page_template_content' ) ) {

	function subetuwebwp_error_page_template_content() {

		// Get template ID from Customizer
		$content = get_theme_mod( 'subetuweb_error_page_template' );

		// Get Polylang Translation of template
		if ( function_exists( 'pll_get_post' ) ) {
			$content = pll_get_post( $content, pll_current_language() );
		}

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'subetuweb_error_page_template_content', $content );

	}
}

/**
 * Create list of attributes into a string and apply filter baes on context
 *
 * @since 1.8.7
 * @param string $context    The context, to build filter name.
 * @param array  $attributes To load defaults attributes.
 * @param array  $args       Custom data to pass to filter.
 * @return string String of HTML attributes and values.
 */
function owp_attr( $context, $attributes = array(), $args = array() ) {

	$attributes = owp_parse_attr( $context, $attributes, $args );

	$output = '';

	// loop through attributes and build attribute string.
	foreach ( $attributes as $key => $value ) {

		if ( ! $value ) {
			continue;
		}

		if ( true === $value ) {
			$output .= esc_html( $key ) . ' ';
		} else {
			$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
		}
	}

	$output = apply_filters( "owp_attr_{$context}_output", $output, $attributes, $context, $args );

	return trim( $output );
}

/**
 * Create list of attributes into a string and apply filter baes on context
 *
 * @since 1.8.7
 * @param string $context    The context, to build filter name.
 * @param array  $attributes To load defaults attributes.
 * @param array  $args       Custom data to pass to filter.
 * @return string String of HTML attributes and values.
 */
function owp_parse_attr( $context, $attributes = array(), $args = array() ) {

	$defaults = array(
		'class' => sanitize_html_class( $context ),
	);

	$attributes = wp_parse_args( $attributes, $defaults );

	// Apply filter based on context.
	return apply_filters( "owp_attr_{$context}", $attributes, $context, $args );
}

function subetuwebwp_body_content() {

	get_template_part( 'content/single' );

}

add_action( 'subetuwebwp_body_content', 'subetuwebwp_body_content' );

function subetuwebwp_blog_page() {

	get_template_part( 'content/blog' );

}

add_action( 'subetuwebwp_blog_page', 'subetuwebwp_blog_page' );

function subetuwebwp_portfolio_data() {

	get_template_part( 'assets/epanel/portfolio' );

}

add_action( 'subetuwebwp_portfolio_data', 'subetuwebwp_portfolio_data' );
