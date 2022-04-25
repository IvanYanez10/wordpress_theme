<?php
/**
 * Displays the post entry header
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Heading tag.
$heading = get_theme_mod( 'subetuweb_blog_entries_heading_tag', 'h2' );
$heading = $heading ? $heading : 'h2';
$heading = apply_filters( 'subetuweb_blog_entries_heading', $heading ); ?>

<?php do_action( 'subetuweb_before_blog_entry_title' ); ?>

<header class="blog-entry-header clr">
	<<?php echo esc_attr( $heading ); ?> class="blog-entry-title entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</<?php echo esc_attr( $heading ); ?>><!-- .blog-entry-title -->
</header><!-- .blog-entry-header -->

<?php do_action( 'subetuweb_after_blog_entry_title' ); ?>
