/**
 * Ajax single add to cart
 *
 * @package Woostify Pro
 */

/* global woostify_ajax_single_add_to_cart_data */

'use strict';

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
				productInfo   = form.querySelector( '.additional-product' ),
				variationId   = false,
				items         = {};

			if ( variationForm ) {
				var productField   = form.querySelector( '[name="product_id"]' ),
					variationField = form.querySelector( '[name="variation_id"]' ),
					getProductAttr = form.querySelectorAll( 'select[name^="attribute"]' );
			}

			if ( ! productId || form.classList.contains( 'grouped_form' ) || form.classList.contains( 'mnm_form' ) ) {
				return;
			}

			button.addEventListener(
				'click',
				function( e ) {
					e.preventDefault();

					var quantity = input ? parseInt( input.value ) : 0;

					// For variations product.
					if ( variationForm ) {
						productId   = productField.value;
						variationId = variationField.value;

						getProductAttr.forEach(
							function( x ) {
								var productName  = x.name,
									productValue = x.value;

								items[productName] = productValue;
							}
						);
					}

					// Elements.
					var cartSidebar  = document.querySelector( '.cart-sidebar-content' ),
						productCount = document.getElementsByClassName( 'shop-cart-count' );

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

					// Request.
					var request = new Request(
						woostify_ajax_single_add_to_cart_data.ajax_url,
						{
							method: 'POST',
							body: 'action=single_add_to_cart&ajax_nonce=' + woostify_ajax_single_add_to_cart_data.ajax_nonce + '&product_id=' + productId + '&product_qty=' + quantity + '&variation_id=' + variationId + '&variations=' + JSON.stringify( items ),
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
							}
						);
				}
			);
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		woostifyAjaxSingleAddToCartButton();
	}
);
