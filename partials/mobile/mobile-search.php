<?php
/**
 * Mobile search template.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Post type.
$post_type = get_theme_mod( 'subetuweb_menu_search_source', 'any' );

// Assign mobile search form unique ID.
$subetuweb_msf_id = subetuwebwp_unique_id( 'subetuweb-mobile-search-' );
$mosf_id      = esc_attr( $subetuweb_msf_id );
?>

<div id="mobile-menu-search" class="clr">
	<form aria-label="<?php subetuwebwp_theme_strings( 'owp-string-search-form-label' ); ?>" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-searchform" role="search">
		<input aria-label="<?php subetuwebwp_theme_strings( 'owp-string-search-field' ); ?>" value="" class="field" id="<?php echo $mosf_id; ?>" type="search" name="s" autocomplete="off" placeholder="<?php subetuwebwp_theme_strings( 'owp-string-mobile-search-text' ); ?>" />
		<button aria-label="<?php subetuwebwp_theme_strings( 'owp-string-mobile-submit-search' ); ?>" type="submit" class="searchform-submit">
			<?php subetuwebwp_icon( 'search' ); ?>
		</button>
		<?php if ( 'any' !== $post_type ) { ?>
			<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
		<?php } ?>
		<?php do_action( 'wpml_add_language_form_field' ); ?>
	</form>
</div><!-- .mobile-menu-search -->
