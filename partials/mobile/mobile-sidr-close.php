<?php
/**
 * Mobile Menu sidr close
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get icon.
$icon_html  = '';
$icon_type  = subetuwebwp_theme_icon_class();
$theme_icon = subetuwebwp_theme_icons();
$icon       = $theme_icon['close_x'][ $icon_type ];
$icon_class = get_theme_mod( 'subetuweb_mobile_menu_close_btn_icon', $icon );

if ( 'svg' === $icon_type ) {
	$icon_html = subetuwebwp_icon( 'close_x', false );
} else {
	$icon_html = '<i class="icon ' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';
}

$icon = apply_filters( 'subetuweb_mobile_menu_close_btn_icon', $icon );

// Text.
$text = get_theme_mod( 'subetuweb_mobile_menu_close_btn_text' );
$text = subetuwebwp_tm_translation( 'subetuweb_mobile_menu_close_btn_text', $text );
$text = $text ? $text : esc_html__( 'Close Menu', 'subetuwebwp' );
?>

<div id="sidr-close">
	<a href="javascript:void(0)" class="toggle-sidr-close" aria-label="<?php esc_attr( subetuwebwp_theme_strings( 'owp-string-close-mobile-menu', 'subetuwebwp' ) ); ?>">
		<?php echo $icon_html; ?><span class="close-text"><?php echo do_shortcode( $text ); ?></span>
	</a>
</div>
