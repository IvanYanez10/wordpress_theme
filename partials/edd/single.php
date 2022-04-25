<?php
/**
 * Template for displaying single layout for easy digital downloads
 *
 * @package subetuwebWP WordPress theme
 */

global $post;

do_action( 'subetuweb_before_single_download_item' ); ?>
<div <?php post_class(); ?>>
	<div class="edd_download_inner">

		<h2 class="edd_download_title">
			<?php the_title(); ?>
		</h2>

		<?php
		if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) :
			?>
			<div class="edd_download_image">

				<?php do_action( 'subetuweb_before_single_download_image' ); ?>

				<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>

				<?php do_action( 'subetuweb_after_single_download_image' ); ?>

			</div>
		<?php endif; ?>

		<div class="edd_download_content">

			<?php do_action( 'subetuweb_before_single_download_content' ); ?>

			<?php the_content(); ?>

			<?php do_action( 'subetuweb_after_single_download_content' ); ?>

		</div>

		<?php
		if ( get_theme_mod( 'subetuweb_edd_display_navigation', true ) ) :
			?>
			<div class="edd_download_navigation">
				<?php
				// Term.
				$term_tax = get_theme_mod( 'subetuweb_edd_next_prev_taxonomy', 'download_tag' );
				$term_tax = $term_tax ? $term_tax : 'download_tag';

				// Args.
				$args = array(
					'prev_text'          => '<span class="title">' . subetuwebwp_icon( 'long_arrow_alt_left', false ) . ' ' . esc_html__( 'Previous', 'subetuwebwp' ) . '</span><span class="post-title">%title</span>',
					'next_text'          => '<span class="title">' . subetuwebwp_icon( 'long_arrow_alt_right', false ) . ' ' . esc_html__( 'Next', 'subetuwebwp' ) . '</span><span class="post-title">%title</span>',
					'in_same_term'       => true,
					'taxonomy'           => $term_tax,
					'screen_reader_text' => esc_html__( 'Continue Reading', 'subetuwebwp' ),
				);

				// Args.
				$args = apply_filters( 'subetuweb_single_post_next_prev_args', $args );

				?>

				<?php do_action( 'subetuweb_before_single_post_next_prev' ); ?>

				<?php the_post_navigation( $args ); ?>

				<?php do_action( 'subetuweb_after_single_post_next_prev' ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
do_action( 'subetuweb_after_single_download_item' ); ?>
