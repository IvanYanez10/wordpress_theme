<?php
/**
 * Search for the full screen mobile style.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'fullscreen' !== subetuwebwp_mobile_menu_style() ) {
	return;
}

// Post type.
$post_type = get_theme_mod( 'subetuweb_menu_search_source', 'any' ); ?>

<div id="mobile-search" class="clr">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-searchform" role="search" aria-label="<?php esc_attr_e( 'Mobile Search', 'subetuwebwp' ); ?>">
		<input type="search" name="s" value="" autocomplete="off" />
		<?php
		// If the headerSearchForm script is not disable.
		if ( subetuweb_EXTRA_ACTIVE
			&& class_exists( 'subetuweb_Extra_Scripts_Panel' )
			&& subetuweb_Extra_Scripts_Panel::get_setting( 'oe_headerSearchForm_script' ) ) {
			?>
			<label><?php subetuwebwp_theme_strings( 'owp-string-mobile-fs-search-text', 'subetuwebwp' ); ?><span><i></i><i></i><i></i></span></label>
			<?php
		}
		?>
		<?php if ( 'any' !== $post_type ) { ?>
			<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
		<?php } ?>
	</form>
</div>
