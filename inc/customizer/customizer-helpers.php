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

/*-------------------------------------------------------------------------------*/
/* [ Footer ]
/*-------------------------------------------------------------------------------*/

function subetuwebwp_cac_has_footer_bottom() {
	return get_theme_mod( 'subetuweb_footer_bottom', true );
}