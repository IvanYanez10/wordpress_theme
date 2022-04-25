<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package subetuwebWP WordPress theme
 */

function subetuwebwp_tgmpa_register() {

	// Get array of recommended plugins.
	$plugins = array(
		array(
			'name'				=> 'subetuweb importer',
			'slug'				=> 'subetuweb-extra',
			'required'			=> false,
			'force_activation'	=> false,
		),
	);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'subetuwebwp_theme',
		'domain'       => 'subetuwebwp',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'subetuwebwp_tgmpa_register' );