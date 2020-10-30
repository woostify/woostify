/**
 * Ajax single add to cart
 *
 * @package Woostify Pro
 */

/* global woostify_ajax_single_add_to_cart_data */

'use strict';

var woostifyFormData = function( form ) {
	var output = [];

	for ( var i = 0, j = form.elements.length; i < j; i++ ) {
		var field = form.elements[i];

		if ( field.name && ! field.disabled && 'reset' !== field.type ) {
			output[output.length] = { name: field.name, value: field.value };
		}
	}

	return output;
}

function woostifyAjaxSingleAddToCartButton() {
	var buttons = document.querySelectorAll( '.single_add_to_cart_button' );
	if ( ! buttons.length ) {
		return;
	}

	buttons.forEach(
		function( button ) {
			var form          = button.closest( 'form.cart' ),
				variationForm = form.classList.contains( 'variations_form' ),
				addToCart     = form.querySelector( '[name="add-to-cart"]' ),
				productId     = addToCart ? addToCart.value : false,
				input         = form.querySelector( '.qty' ),
				variationId   = false,
				variations    = {};

			if ( variationForm ) {
				var productField   = form.querySelector( '[name="product_id"]' ),
					variationField = form.querySelector( '[name="variation_id"]' ),
					getProductAttr = form.querySelectorAll( 'select[name^="attribute"]' );
			}

			if ( ! productId || form.classList.contains( 'grouped_form' ) || form.classList.contains( 'mnm_form' ) || form.classList.contains( 'bundle_form' ) ) {
				return;
			}

			// Get product info.
			var productInfo   = form.querySelector( '.additional-product' ),
				inStock       = productInfo ? productInfo.getAttribute( 'data-in_stock' ) : 'no',
				outStock      = productInfo ? productInfo.getAttribute( 'data-out_of_stock' ) : 'Out of stock',
				notEnough     = productInfo ? productInfo.getAttribute( 'data-not_enough' ) : '',
				quantityValid = productInfo ? productInfo.getAttribute( 'data-valid_quantity' ) : '',
				currentlyQty  = 0;

			button.onclick = function( e ) {
				e.preventDefault();

				var isDisabled = button.classList.contains( 'disabled' ),
					hiddenQty  = form.querySelector( '.quantity.hidden' ),
					quantity   = input ? parseInt( input.value ) : 0,
					inCartQty  = productInfo ? parseInt( productInfo.value ) : 0,
					minInput   = parseInt( input.getAttribute( 'min' ) || 0 ),
					maxInput   = parseInt( input.getAttribute( 'max' ) );

				if ( isDisabled ) {
					return;
				}

				// Stock status.
				if ( 'yes' == inStock && hiddenQty && ( inCartQty > 0 || currentlyQty > 0 ) ) {
					alert( outStock );
					return;
				}

				// Out of stock.
				if ( ! isNaN( maxInput ) && inCartQty >= maxInput ) {
					alert( outStock );
					return;
				}

				// Not enough quantity.
				if ( ! isNaN( maxInput ) && ( +quantity + +inCartQty > maxInput ) ) {
					alert( notEnough );
					return;
				}

				// Support gift wrap plugin.
				var giftWrap     = form.querySelector( '[name="wcgwp_action"]' ),
					giftWrapData = {};
				if ( giftWrap ) {
					var giftProduct = form.querySelector( '[name="wcgwp_single_product"]:checked' ),
						giftNote    = form.querySelector( '[name="wcgwp_single_product_note"]' );

					if ( giftProduct ) {
						giftWrapData['gift_product_id'] = giftProduct.value;
					}

					if ( giftNote ) {
						giftWrapData['gift_product_note'] = giftNote.value.trim();
					}
				}

				// For variations product.
				if ( variationForm ) {
					productId   = productField.value;
					variationId = variationField.value;

					getProductAttr.forEach(
						function( x ) {
							var productName  = x.name,
								productValue = x.value;

							variations[ productName ] = productValue;
						}
					);
				}

				// Elements.
				var cartSidebar  = document.querySelector( '.cart-sidebar-content' ),
					productCount = document.querySelectorAll( '.shop-cart-count' );

				// Alert if not valid quantity.
				if ( ! input.classList.contains( 'ajax-ready' ) ) {
					return;
				}

				// Add loading.
				button.classList.add( 'loading' );

				// Update product infomation value.
				if ( productInfo ) {
					productInfo.value = +productInfo.value + +input.value;
				}

				// Events.
				if ( 'function' === typeof( eventCartSidebarOpen ) ) {
					eventCartSidebarOpen();
				}

				if ( 'function' === typeof( cartSidebarOpen ) ) {
					cartSidebarOpen();
				}

				if ( 'function' === typeof( closeAll ) ) {
					closeAll();
				}

				// Data.
				var data = {
					action: 'single_add_to_cart',
					ajax_nonce: woostify_ajax_single_add_to_cart_data.ajax_nonce,
					product_id: productId,
					product_qty: quantity,
					variation_id: variationId,
					variations: JSON.stringify( variations ),
					gift_wrap_data: JSON.stringify( giftWrapData )
				};

				data = new URLSearchParams( data ).toString();

				// Request.
				var request = new Request(
					woostify_ajax_single_add_to_cart_data.ajax_url,
					{
						method: 'POST',
						body: data,
						credentials: 'same-origin',
						headers: new Headers(
							{
								'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
							}
						)
					}
				);

				// Fetch API.
				fetch( request )
					.then(
						function( res ) {
							if ( 200 !== res.status ) {
								alert( woostify_ajax_single_add_to_cart_data.ajax_error );
								console.log( 'Status Code: ' + res.status );
								throw res;
							}

							return res.json();
						}
					).then(
						function( json ) {
							if ( ! json.success ) {
								return;
							}

							var data = json.data;

							// Update product count.
							if ( productCount.length ) {
								for ( var c = 0, n = productCount.length; c < n; c++ ) {
									productCount[c].innerHTML = data.item;
								}
							}

							// Append Cart sidebar content.
							if ( cartSidebar ) {
								cartSidebar.innerHTML = data.content;
							}

							// Redirect to checkout page.
							if ( button.classList.contains( 'woostify-buy-now' ) ) {
								var checkoutUrl = button.getAttribute( 'data-checkout_url' );
								window.location = checkoutUrl;
							}

							// Update total price, for header-layout-6.
							var totalPrice = document.querySelector( '.woostify-total-price' );
							if ( totalPrice ) {
								totalPrice.innerHTML = data.total;
							}

							currentlyQty++;
						}
					).catch(
						function( err ) {
							console.log( err );
						}
					).finally(
						function() {
							// Event when added to cart.
							if ( 'function' === typeof( eventCartSidebarClose ) ) {
								eventCartSidebarClose();
							}

							// Remove loading.
							button.classList.remove( 'loading' );

							// Hide quick view popup when product added to cart.
							document.documentElement.classList.remove( 'quick-view-open' );

							jQuery( document.body ).trigger( 'added_to_cart' );
						}
					);
			}
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		woostifyAjaxSingleAddToCartButton();
	}
);
