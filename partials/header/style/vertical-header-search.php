<?php
/**
 * Search Form for The Vertical Header Style
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Post type.
$post_type = get_theme_mod( 'subetuweb_menu_search_source', 'any' ); ?>

<div id="vertical-searchform" class="header-searchform-wrap clr">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-searchform" role="search" aria-label="<?php esc_attr_e( 'Vertical Header Search', 'subetuwebwp' ); ?>">
		<input type="search" name="s" autocomplete="off" value="" />
		<?php
		// If the headerSearchForm script is not disable.
		if ( subetuweb_EXTRA_ACTIVE
			&& class_exists( 'subetuweb_Extra_Scripts_Panel' )
			&& subetuweb_Extra_Scripts_Panel::get_setting( 'oe_headerSearchForm_script' ) ) {
			?>
			<label><?php subetuwebwp_theme_strings( 'owp-string-vertical-header-search-text', 'subetuwebwp' ); ?></label>
			<?php
		}
		?>
		<button class="search-submit"><?php subetuwebwp_icon( 'search' ); ?></button>
		<div class="search-bg"></div>
		<?php if ( 'any' !== $post_type ) { ?>
			<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
		<?php } ?>
		<?php do_action( 'wpml_add_language_form_field' ); ?>
	</form>
</div><!-- #vertical-searchform -->
