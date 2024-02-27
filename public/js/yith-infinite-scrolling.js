( function ( $, window, document ) {
	'use strict';
	$( document ).on( 'yith-infs-scroll-finished', function () {
		setTimeout(function(){
			woo_swiper_init_swiper();
		},100)
	} );
} )( jQuery, window, document );
