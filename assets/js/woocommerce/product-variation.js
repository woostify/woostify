/**
 * Product variation
 *
 * @global easyZoom
 * @package woostify
 */

'use strict';

function productVariation( selector, form ) {
	var gallery        = jQuery( selector ),
		variationsForm = form ? jQuery( form ) : jQuery( '.summary form.variations_form' ),
		imageWrapper   = gallery.find( '.image-item:eq(0)' ),
		image          = imageWrapper.find( 'img' ),
		imageSrc       = image.prop( 'src' ),
		imageSrcset    = image.prop( 'srcset' ) || '',
		// Photoswipe + zoom.
		photoSwipe     = imageWrapper.find( 'a' ),
		photoSwipeSrc  = photoSwipe.prop( 'href' ),
		// Product thumbnail.
		thumb          = gallery.find( '.thumbnail-item:eq(0)' ),
		thumbSrc       = thumb.find( 'img' ).prop( 'src' );

	// event when variation changed.
	jQuery( variationsForm ).on( 'found_variation', function( event, variation ) {
		// get image url form `variation`.
		var fullSrc  = variation.image.full_src,
			imgSrc   = variation.image.src,
			thumbSrc = variation.image.thumb_src;

		// Change src image.
		image.removeAttr( 'srcset' );
		thumb.find( 'img' ).prop( 'src', thumbSrc );

		// Photoswipe + zoom.
		photoSwipe.prop( 'href', fullSrc );

		// Image loading.
		imageWrapper.addClass( 'image-loading' );
		image
			.prop( 'src', fullSrc )
			.one( 'load', function() {
				imageWrapper.removeClass( 'image-loading' );
			} );

		// Zoom handle.
		if ( 'function' === typeof( easyZoomHandle ) ) {
			easyZoomHandle();
		}
	} );

	// Reset variation.
	jQuery( '.reset_variations' ).on( 'click', function( e ) {
		e.preventDefault();

		// Change src image.
		image.prop( 'src', imageSrc );
		image.attr( 'srcset', imageSrcset );
		thumb.find( 'img' ).prop( 'src', thumbSrc );

		// Photoswipe + zoom.
		photoSwipe.prop( 'href', photoSwipeSrc );

		// Zoom handle.
		if ( 'function' === typeof( easyZoomHandle ) ) {
			easyZoomHandle();
		}
	} );
}

document.addEventListener( 'DOMContentLoaded', function() {
	productVariation( '.product-gallery' );

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded( function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
				productVariation( '.product-gallery' );
			} );
		} );
	}
} );
