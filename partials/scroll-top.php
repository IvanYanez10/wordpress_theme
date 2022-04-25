<?php
/**
 * The template for displaying the scroll top button.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If no scroll top button.
if ( ! subetuwebwp_display_scroll_up_button() ) {
	return;
}

// Get arrow.

$arrow = apply_filters( 'subetuweb_scroll_top_arrow', get_theme_mod( 'subetuweb_scroll_top_arrow', 'angle_up' ) );
$arrow = in_array( $arrow, subetuwebwp_get_scrolltotop_icons() ) && $arrow ? $arrow : 'angle_up';

// Position.
$position = apply_filters( 'subetuweb_scroll_top_position', get_theme_mod( 'subetuweb_scroll_top_position' ) );
$position = $position ? $position : 'right'; ?>

<a aria-label="<?php subetuwebwp_theme_strings( 'owp-string-scroll-top' ); ?>" href="#" id="scroll-top" class="scroll-top-<?php echo esc_attr( $position ); ?>"><?php subetuwebwp_icon( $arrow ); ?></a>
