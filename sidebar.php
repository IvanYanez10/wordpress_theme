<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package subetuwebWP WordPress theme
 */

// Retunr if full width or full screen.
if ( in_array( subetuwebwp_post_layout(), array( 'full-screen', 'full-width' ), true ) ) {
	return;
} ?>

<?php do_action( 'subetuweb_before_sidebar' ); ?>

<aside id="right-sidebar" class="sidebar-container widget-area sidebar-primary"<?php subetuwebwp_schema_markup( 'sidebar' ); ?> role="complementary" aria-label="<?php esc_attr_e( 'Primary Sidebar', 'subetuwebwp' ); ?>">

	<?php do_action( 'subetuweb_before_sidebar_inner' ); ?>

	<div id="right-sidebar-inner" class="clr">

		<?php
		$sidebar = subetuwebwp_get_sidebar();
		if ( $sidebar ) {
			dynamic_sidebar( $sidebar );
		}
		?>

	</div><!-- #sidebar-inner -->

	<?php do_action( 'subetuweb_after_sidebar_inner' ); ?>

</aside><!-- #right-sidebar -->

<?php do_action( 'subetuweb_after_sidebar' ); ?>
