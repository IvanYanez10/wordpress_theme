<?php
/**
 * Search result page entry read more
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="search-entry-readmore clr">
	<a href="<?php the_permalink(); ?>" title="<?php subetuwebwp_theme_strings( 'owp-string-search-continue-reading', 'subetuwebwp' ); ?>"><?php subetuwebwp_theme_strings( 'owp-string-search-continue-reading', 'subetuwebwp' ); ?></a>
	<span class="screen-reader-text"><?php the_title(); ?></span>
</div><!-- .search-entry-readmore -->
