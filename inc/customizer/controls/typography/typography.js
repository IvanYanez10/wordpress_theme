( function($) {

	$( document ).ready(function () {

		$( '.subetuwebwp-typography-select' ).each( function() {
			$(this).append( subetuweb_wp_fonts_list.content );
		});

		$( '.subetuwebwp-typography-select' ).select2();
	} );

} )( jQuery );