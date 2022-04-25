<?php
/**
 * Custom Header Style
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get ID.
$get_id = subetuwebwp_custom_header_template();

// Check if page is Elementor page.
$elementor = get_post_meta( $get_id, '_elementor_edit_mode', true );

// Get content.
$get_content = subetuwebwp_header_template_content();

// Get classes.
$classes = array( 'clr' );

// Add container class.
if ( true === get_theme_mod( 'subetuweb_add_custom_header_container', true ) ) {
	$classes[] = 'container';
}

// Turn classes into space seperated string.
$classes = implode( ' ', $classes ); ?>

<?php do_action( 'subetuweb_before_header_inner' ); ?>

<div id="site-header-inner" class="<?php echo esc_attr( $classes ); ?>">

	<?php

	if ( subetuwebWP_ELEMENTOR_ACTIVE && $elementor ) {

		// If Elementor.
		subetuwebWP_Elementor::get_header_content();

	} elseif ( subetuwebWP_BEAVER_BUILDER_ACTIVE && ! empty( $get_id ) ) {

		// If Beaver Builder.
		echo do_shortcode( '[fl_builder_insert_layout id="' . $get_id . '"]' );

	} else {

		// Display template content.
		echo do_shortcode( $get_content );

	}

	?>

</div>

<?php get_template_part( 'partials/mobile/mobile-dropdown' ); ?>

<?php do_action( 'subetuweb_after_header_inner' ); ?>
