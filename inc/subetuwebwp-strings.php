<?php
/**
 * subetuwebWP theme strings
 *
 * @package subetuwebWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'subetuwebwp_theme_strings' ) ) {

	/**
	 * subetuwebWP Theme Strings
	 *
	 *  @author Amit Singh (apprimit@gmail.com)
	 *  @since 1.8.5
	 *
	 * @param  string  $value  String key.
	 * @param  boolean $echo   Print string.
	 * @return mixed           Return string or nothing.
	 */
	function subetuwebwp_theme_strings( $value, $echo = true ) {

		$subetuwebwp_strings = apply_filters(
			'subetuwebwp_theme_strings',
			array(

				'owp-string-header-skip-link'            => apply_filters( 'subetuweb_header_skip_link', __( 'Skip to content', 'subetuwebwp' ) ),
				'owp-string-search-text'                 => apply_filters( 'subetuweb_search_text', __( 'Search', 'subetuwebwp' ) ),
				'owp-string-header-replace-search-text'  => apply_filters( 'subetuweb_header_replace_search_text', __( 'Type then hit enter to search...', 'subetuwebwp' ) ),
				'owp-string-search-overlay-search-text'  => apply_filters( 'subetuweb_search_overlay_search_text', __( 'Type then hit enter to search', 'subetuwebwp' ) ),
				'owp-string-vertical-header-search-text' => apply_filters( 'subetuweb_vertical_header_search_text', __( 'Search...', 'subetuwebwp' ) ),
				'owp-string-medium-header-search-text'   => apply_filters( 'subetuweb_medium_header_search_text', __( 'Search...', 'subetuwebwp' ) ),
				'owp-string-comment-logout-text'         => apply_filters( 'subetuweb_comment_logout_text', __( 'Log out of this account', 'subetuwebwp' ) ),
				'owp-string-comment-placeholder'         => apply_filters( 'subetuweb_comment_placeholder', __( 'Your comment here...', 'subetuwebwp' ) ),
				'owp-string-comment-profile-edit'        => apply_filters( 'subetuweb_comment_profile_edit', __( 'Click to edit your profile', 'subetuwebwp' ) ),
				'owp-string-comment-post-button'         => apply_filters( 'subetuweb_comment_post_button', __( 'Post Comment', 'subetuwebwp' ) ),
				'owp-string-comment-name-req'            => apply_filters( 'subetuweb_comment_name_req', __( 'Name (required)', 'subetuwebwp' ) ),
				'owp-string-comment-email-req'           => apply_filters( 'subetuweb_comment_email_req', __( 'Email (required)', 'subetuwebwp' ) ),
				'owp-string-comment-name'                => apply_filters( 'subetuweb_comment_name', __( 'Name', 'subetuwebwp' ) ),
				'owp-string-comment-email'               => apply_filters( 'subetuweb_comment_email', __( 'Email', 'subetuwebwp' ) ),
				'owp-string-comment-website'             => apply_filters( 'subetuweb_comment_website', __( 'Website', 'subetuwebwp' ) ),
				'owp-string-post-continue-reading'       => apply_filters( 'subetuweb_post_continue_reading', __( 'Continue Reading', 'subetuwebwp' ) ),
				'owp-string-single-related-posts'        => apply_filters( 'subetuweb_single_related_posts', __( 'You Might Also Like', 'subetuwebwp' ) ),
				'owp-string-single-next-post'            => apply_filters( 'subetuweb_single_next_post', __( 'Next Post', 'subetuwebwp' ) ),
				'owp-string-single-prev-post'            => apply_filters( 'subetuweb_single_prev_post', __( 'Previous Post', 'subetuwebwp' ) ),
				'owp-string-single-screen-reader-rm'     => apply_filters( 'subetuweb_single_screen_reader_rm', __( 'Read more articles', 'subetuwebwp' ) ),
				'owp-string-author-page'                 => apply_filters( 'subetuweb_author_page', __( 'Visit author page', 'subetuwebwp' ) ),

				// Aria.
				'owp-string-close-mobile-menu'           => apply_filters( 'subetuweb_wai_close_mobile_menu', __( 'Close mobile menu', 'subetuwebwp' ) ),
				'owp-string-scroll-top'                  => apply_filters( 'subetuweb_wai_scroll_top', __( 'Scroll to the top of the page', 'subetuwebwp' ) ),
				'owp-string-link-post-format'            => apply_filters( 'subetuweb_wai_link_post_format', __( 'Visit this link', 'subetuwebwp' ) ),
				'owp-string-new-tab-alert'               => apply_filters( 'subetuweb_wai_new_tab_alert', __( 'Opens in a new tab', 'subetuwebwp' ) ),
				'owp-string-read-more'                   => apply_filters( 'subetuweb_wai_read_more', __( 'Read more about', 'subetuwebwp' ) ),
				'owp-string-read-more-article'           => apply_filters( 'subetuweb_wai_read_more_article', __( 'Read more about the article', 'subetuwebwp' ) ),
				'owp-string-current-read'                => apply_filters( 'subetuweb_wai_current_read', __( 'You are currently viewing', 'subetuwebwp' ) ),
				'owp-string-author-img'                  => apply_filters( 'subetuweb_wai_author_img', __( 'Post author avatar', 'subetuwebwp' ) ),

				// Post Header templates.
				'owp-string-posted-by'                   => apply_filters( 'subetuweb_posted_by', _x( 'By', 'Prefix for post author name', 'subetuwebwp' ) ),
				'owp-string-written-by'                  => apply_filters( 'subetuweb_written_by', _x( 'Written by', 'Prefix for post author name', 'subetuwebwp' ) ),
				'owp-string-all-posts-by'                => apply_filters( 'subetuweb_wai_all_posts_by', _x( 'All posts by', 'Aria label prefix for post author link', 'subetuwebwp' ) ),
				'owp-string-posted-on'                   => apply_filters( 'subetuweb_posted_on', _x( 'Published', 'Prefix for post published date', 'subetuwebwp' ) ),
				'owp-string-updated-on'                  => apply_filters( 'subetuweb_updated_on', _x( 'Updated', 'Prefix for post modified date', 'subetuwebwp' ) ),
				'owp-string-reading-one'                 => apply_filters( 'subetuweb_reading_one', _x( 'min read', 'Suffix for post reading time equal to 1', 'subetuwebwp' ) ),
				'owp-string-reading-more'                => apply_filters( 'subetuweb_reading_more', _x( 'mins read', 'Suffix for post reading time more than 1', 'subetuwebwp' ) ),
				'owp-string-posted-in'                   => apply_filters( 'subetuweb_posted_in', _x( 'Posted in', 'Prefix for categories list', 'subetuwebwp' ) ),
				'owp-string-tagged-as'                   => apply_filters( 'subetuweb_tagged_as', _x( 'Tagged as', 'Prefix for tags list', 'subetuwebwp' ) ),
				'owp-string-wai-updated-on'              => apply_filters( 'subetuweb_wai_updated_on', _x( 'Updated on', 'Aria label: post modified date', 'subetuwebwp' ) ),
				'owp-string-wai-published-on'            => apply_filters( 'subetuweb_wai_published_on', _x( 'Published on', 'Aria label: post published date', 'subetuwebwp' ) ),
				'owp-string-wai-reading-time'            => apply_filters( 'subetuweb_wai_reading_time', _x( 'Reading time', 'Aria label: post reading time', 'subetuwebwp' ) ),
				'owp-string-wai-comments'                => apply_filters( 'subetuweb_wai_comments', _x( 'Comments', 'Aria label: post comments', 'subetuwebwp' ) ),

			)
		);

		if ( is_rtl() ) {
			// do your stuff.
		}

		$owp_string = isset( $subetuwebwp_strings[ $value ] ) ? $subetuwebwp_strings[ $value ] : '';

		/**
		 * Print or return strings
		 */
		if ( $echo ) {
			echo $owp_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $owp_string;
		}
	}
}
