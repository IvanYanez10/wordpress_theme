<?php
/**
 * Archive product template.
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

// Get links conditional mod.
$subetuweb_woo_disable_links = get_theme_mod( 'subetuweb_shop_woo_disable_links', false );
$subetuweb_woo_disable_links_cond = get_theme_mod( 'subetuweb_shop_woo_disable_links_cond', 'no' );

$disable_links = '';
$disable_links = ( true === $subetuweb_woo_disable_links && 'yes' === $subetuweb_woo_disable_links_cond );

/**
 * Display shop and product archive items
 * 
 */
do_action( 'subetuweb_before_archive_product_item' );

echo '<ul class="woo-entry-inner clr">';

// Get elements.
$elements = subetuwebwp_woo_product_elements_positioning();

// Loop through elements.
foreach ( $elements as $element ) {

	// Image.
	if ( 'image' === $element ) {

		echo '<li class="image-wrap">';

		do_action( 'subetuweb_before_archive_product_image' );
		if ( class_exists( 'subetuwebWP_WooCommerce_Config' ) ) {
			subetuwebWP_WooCommerce_Config::add_out_of_stock_badge();
		}
		woocommerce_show_product_loop_sale_flash();
		if ( class_exists( 'subetuwebWP_WooCommerce_Config' ) ) {
			subetuwebWP_WooCommerce_Config::loop_product_thumbnail();
		}
		do_action( 'subetuweb_after_archive_product_image' );

		echo '</li>';

	}

	// Category.
	if ( 'category' === $element ) {

		do_action( 'subetuweb_before_archive_product_categories' );
		echo wp_kses_post( wc_get_product_category_list( $product->get_id(), ', ', '<li class="category">', '</li>' ) );
		do_action( 'subetuweb_after_archive_product_categories' );

	}

	// Title.
	if ( 'title' === $element ) {

		$heading = 'h2';
		$heading = apply_filters( 'subetuweb_product_archive_title_tag', $heading );

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

	}

	// Price.
	if ( 'price-rating' === $element ) {

		do_action( 'subetuweb_before_archive_product_inner' );

		if ( false === $subetuweb_woo_cond || $show_woo_cond ) {

			echo '<li class="price-wrap">';
			
				do_action( 'subetuweb_before_archive_product_price' );
				woocommerce_template_loop_price();
				do_action( 'subetuweb_after_archive_product_price' );

			echo '</li>';

		}

		do_action( 'subetuweb_after_archive_product_inner' );

	}

	// Star Rating.
	if ( 'woo-rating' === $element ) {

		echo '<li class="rating">';
			do_action( 'subetuweb_before_archive_product_rating' );
			woocommerce_template_loop_rating();
			do_action( 'subetuweb_after_archive_product_rating' );
		echo '</li>';

	}

	// Description for product archive List view.
	if ( 'description' === $element ) {

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

	}

	// Add to cart button.
	if ( 'button' === $element ) {

		do_action( 'subetuweb_before_archive_product_add_to_cart' );

		if ( false === $subetuweb_woo_cond || $show_woo_cond ) {

			echo '<li class="btn-wrap clr">';

				do_action( 'subetuweb_before_archive_product_add_to_cart_inner' );
				woocommerce_template_loop_add_to_cart();
				do_action( 'subetuweb_after_archive_product_add_to_cart_inner' );

			echo '</li>';

		} else {

			// Get conditional message display state.
			$subetuweb_woo_cond_msg = get_theme_mod( 'subetuweb_shop_cond_msg', 'yes' );
		
			if ( $subetuweb_woo_cond_msg === 'yes' ) {

				// Get Add to Cart button replacement message.
				$woo_cond_message = get_theme_mod( 'subetuweb_shop_msg_text' );
				$woo_cond_message = $woo_cond_message ? $woo_cond_message : esc_html__( 'Log in to view price and purchase', 'subetuwebwp' );

				$woo_add_myaccunt_link = get_theme_mod( 'subetuweb_shop_add_myaccount_link', false );

				echo '<li class="owp-woo-cond-notice">';
				if ( false === $woo_add_myaccunt_link ) {
					echo '<span>'. $woo_cond_message .'</span>';
				} else {
					echo '<a href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '">' . $woo_cond_message . '</a>';
				}	
				echo '</li>';
				
			}
		}

		do_action( 'subetuweb_after_archive_product_add_to_cart' );

	}

}

echo '</ul>';

do_action( 'subetuweb_after_archive_product_item' );
