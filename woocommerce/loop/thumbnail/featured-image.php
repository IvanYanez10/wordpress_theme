<?php
/**
 * Image Swap style thumbnail
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return placeholder if there isn't a thumbnail defined.
if ( ! has_post_thumbnail() ) {
	subetuwebwp_woo_placeholder_img();
	return;
}

// Get global product data.
global $product;

// Get links conditional mod.
$subetuweb_woo_disable_links = get_theme_mod( 'subetuweb_shop_woo_disable_links', false );
$subetuweb_woo_disable_links_cond = get_theme_mod( 'subetuweb_shop_woo_disable_links_cond', 'no' );

$disable_links = '';
$disable_links = ( true === $subetuweb_woo_disable_links && 'yes' === $subetuweb_woo_disable_links_cond );

// Get featured image.
$attachment = $product->get_image_id();

// Image args.
$img_args = array(
	'class' => 'woo-entry-image-main',
	'alt'   => get_the_title(),
);
if ( subetuwebwp_get_schema_markup( 'image' ) ) {
	$img_args['itemprop'] = 'image';
}

// Display featured image if defined.
if ( $attachment ) {
	?>

	<div class="woo-entry-image clr">
		<?php
		do_action( 'subetuweb_before_product_entry_image' );

		if ( false === $subetuweb_woo_disable_links
			|| ( $disable_links && is_user_logged_in() ) ) {

			subetuweb_woo_img_link_open();
			
				// Single Image.
				echo wp_get_attachment_image( $attachment, 'shop_catalog', '', $img_args );
					
			subetuweb_woo_img_link_close();

		} else {
				
			// Single Image.
			echo wp_get_attachment_image( $attachment, 'shop_catalog', '', $img_args );

		}
		
		do_action( 'subetuweb_after_product_entry_image' );
		?>
	</div><!-- .woo-entry-image -->

	<?php
} else {
	// Display placeholder.
	?>

	<div class="woo-entry-image clr">
		<?php
		do_action( 'subetuweb_before_product_entry_image' );

		if ( false === $subetuweb_woo_disable_links
			|| ( $disable_links && is_user_logged_in() ) ) {

			subetuweb_woo_img_link_open();
			
				echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="' . esc_html__( 'Placeholder Image', 'subetuwebwp' ) . '" class="woo-entry-image-main" />';
					
			subetuweb_woo_img_link_close();

		} else {
				
			echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="' . esc_html__( 'Placeholder Image', 'subetuwebwp' ) . '" class="woo-entry-image-main" />';

		}

		do_action( 'subetuweb_after_product_entry_image' );
		?>
	</div><!-- .woo-entry-image -->
<?php } ?>
