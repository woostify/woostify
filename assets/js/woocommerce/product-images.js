/**
 * Product images
 *
 * @package woostify
 */

'use strict';

document.addEventListener( 'DOMContentLoaded', function(){

	// Product image.
	var imageCarousel,
		option = {
			loop: false,
			container: '#product-images',
			navContainer: '#product-thumbnail-images',
			items: 1,
			navAsThumbnails: true,
			autoHeight: true,
			mouseDrag: true
	}

	if ( document.getElementById( 'product-thumbnail-images' ) ) {
		imageCarousel = tns( option );
	}

	// Product thumb images.
	var thumbCarousel,
		thumbOption = {
			loop: false,
			container: '#product-thumbnail-images',
			gutter: 10,
			items: 5,
			mouseDrag: true,
			nav: false,
			controls: true
	}

	var media = window.matchMedia( '( min-width: 768px )' ).matches;
	if ( media ) {
		thumbOption.axis = document.body.classList.contains( 'has-gallery-layout-vertical' ) ? 'vertical' : 'horizontal';
	}

	if ( document.getElementById( 'product-thumbnail-images' ) ) {
		thumbCarousel = tns( thumbOption );
	}

	// Arrow event.
	function arrowsEvent() {
		if ( ! thumbCarousel ) {
			return;
		}

		var buttons = document.querySelectorAll( '.product-images .tns-controls button' );

		if ( ! buttons.length ) {
			return;
		}

		buttons.forEach( function( el ) {
			el.addEventListener( 'click', function() {
				var nav = el.getAttribute( 'data-controls' );

				if ( 'next' === nav ) {
					thumbCarousel.goTo( 'next' );
				} else {
					thumbCarousel.goTo( 'prev' );
				}
			} );
		} );
	}

	// Reset carousel.
	function resetCarousel() {
		if ( imageCarousel ) {
			imageCarousel.goTo( 'first' );
		}

		if ( thumbCarousel ) {
			thumbCarousel.goTo( 'first' );
		}
	}

	// Carousel action.
	function carouselAction() {
		// Trigger variation.
		jQuery( document.body ).on( 'found_variation', 'form.variations_form', function() {
			resetCarousel();
		});

		// Trigger reset.
		jQuery( '.reset_variations' ).on( 'click', function(){
			resetCarousel();
		});
	}
	carouselAction();

	// Load event.
	window.addEventListener( 'load', arrowsEvent );

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded( function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
				if ( document.getElementById( 'product-thumbnail-images' ) && ! imageCarousel ) {
					imageCarousel = tns( option );
				}
				if ( document.getElementById( 'product-thumbnail-images' ) && ! thumbCarousel ) {
					thumbCarousel = tns( thumbOption );
				}
				carouselAction();
				arrowsEvent();
			} );
		} );
	}
} );
