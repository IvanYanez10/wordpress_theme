<?php
/**
 * Header content.
 *
 * @package subetuwebWP WordPress theme
 */

// Vars.
$header_style        = subetuwebwp_header_style();
$position            = get_theme_mod( 'subetuweb_mobile_elements_positioning', 'one' );
$woo_icon_visibility = get_theme_mod( 'subetuweb_woo_menu_icon_visibility', 'default' );

if ( 'three' === $position ) {
	add_action( 'subetuweb_header_inner_left_content', 'subetuwebwp_mobile_icon', 1 );
}


add_action( 'subetuweb_header_inner_middle_content', 'subetuwebwp_header_navigation', 12 );

if ( 'three' !== $position ) {
	add_action( 'subetuweb_header_inner_right_content', 'subetuwebwp_mobile_icon', 99 );
}


if ( ! function_exists( 'subetuwebwp_header_navigation' ) ) {

	/**
	 * Header navigation
	 *
	 * @since 1.5.6
	 */
	function subetuwebwp_header_navigation() {

		get_template_part( 'partials/header/nav' );

	}
}

if ( ! function_exists( 'subetuwebwp_mobile_icon' ) ) {

	/**
	 * Header navigation
	 *
	 * @since 1.5.6
	 */
	function subetuwebwp_mobile_icon() {

		get_template_part( 'partials/mobile/mobile-icon' );

	}
}

if ( ! function_exists( 'subetuwebwp_mobile_cart_icon_medium_header' ) ) {

	/**
	 * Mobile cart icon for the Medium header style
	 *
	 * @since 1.5.6
	 */
	function subetuwebwp_mobile_cart_icon_medium_header() {
		$header_style = subetuwebwp_header_style();

		// Return if it is not medium or vertical header styles.
		if ( 'medium' !== $header_style
			&& 'vertical' !== $header_style ) {
			return;
		}

		echo subetuwebwp_wcmenucart_menu_item(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
}

if ( ! function_exists( 'subetuwebwp_mobile_cart_icon_not_medium_header' ) ) {

	/**
	 * Mobile cart icon if it is not the Medium header style
	 *
	 * @since 1.5.6
	 */
	function subetuwebwp_mobile_cart_icon_not_medium_header() {
		$header_style = subetuwebwp_header_style();

		// Return if medium or vertical header styles.
		if ( 'medium' === $header_style
			|| 'vertical' === $header_style ) {
			return;
		}

		echo subetuwebwp_wcmenucart_menu_item(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
}
