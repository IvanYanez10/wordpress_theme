<?php
/**
 * Blog single tags
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display tags. ?>
<div class="post-tags clr">
	<?php the_tags( '<span class="owp-tag-text">' . esc_attr__( 'Tags: ', 'subetuwebwp' ) . '</span>', '<span class="owp-sep">,</span> ', '' ); ?>
</div>
