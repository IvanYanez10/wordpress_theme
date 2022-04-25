<?php
/**
 * The left sidebar containing the widget area.
 *
 * @package subetuwebWP WordPress theme
 */

?>

<?php do_action( 'subetuweb_before_sidebar' ); ?>

<aside id="left-sidebar" class="sidebar-container widget-area sidebar-secondary"<?php subetuwebwp_schema_markup( 'sidebar' ); ?> role="complementary" aria-label="<?php esc_attr_e( 'Secondary Sidebar', 'subetuwebwp' ); ?>">

	<?php do_action( 'subetuweb_before_sidebar_inner' ); ?>

	<div id="left-sidebar-inner" class="clr">

		<?php
		$sidebar = subetuwebwp_get_second_sidebar();
		if ( $sidebar ) {
			dynamic_sidebar( $sidebar );
		}
		?>

	</div><!-- #sidebar-inner -->

	<?php do_action( 'subetuweb_after_sidebar_inner' ); ?>

</aside><!-- #sidebar -->

<?php do_action( 'subetuweb_after_sidebar' ); ?>
