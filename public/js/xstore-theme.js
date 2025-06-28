( function ( $, window, document ) {
	$( document ).on( 'et_ajax_content_loaded', function () {
		setTimeout( function () {
			wdevs_gallery_swiper_init_swiper();
		}, 100 );
	} );
} )( jQuery, window, document );
