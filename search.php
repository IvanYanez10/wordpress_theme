<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package subetuwebWP WordPress theme
 */

get_header(); ?>

	<?php do_action( 'subetuweb_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'subetuweb_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'subetuweb_before_content' ); ?>

			<div id="content" class="site-content clr">

				<?php
				$logo_search = get_theme_mod( 'subetuweb_search_logo' );
				if ( ! empty( $logo_search ) ) {
					?>
					<img class="logo-search" src="<?php echo esc_url( $logo_search ); ?>" alt="<?php esc_html_e( 'Search Logo', 'subetuwebwp' ); ?>" title="<?php esc_html_e( 'Search Logo', 'subetuwebwp' ); ?>" />
				<?php } ?>
			
				<?php do_action( 'subetuweb_before_content_inner' ); ?>

				<?php if ( have_posts() ) : ?>

						<?php
						while ( have_posts() ) :
							the_post();
							?>

							<?php get_template_part( 'partials/search/layout' ); ?>

						<?php endwhile; ?>

					<?php subetuwebwp_pagination(); ?>

				<?php else : ?>

					<?php
					// Display no post found notice.
					get_template_part( 'partials/none' );
					?>

				<?php endif; ?>

				<?php do_action( 'subetuweb_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'subetuweb_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'subetuweb_after_primary' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'subetuweb_after_content_wrap' ); ?>

<?php get_footer(); ?>
