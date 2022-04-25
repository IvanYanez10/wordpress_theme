<?php
/**
 * Top Bar Customizer Options
 *
 * @package subetuwebWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'subetuwebWP_Top_Bar_Customizer' ) ) :

	class subetuwebWP_Top_Bar_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register', 	array( $this, 'customizer_options' ) );
			add_filter( 'subetuweb_head_css', 		array( $this, 'head_css' ) );

		}

		/**
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function customizer_options( $wp_customize ) {

			/**
			 * Panel
			 */
			$panel = 'subetuweb_topbar_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'Top Bar', 'subetuwebwp' ),
				'priority' 			=> 210,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'subetuweb_topbar_general' , array(
				'title' 			=> esc_html__( 'General', 'subetuwebwp' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Top Bar
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar', array(
				'label'	   				=> esc_html__( 'Enable Top Bar', 'subetuwebwp' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Top Bar Full Width
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_full_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> false,
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_full_width', array(
				'label'	   				=> esc_html__( 'Top Bar Full Width', 'subetuwebwp' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_full_width',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Visibility
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_visibility', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'all-devices',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_visibility', array(
				'label'	   				=> esc_html__( 'Visibility', 'subetuwebwp' ),
				'type' 					=> 'select',
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_visibility',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
				'choices' 				=> array(
					'all-devices' 			=> esc_html__( 'Show On All Devices', 'subetuwebwp' ),
					'hide-tablet' 			=> esc_html__( 'Hide On Tablet', 'subetuwebwp' ),
					'hide-mobile' 			=> esc_html__( 'Hide On Mobile', 'subetuwebwp' ),
					'hide-tablet-mobile' 	=> esc_html__( 'Hide On Tablet & Mobile', 'subetuwebwp' ),
				),
			) ) );

			/**
			 * Top Bar Style
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_style', array(
				'default'           	=> 'one',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_style', array(
				'label'	   				=> esc_html__( 'Style', 'subetuwebwp' ),
				'type' 					=> 'select',
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_style',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
				'choices' 				=> array(
					'one' 		=> esc_html__( 'Left Content & Right Social', 'subetuwebwp' ),
					'two' 		=> esc_html__( 'Left Social & Right Content', 'subetuwebwp' ),
					'three' 	=> esc_html__( 'Centered Content & Social', 'subetuwebwp' ),
				),
			) ) );

			/**
			 * Top Bar Padding
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '8',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_right_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '8',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_left_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'subetuweb_top_bar_tablet_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_tablet_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_tablet_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_tablet_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'subetuweb_top_bar_mobile_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_mobile_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_mobile_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_mobile_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Dimensions_Control( $wp_customize, 'subetuweb_top_bar_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_general',
				'settings' => array(
		            'desktop_top' 		=> 'subetuweb_top_bar_top_padding',
		            'desktop_right' 	=> 'subetuweb_top_bar_right_padding',
		            'desktop_bottom' 	=> 'subetuweb_top_bar_bottom_padding',
		            'desktop_left' 		=> 'subetuweb_top_bar_left_padding',
		            'tablet_top' 		=> 'subetuweb_top_bar_tablet_top_padding',
		            'tablet_right' 		=> 'subetuweb_top_bar_tablet_right_padding',
		            'tablet_bottom' 	=> 'subetuweb_top_bar_tablet_bottom_padding',
		            'tablet_left' 		=> 'subetuweb_top_bar_tablet_left_padding',
		            'mobile_top' 		=> 'subetuweb_top_bar_mobile_top_padding',
		            'mobile_right' 		=> 'subetuweb_top_bar_mobile_right_padding',
		            'mobile_bottom' 	=> 'subetuweb_top_bar_mobile_bottom_padding',
		            'mobile_left' 		=> 'subetuweb_top_bar_mobile_left_padding',
			    ),
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Bar Background Color
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_bg',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Border Color
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#f1f1f1',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_border_color', array(
				'label'	   				=> esc_html__( 'Border Color', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_border_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Text Color
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_text_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#929292',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_text_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_text_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Link Color
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#555555',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_link_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Link Color Hover
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_general',
				'settings' 				=> 'subetuweb_top_bar_link_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'subetuweb_topbar_content' , array(
				'title' 			=> esc_html__( 'Content', 'subetuwebwp' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Top Bar Template
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_template', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_template', array(
				'label'	   				=> esc_html__( 'Select Template', 'subetuwebwp' ),
				'description'	   		=> esc_html__( 'Choose a template created in Theme Panel > My Library to replace the content.', 'subetuwebwp' ),
				'type' 					=> 'select',
				'section'  				=> 'subetuweb_topbar_content',
				'settings' 				=> 'subetuweb_top_bar_template',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
				'choices' 				=> subetuwebwp_customizer_helpers( 'library' ),
			) ) );

			/**
			 * Top Bar Content
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_content', array(
				'transport'           	=> 'postMessage',
				'default'           	=> esc_html__( 'Place your content here', 'subetuwebwp' ),
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Textarea_Control( $wp_customize, 'subetuweb_top_bar_content', array(
				'label'	   				=> esc_html__( 'Content', 'subetuwebwp' ),
				'description'	   		=> sprintf( esc_html__( 'Shortcodes allowed, %1$ssee the list%2$s.', 'subetuwebwp' ), '<a href="http://docs.subetuwebwp.org/category/369-shortcodes" target="_blank">', '</a>' ),
				'section'  				=> 'subetuweb_topbar_content',
				'settings' 				=> 'subetuweb_top_bar_content',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'subetuweb_topbar_social' , array(
				'title' 			=> esc_html__( 'Social', 'subetuwebwp' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Top Bar Social
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_social', array(
				'label'	   				=> esc_html__( 'Enable Social', 'subetuwebwp' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'subetuweb_topbar_social',
				'settings' 				=> 'subetuweb_top_bar_social',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar',
			) ) );

			/**
			 * Top Bar Social Alternative
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social_alt_template', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_social_alt_template', array(
				'label'	   				=> esc_html__( 'Social Alternative', 'subetuwebwp' ),
				'description'	   		=> esc_html__( 'Choose a template created in Theme Panel > My Library.', 'subetuwebwp' ),
				'type' 					=> 'select',
				'section'  				=> 'subetuweb_topbar_social',
				'settings' 				=> 'subetuweb_top_bar_social_alt_template',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
				'choices' 				=> subetuwebwp_customizer_helpers( 'library' ),
			) ) );

			/**
			 * Top Bar Social Link Target
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social_target', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'blank',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_social_target', array(
				'label'	   				=> esc_html__( 'Social Link Target', 'subetuwebwp' ),
				'type' 					=> 'select',
				'section'  				=> 'subetuweb_topbar_social',
				'settings' 				=> 'subetuweb_top_bar_social_target',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
				'choices' 				=> array(
					'blank' => esc_html__( 'New Window', 'subetuwebwp' ),
					'self' 	=> esc_html__( 'Same Window', 'subetuwebwp' ),
				),
			) ) );

			/**
			 * Top Bar Social Font Size
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social_font_size', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '14',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'subetuweb_top_bar_social_tablet_font_size', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'subetuweb_top_bar_social_mobile_font_size', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Slider_Control( $wp_customize, 'subetuweb_top_bar_social_font_size', array(
				'label' 			=> esc_html__( 'Font Size (px)', 'subetuwebwp' ),
				'section'  			=> 'subetuweb_topbar_social',
				'settings' => array(
		            'desktop' 	=> 'subetuweb_top_bar_social_font_size',
		            'tablet' 	=> 'subetuweb_top_bar_social_tablet_font_size',
		            'mobile' 	=> 'subetuweb_top_bar_social_mobile_font_size',
			    ),
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Bar Social Padding
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social_right_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '6',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_social_left_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '6',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'subetuweb_top_bar_social_tablet_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_social_tablet_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'subetuweb_top_bar_social_mobile_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'subetuweb_top_bar_social_mobile_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Dimensions_Control( $wp_customize, 'subetuweb_top_bar_social_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_social',
				'settings' => array(
		            'desktop_right' 	=> 'subetuweb_top_bar_social_right_padding',
		            'desktop_left' 		=> 'subetuweb_top_bar_social_left_padding',
		            'tablet_right' 		=> 'subetuweb_top_bar_social_tablet_right_padding',
		            'tablet_left' 		=> 'subetuweb_top_bar_social_tablet_left_padding',
		            'mobile_right' 		=> 'subetuweb_top_bar_social_mobile_right_padding',
		            'mobile_left' 		=> 'subetuweb_top_bar_social_mobile_left_padding',
			    ),
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 60,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Top Bar Social Link Color
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social_links_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#bbbbbb',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_social_links_color', array(
				'label'	   				=> esc_html__( 'Social Links Color', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_social',
				'settings' 				=> 'subetuweb_top_bar_social_links_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
			) ) );

			/**
			 * Top Bar Social Link Color Hover
			 */
			$wp_customize->add_setting( 'subetuweb_top_bar_social_hover_links_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'subetuwebwp_sanitize_color',
			) );

			$wp_customize->add_control( new subetuwebWP_Customizer_Color_Control( $wp_customize, 'subetuweb_top_bar_social_hover_links_color', array(
				'label'	   				=> esc_html__( 'Social Links Color: Hover', 'subetuwebwp' ),
				'section'  				=> 'subetuweb_topbar_social',
				'settings' 				=> 'subetuweb_top_bar_social_hover_links_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
			) ) );

			/**
			 * Top Bar Social Settings
			 */
			$social_options = subetuwebwp_social_options();
			foreach ( $social_options as $key => $val ) {
				if ( 'skype' == $key ) {
					$sanitize = 'wp_filter_nohtml_kses';
				} else if ( 'email' == $key ) {
					$sanitize = 'sanitize_email';
				} else {
					$sanitize = 'esc_url_raw';
				}

				$wp_customize->add_setting( 'subetuweb_top_bar_social_profiles[' . $key .']', array(
					'sanitize_callback' 	=> $sanitize,
				) );

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'subetuweb_top_bar_social_profiles[' . $key .']', array(
					'label'	   				=> esc_html( $val['label'] ),
					'type' 					=> 'text',
					'section'  				=> 'subetuweb_topbar_social',
					'settings' 				=> 'subetuweb_top_bar_social_profiles[' . $key .']',
					'priority' 				=> 10,
					'active_callback' 		=> 'subetuwebwp_cac_has_topbar_social',
				) ) );
			}

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {

			// Global vars
			$top_padding 					= get_theme_mod( 'subetuweb_top_bar_top_padding', '8' );
			$right_padding 					= get_theme_mod( 'subetuweb_top_bar_right_padding', '0' );
			$bottom_padding 				= get_theme_mod( 'subetuweb_top_bar_bottom_padding', '8' );
			$left_padding 					= get_theme_mod( 'subetuweb_top_bar_left_padding', '0' );
			$tablet_top_padding 			= get_theme_mod( 'subetuweb_top_bar_tablet_top_padding' );
			$tablet_right_padding 			= get_theme_mod( 'subetuweb_top_bar_tablet_right_padding' );
			$tablet_bottom_padding 			= get_theme_mod( 'subetuweb_top_bar_tablet_bottom_padding' );
			$tablet_left_padding 			= get_theme_mod( 'subetuweb_top_bar_tablet_left_padding' );
			$mobile_top_padding 			= get_theme_mod( 'subetuweb_top_bar_mobile_top_padding' );
			$mobile_right_padding 			= get_theme_mod( 'subetuweb_top_bar_mobile_right_padding' );
			$mobile_bottom_padding 			= get_theme_mod( 'subetuweb_top_bar_mobile_bottom_padding' );
			$mobile_left_padding 			= get_theme_mod( 'subetuweb_top_bar_mobile_left_padding' );
			$background 					= get_theme_mod( 'subetuweb_top_bar_bg', '#ffffff' );
			$border_color 					= get_theme_mod( 'subetuweb_top_bar_border_color', '#f1f1f1' );
			$text_color 					= get_theme_mod( 'subetuweb_top_bar_text_color', '#929292' );
			$link_color 					= get_theme_mod( 'subetuweb_top_bar_link_color', '#555555' );
			$link_color_hover 				= get_theme_mod( 'subetuweb_top_bar_link_color_hover', '#13aff0' );
			$social_font_size 				= get_theme_mod( 'subetuweb_top_bar_social_font_size' );
			$social_tablet_font_size 		= get_theme_mod( 'subetuweb_top_bar_social_tablet_font_size' );
			$social_mobile_font_size 		= get_theme_mod( 'subetuweb_top_bar_social_mobile_font_size' );
			$social_right_padding 			= get_theme_mod( 'subetuweb_top_bar_social_right_padding' );
			$social_left_padding 			= get_theme_mod( 'subetuweb_top_bar_social_left_padding' );
			$social_tablet_right_padding 	= get_theme_mod( 'subetuweb_top_bar_social_tablet_right_padding' );
			$social_tablet_left_padding 	= get_theme_mod( 'subetuweb_top_bar_social_tablet_left_padding' );
			$social_mobile_right_padding 	= get_theme_mod( 'subetuweb_top_bar_social_mobile_right_padding' );
			$social_mobile_left_padding 	= get_theme_mod( 'subetuweb_top_bar_social_mobile_left_padding' );
			$social_links_color 			= get_theme_mod( 'subetuweb_top_bar_social_links_color', '#bbbbbb' );
			$social_hover_links_color 		= get_theme_mod( 'subetuweb_top_bar_social_hover_links_color' );

			// Define css var
			$css = '';

			// Top bar padding
			if ( isset( $top_padding ) && '8' != $top_padding && '' != $top_padding
				|| isset( $right_padding ) && '0' != $right_padding && '' != $right_padding
				|| isset( $bottom_padding ) && '8' != $bottom_padding && '' != $bottom_padding
				|| isset( $left_padding ) && '0' != $left_padding && '' != $left_padding ) {
				$css .= '#top-bar{padding:'. subetuwebwp_spacing_css( $top_padding, $right_padding, $bottom_padding, $left_padding ) .'}';
			}

			// Tablet top bar padding
			if ( isset( $tablet_top_padding ) && '' != $tablet_top_padding
				|| isset( $tablet_right_padding ) && '' != $tablet_right_padding
				|| isset( $tablet_bottom_padding ) && '' != $tablet_bottom_padding
				|| isset( $tablet_left_padding ) && '' != $tablet_left_padding ) {
				$css .= '@media (max-width: 768px){#top-bar{padding:'. subetuwebwp_spacing_css( $tablet_top_padding, $tablet_right_padding, $tablet_bottom_padding, $tablet_left_padding ) .'}}';
			}

			// Mobile top bar padding
			if ( isset( $mobile_top_padding ) && '' != $mobile_top_padding
				|| isset( $mobile_right_padding ) && '' != $mobile_right_padding
				|| isset( $mobile_bottom_padding ) && '' != $mobile_bottom_padding
				|| isset( $mobile_left_padding ) && '' != $mobile_left_padding ) {
				$css .= '@media (max-width: 480px){#top-bar{padding:'. subetuwebwp_spacing_css( $mobile_top_padding, $mobile_right_padding, $mobile_bottom_padding, $mobile_left_padding ) .'}}';
			}

			// Top bar background color
			if ( ! empty( $background ) && '#ffffff' != $background ) {
				$css .= '#top-bar-wrap,.subetuwebwp-top-bar-sticky{background-color:'. $background .';}';
			}

			// Top bar border color
			if ( ! empty( $border_color ) && '#f1f1f1' != $border_color ) {
				$css .= '#top-bar-wrap{border-color:'. $border_color .';}';
			}

			// Top bar text color
			if ( ! empty( $text_color ) && '#929292' != $text_color ) {
				$css .= '#top-bar-wrap,#top-bar-content strong{color:'. $text_color .';}';
			}

			// Top bar link color
			if ( ! empty( $link_color ) && '#555555' != $link_color ) {
				$css .= '#top-bar-content a,#top-bar-social-alt a{color:'. $link_color .';}';
			}

			// Top bar link color hover
			if ( ! empty( $link_color_hover ) && '#13aff0' != $link_color_hover ) {
				$css .= '#top-bar-content a:hover,#top-bar-social-alt a:hover{color:'. $link_color_hover .';}';
			}

			// Add top bar social font size
			if ( ! empty( $social_font_size ) && '14' != $social_font_size ) {
				$css .= '#top-bar-social li a{font-size:'. $social_font_size .'px;}';
			}

			// Add top bar social tablet font size
			if ( ! empty( $social_tablet_font_size ) ) {
				$css .= '@media (max-width: 768px){#top-bar-social li a{font-size:'. $social_tablet_font_size .'px;}}';
			}

			// Add top bar social mobile font size
			if ( ! empty( $social_mobile_font_size ) ) {
				$css .= '@media (max-width: 480px){#top-bar-social li a{font-size:'. $social_mobile_font_size .'px;}}';
			}

			// Top bar padding
			if ( isset( $social_right_padding ) && '6' != $social_right_padding && '' != $social_right_padding
				|| isset( $social_left_padding ) && '6' != $social_left_padding && '' != $social_left_padding ) {
				$css .= '#top-bar-social li a{padding:'. subetuwebwp_spacing_css( '', $social_right_padding, '', $social_left_padding ) .'}';
			}

			// Tablet top bar padding
			if ( isset( $social_tablet_right_padding ) && '' != $social_tablet_right_padding
				|| isset( $social_tablet_left_padding ) && '' != $social_tablet_left_padding ) {
				$css .= '@media (max-width: 768px){#top-bar-social li a{padding:'. subetuwebwp_spacing_css( '', $social_tablet_right_padding, '', $social_tablet_left_padding ) .'}}';
			}

			// Mobile top bar padding
			if ( isset( $social_mobile_right_padding ) && '' != $social_mobile_right_padding
				|| isset( $social_mobile_left_padding ) && '' != $social_mobile_left_padding ) {
				$css .= '@media (max-width: 480px){#top-bar-social li a{padding:'. subetuwebwp_spacing_css( '', $social_mobile_right_padding, '', $social_mobile_left_padding ) .'}}';
			}

			// Top bar social link color
			if ( ! empty( $social_links_color ) && '#bbbbbb' != $social_links_color ) {
				$css .= '#top-bar-social li a{color:'. $social_links_color .';}';
				$css .= '#top-bar-social li a .owp-icon use{stroke:'. $social_links_color .';}';
			}

			// Top bar social link color hover
			if ( ! empty( $social_hover_links_color ) ) {
				$css .= '#top-bar-social li a:hover{color:'. $social_hover_links_color .'!important;}';
				$css .= '#top-bar-social li a:hover .owp-icon use{stroke:'. $social_hover_links_color .'!important;}';
			}

			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Top Bar CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new subetuwebWP_Top_Bar_Customizer();