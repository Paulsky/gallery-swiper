( function ( $, window, document ) {
	$( document ).ajaxSuccess( function ( event, xhr, settings, response ) {
		if (
			settings.data &&
			settings.data.includes( 'mod=woofilters' ) &&
			settings.data.includes( 'action=filtersFrontend' )
		) {
			setTimeout( function () {
				wdevs_gallery_swiper_init_swiper();
			}, 100 );
		}
	} );
} )( jQuery, window, document );
