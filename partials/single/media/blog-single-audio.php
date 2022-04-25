<?php
/**
 * Blog single audio format media
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

// Get audio html.
$audio = subetuwebwp_get_post_audio_html();

// Display audio if audio exists and the post isn't protected.
if ( $audio && ! post_password_required() ) :
	?>

	<div id="post-media" class="thumbnail clr">
		<div class="blog-post-audio clr"><?php echo $audio; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	</div>

	<?php
	// Else display post thumbnail.
else :

	get_template_part( 'partials/single/media/blog-single' );

endif;
