<?php
/**
 * The default template for displaying post meta.
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get meta sections.
$sections = subetuwebwp_blog_entry_meta();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}

// Get meta separator style.
$meta_class = subetuwebwp_theme_blog_meta_separator();

do_action( 'subetuweb_before_blog_entry_meta' );
?>

<ul class="meta obem-<?php echo $meta_class; ?> clr" aria-label="<?php esc_attr_e( 'Post details:', 'subetuwebwp' ); ?>">

	<?php
	// Loop through meta sections.
	foreach ( $sections as $section ) {
		?>

		<?php if ( 'author' === $section ) { ?>
			<li class="meta-author"<?php subetuwebwp_schema_markup( 'author_name' ); ?>><span class="screen-reader-text"><?php esc_html_e( 'Post author:', 'subetuwebwp' ); ?></span><?php subetuwebwp_icon( 'user' ); ?><?php echo esc_html( the_author_posts_link() ); ?></li>
		<?php } ?>

		<?php if ( 'date' === $section ) { ?>
			<li class="meta-date"<?php subetuwebwp_schema_markup( 'publish_date' ); ?>><span class="screen-reader-text"><?php esc_html_e( 'Post published:', 'subetuwebwp' ); ?></span><?php subetuwebwp_icon( 'date' ); ?><?php echo get_the_date(); ?></li>
		<?php } ?>

		<?php if ( 'mod-date' === $section ) { ?>
			<li class="meta-mod-date"<?php subetuwebwp_schema_markup( 'modified_date' ); ?>><span class="screen-reader-text"><?php esc_html_e( 'Post last modified:', 'subetuwebwp' ); ?></span><?php subetuwebwp_icon( 'm_date' ); ?><?php echo esc_html( get_the_modified_date() ); ?></li>
		<?php } ?>

		<?php if ( 'categories' === $section ) { ?>
			<li class="meta-cat"><span class="screen-reader-text"><?php esc_html_e( 'Post category:', 'subetuwebwp' ); ?></span><?php subetuwebwp_icon( 'category' ); ?><?php the_category( '<span class="owp-sep" aria-hidden="true">/</span>', get_the_ID() ); ?></li>
		<?php } ?>

		<?php if ( 'reading-time' === $section ) { ?>
			<li class="meta-cat"><span class="screen-reader-text"><?php esc_html_e( 'Reading time:', 'subetuwebwp' ); ?></span><?php subetuwebwp_icon( 'r_time' ); ?><?php echo esc_html( subetuweb_reading_time() ); ?></li>
		<?php } ?>

		<?php if ( 'comments' === $section && comments_open() && ! post_password_required() ) { ?>
			<li class="meta-comments"><span class="screen-reader-text"><?php esc_html_e( 'Post comments:', 'subetuwebwp' ); ?></span><?php subetuwebwp_icon( 'comment' ); ?><?php comments_popup_link( esc_html__( '0 Comments', 'subetuwebwp' ), esc_html__( '1 Comment', 'subetuwebwp' ), esc_html__( '% Comments', 'subetuwebwp' ), 'comments-link' ); ?></li>
		<?php } ?>

	<?php } ?>

</ul>

<?php do_action( 'subetuweb_after_blog_entry_meta' ); ?>
