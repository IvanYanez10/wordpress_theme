<?php
/**
 * The Header for our theme.
 *
 * @package subetuwebWP WordPress theme
 */

?>
<!DOCTYPE html>
<html class="<?php echo esc_attr( subetuwebwp_html_classes() ); ?>" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php subetuwebwp_schema_markup( 'html' ); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'subetuweb_before_outer_wrap' ); ?>

	<div id="outer-wrap" class="site clr">

		<a class="skip-link screen-reader-text" href="#main"><?php subetuwebwp_theme_strings( 'owp-string-header-skip-link', 'subetuwebwp' ); ?></a>

		<?php do_action( 'subetuweb_before_wrap' ); ?>

		<div id="wrap" class="clr">

			<?php do_action( 'subetuweb_top_bar' ); ?>

			<?php do_action( 'subetuweb_header' ); ?>

			<?php do_action( 'subetuweb_before_main' ); ?>

			<main id="main" class="site-main clr"<?php subetuwebwp_schema_markup( 'main' ); ?> role="main">

				<?php do_action( 'subetuweb_page_header' ); ?>
