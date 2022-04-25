<?php
/**
 * The template for displaying the footer.
 *
 * @package subetuwebWP WordPress theme
 */

?>

	</main><!-- #main -->

	<?php do_action( 'subetuweb_after_main' ); ?>

	<?php do_action( 'subetuweb_before_footer' ); ?>

	<?php
	// Elementor `footer` location.
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
		?>

		<?php do_action( 'subetuweb_footer' ); ?>

	<?php } ?>

	<?php do_action( 'subetuweb_after_footer' ); ?>

</div><!-- #wrap -->

<?php do_action( 'subetuweb_after_wrap' ); ?>

</div><!-- #outer-wrap -->

<?php do_action( 'subetuweb_after_outer_wrap' ); ?>

<?php
// If is not sticky footer.
if ( ! class_exists( 'subetuweb_Sticky_Footer' ) ) {
	get_template_part( 'partials/scroll-top' );
}
?>

<?php
// Search overlay style.
if ( 'overlay' === subetuwebwp_menu_search_style() ) {
	get_template_part( 'partials/header/search-overlay' );
}
?>

<?php
// If sidebar mobile menu style.
if ( 'sidebar' === subetuwebwp_mobile_menu_style() ) {

	// Mobile panel close button.
	if ( get_theme_mod( 'subetuweb_mobile_menu_close_btn', true ) ) {
		get_template_part( 'partials/mobile/mobile-sidr-close' );
	}
	?>

	<?php
	// Mobile Menu (if defined).
	get_template_part( 'partials/mobile/mobile-nav' );
	?>

	<?php
	// Mobile search form.
	if ( get_theme_mod( 'subetuweb_mobile_menu_search', true ) ) {
		ob_start();
		get_template_part( 'partials/mobile/mobile-search' );
		echo ob_get_clean();
	}
}
?>

<?php
// If full screen mobile menu style.
if ( 'fullscreen' === subetuwebwp_mobile_menu_style() ) {
	get_template_part( 'partials/mobile/mobile-fullscreen' );
}
?>

<?php wp_footer(); ?>
</body>
</html>
