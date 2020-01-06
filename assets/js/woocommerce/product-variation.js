/**
 * Product variation
 *
 * @global easyZoom
 * @package woostify
 */

'use strict';

function productVariation( selector, form ) {
	var gallery        = jQuery( selector ),
		variationsForm = form ? form : 'form.variations_form',
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

	if ( ! jQuery( variationsForm ).length ) {
		return;
	}

	jQuery( document.body ).on( 'found_variation', variationsForm, function( event, variation ) {
		// get image url form `variation`.
		var fullSrc  = variation.image.full_src,
			imgSrc   = variation.image.src,
			thumbSrc = variation.image.thumb_src,
			inStock  = variation.is_in_stock;

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

		// Re-init zoom handle.
		if ( 'function' === typeof( easyZoomHandle ) ) {
			easyZoomHandle();
		}

		// Update quantity for variation.
		if ( inStock && variation.max_qty ) {
			var inStock      = variation.max_qty <= 10 ? variation.max_qty : ( Math.floor( Math.random() * 66 ) + 10 ),
				availability = event.currentTarget.querySelector( '.woocommerce-variation-availability' ),
				markupHtml   = '';

			markupHtml += '<div class="woostify-single-product-stock stock">';
			markupHtml += '<span class="woostify-single-product-stock-label">Hurry! only ' + variation.max_qty + ' left in stock.</span>';
			markupHtml += '<div class="woostify-product-stock-progress">';
			markupHtml += '<span class="woostify-single-product-stock-progress-bar" data-number="' + inStock + '"></span>';
			markupHtml += '</div>';
			markupHtml += '</div>';

			availability.innerHTML = markupHtml;

			// Re-init stock progress bar.
			if ( 'function' === typeof( woostifyStockQuantityProgressBar ) ) {
				setTimeout(
					function() {
						woostifyStockQuantityProgressBar();
					},
					200
				)
			}
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
