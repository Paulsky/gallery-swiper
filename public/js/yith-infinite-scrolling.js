( function ( $, window, document ) {
	'use strict';
	$( document ).on( 'yith-infs-scroll-finished', function () {
		setTimeout( function () {
			wdevs_gallery_slider_init_swiper();
		}, 100 );
	} );
} )( jQuery, window, document );
