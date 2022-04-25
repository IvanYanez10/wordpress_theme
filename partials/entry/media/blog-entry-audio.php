<?php
/**
 * Blog entry audio format media
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

<?php $audio = subetuwebwp_get_post_audio_html(); ?>

<?php if ( $audio ) : ?>

	<div class="thumbnail"><?php echo $audio; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>

	<?php

else :

	// Else display post thumbnail.
	?>

	<?php get_template_part( 'partials/entry/media/blog-entry' ); ?>

<?php endif; ?>
