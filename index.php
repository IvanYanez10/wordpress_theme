<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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

				<?php do_action( 'subetuweb_before_content_inner' ); ?>

				<?php
				// Check if posts exist.
				if ( have_posts() ) :

					// Elementor `archive` location.
					if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {

						// Add Support For EDD Archive Pages.
						if ( is_post_type_archive( 'download' ) || is_tax( array( 'download_category', 'download_tag' ) ) ) {

							do_action( 'subetuweb_before_archive_download' );
							?>

							<div class="subetuwebwp-row <?php echo esc_attr( subetuwebwp_edd_loop_classes() ); ?>">
								<?php
								// Archive Post Count for clearing float.
								$subetuwebwp_count = 0;
								while ( have_posts() ) :
									the_post();
									$subetuwebwp_count++;
									get_template_part( 'partials/edd/archive' );
									if ( subetuwebwp_edd_entry_columns() === $subetuwebwp_count ) {
										$subetuwebwp_count = 0;
									}
								endwhile;
								?>
							</div>

							<?php
							do_action( 'subetuweb_after_archive_download' );
						} else {
							?>
						<div id="blog-entries" class="<?php subetuwebwp_blog_wrap_classes(); ?>">

							<?php
							// Define counter for clearing floats.
							$subetuwebwp_count = 0;
							?>

							<?php
							// Loop through posts.
							while ( have_posts() ) :
								the_post();
								?>

								<?php
								// Add to counter.
								$subetuwebwp_count++;
								?>

								<?php
								// Get post entry content.
								get_template_part( 'partials/entry/layout', get_post_type() );
								?>

								<?php
								// Reset counter to clear floats.
								if ( subetuwebwp_blog_entry_columns() === $subetuwebwp_count ) {
									$subetuwebwp_count = 0;
								}
								?>

							<?php endwhile; ?>

						</div><!-- #blog-entries -->

							<?php
							// Display post pagination.
							subetuwebwp_blog_pagination();
						}
					}
					?>

					<?php
					// No posts found.
					else :
						?>

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
