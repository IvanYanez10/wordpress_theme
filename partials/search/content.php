<?php
/**
 * Search result page entry content
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

// Excerpt length.
$length = apply_filters( 'subetuweb_search_results_excerpt_length', '30' );

?>

<div class="search-entry-summary clr"<?php subetuwebwp_schema_markup( 'entry_content' ); ?>>
	<p>
		<?php
		// Display excerpt.
		if ( has_excerpt( $post->ID ) ) {
			the_excerpt();

		} else {
			// Display custom excerpt.
			echo wp_trim_words( strip_shortcodes( $post->post_content ), $length ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</p>
</div><!-- .search-entry-summary -->
