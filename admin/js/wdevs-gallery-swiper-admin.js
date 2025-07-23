( function ( $, window, document ) {
	'use strict';

	/**
	 * Toggle visibility of hover field based on breakpoint selection
	 */
	function toggleHoverField() {
		const breakpointValue = $( '#wdevs_gallery_swiper_breakpoint' ).val();
		const hoverField = $( '.wdevs-gallery-swiper-hover-field' ).closest(
			'tr'
		);

		if ( breakpointValue === '' ) {
			hoverField.hide();
		} else {
			hoverField.show();
		}
	}

	$( document ).ready( function () {
		// Only run on WooCommerce settings page
		if ( $( '#wdevs_gallery_swiper_breakpoint' ).length ) {
			// Initial state
			toggleHoverField();

			// On change
			$( '#wdevs_gallery_swiper_breakpoint' ).on(
				'change',
				toggleHoverField
			);
		}
	} );
} )( jQuery, window, document );
