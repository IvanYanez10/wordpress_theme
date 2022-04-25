<?php
/**
 * Mobile Menu icon
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if disabled.
if ( ! subetuwebwp_display_navigation() ) {
	return;
}

// Menu Location.
$menu_location = apply_filters( 'subetuweb_main_menu_location', 'main_menu' );

// Multisite global menu.
$ms_global_menu = apply_filters( 'subetuweb_ms_global_menu', false );

// Menu data attributes.
$toggle_menu_attrs = apply_filters( 'subetuwebwp_menu_toggle_data_attrs', '' );

// Display if menu is defined.
if ( has_nav_menu( $menu_location ) || $ms_global_menu ) :

	// Get menu icon.
	$icon = get_theme_mod( 'subetuweb_mobile_menu_open_icon', 'fa fa-bars' );
	$icon = apply_filters( 'subetuweb_mobile_menu_navbar_open_icon', $icon );

	// Custom hamburger button.
	$btn = get_theme_mod( 'subetuweb_mobile_menu_open_hamburger', 'default' );

	// Get menu text.
	$text = get_theme_mod( 'subetuweb_mobile_menu_text' );
	$text = subetuwebwp_tm_translation( 'subetuweb_mobile_menu_text', $text );
	$text = $text ? $text : esc_html__( 'Menu', 'subetuwebwp' );

	// Get close menu text.
	$close_text = get_theme_mod( 'subetuweb_mobile_menu_close_text' );
	$close_text = subetuwebwp_tm_translation( 'subetuweb_mobile_menu_close_text', $close_text );
	$close_text = $close_text ? $close_text : esc_html__( 'Close', 'subetuwebwp' );

	if ( subetuwebWP_WOOCOMMERCE_ACTIVE ) {

		// Get cart icon.
		$woo_icon = get_theme_mod( 'subetuweb_woo_menu_icon', 'icon_handbag' );
		$woo_icon = in_array( $woo_icon, subetuwebwp_get_cart_icons() ) && $woo_icon ? $woo_icon : 'icon_handbag';

		// If has custom cart icon.
		$custom_icon = get_theme_mod( 'subetuweb_woo_menu_custom_icon' );
		if ( '' !== $custom_icon ) {
			$woo_icon = $custom_icon;
		}

		if ( '' !== $custom_icon ) {
			$cart_icon = '<i class="' . esc_attr( $woo_icon ) . '" aria-hidden="true"></i>';
		} else {
			$cart_icon = subetuwebwp_icon( $woo_icon, false );
		}

		// Cart Icon.
		$cart_icon = apply_filters( 'subetuweb_menu_cart_icon_html', $cart_icon );

	}

	// Classes.
	$classes = array( 'subetuwebwp-mobile-menu-icon', 'clr' );

	// Position.
	if ( 'three' === get_theme_mod( 'subetuweb_mobile_elements_positioning', 'one' ) ) {
		$classes[] = 'mobile-left';
	} else {
		$classes[] = 'mobile-right';
	}

	// Turn classes into space seperated string.
	$classes = implode( ' ', $classes ); ?>

	<?php do_action( 'subetuweb_mobile_menu_icon_before' ); ?>

	<div class="<?php echo esc_attr( $classes ); ?>">

		<?php do_action( 'subetuweb_before_mobile_icon' ); ?>

		<?php
		// If big header style.
		if ( 'big' === subetuwebwp_header_style() ) {
			?>
			<div class="container clr">
			<?php
		}
		?>

		<?php do_action( 'subetuweb_before_mobile_icon_inner' ); ?>

		<a href="#" class="mobile-menu" <?php echo $toggle_menu_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php esc_attr_e( 'Mobile Menu', 'subetuwebwp' ); ?>">
			<?php
			if ( 'default' !== $btn ) {
				?>
				<div class="hamburger hamburger--<?php echo esc_attr( $btn ); ?>" aria-expanded="false" role="navigation">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
				<?php
			} else {
				?>
				<i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
				<?php
			}

			// Mobile menu text.
			if ( get_theme_mod( 'subetuweb_mobile_menu_display_opening_text', true ) ) {
				?>
				<span class="subetuwebwp-text"><?php echo do_shortcode( $text ); ?></span>
				<span class="subetuwebwp-close-text"><?php echo do_shortcode( $close_text ); ?></span>
				<?php
			}
			?>
		</a>

		<?php do_action( 'subetuweb_after_mobile_icon_inner' ); ?>

		<?php
		// If big header style.
		if ( 'big' === subetuwebwp_header_style() ) {
			?>
			</div>
			<?php
		}
		?>

		<?php do_action( 'subetuweb_after_mobile_icon' ); ?>

	</div><!-- #subetuwebwp-mobile-menu-navbar -->

	<?php do_action( 'subetuweb_mobile_menu_icon_after' ); ?>

<?php endif; ?>
