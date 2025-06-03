/**
 * Product variation
 *
 * @package woostify
 */

/* global woostify_woocommerce_variable_product_data */

'use strict';

if ( typeof woostifyEvent == 'undefined' ){
	var woostifyEvent = {};
} 
/**
 * Variation product
 *
 * @param      string selector  The selector.
 * @param      string form      The form.
 */
var productMetaSku = document.querySelector( '.elementor-widget-woostify-product-meta .sku' );
woostifyEvent.productMetaSkuDefault = productMetaSku ? productMetaSku.innerHTML : '';
function productVariation( selector, form ) {

	var galleries = document.querySelectorAll( selector );
	if( ! galleries.length ) return;
	var gallery = galleries[0];
	var currProductID = gallery.getAttribute( 'data-pid' ),
	variationsForm    = form ? form : 'form.variations_form[data-product_id="' + currProductID + '"]';

	jQuery( document.body ).on(
		'found_variation',
		variationsForm,
		function( event, variation ) {
			var galleries = document.querySelectorAll( selector );
			if ( ! galleries.length ) {
				return;
			}
			
			if ( ! document.querySelector( variationsForm ) ) {
				return;
			}
			// get image url form `variation`.
			var imgSrc  = variation.image.src,
			fullSrc = variation.image.full_src,
			inStock = variation.is_in_stock,
			imgSrcheight = variation.image.src_h;

			if ( ! imgSrc || ! fullSrc ) {
				return;
			}
			
			galleries.forEach( function( gallery, index){
				var _thumbSlider = gallery.querySelector( woostify_product_images_slider_options.thumb.container );
				if (_thumbSlider && _thumbSlider.children.length) {
					_thumbSlider.children[0].click();
				}
				
				var imageWrapper = ( _thumbSlider == null )? gallery.querySelector( '.image-item' ) : gallery.querySelector( '.image-item.is-selected' ); // is-selected
				
				if ( imageWrapper == null ) {
					return;
				}
				
				var image       = imageWrapper ? imageWrapper.querySelector( 'img' ) : false,
					imageSrc    = image ? image.getAttribute( 'src' ) : '',
					imageSrcset = image ? image.getAttribute( 'srcset' ) : '',
					// Photoswipe + zoom.
					photoSwipe    = imageWrapper.querySelector( 'a' ),
					photoSwipeSrc = photoSwipe ? photoSwipe.getAttribute( 'href' ) : '',
					// Product thumbnail.
					thumb    = gallery.querySelector( '.thumbnail-item' ),
					thumbImg = thumb ? thumb.querySelector( 'img' ) : false,
					thumbSrc = thumbImg ? thumbImg.getAttribute( 'src' ) : '';

				// Update
				if( variation.max_qty || 0 ){
					woostify_woocommerce_general.qty_max_warning = woostify_woocommerce_general.qty_max_warning_variation.replace( '%s', variation.max_qty);
				}

				// Update product_id for button add to cart
				var buttons = document.querySelectorAll( '.single_add_to_cart_button' );
				buttons.forEach( elm => ( elm.value = variation.variation_id) );
				
				// Support Product meta widget.
				var productMetaSkus        = document.querySelectorAll( '.elementor-widget-woostify-product-meta .sku' );
				var wpmGtinCodeWrappers    = document.querySelectorAll( '.wpm_gtin_code_wrapper .wpm_pgw_code' );

				// Support Product meta widget.
				if ( productMetaSkus ) {
					productMetaSkus.forEach( function (productMetaSku) {
						productMetaSku.innerHTML = variation.sku;
					});
				}
				if ( wpmGtinCodeWrappers ) {
					wpmGtinCodeWrappers.forEach( function (wpmGtinCodeWrapper) {
						wpmGtinCodeWrapper.innerHTML = variation.sku;
					});
					if ( variation.wpm_pgw_code ) {
						wpmGtinCodeWrapper.innerHTML = variation.wpm_pgw_code;
					}
				}

				// Photoswipe + zoom.
				if ( photoSwipe ) {
					photoSwipe.setAttribute( 'href', fullSrc );
				}

				// Change image src image.
				if ( image && imgSrc ) {
					imageWrapper.classList.add( 'image-loading' );
					var flickity_viewport = imageWrapper.closest('.flickity-viewport');
					var img    = new Image();

					img.onload = function () {
						imageWrapper.classList.remove( 'image-loading' );
						setTimeout( function() {
							if ( flickity_viewport != null ) {
								flickity_viewport.style.height = image.height + 'px';		
							}

						}, 50);
					}
					img.src = imgSrc;
					image.setAttribute( 'src', imgSrc );

					if ( imageSrcset ) {
						image.setAttribute( 'srcset', variation.image.srcset );
					}
				}

				// Change thumb src image.
				if ( thumbImg ) {
					thumbImg.setAttribute( 'src', variation.image.thumb_src );
				}

				// Re-init zoom handle.
				if ( 'function' === typeof( easyZoomHandle ) ) {
					easyZoomHandle();
				}

				var jsSelector    = gallery,
					productImages = jsSelector ? jsSelector.querySelector( '.product-images' ) : false,
					outStockLabel = productImages ? productImages.querySelector( '.woostify-out-of-stock-label' ) : false,
					onSaleLabel   = productImages ? productImages.querySelector( '.woostify-tag-on-sale' ) : false;

				// In stock.
				if ( inStock ) {
					// Re-init stock progress bar.
					if ( variation.max_qty && 'function' === typeof( woostifyStockQuantityProgressBar ) ) {
						setTimeout(
							function() {
								woostifyStockQuantityProgressBar();
							},
							300
						);
					}

					// Remove label out of stock.
					if ( outStockLabel ) {
						outStockLabel.remove();
					}

					// Update sale tag.
					if ( onSaleLabel && 'undefined' !== typeof( woostify_woocommerce_variable_product_data ) && woostify_woocommerce_variable_product_data.sale_tag_percent && variation.display_price != variation.display_regular_price ) {
						onSaleLabel.innerHTML = '-' + Math.round( ( ( variation.display_regular_price - variation.display_price ) / variation.display_regular_price ) * 100 ) + '%';
					}
				} else if ( 'undefined' !== typeof( woostify_woocommerce_variable_product_data ) ) {
					var outStockLabelHtml = '<span class="woostify-out-of-stock-label position-' + woostify_woocommerce_variable_product_data.out_of_stock_display + ' ' + woostify_woocommerce_variable_product_data.out_of_stock_square + '">' + woostify_woocommerce_variable_product_data.out_of_stock_text + '</span>';

					if ( ! outStockLabel ) {
						productImages.insertAdjacentHTML( 'beforeend', outStockLabelHtml );
					}
				}
			});  // End forEach galleries.
		}
	);

	jQuery( '.single_variation_wrap' ).on( 'show_variation', function( event, variation ) {
	
		if ( variation ) {
			var reset_variations = document.querySelector( '.reset_variations' );
			if( reset_variations ) {
				reset_variations.style.visibility = 'visible';
			}
		}

	});

	var imageItemDefault = '';
	var thumbDefault = '';
	if (gallery) {
		var thumb        = gallery.querySelector( '.thumbnail-item' );
		var imageWrapper = ( thumb && thumb.length != 0 ) ? gallery.querySelector( '.image-item' ) : gallery.querySelector( '.image-item.is-selected' );
		thumbDefault = ( thumb && thumb.length != 0 ) ? thumb.cloneNode(true) : null;
		imageItemDefault = imageWrapper ? imageWrapper.cloneNode(true) : null;
	}
	
	// Reset variation.
	jQuery( '.reset_variations' ).on(
		'click',
		function( e ) {
			
			if( !( woostifyEvent.productVariationReady || 0 ) ){
				return;
			}
			e.preventDefault();
			
			// Resset qty_max_warning 
			woostify_woocommerce_general.qty_max_warning = woostify_woocommerce_general.qty_max_warning_default;

			// Support Product meta widget.
			var productMetaSkus        = document.querySelectorAll( '.elementor-widget-woostify-product-meta .sku' );
			var wpmGtinCodeWrappers    = document.querySelector( '.wpm_gtin_code_wrapper .wpm_pgw_code' );

			// Support Product meta widget.
			if ( productMetaSkus ) {
				productMetaSkus.forEach( function (productMetaSku) {
					productMetaSku.innerHTML = woostifyEvent.productMetaSkuDefault;
				});
			}
			if ( wpmGtinCodeWrappers ) {
				wpmGtinCodeWrappers.forEach( function (wpmGtinCodeWrapper) {
					wpmGtinCodeWrapper.innerHTML = woostifyEvent.productMetaSkuDefault;
				});
			}

			setTimeout( function(){
				var galleryElement = document.querySelector('.product-gallery');
				var thumb    = galleryElement.querySelector( '.thumbnail-item' );
				var imageWrapper = ( thumb && thumb.length != 0 )? galleryElement.querySelector( '.image-item' ) : galleryElement.querySelector( '.image-item.is-selected' );
				var image        = imageWrapper ? imageWrapper.querySelector( 'img' ) : false;
				
				if ( imageWrapper == null ) {
					return;
				}
				
				// Reset src image.
				if ( image ) {
					var imageDefault = imageItemDefault ? imageItemDefault.querySelector( 'img' ) : false;
					var imageSrc    = image ? image.getAttribute( 'src' ) : '';
					var imageSrcset = image ? image.getAttribute( 'srcset' ) : '';

					imageSrc    = imageDefault ? imageDefault.getAttribute( 'src' ) : imageSrc;
					imageSrcset = imageDefault ? imageDefault.getAttribute( 'srcset' ) : imageSrcset;

					imageWrapper.classList.add( 'image-loading' );

					var resetImg    = new Image();
					resetImg.onload = function () {
						imageWrapper.classList.remove( 'image-loading' );
					}

					resetImg.src = imageSrc;
					image.setAttribute( 'src', imageSrc );

					if ( imageSrcset ) {
						image.setAttribute( 'srcset', imageSrcset );
					}
				}

				
				var thumbImg = thumb ? thumb.querySelector( 'img' ) : false;
				var thumbSrc = thumbImg ? thumbImg.getAttribute( 'src' ) : '';

				var thumbImgDefault = thumbDefault ? thumbDefault.querySelector( 'img' ) : false;
				 	thumbSrc = thumbImgDefault ? thumbImgDefault.getAttribute( 'src' ) : thumbSrc;

				if ( thumbImg ) {
					thumbImg.setAttribute( 'src', thumbSrc );
				}

				var photoSwipe    = imageWrapper.querySelector( 'a' ),
					photoSwipeSrc = photoSwipe ? photoSwipe.getAttribute( 'href' ) : '';
				
				var photoSwipeDefault = imageItemDefault ? imageItemDefault.querySelector( 'a' ) : false,
					photoSwipeSrc = photoSwipeDefault ? photoSwipeDefault.getAttribute( 'href' ) : photoSwipeSrc;

				// Photoswipe + zoom.
				if ( photoSwipeSrc ) {
					photoSwipe.setAttribute( 'href', photoSwipeSrc );
				}

				// Zoom handle.
				if ( 'function' === typeof( easyZoomHandle ) ) {
					easyZoomHandle();
				}

				if ( 'function' === typeof( initPhotoSwipe ) ) {
					initPhotoSwipe( '.product-images-container' );
				}
				
				var woostifyGallery = new WoostifyGallery( '.product-gallery', woostify_product_images_slider_options);
				
				var swatch_cont = document.querySelector('.woostify-variation-swatches');
				if( swatch_cont ) {
					swatch_cont.querySelectorAll('.swatch').forEach( function( swatch, index){ 
						swatch.classList.remove('selected');
					});
				}
			}, 150);

		}
	); // END reset event
	woostifyEvent.productVariationReady = 1;
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		if( ! (woostifyEvent.productVariationReady||0 ) ){
			productVariation( '.product-gallery' );
			// For Elementor Preview Mode.
			if ( 'function' === typeof( onElementorLoaded ) ) {
				onElementorLoaded(
					function() {
						if( ! woostifyEvent.productVariationReady||0 ){
							window.elementorFrontend.hooks.addAction(
								'frontend/element_ready/global',
								function() {
									productVariation( '.product-gallery' );
								}
							);
						}
					}
				);
			}
		}
	}
);