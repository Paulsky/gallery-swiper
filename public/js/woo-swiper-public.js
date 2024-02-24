function woo_swiper_init_swiper() {
	const swiperElements = document.querySelectorAll( '.swiper' );

	swiperElements.forEach( function ( swiperElement ) {
		if ( ! swiperElement.dataset.swiperInitialized ) {
			const swiperOptions = {
				loop: true,
				scrollbar: {
					el: '.swiper-scrollbar',
					hide: false,
					enabled: window.wooSwiperSettings.swiper.scrollbar,
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
					enabled: window.wooSwiperSettings.swiper.pagination,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
					enabled: window.wooSwiperSettings.swiper.navigation,
				},
			};

			if ( window.wooSwiperSettings.swiper.breakpoint ) {
				swiperOptions.breakpoints = {
					[ window.wooSwiperSettings.swiper.breakpoint ]: {
						enabled: false,
					},
				};
			}

			const swiper = new Swiper( swiperElement, swiperOptions );

			if ( window.wooSwiperSettings.swiper.breakpoint ) {
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
		typeof window.wooSwiperSettings === 'undefined' ||
		typeof window.wooSwiperSettings.swiper === 'undefined'
	) {
		window.wooSwiperSettings = {
			swiper: {
				scrollbar: true,
				pagination: false,
				navigation: false,
				breakpoint: null,
			},
		};
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		woo_swiper_init_swiper();
	} );
} )( window, document );
