<?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @package subetuwebWP WordPress theme
 */

get_header(); 

wp_body_open(); 

?>

singular
	<?php do_action( 'subetuweb_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'subetuweb_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'subetuweb_before_content' ); ?>

			<div id="content" class="site-content clr">

				<?php do_action( 'subetuweb_before_content_inner' ); ?>

				<?php

					// Start loop.
					while ( have_posts() ) :
						the_post();
						
						if ( is_singular( 'page' ) ) {

							// Single post.
							get_template_part( 'partials/page/layout' );

						} elseif ( is_singular( 'subetuwebwp_library' ) ) {
							echo 'library';
							// Library post types.
							get_template_part( 'partials/library/layout' );

						} else {

							echo 'singular single';
							// All other post types.
							get_template_part( 'partials/single/layout', get_post_type() );

						}

					endwhile;

				?>

				<?php do_action( 'subetuweb_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'subetuweb_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'subetuweb_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'subetuweb_after_content_wrap' ); ?>

<?php get_footer(); ?>
