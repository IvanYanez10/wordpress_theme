<?php
/**
 * Post single content
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php do_action( 'subetuweb_before_single_post_content' ); ?>

<div class="entry-content clr"<?php subetuwebwp_schema_markup( 'entry_content' ); ?>>
	<?php
	the_content();

	wp_link_pages(
		array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'subetuwebwp' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		)
	);
	?>

</div><!-- .entry -->

<?php do_action( 'subetuweb_after_single_post_content' ); ?>
