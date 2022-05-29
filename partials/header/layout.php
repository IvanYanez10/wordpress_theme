<?php
/**
 * Main Header Layout
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'subetuweb_before_header' ); ?>

<div class="header-image">

<header id="site-header" class="">

	<?php do_action( 'subetuweb_header_inner_middle_content' ); ?>

	<?php do_action( 'subetuweb_after_header_inner' ); ?>

</header>

<?php do_action( 'subetuweb_after_header' ); ?>