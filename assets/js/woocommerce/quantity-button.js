/**
 * Quantity button
 *
 * @package woostify
 */

'use strict';

// Create Minus button.
var minusBtn = function() {
	var minusBtn = document.createElement( 'span' );

	minusBtn.setAttribute( 'class', 'product-qty' );
	minusBtn.setAttribute( 'data-qty', 'minus' );

	return minusBtn;
}

// Create Plus button.
var plusBtn = function() {
	var plusBtn = document.createElement( 'span' );

	plusBtn.setAttribute( 'class', 'product-qty' );
	plusBtn.setAttribute( 'data-qty', 'plus' );

	return plusBtn;
}

// Add Minus and Plus button on Product Quantity.
function customQuantity() {
	var quantity = document.querySelectorAll( '.quantity' );
	if ( ! quantity.length ) {
		return;
	}

	// Foreach.
	quantity.forEach(
		function( ele ) {
			// Input.
			var input = ele.querySelector( 'input.qty' );
			if ( ! input ) {
				return;
			}

			// Add class ajax-ready on first load.
			input.classList.add( 'ajax-ready' );

			// Append Minus button before Input.
			if ( ! ele.querySelector( '.product-qty[data-qty="minus"]' ) ) {
				ele.insertBefore( minusBtn(), input );
			}

			// Append Plus button after Input.
			if ( ! ele.querySelector( '.product-qty[data-qty="plus"]' ) ) {
				ele.appendChild( plusBtn() );
			}

			// Vars.
			var cart        = ele.closest( 'form.cart' ),
				buttons     = ele.querySelectorAll( '.product-qty' ),
				maxInput    = parseInt( input.getAttribute( 'max' ) ),
				eventChange = new Event( 'change' );

			// Get product info.
			var productInfo   = cart ? cart.querySelector( '.additional-product' ) : false,
				inStock       = productInfo ? productInfo.getAttribute( 'data-in_stock' ) : 'no',
				outStock      = productInfo ? productInfo.getAttribute( 'data-out_of_stock' ) : 'Out of stock',
				notEnough     = productInfo ? productInfo.getAttribute( 'data-not_enough' ) : '',
				quantityValid = productInfo ? productInfo.getAttribute( 'data-valid_quantity' ) : '';

			// Check valid quantity.
			input.addEventListener(
				'change',
				function() {
					var inputVal  = input.value,
						inCartQty = productInfo ? parseInt( productInfo.value ) : 0,
						min       = parseInt( input.getAttribute( 'min' ) || 0 ),
						ajaxReady = function() {
							input.classList.remove( 'ajax-ready' );
						};

					// When quantity updated.
					input.classList.add( 'ajax-ready' );

					// Valid quantity.
					if ( inputVal < min || isNaN( inputVal ) ) {
						alert( quantityValid );
						ajaxReady();
						return;
					}

					// Stock status.
					if ( 'yes' == inStock ) {
						// Out of stock.
						if ( inCartQty == maxInput ) {
							alert( outStock );
							ajaxReady();
							return;
						}

						// Not enough quantity.
						if ( +inputVal + +inCartQty > maxInput ) {
							alert( notEnough );
							ajaxReady();
							return;
						}
					}
				}
			);

			// Minus & Plus button click.
			for ( var i = 0, j = buttons.length; i < j; i++ ) {
				buttons[i].onclick = function() {
					// Variables.
					var t        = this,
						current  = parseInt( input.value || 0 ),
						step     = parseInt( input.getAttribute( 'step' ) || 1 ),
						min      = parseInt( input.getAttribute( 'min' ) || 0 ),
						max      = parseInt( input.getAttribute( 'max' ) ),
						dataType = t.getAttribute( 'data-qty' );

					if ( 'minus' === dataType && current >= step ) { // Minus button.
						if ( current <= min || ( current - step ) < min ) {
							return;
						}

						input.value = current - step;
					} else if ( 'plus' === dataType ) { // Plus button.
						if ( max && ( current >= max || ( current + step ) > max ) ) {
							return;
						}

						input.value = current + step;
					}

					// Trigger event.
					input.dispatchEvent( eventChange );
					jQuery( input ).trigger( 'input' );

					// Remove disable attribute on Update Cart button on Cart page.
					var updateCart = document.querySelector( '[name=\'update_cart\']' );
					if ( updateCart ) {
						updateCart.disabled = false;
					}
				}
			}
		}
	);
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		// For preview mode.
		if ( 'function' === typeof( onElementorLoaded ) ) {
			onElementorLoaded(
				function() {
					window.elementorFrontend.hooks.addAction(
						'frontend/element_ready/woostify-product-add-to-cart.default',
						function() {
							customQuantity();
						}
					);
				}
			);
		}

		// For frontend mode.
		customQuantity();
	}
);
