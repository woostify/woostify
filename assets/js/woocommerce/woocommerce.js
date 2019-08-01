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

document.addEventListener( 'DOMContentLoaded', function() {
	shoppingBag();

	window.addEventListener( 'scroll', function() {
		if (
			document.body.classList.contains( 'woocommerce-demo-store' ) &&
			-1 === document.cookie.indexOf( 'store_notice' )
		) {
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
