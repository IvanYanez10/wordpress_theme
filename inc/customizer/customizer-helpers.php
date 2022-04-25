<?php
/**
 * Active callback functions for the customizer
 *
 * @package subetuwebWP WordPress theme
 */

/*-------------------------------------------------------------------------------*/
/* [ Table of contents ]
/*-------------------------------------------------------------------------------*

	# Core
	# Background
	# Topbar
	# Header
	# Logo
	# Menu
	# Mobile
	# Page Header
	# Blog
	# WooCommerce
	# Footer

/*-------------------------------------------------------------------------------*/
/* [ Core ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_customizer_layout() {

	$layouts = array(
		'right-sidebar'  	=> [
			'name'  => 'right-sidebar',
			'image' => subetuwebWP_INC_DIR_URI . 'customizer/assets/img/rs.png'
		],
		'left-sidebar' 		=> [
			'name'  => 'left-sidebar',
			'image' => subetuwebWP_INC_DIR_URI . 'customizer/assets/img/ls.png'
		],
		'full-width'  		=> [
			'name'  => 'full-width',
			'image' => subetuwebWP_INC_DIR_URI . 'customizer/assets/img/fw.png'
		],
		'full-screen'  		=> [
			'name'  => 'full-screen',
			'image' => subetuwebWP_INC_DIR_URI . 'customizer/assets/img/fs.png'
		],
		'both-sidebars'  	=> [
			'name'  => 'both-sidebars',
			'image' => subetuwebWP_INC_DIR_URI . 'customizer/assets/img/bs.png'
		],
	);

	return $layouts;

}

function subetuwebwp_customizer_helpers( $return = NULL ) {

	// Return library templates array
	if ( 'library' == $return ) {
		$templates 		= array( '&mdash; '. esc_html__( 'Select', 'subetuwebwp' ) .' &mdash;' );
		$get_templates 	= get_posts( array( 'post_type' => 'subetuwebwp_library', 'numberposts' => -1, 'post_status' => 'publish' ) );

	    if ( ! empty ( $get_templates ) ) {
	    	foreach ( $get_templates as $template ) {
				$templates[ $template->ID ] = $template->post_title;
		    }
		}

		return $templates;
	}

}

function subetuwebwp_cac_has_boxed_layout() {
	if ( 'boxed' == get_theme_mod( 'subetuweb_main_layout_style', 'wide' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_separate_layout() {
	if ( 'separate' == get_theme_mod( 'subetuweb_main_layout_style', 'wide' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_boxed_or_separate_layout() {
	if ( 'boxed' == get_theme_mod( 'subetuweb_main_layout_style', 'wide' )
		|| 'separate' == get_theme_mod( 'subetuweb_main_layout_style', 'wide' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_boxed_layout() {
	if ( 'wide' == get_theme_mod( 'subetuweb_main_layout_style', 'wide' )
		|| 'separate' == get_theme_mod( 'subetuweb_main_layout_style', 'wide' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_page_single_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_page_single_layout', 'right-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_page_single_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_page_single_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_search_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_search_layout', 'right-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_search_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_search_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_page_header() {
	if ( 'hide-all-devices' != get_theme_mod( 'subetuweb_page_header_visibility' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		return true;
	} else {
		return get_theme_mod( 'subetuweb_breadcrumbs', true );
	}
}


function subetuwebwp_cac_enabled_not_yoast() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		return false;
	} else {
		return subetuwebwp_cac_has_breadcrumbs();
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Background ]
/*-------------------------------------------------------------------------------*/

function subetuwebwp_cac_has_background_image() {
	if ( '' != get_theme_mod( 'subetuweb_background_image' ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Topbar ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_topbar() {
	return get_theme_mod( 'subetuweb_top_bar', true );
}

function subetuwebwp_cac_has_topbar_social() {
	if ( subetuwebwp_cac_has_topbar()
		&& get_theme_mod( 'subetuweb_top_bar_social' ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Header ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_minimal_or_transparent_header_styles() {
	if ( 'minimal' == subetuwebwp_header_style()
		|| 'transparent' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_transparent_header_style() {
	if ( 'transparent' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_top_header_style() {
	if ( 'top' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_full_screen_header_style() {
	if ( 'full_screen' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_center_header_style() {
	if ( 'center' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_medium_header_style() {
	if ( 'medium' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_medium_header_style() {
	if ( 'medium' == subetuwebwp_header_style() ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_hasnt_medium_or_vertical_header_styles() {
	if ( 'medium' == subetuwebwp_header_style()
		|| 'vertical' == subetuwebwp_header_style() ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_has_vertical_header_style() {
	if ( 'vertical' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_menu_social() {
	if ( true == get_theme_mod( 'subetuweb_menu_social', false ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_menu_social_and_simple_style() {
	if ( true == get_theme_mod( 'subetuweb_menu_social', false )
		&& 'simple' == get_theme_mod( 'subetuweb_menu_social_style', 'simple' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_custom_header() {
	if ( 'custom' == subetuwebwp_header_style() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_header_styles() {
	if ( 'top' == subetuwebwp_header_style()
		|| 'medium' == subetuwebwp_header_style() ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_hasnt_medium_custom_header_styles() {
	if ( 'medium' == subetuwebwp_header_style()
		|| 'custom' == subetuwebwp_header_style() ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_mobile_header_position() {
	if ( 'medium' == subetuwebwp_header_style()
		|| 'vertical' == subetuwebwp_header_style()
		|| 'custom' == subetuwebwp_header_style() ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Logo ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_custom_logo() {
	if ( has_custom_logo() ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_custom_logo() {
	if ( has_custom_logo() ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_has_responsive_logo() {
	if ( '' != get_theme_mod( 'subetuweb_responsive_logo' ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Menu ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_hasnt_menu_search_disabled() {
	if ( 'disabled' == get_theme_mod( 'subetuweb_menu_search_style', 'drop_down' ) ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_has_menu_search_dropdown() {
	if ( 'drop_down' == get_theme_mod( 'subetuweb_menu_search_style', 'drop_down' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_menu_search_overlay() {
	if ( 'overlay' == get_theme_mod( 'subetuweb_menu_search_style', 'drop_down' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_menu_dropdown_top_border() {
	return get_theme_mod( 'subetuweb_menu_dropdown_top_border', false );
}

function subetuwebwp_cac_has_menu_links_effect_blue() {
	if ( 'one' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'three' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'four' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'five' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'seven' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'nine' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_menu_links_effect_dark() {
	if ( 'two' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'six' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'eight' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' )
		|| 'ten' == get_theme_mod( 'subetuweb_menu_links_effect', 'no' ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Mobile ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_mobile_menu_cac_has_custom_breakpoint() {
	if ( 'custom' == get_theme_mod( 'subetuweb_mobile_menu_breakpoints', '959' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_custom_hamburger_btn() {
	if ( 'default' != get_theme_mod( 'subetuweb_mobile_menu_open_hamburger', 'default' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_sidebar_mobile_menu() {
	if ( 'sidebar' == get_theme_mod( 'subetuweb_mobile_menu_style', 'sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_dropdown_mobile_menu() {
	if ( 'dropdown' == get_theme_mod( 'subetuweb_mobile_menu_style', 'sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_fullscreen_mobile_menu() {
	if ( 'fullscreen' == get_theme_mod( 'subetuweb_mobile_menu_style', 'sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_fullscreen_mobile_menu() {
	if ( 'fullscreen' == get_theme_mod( 'subetuweb_mobile_menu_style', 'sidebar' ) ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Page Header ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_bg_image_page_header() {
	if ( 'background-image' == get_theme_mod( 'subetuweb_page_header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_bg_image_page_header() {
	if ( 'background-image' == get_theme_mod( 'subetuweb_page_header_style' ) ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Blog ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_grid_blog_style() {
	if ( 'grid-entry' == get_theme_mod( 'subetuweb_blog_style', 'large-entry' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_blog_supports_equal_heights() {
	if ( subetuwebwp_cac_grid_blog_style()
		&& 'masonry' != get_theme_mod( 'subetuweb_blog_grid_style', 'fit-rows' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_blog_single_title_bg_image() {
	if ( true == get_theme_mod( 'subetuweb_blog_single_featured_image_title', false )
		&& 'default' === get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_blog_entries_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_blog_archives_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_blog_entries_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_blog_archives_layout', 'right-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_single_post_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_blog_single_layout', 'right-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_single_post_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_blog_single_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_thumbnail_blog_style() {
	if ( 'thumbnail-entry' == get_theme_mod( 'subetuweb_blog_style', 'large-entry' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_thumbnail_blog_style() {
	if ( 'thumbnail-entry' == get_theme_mod( 'subetuweb_blog_style', 'large-entry' ) ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_has_blog_infinite_scroll() {
	if ( 'infinite_scroll' == get_theme_mod( 'subetuweb_blog_pagination_style', 'standard' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_default_post_header_style() {
	$return = ( 'default' === get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' ) ) ? true : false;
	return $return;
}

function subetuwebwp_cac_hasnt_default_post_header_style() {
	$return = ( 'default' !== get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' ) ) ? true : false;
	return $return;
}

function subetuwebwp_cac_has_post_header_cover_style() {
	$return = ( 'sph_style_3' === get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' ) ) ? true : false;
	return $return;
}

function subetuwebwp_cac_has_post_meta_stylish() {
	$return = ( 'spm_style_3' === get_theme_mod( 'subetuwebwp_single_post_header_meta_style', 'default' ) && subetuwebwp_cac_hasnt_default_post_header_style() ) ? true : false;
	return $return;
}

function subetuwebwp_cac_has_not_cover_default_style() {
	$return = ( 'sph_style_3' !== get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' ) && 'default' !== get_theme_mod( 'subetuwebwp_single_post_header_style', 'default' ) ) ? true : false;
	return $return;
}

/*-------------------------------------------------------------------------------*/
/* [ WooCommerce ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_woo_bag_style() {
	if ( 'yes' == get_theme_mod( 'subetuweb_woo_menu_bag_style', 'no' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_woo_bag_style() {
	if ( 'yes' == get_theme_mod( 'subetuweb_woo_menu_bag_style', 'no' ) ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_has_grid_list_buttons() {
	if ( true == get_theme_mod( 'subetuweb_woo_grid_list', true ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_shop_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_woo_shop_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_shop_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_woo_shop_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_product_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_woo_product_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_product_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_woo_product_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_infinite_scroll() {
	if ( 'infinite_scroll' == get_theme_mod( 'subetuweb_woo_pagination_style', 'standard' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_filter_button() {
	if ( true == get_theme_mod( 'subetuweb_woo_off_canvas_filter', false ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_filter_close_button() {
	if ( true == get_theme_mod( 'subetuweb_woo_off_canvas_close_button', false ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_default_products_style() {
	if ( 'default' == get_theme_mod( 'subetuweb_woo_products_style', 'default' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_hover_products_style() {
	if ( 'hover' == get_theme_mod( 'subetuweb_woo_products_style', 'default' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_floating_bar() {
	if ( 'on' == get_theme_mod( 'subetuweb_woo_display_floating_bar', 'on' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_woo_multistep_checkout() {
	if ( true == get_theme_mod( 'subetuweb_woo_multi_step_checkout', false ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_shop_condition() {
	if ( true === get_theme_mod( 'subetuweb_shop_conditional', true ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_single_condition() {
	if ( true === get_theme_mod( 'subetuweb_woo_single_conditional', true ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_shop_links_disabled() {
	if ( true === get_theme_mod( 'subetuweb_shop_woo_disable_links', false ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Easy Digital Downloads ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_edd_bag_style() {
	if ( 'yes' == get_theme_mod( 'subetuweb_edd_menu_bag_style', 'no' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_hasnt_edd_bag_style() {
	if ( 'yes' == get_theme_mod( 'subetuweb_edd_menu_bag_style', 'no' ) ) {
		return false;
	} else {
		return true;
	}
}

function subetuwebwp_cac_has_edd_archive_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_edd_archive_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_edd_archive_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_edd_archive_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_edd_download_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_edd_download_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_edd_download_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_edd_download_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Footer ]
/*-------------------------------------------------------------------------------*/
function subetuwebwp_cac_has_scrolltop() {
	return get_theme_mod( 'subetuweb_scroll_top', true );
}

function subetuwebwp_cac_has_footer_widgets() {
	return get_theme_mod( 'subetuweb_footer_widgets', true );
}

function subetuwebwp_cac_has_footer_widgets_and_no_page_id() {
	if ( true == get_theme_mod( 'subetuweb_footer_widgets', true )
		&& '' == get_theme_mod( 'subetuweb_footer_widgets_page_id' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_footer_bottom() {
	return get_theme_mod( 'subetuweb_footer_bottom', true );
}

/*-------------------------------------------------------------------------------*/
/* [ LifterLMS ]
/*-------------------------------------------------------------------------------*/

function subetuwebwp_cac_has_llms_global_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_llms_global_layout', 'full-width' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_llms_global_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_llms_global_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_llms_course_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_llms_course_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_llms_course_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_llms_course_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_llms_lesson_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_llms_lesson_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_llms_lesson_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_llms_lesson_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ LearnDash ]
/*-------------------------------------------------------------------------------*/

function subetuwebwp_cac_has_ld_global_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_ld_global_layout', 'full-width' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_ld_global_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_ld_global_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_ld_course_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_ld_course_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_ld_course_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_ld_course_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_ld_lesson_bs_layout() {
	if ( 'both-sidebars' == get_theme_mod( 'subetuweb_ld_lesson_layout', 'left-sidebar' ) ) {
		return true;
	} else {
		return false;
	}
}

function subetuwebwp_cac_has_ld_lesson_rl_layout() {
	$layout = get_theme_mod( 'subetuweb_ld_lesson_layout', 'right-sidebar' );
	if ( 'right-sidebar' == $layout
		|| 'left-sidebar' == $layout ) {
		return true;
	} else {
		return false;
	}
}