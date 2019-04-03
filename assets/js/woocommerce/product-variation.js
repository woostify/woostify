/**
 * Product variation
 *
 * @global easyZoom
 * @package woostify
 */

'use strict';

function productVariation() {
	var gallery       = jQuery( document.body ).find( '.product-gallery' ),
		image         = gallery.find( '.image-item:eq(0)' ),
		imageSrc      = image.find( 'img' ).prop( 'src' ),
		// Photoswipe + zoom.
		photoSwipe    = image.find( 'a' ),
		photoSwipeSrc = photoSwipe.prop( 'href' ),
		// Product thumbnail.
		thumb         = gallery.find( '.thumbnail-item:eq(0)' ),
		thumbSrc      = thumb.find( 'img' ).prop( 'src' );

	// event when variation changed.
	jQuery( document.body ).on( 'found_variation', 'form.variations_form', function( event, variation ) {
		// get image url form `variation`.
		var imgUrl  = variation.image.full_src,
			thumUrl = variation.image.thumb_src;

		// Change src image.
		image.find( 'img' ).prop( 'src', imgUrl );
		thumb.find( 'img' ).prop( 'src', thumUrl );
		// Photoswipe + zoom.
		photoSwipe.prop( 'href', imgUrl );
		// Image loading.
		image.addClass( 'image-loading' );
		image.find( 'img' )
			.prop( 'src', imgUrl )
			.one( 'load', function() {
				image.removeClass( 'image-loading' );
			} );
		// Zoom handle.
		easyZoomHandle();
	} );

	// Reset variation.
	jQuery( '.reset_variations' ).on( 'click', function( e ) {
		e.preventDefault();
		// Change src image.
		image.find( 'img' ).prop( 'src', imageSrc );
		thumb.find( 'img' ).prop( 'src', thumbSrc );
		// Photoswipe + zoom.
		photoSwipe.prop( 'href', photoSwipeSrc );
		// Zoom handle.
		easyZoomHandle();
	} );
}

document.addEventListener( 'DOMContentLoaded', function() {
	productVariation();

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded( function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
				productVariation();
			} );
		} );
	}
} );
