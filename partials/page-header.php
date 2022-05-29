<?php
/**
 * The template for displaying the page header.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if page header is disabled.
if ( ! subetuwebwp_has_page_header() ) {
	return;
}

// Classes.
$classes = array( 'page-header' );

// Get header style.
$style = subetuwebwp_page_header_style();

// Add classes for title style.
if ( $style ) {
	$classes[ $style . '-page-header' ] = $style . '-page-header';
}

// Visibility.
$visibility = get_theme_mod( 'subetuweb_page_header_visibility', 'all-devices' );
if ( 'all-devices' !== $visibility ) {
	$classes[] = $visibility;
}

// Turn into space seperated list.
$classes = implode( ' ', $classes );

// Heading tag.
$heading = get_theme_mod( 'subetuweb_page_header_heading_tag', 'h1' );
$heading = $heading ? $heading : 'h1';
$heading = apply_filters( 'subetuweb_page_header_heading', $heading );

?>

<?php do_action( 'subetuweb_before_page_header' ); ?>

<header class="<?php echo esc_attr( $classes ); ?>">

	<?php do_action( 'subetuweb_before_page_header_inner' ); ?>

	<?php subetuwebwp_page_header_overlay(); ?>

	<?php do_action( 'subetuweb_after_page_header_inner' ); ?>

</header><!-- .page-header -->

<?php do_action( 'subetuweb_after_page_header' ); ?>
