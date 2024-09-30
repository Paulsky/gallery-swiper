function wdevs_gallery_swiper_init_swiper() {
	const swiperElements = document.querySelectorAll( '.swiper' );

	swiperElements.forEach( function ( swiperElement ) {
		if ( ! swiperElement.dataset.swiperInitialized ) {
			const swiperOptions = {
				loop: true,
				scrollbar: {
					el: '.swiper-scrollbar',
					hide: false,
					enabled: window.wgsSettings.swiper.scrollbar,
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
					enabled: window.wgsSettings.swiper.pagination,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
					enabled: window.wgsSettings.swiper.navigation,
				},
			};

			if ( window.wgsSettings.swiper.breakpoint ) {
				swiperOptions.breakpoints = {
					[ window.wgsSettings.swiper.breakpoint ]: {
						enabled: false,
					},
				};
			}

			const swiper = new Swiper( swiperElement, swiperOptions );

			if ( window.wgsSettings.swiper.breakpoint ) {
				swiperElement.addEventListener( 'mouseenter', function () {
					if (
						swiper.activeIndex === 0 &&
						swiper.slides.length > 1
					) {
						const defaultStatus = swiper.enabled;

						swiper.enabled = true;
						swiper.slideTo( 1, 0 );

						swiper.enabled = defaultStatus;
					}
				} );
				swiperElement.addEventListener( 'mouseleave', function () {
					if ( swiper.activeIndex !== 0 ) {
						const defaultStatus = swiper.enabled;

						swiper.enabled = true;
						swiper.slideTo( 0, 0 );

						swiper.enabled = defaultStatus;
					}
				} );
			}

			swiperElement.dataset.swiperInitialized = true;
		}
	} );
}

( function ( window, document ) {
	'use strict';

	if (
		typeof window.wgsSettings === 'undefined' ||
		typeof window.wgsSettings.swiper === 'undefined'
	) {
		window.wgsSettings = {
			swiper: {
				scrollbar: true,
				pagination: false,
				navigation: false,
				breakpoint: null,
			},
		};
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		wdevs_gallery_swiper_init_swiper();
	} );
} )( window, document );
