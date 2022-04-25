<?php
/**
 * The template for displaying search forms.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Post type.
$post_type = get_theme_mod( 'subetuweb_menu_search_source', 'any' );

// Generate unique form ID.
$subetuweb_sf_id = subetuwebwp_unique_id( 'subetuweb-search-form-' );
$osf_id      = esc_attr( $subetuweb_sf_id );

?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $osf_id ); ?>">
		<span class="screen-reader-text"><?php subetuwebwp_theme_strings( 'owp-string-search-form-label' ); ?></span>
		<input type="search" id="<?php echo esc_attr( $osf_id ); ?>" class="field" autocomplete="off" placeholder="<?php subetuwebwp_theme_strings( 'owp-string-search-text', 'subetuwebwp' ); ?>" name="s">
		<?php if ( 'any' !== $post_type ) { ?>
			<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
		<?php } ?>
	</label>
	<?php do_action( 'wpml_add_language_form_field' ); ?>
</form>
