<?php
/**
 * Gallery Style WooCommerce
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return dummy image if no featured image is defined.
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
$thumbnail_id = $product->get_image_id();

// Get gallery images.
if ( version_compare( subetuwebWP_WooCommerce_Config::get_wc_version(), '2.7', '>=' ) ) {
	$attachment_ids = $product->get_gallery_image_ids();
} else {
	$attachment_ids = $product->get_gallery_attachment_ids();
}

// Get attachments count.
$attachments_count = count( $attachment_ids );

// Image args.
$img_args = array(
	'alt' => get_the_title(),
);
if ( subetuwebwp_get_schema_markup( 'image' ) ) {
	$img_args['itemprop'] = 'image';
}

// If there are attachments display slider.
if ( $attachment_ids ) : ?>

	<div class="product-entry-slider-wrap">

		<?php do_action( 'subetuweb_before_product_entry_slider' ); ?>

		<div class="product-entry-slider woo-entry-image clr">

			<?php do_action( 'subetuweb_before_product_entry_image' ); ?>

			<?php
			// Define counter variable.
			$count = 0;

			if ( has_post_thumbnail() ) :
				?>

				<div class="subetuwebwp-slider-slide">
					<?php
					if ( false === $subetuweb_woo_disable_links
						|| ( $disable_links && is_user_logged_in() ) ) {
		
						subetuweb_woo_img_link_open();
					
							echo wp_get_attachment_image( $thumbnail_id, 'shop_catalog', '', $img_args );
							
						subetuweb_woo_img_link_close();
		
					} else {
							
						echo wp_get_attachment_image( $thumbnail_id, 'shop_catalog', '', $img_args );
			
					}
					?>
				</div>

				<?php
			endif;

			if ( $attachments_count > 0 ) :

				// Loop through images.
				foreach ( $attachment_ids as $attachment_id ) :

					// Add to counter.
					$count++;

					// Only display the first 5 images.
					if ( $count < 5 ) :
						?>

						<div class="subetuwebwp-slider-slide">
						<?php
						if ( false === $subetuweb_woo_disable_links
							|| ( $disable_links && is_user_logged_in() ) ) {
			
							subetuweb_woo_img_link_open();
						
								echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', $img_args );
								
							subetuweb_woo_img_link_close();
			
						} else {
								
							echo wp_get_attachment_image( $attachment_id, 'shop_catalog', '', $img_args );
				
						}
						?>
						</div>

						<?php
					endif;

				endforeach;

			endif;
			?>

			<?php do_action( 'subetuweb_after_product_entry_image' ); ?>

		</div>

		<?php do_action( 'subetuweb_after_product_entry_slider' ); ?>

	</div>

	<?php
	// There aren't any images so lets display the featured image.
else :

	wc_get_template( 'loop/thumbnail/featured-image.php' );

endif;
?>