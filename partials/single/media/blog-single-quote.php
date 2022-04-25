<?php
/**
 * Blog single quote format
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if subetuweb Extra is not active.
if ( ! subetuweb_EXTRA_ACTIVE ) {
	return;
}

?>

<div class="post-quote-wrap">

	<div class="post-quote-content">

		<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'subetuweb_quote_format', true ) ); ?>

		<span class="post-quote-icon"><?php subetuwebwp_icon( 'quote' ); ?></span>

	</div>

	<div class="post-quote-author"><?php the_title(); ?></div>

</div>
