<?php
/**
 * Single related posts
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only display for standard posts.
if ( 'post' !== get_post_type() ) {
	return;
}

// Number of columns for entries.
$subetuwebwp_columns = apply_filters( 'subetuweb_related_blog_posts_columns', absint( get_theme_mod( 'subetuweb_blog_related_columns', '3' ) ) );

// Term.
$term_tax = get_theme_mod( 'subetuweb_blog_related_taxonomy', 'category' );
$term_tax = $term_tax ? $term_tax : 'category';

// Create an array of current term ID's.
$terms     = wp_get_post_terms( get_the_ID(), $term_tax );
$terms_ids = array();
foreach ( $terms as $termkey ) {
	$terms_ids[] = $termkey->term_id;
}

// Query args.
$args = array(
	'posts_per_page' => apply_filters( 'subetuweb_related_blog_posts_count', absint( get_theme_mod( 'subetuweb_blog_related_count', '3' ) ) ),
	'orderby'        => 'rand',
	'post__not_in'   => array( get_the_ID() ),
	'no_found_rows'  => true,
	'tax_query'      => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-quote', 'post-format-link' ),
			'operator' => 'NOT IN',
		),
	),
);

// If category.
if ( 'category' === $term_tax ) {
	$args['category__in'] = $terms_ids;
}

// If tags.
if ( 'post_tag' === $term_tax ) {
	$args['tag__in'] = $terms_ids;
}

// Define image alt text usage status.
$srp_seo_set = get_theme_mod( 'subetuweb_enable_srp_fimage_alt', false );
$srp_seo_set = $srp_seo_set ? $srp_seo_set : false;

// Display date.
$srp_date = true;
$srp_date = apply_filters( 'subetuweb_related_posts_date', $srp_date );

// Args.
$args = apply_filters( 'subetuweb_blog_post_related_query_args', $args );

do_action( 'subetuweb_before_single_post_related_posts' );

// Related query arguments.
$subetuwebwp_related_query = new WP_Query( $args );

// If the custom query returns post display related posts section.
if ( $subetuwebwp_related_query->have_posts() ) :

	// Wrapper classes.
	$classes = 'clr';
	if ( 'full-screen' === subetuwebwp_post_layout() ) {
		$classes .= ' container';
	} ?>

	<section id="related-posts" class="<?php echo esc_attr( $classes ); ?>">

		<h3 class="theme-heading related-posts-title">
			<span class="text"><?php subetuwebwp_theme_strings( 'owp-string-single-related-posts', 'subetuwebwp' ); ?></span>
		</h3>

		<div class="subetuwebwp-row clr">

			<?php $subetuwebwp_count = 0; ?>

			<?php
			foreach ( $subetuwebwp_related_query->posts as $post ) :
				setup_postdata( $post );
				?>

				<?php
				$subetuwebwp_count++;

				// Disable embeds.
				$show_embeds = apply_filters( 'subetuweb_related_blog_posts_embeds', false );

				// Get post format.
				$format = get_post_format();

				// Add classes.
				$classes   = array( 'related-post', 'clr', 'col' );
				$classes[] = subetuwebwp_grid_class( $subetuwebwp_columns );
				$classes[] = 'col-' . $subetuwebwp_count;
				?>

				<article <?php post_class( $classes ); ?>>

					<?php
					// Display post video.
					if ( $show_embeds && 'video' === $format && subetuwebwp_get_post_video_html() === $video ) :
						?>

						<div class="related-post-video">
							<?php echo $video; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div><!-- .related-post-video -->

						<?php
						// Display post audio.
					elseif ( $show_embeds && 'audio' === $format && subetuwebwp_get_post_audio_html() === $audio ) :
						?>

						<div class="related-post-video">
							<?php echo $audio; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div><!-- .related-post-audio -->

						<?php
						// Display post thumbnail.
					elseif ( has_post_thumbnail() ) :
						?>

						<figure class="related-post-media clr">

							<a href="<?php the_permalink(); ?>" class="related-thumb">

								<?php
								// Image width.
								$img_width  = apply_filters( 'subetuweb_related_blog_posts_img_width', absint( get_theme_mod( 'subetuweb_blog_related_img_width' ) ) );
								$img_height = apply_filters( 'subetuweb_related_blog_posts_img_height', absint( get_theme_mod( 'subetuweb_blog_related_img_height' ) ) );

								// Images attr.
								$img_id  = get_post_thumbnail_id( get_the_ID(), 'full' );
								$img_url = wp_get_attachment_image_src( $img_id, 'full', true );
								if ( subetuweb_EXTRA_ACTIVE
									&& function_exists( 'subetuweb_extra_image_attributes' ) ) {
									$img_atts = subetuweb_extra_image_attributes( $img_url[1], $img_url[2], $img_width, $img_height );
								}

								// If subetuweb Extra is active and has a custom size.
								if ( subetuweb_EXTRA_ACTIVE
									&& function_exists( 'subetuweb_extra_resize' )
									&& ! empty( $img_atts ) ) {
									?>

									<img src="<?php echo subetuweb_extra_resize( $img_url[0], $img_atts['width'], $img_atts['height'], $img_atts['crop'], true, $img_atts['upscale'] ); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr( $img_width ); ?>" height="<?php echo esc_attr( $img_height ); ?>"<?php subetuwebwp_schema_markup( 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> />

									<?php
								} else {

									// Images size.
									if ( 'full-width' === subetuwebwp_post_layout()
										|| 'full-screen' === subetuwebwp_post_layout() ) {
										$size = 'medium_large';
									} else {
										$size = 'medium';
									}

									// Retreive image alt text or use subetuwebWP default text if image alt text not set.
									$srpfe_img_alt = get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true);

									$srp_fimage_alt = ( false === $srp_seo_set || ( true === $srp_seo_set && ! $srpfe_img_alt ) ) ? subetuwebwp_theme_strings( 'owp-string-read-more-article', false ) . ' ' . get_the_title() : $srpfe_img_alt;

									// Image args.
									$img_args = array(
										'alt' => $srp_fimage_alt,
									);
									if ( subetuwebwp_get_schema_markup( 'image' ) ) {
										$img_args['itemprop'] = 'image';
									}

									// Display post thumbnail.
									the_post_thumbnail( $size, $img_args );

								}
								?>
							</a>

						</figure>

					<?php endif; ?>

					<h3 class="related-post-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3><!-- .related-post-title -->

					<?php if ( true === $srp_date ) { ?>			
						<time class="published" datetime="<?php echo esc_html( get_the_date( 'c' ) ); ?>"><?php subetuwebwp_icon( 'date' ); ?><?php echo esc_html( get_the_date() ); ?></time>
					<?php } ?>	
					
				</article><!-- .related-post -->

				<?php
				if ( $subetuwebwp_columns === $subetuwebwp_count ) {
					$subetuwebwp_count = 0;
				}
				?>

			<?php endforeach; ?>

		</div><!-- .subetuwebwp-row -->

	</section><!-- .related-posts -->

<?php endif; ?>

<?php wp_reset_postdata(); ?>

<?php do_action( 'subetuweb_after_single_post_related_posts' ); ?>
