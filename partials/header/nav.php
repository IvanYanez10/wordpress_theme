<?php
/**
 * Header menu template part.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Get ID.
$template = subetuwebwp_custom_nav_template();

// Get content.
$get_content = subetuwebwp_nav_template_content();

// Nav attributes.
$owp_nav_attrs = apply_filters( 'subetuwebwp_attrs_main_nav', '' );

if ( ! empty( $template ) && ! defined( 'subetuwebWP_NAV_SHORTCODE_DONE' ) ) {
	do_action( 'subetuweb_before_nav' );

	if ( preg_match( '(subetuwebwp_nav|subetuweb_wp)', $get_content ) === 1 ) {
		define( 'subetuwebWP_NAV_SHORTCODE_DONE', true );
	}

	do_action( 'subetuweb_before_nav_inner' );

		
	if ( subetuwebWP_BEAVER_BUILDER_ACTIVE && ! empty( $template ) ) {

		// If Beaver Builder.
		echo do_shortcode( '[fl_builder_insert_layout id="' . $template . '"]' );

	} else {

		// Display template content.
		echo do_shortcode( $get_content );

	}

	do_action( 'subetuweb_after_nav_inner' );


	do_action( 'subetuweb_after_nav' );

} else {

	// Menu Location.
	$menu_location = apply_filters( 'subetuweb_main_menu_location', 'main_menu' );

	// Multisite global menu.
	$ms_global_menu = apply_filters( 'subetuweb_ms_global_menu', false );

	// Get menu classes.	
	$menu_classes = array( 'nav nav-pills' );	

	// Turn menu classes into space seperated string.
	$menu_classes = implode( ' ', $menu_classes );

	// Menu arguments.
	$menu_args = array(
		'theme_location' => $menu_location,
		'menu_class'     => $menu_classes,
		'container'      => false,
		'fallback_cb'    => false,
		'add_li_class'  => 'nav-item',
		'link_class' => 'nav-link',
		'items_wrap'     => '%3$s',
	);

	do_action( 'subetuweb_before_nav' );

	do_action( 'subetuweb_before_nav_inner' ); 
	
?>

<nav id="site-navigation" class="<?php echo esc_attr( $inner_classes ); ?> d-flex flex-wrap justify-content-end py-3 mb-4 navbar-expand-lg"
	<?php subetuwebwp_schema_markup( 'site_navigation' ); ?> role="navigation" <?php echo $owp_nav_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div id="site-logo-inner" class="clr">

		<div id="site-logo" class="<?php echo esc_attr( subetuwebwp_header_logo_classes() ); ?>"<?php subetuwebwp_schema_markup( 'logo' ); ?> >

	<?php do_action( 'subetuweb_before_logo_inner' ); ?>

	<div id="site-logo-inner" class="clr">

		<?php
		// Custom site-wide image logo.
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {

			do_action( 'subetuweb_before_logo_img' );

			// Default logo.
			the_custom_logo();

			do_action( 'subetuweb_after_logo_img' );

		}	
		?>

	</div><!-- #site-logo-inner -->

	<?php do_action( 'subetuweb_after_logo_inner' ); ?>

</div><!-- #site-logo -->

	</div><!-- #site-logo-inner -->
	<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
		<i class="fa-solid fa-bars"></i>
	</button>

	<div class="collapse navbar-collapse" id="navbarCollapse">
			<div class="navbar-nav ms-auto nav nav-pills">
				<?php wp_nav_menu( $menu_args ); ?>
				<a href="#" class="contact-btn">Contacto</a>	
			</div>
	</div>

</nav>


<?php do_action( 'subetuweb_after_nav_inner' ); ?>

<?php do_action( 'subetuweb_after_nav' ); } ?>
