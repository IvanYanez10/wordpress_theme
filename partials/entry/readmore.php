<?php
/**
 * Displays post entry read more
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define read more icon.
$icon = '';
$icon = is_rtl() ? subetuwebwp_icon( 'angle_left', false ) : subetuwebwp_icon( 'angle_right', false );

$blog_continue_reading_content = '';
ob_start();
?>
<a href="<?php the_permalink(); ?>"><?php subetuwebwp_theme_strings( 'owp-string-post-continue-reading' ); ?><span class="screen-reader-text"><?php the_title(); ?></span><?php echo $icon; ?></a>
<?php
$blog_continue_reading_content .= ob_get_clean();
?>

<?php do_action( 'subetuweb_before_blog_entry_readmore' ); ?>

<div class="blog-entry-readmore clr">
	<?php echo $blog_continue_reading_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div><!-- .blog-entry-readmore -->

<?php do_action( 'subetuweb_after_blog_entry_readmore' ); ?>
