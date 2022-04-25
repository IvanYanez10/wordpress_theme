<?php
/**
 * Outputs page article
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="entry clr"<?php subetuwebwp_schema_markup( 'entry_content' ); ?>>

	<?php do_action( 'subetuweb_before_page_entry' ); ?>

	<?php
	the_content();

	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'subetuwebwp' ),
			'after'  => '</div>',
		)
	);
	?>

	<?php do_action( 'subetuweb_after_page_entry' ); ?>

</div>
