<?php
/**
 * The default template for displaying post meta.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'post' === get_post_type() ) {
	?>

	<div class="blog-entry-comments clr">
		<?php subetuwebwp_icon( 'comment' ); ?><?php comments_popup_link( esc_html__( '0 Comments', 'subetuwebwp' ), esc_html__( '1 Comment', 'subetuwebwp' ), esc_html__( '% Comments', 'subetuwebwp' ), 'comments-link' ); ?>
	</div>

	<?php
}
?>
