/**
 * Woocommerce js
 *
 * @package woostify
 */

'use strict';

function cartSidebarOpen() {
	document.body.classList.add( 'cart-sidebar-open' );
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

// Get cookie.
function getCookie( name ) {
	var dc     = document.cookie,
		prefix = name + '=',
		begin  = dc.indexOf( '; ' + prefix );

	if ( -1 == begin ) {
		begin = dc.indexOf( prefix );

		if ( 0 != begin ) {
			return false;
		}

		return false;
	} else {
		begin += 2;
		var end = document.cookie.indexOf( ';', begin );
		if ( -1 == end ) {
			end = dc.length;
		}
	}

	return decodeURI( dc.substring( begin + prefix.length, end ) );
}


// Store notice.
function storeNotice() {
	if ( document.body.classList.contains( 'woocommerce-demo-store' ) && false !== getCookie( 'store_notice' ) ) {
		return true;
	}

	return false;
}

document.addEventListener( 'DOMContentLoaded', function() {
	shoppingBag();

	window.addEventListener( 'scroll', function() {
		if ( storeNotice() ) {
			// "false" if direction is down and "true" if up.
			if ( this.oldScroll > this.scrollY ) {
				document.body.classList.add( 'scrolling-up' );
				document.body.classList.remove( 'scrolling-down' );
			} else {
				document.body.classList.remove( 'scrolling-up' );
				document.body.classList.add( 'scrolling-down' );
			}

			// Reset state.
			this.oldScroll = this.scrollY;
		}
	} );

	jQuery( document.body ).on( 'adding_to_cart', function() {
		eventCartSidebarOpen();
		cartSidebarOpen();
	} ).on( 'added_to_cart', function() {
		eventCartSidebarClose();
		closeAll();
	} ).on( 'updated_cart_totals', function() {
		quantity();
	} );
} );
