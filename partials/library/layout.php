<?php
/**
 * Outputs correct library layout
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<article class="single-library-article clr">
	layout
	<div class="entry clr"<?php subetuwebwp_schema_markup( 'entry_content' ); ?>>
		<?php the_content(); ?>
	</div>

</article>
