/**
 * Product variation
 *
 * @package woostify
 */

/* global woostify_woocommerce_variable_product_data */

'use strict';

/**
 * Variation product
 *
 * @param      string selector  The selector.
 * @param      string form      The form.
 */
function productVariation( selector, form ) {
	var gallery        = jQuery( selector ),
		variationsForm = form ? form : 'form.variations_form',
		imageWrapper   = gallery.find( '.image-item:eq(0)' ),
		image          = imageWrapper.find( 'img' ),
		imageSrc       = image.prop( 'src' ),
		imageSrcset    = image.prop( 'srcset' ) || '',
		// Photoswipe + zoom.
		photoSwipe    = imageWrapper.find( 'a' ),
		photoSwipeSrc = photoSwipe.prop( 'href' ),
		// Product thumbnail.
		thumb    = gallery.find( '.thumbnail-item:eq(0)' ),
		thumbSrc = thumb.find( 'img' ).prop( 'src' );

	if ( ! jQuery( variationsForm ).length ) {
		return;
	}

	jQuery( document.body ).on(
		'found_variation',
		variationsForm,
		function( event, variation ) {
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
				.one(
					'load',
					function() {
						imageWrapper.removeClass( 'image-loading' );
					}
				);

			// Re-init zoom handle.
			if ( 'function' === typeof( easyZoomHandle ) ) {
				easyZoomHandle();
			}

			var jsSelector    = document.querySelector( selector ),
				productImages = jsSelector ? jsSelector.querySelector( '.product-images' ) : false,
				outStockLabel = productImages ? productImages.querySelector( '.woostify-out-of-stock-label' ) : false,
				onSaleLabel   = productImages ? productImages.querySelector( '.woostify-tag-on-sale' ) : false;

			// In stock.
			if ( inStock ) {
				// Update quantity for variation.
				if ( variation.max_qty ) {
					var inStock          = variation.max_qty <= 10 ? variation.max_qty : ( Math.floor( Math.random() * 66 ) + 10 ),
						availability     = event.currentTarget.querySelector( '.woocommerce-variation-availability' ),
						markupHtml       = '',
						soldIndividually = event.currentTarget.closest( '.sold-individually' );

					if ( ! soldIndividually ) {
						markupHtml += '<div class="woostify-single-product-stock stock">';
						if ( woostify_woocommerce_variable_product_data && woostify_woocommerce_variable_product_data.stock_label ) {
							markupHtml += '<span class="woostify-single-product-stock-label">' + woostify_woocommerce_variable_product_data.stock_label.replace( '%s', variation.max_qty ) + '</span>';
						}
						markupHtml += '<div class="woostify-product-stock-progress">';
						markupHtml += '<span class="woostify-single-product-stock-progress-bar" data-number="' + inStock + '"></span>';
						markupHtml += '</div>';
						markupHtml += '</div>';

						if ( availability ) {
							availability.innerHTML = markupHtml;
						}
					}

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

				// Remove label out of stock.
				if ( outStockLabel ) {
					outStockLabel.remove();
				}

				// Update sale tag.
				if ( onSaleLabel && woostify_woocommerce_variable_product_data.sale_tag_percent && variation.display_price != variation.display_regular_price ) {
					onSaleLabel.innerHTML = '-' + Math.round( ( ( variation.display_regular_price - variation.display_price ) / variation.display_regular_price ) * 100 ) + '%';
				}
			} else if ( woostify_woocommerce_variable_product_data ) {
				var outStockLabelHtml = '<span class="woostify-out-of-stock-label position-' + woostify_woocommerce_variable_product_data.out_of_stock_display + ' ' + woostify_woocommerce_variable_product_data.out_of_stock_square + '">' + woostify_woocommerce_variable_product_data.out_of_stock_text + '</span>';

				if ( ! outStockLabel ) {
					productImages.insertAdjacentHTML( 'beforeend', outStockLabelHtml );
				}
			}
		}
	);

	// Reset variation.
	jQuery( '.reset_variations' ).on(
		'click',
		function( e ) {
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
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		productVariation( '.product-gallery' );

		// For Elementor Preview Mode.
		if ( 'function' === typeof( onElementorLoaded ) ) {
			onElementorLoaded(
				function() {
					window.elementorFrontend.hooks.addAction(
						'frontend/element_ready/global',
						function() {
							productVariation( '.product-gallery' );
						}
					);
				}
			);
		}
	}
);
