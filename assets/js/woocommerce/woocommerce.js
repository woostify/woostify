/**
 * Woocommerce js
 *
 * @package woostify
 */

'use strict';

function cartSidebarOpen() {
	document.documentElement.classList.add( 'cart-sidebar-open' );
}

function eventCartSidebarOpen() {
	document.body.classList.add( 'updating-cart' );
	document.body.classList.remove( 'cart-updated' );
}

function eventCartSidebarClose() {
	document.body.classList.add( 'cart-updated' );
	document.body.classList.remove( 'updating-cart' );
}

// Event when click shopping bag button.
function shoppingBag() {
	var shoppingBag = document.getElementsByClassName( 'shopping-bag-button' );

	if ( ! shoppingBag.length || document.body.classList.contains( 'woocommerce-cart' ) ) {
		return;
	}

	for ( var i = 0, j = shoppingBag.length; i < j; i++ ) {
		shoppingBag[i].addEventListener( 'click', function( e ) {
			e.preventDefault();

			cartSidebarOpen();
			closeAll();
		} );
	}
}

// Condition for Add 'scrolling-up' and 'scrolling-down' class to body.
var woostifyConditionScrolling = function() {
	if (
		// When Demo store enable.
		( document.body.classList.contains( 'woocommerce-demo-store' ) && -1 === document.cookie.indexOf( 'store_notice' ) ) ||
		// When sticky button on mobile, Cart and Checkout page enable.
		( ( document.body.classList.contains( 'has-order-sticky-button' ) || document.body.classList.contains( 'has-proceed-sticky-button' ) ) && window.innerWidth < 768 )
	) {
		return true;
	}

	return false;
}

document.addEventListener( 'DOMContentLoaded', function() {
	shoppingBag();

	window.addEventListener( 'scroll', function() {
		if ( woostifyConditionScrolling() ) {
			scrollingDetect();
		}
	} );

	jQuery( document.body ).on( 'adding_to_cart', function() {
		eventCartSidebarOpen();
		cartSidebarOpen();
	} ).on( 'added_to_cart', function() {
		eventCartSidebarClose();
		closeAll();
	} ).on( 'updated_cart_totals', function() {
		if ( 'function' === typeof( customQuantity ) ) {
			customQuantity();
		}
	} );
} );
