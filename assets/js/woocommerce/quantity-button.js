/**
 * Quantity button
 *
 * @package woostify
 */

'use strict';

// Add Minus and Plus button on Product Quantity.
function quantity() {
	// Selector form.
	var params    = arguments.length > 0 && undefined !== arguments[ 0 ] ? arguments[ 0 ] : 'form.cart, form.woocommerce-cart-form',
		selectors = document.querySelectorAll( params );

	// Return if empty.
	if ( ! selectors.length ) {
		return;
	}

	// Create Minus button.
	function minusBtn() {
		var minusBtn = document.createElement( 'span' );

		minusBtn.setAttribute( 'class', 'product-qty' );
		minusBtn.setAttribute( 'data-qty', 'minus' );

		return minusBtn;
	}

	// Create Plus button.
	function plusBtn() {
		var plusBtn = document.createElement( 'span' );

		plusBtn.setAttribute( 'class', 'product-qty' );
		plusBtn.setAttribute( 'data-qty', 'plus' );

		return plusBtn;
	}

	// Foreach.
	selectors.forEach( function( ele ) {
		var quantity = ele.querySelectorAll( '.quantity' );
		if ( ! quantity.length ) {
			return;
		}

		// Foreach again, sorry :(.
		quantity.forEach( function( ele ) {
			// Quantity Input.
			var input = ele.querySelector( 'input.qty' );

			// Append Minus button before Input.
			ele.insertBefore( minusBtn(), input );

			// Append Plus button after Input.
			ele.appendChild( plusBtn() );

			// Get all Button was created above.
			var qtyButton = ele.querySelectorAll( '.product-qty' );

			// Create new custom event.
			var eventChange = new Event( 'change' );

			// For.
			for ( var i = 0, j = qtyButton.length; i < j; i++ ) {
				qtyButton[i].addEventListener( 'click', function() {
					// Variables.
					var t       = this,
						current = parseInt( input.value ),
						min     = parseInt( input.getAttribute( 'min' ) ),
						max     = parseInt( input.getAttribute( 'max' ) ),
						dataQty = t.getAttribute( 'data-qty' );

					// Action when hit Minus button.
					if ( 'minus' === dataQty && current > 1 ) {
						if ( current <= min ) {
							return;
						}
						input.value = current - 1;

						// Trigger event.
						input.dispatchEvent( eventChange );
					}

					// Action when hit Plus button.
					if ( 'plus' === dataQty ) {
						if ( max && current >= max ) {
							return;
						}
						input.value = current + 1;

						// Trigger event.
						input.dispatchEvent( eventChange );
					}

					// Remove disable attribute on Update Cart button on Cart page.
					var updateCart = document.querySelector( '[name=\'update_cart\']' );
					if ( updateCart ) {
						updateCart.disabled = false;
					}
				} );
			}
		} );
	});
}

document.addEventListener( 'DOMContentLoaded', function() {
	quantity();
} );
