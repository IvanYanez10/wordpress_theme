<?php
/**
 * Drop down mobile style template part.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'dropdown' !== subetuwebwp_mobile_menu_style()
	|| ! subetuwebwp_display_navigation() ) {
	return;
}

// Navigation classes.
$classes = array( 'clr' );

// If social.
if ( true === get_theme_mod( 'subetuweb_menu_social', false ) ) {
	$classes[] = 'has-social';
}

// Turn classes into space seperated string.
$classes = implode( ' ', $classes );

// Menu Location.
$menu_location = apply_filters( 'subetuweb_main_menu_location', 'main_menu' );

// Dropdown menu attributes.
$dropdown_menu_attrs = apply_filters( 'subetuwebwp_attrs_mobile_dropdown', '' );

// Menu arguments.
$menu_args = array(
	'theme_location' => $menu_location,
	'container'      => false,
	'fallback_cb'    => false,
);

// Check if custom menu.
if ( $menu = subetuwebwp_header_custom_menu() ) {
	$menu_args['menu'] = $menu;
}

// Left menu for the Center header style.
$left_menu = get_theme_mod( 'subetuweb_center_header_left_menu' );
$left_menu = '0' !== $left_menu ? $left_menu : '';
$left_menu = apply_filters( 'subetuweb_center_header_left_menu', $left_menu );

// Menu arguments.
$left_menu_args = array(
	'menu'        => $left_menu,
	'container'   => false,
	'fallback_cb' => false,
);

// Top bar menu Location.
$top_menu_location = 'topbar_menu';

// Menu arguments.
$top_menu_args = array(
	'theme_location' => $top_menu_location,
	'container'      => false,
	'fallback_cb'    => false,
);

// Get close menu text.
$close_text = get_theme_mod( 'subetuweb_mobile_menu_close_text' );
$close_text = subetuwebwp_tm_translation( 'subetuweb_mobile_menu_close_text', $close_text );
$close_text = $close_text ? $close_text : esc_html__( 'Close', 'subetuwebwp' );

?>

<div id="mobile-dropdown" class="clr" <?php echo $dropdown_menu_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<nav class="<?php echo esc_attr( $classes ); ?>"<?php subetuwebwp_schema_markup( 'site_navigation' ); ?>>

		<?php
		// If has mobile menu.
		if ( has_nav_menu( 'mobile_menu' ) ) {
			get_template_part( 'partials/mobile/mobile-nav' );
		} else {

			// If has center header style and left menu.
			if ( 'center' === subetuwebwp_header_style()
				&& $left_menu ) {
				wp_nav_menu( $left_menu_args );
			}

			// Navigation.
			wp_nav_menu( $menu_args );

			// If has top bar menu.
			if ( has_nav_menu( $top_menu_location ) ) {
				wp_nav_menu( $top_menu_args );
			}
		}

		// Social.
		if ( true === get_theme_mod( 'subetuweb_menu_social', false ) ) {
			get_template_part( 'partials/header/social' );
		}

		// Mobile search form.
		if ( get_theme_mod( 'subetuweb_mobile_menu_search', true ) ) {
			get_template_part( 'partials/mobile/mobile-search' );
		}
		?>

	</nav>

</div>
