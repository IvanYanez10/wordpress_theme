<?php
/**
 * Blog single video format media
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

// Get post video.
$video = subetuwebwp_get_post_video_html();

// Display video if one exists and it's not a password protected post.
if ( $video && ! post_password_required() ) :

	?>
	<div id="post-media" class="thumbnail clr">

		<div class="blog-post-video">

			<?php echo $video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		</div><!-- .blog-post-video -->

	</div><!-- #post-media -->
	<?php

	// Else display post thumbnail.
else :

	get_template_part( 'partials/single/media/blog-single' );

endif;
