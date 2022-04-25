<?php
/**
 * Archive product hover style template.
 *
 * @package subetuwebWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product, $post;

// Get price and Add to Cart button conditional display state.
$subetuweb_woo_cond = get_theme_mod( 'subetuweb_shop_conditional', false );

// Conditional vars.
$show_woo_cond = '';
$show_woo_cond = ( is_user_logged_in() && true === $subetuweb_woo_cond );
$hide_woo_cond = ( ! is_user_logged_in() && true === $subetuweb_woo_cond );

// Get links conditional mod.
$subetuweb_woo_disable_links      = get_theme_mod( 'subetuweb_shop_woo_disable_links', false );
$subetuweb_woo_disable_links_cond = get_theme_mod( 'subetuweb_shop_woo_disable_links_cond', 'no' );

$disable_links = '';
$disable_links = ( true === $subetuweb_woo_disable_links && 'yes' === $subetuweb_woo_disable_links_cond );

do_action( 'subetuweb_before_archive_product_item' );

echo '<ul class="woo-entry-inner clr">';

echo '<li class="image-wrap">';

do_action( 'subetuweb_before_archive_product_image' );

// Add Out of Stock badge.
if ( class_exists( 'subetuwebWP_WooCommerce_Config' ) ) {
	subetuwebWP_WooCommerce_Config::add_out_of_stock_badge();
}

woocommerce_show_product_loop_sale_flash();

// Display product featured image.
if ( function_exists( 'wc_get_template' ) ) {
	wc_get_template( 'loop/thumbnail/featured-image.php' );
}

// Add to cart.
if ( false === $subetuweb_woo_cond || $show_woo_cond ) {
	do_action( 'subetuweb_before_archive_product_add_to_cart_inner' );
	woocommerce_template_loop_add_to_cart();
	do_action( 'subetuweb_after_archive_product_add_to_cart_inner' );
}

// Wishlist button.
if ( get_theme_mod( 'subetuweb_woo_quick_view', true )
	|| subetuweb_woo_wishlist() ) {
	echo '<ul class="woo-entry-buttons">';
	do_action( 'subetuweb_before_archive_woo_entry_buttons' );
	if ( get_theme_mod( 'subetuweb_woo_quick_view', true ) ) {
		echo '<li class="woo-quickview-btn">' . apply_filters( 'subetuweb_woo_quick_view_button_html', '<a href="#" class="owp-quick-view" id="product_id_' . $product->get_id() . '" data-product_id="' . $product->get_id() . '">' . subetuwebwp_icon( 'eye', false ) . '</a>' ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	$wl_plugin = get_theme_mod( 'subetuweb_woo_wl_plugin', 'ti_wl' );

	if ( 'ti_wl' === $wl_plugin && class_exists( 'TInvWL_Wishlist' ) ) {
		echo '<li class="woo-wishlist-btn">' . do_shortcode( '[ti_wishlists_addtowishlist]' ) . '</li>';
	} elseif ( 'yith_wl' === $wl_plugin && class_exists( 'YITH_WCWL' ) ) {
		echo '<li class="woo-wishlist-btn">' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
	}

	do_action( 'subetuweb_after_archive_woo_entry_buttons' );
	echo '</ul>';
}

do_action( 'subetuweb_after_archive_product_image' );

echo '</li>';

echo '<ul class="woo-product-info">';

// Display product categories.
do_action( 'subetuweb_before_archive_product_categories' );
echo wp_kses_post( wc_get_product_category_list( $product->get_id(), ', ', '<li class="category">', '</li>' ) );
do_action( 'subetuweb_after_archive_product_categories' );

$heading = 'h2';
$heading = apply_filters( 'subetuweb_product_archive_title_tag', $heading );

// Display product title.
do_action( 'subetuweb_before_archive_product_title' );

echo '<li class="title">';

	do_action( 'subetuweb_before_archive_product_title_inner' );

if ( false === $subetuweb_woo_disable_links
		|| ( $disable_links && is_user_logged_in() ) ) {

		echo '<' . esc_attr( $heading ) . '><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></' . esc_attr( $heading ) . '>';

} else {

	echo '<' . esc_attr( $heading ) . '>' . get_the_title() . '</' . esc_attr( $heading ) . '>';

}

	do_action( 'subetuweb_after_archive_product_title_inner' );

echo '</li>';

do_action( 'subetuweb_after_archive_product_title' );

// Display price.
do_action( 'subetuweb_before_archive_product_inner' );

if ( false === $subetuweb_woo_cond || $show_woo_cond ) {

	echo '<li class="price-wrap">';

		do_action( 'subetuweb_before_archive_product_price' );
		woocommerce_template_loop_price();
		do_action( 'subetuweb_after_archive_product_price' );

	echo '</li>';

} else {

	$subetuweb_woo_cond_msg = get_theme_mod( 'subetuweb_shop_cond_msg', 'yes' );

	if ( $subetuweb_woo_cond_msg === 'yes' ) {

		// Get Add to Cart button replacement message.
		$woo_cond_message = get_theme_mod( 'subetuweb_shop_msg_text' );
		$woo_cond_message = $woo_cond_message ? $woo_cond_message : esc_html__( 'Log in to view price and purchase', 'subetuwebwp' );

		$woo_add_myaccunt_link = get_theme_mod( 'subetuweb_shop_add_myaccount_link', false );

		echo '<li class="owp-woo-cond-notice">';
		if ( false === $woo_add_myaccunt_link ) {
			echo '<span>' . $woo_cond_message . '</span>';
		} else {
			echo '<a href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '">' . $woo_cond_message . '</a>';
		}
		echo '</li>';

	}
}

do_action( 'subetuweb_after_archive_product_inner' );

// Display rating.
echo '<li class="rating">';
	do_action( 'subetuweb_before_archive_product_rating' );
	woocommerce_template_loop_rating();
	do_action( 'subetuweb_after_archive_product_rating' );
echo '</li>';

// Display product description for product archive List view.
do_action( 'subetuweb_before_archive_product_description' );

if ( ( subetuwebwp_is_woo_shop() || subetuwebwp_is_woo_tax() )
	&& get_theme_mod( 'subetuweb_woo_grid_list', true ) ) {
	$length = get_theme_mod( 'subetuweb_woo_list_excerpt_length', '60' );
	echo '<li class="woo-desc">';
	if ( ! $length ) {
		echo wp_kses_post( strip_shortcodes( $post->post_excerpt ) );
	} else {
		echo wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</li>';
}

do_action( 'subetuweb_after_archive_product_description' );

echo '</ul>';

if ( function_exists( 'wc_get_template' ) ) {
	wc_get_template( 'owp-archive-product-thumbnails.php' );
}

echo '</ul>';

do_action( 'subetuweb_after_archive_product_item' );
