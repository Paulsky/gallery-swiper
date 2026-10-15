( function ( $, window, document ) {
	const thirdPartyEvents = [
		'yith_infs_added_elem', //YITH Infinite Scrolling compatibility
		'et_ajax_content_loaded', //XStore theme AJAX compatibility
		'etheme_product_grid_ajax_loaded', //XStore Elementor AJAX pagination compatibility
		'wc-blocks_product_list_rendered', //WooCommerce Product Collection pagination compatibility
		'wood-images-loaded', //Woodmart theme AJAX compatibility
	];

	thirdPartyEvents.forEach( function ( eventName ) {
		$( document ).on( eventName, function () {
			setTimeout( function () {
				wdevs_gallery_swiper_init_swiper();
			}, 100 );
		} );
	} );
} )( jQuery, window, document );
