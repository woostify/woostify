/**
 * Quantity button
 *
 * @package woostify
 */

'use strict';

// Add `-` and `+` button on product quantity.
function quantity() {
	var params = arguments.length > 0 && undefined !== arguments[ 0 ] ? arguments[ 0 ] : 'form.woocommerce-cart-form, form.cart',
		selector = jQuery( params ),
		quantity = selector.find( '.quantity' );

	if ( ! quantity.length || jQuery( quantity ).hasClass( 'hidden' ) ) {
		return;
	}

	// Create `minus` and `plus` button.
	if ( ! selector.find( '.product-qty' ).length ) {
		quantity.prepend( '<span class=\'product-qty\' data-qty=\'minus\'></span>' )
			.append( '<span class=\'product-qty\' data-qty=\'plus\'></span>' );
	}

	var quantityButton = selector.find( '.product-qty' );

	jQuery( quantityButton ).on( 'click', function() {
		var t = jQuery( this ),
			input = t.parent().find( 'input.qty' ),
			currentValue = parseInt( input.val() ),
			minValue = parseInt( input.prop( 'min' ) ),
			maxValue = parseInt( input.prop( 'max' ) );

		// Event when hit `-` button.
		if ( 'minus' === t.attr( 'data-qty' ) && currentValue > 1 ) {
			if ( currentValue <= minValue ) {
				return;
			}
			input.val( currentValue - 1 ).trigger( 'change' );
		}

		// Event when hit `+` button.
		if ( 'plus' === t.attr( 'data-qty' ) ) {
			if ( currentValue >= maxValue ) {
				return;
			}
			input.val( currentValue + 1 ).trigger( 'change' );
		}

		jQuery( '[name=\'update_cart\']' ).prop( 'disabled', false );
	} );
}

document.addEventListener( 'DOMContentLoaded', function() {
	quantity();
} );
