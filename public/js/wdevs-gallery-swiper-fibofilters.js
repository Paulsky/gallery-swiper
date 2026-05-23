( function ( window ) {
	const fibofiltersEvents = [
		'fiboFilters.renderer.products_loaded',
		'fiboFilters.renderer.product_placeholders_overwritten',
	];
	const namespace = 'wdevs-gallery-swiper';
	const maxAttempts = 20;
	let attempts = 0;

	function initSwiper() {
		if ( typeof window.wdevs_gallery_swiper_init_swiper === 'function' ) {
			setTimeout( window.wdevs_gallery_swiper_init_swiper, 100 );
		}
	}

	function addFibofiltersHooks() {
		attempts += 1;

		if (
			typeof window.fiboFilters === 'undefined' ||
			typeof window.fiboFilters.hooks === 'undefined' ||
			typeof window.fiboFilters.hooks.addAction !== 'function'
		) {
			if ( attempts < maxAttempts ) {
				setTimeout( addFibofiltersHooks, 100 );
			}

			return;
		}

		fibofiltersEvents.forEach( function ( eventName ) {
			window.fiboFilters.hooks.addAction(
				eventName,
				namespace,
				initSwiper
			);
		} );
	}

	addFibofiltersHooks();
} )( window );
