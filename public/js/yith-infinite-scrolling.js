( function ( $, window, document ) {
	$( document ).on( 'yith_infs_added_elem', function () {
		setTimeout( function () {
			wdevs_gallery_swiper_init_swiper();
		}, 100 );
	} );
} )( jQuery, window, document );
