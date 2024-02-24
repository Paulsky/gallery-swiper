( function ( $, window, document ) {
	'use strict';
	$( document ).on( 'yith-infs-scroll-finished', function () {
		woo_swiper_init_swiper();
	} );
} )( jQuery, window, document );
