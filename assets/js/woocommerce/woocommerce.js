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

// Get product item in cart.
function getProductItemInCart() {

	// Variables.
	var cart   = document.getElementsByClassName( 'cart' )[0],
		button = cart ? cart.getElementsByClassName( 'single_add_to_cart_button' )[0] : false;

	if ( ! cart || ! button || 'A' == button.tagName || cart.classList.contains( 'grouped_form' ) ) {
		return;
	}

	var addToCart     = cart.querySelector( '[name="add-to-cart"]' ),
		productId     = addToCart ? addToCart.value : false,
		input         = cart.getElementsByClassName( 'qty' )[0],
		quantity      = parseInt( input.value ),
		productInfo   = cart.getElementsByClassName( 'additional-product' )[0],
		inStock       = productInfo.getAttribute( 'data-in_stock' );

	if ( ! productId || 'no' == inStock ) {
		return;
	}

	// Product variations id.
	if ( cart.classList.contains( 'variations_form' ) ) {
		productId = cart.querySelector( '[name="product_id"]' ).value;
	}

	// Request.
	var request = new Request( woostify_woocommerce_data.ajax_url, {
		method: 'POST',
		body: 'action=get_product_item_incart&nonce=' + woostify_woocommerce_data.ajax_nonce + '&product_id=' + productId,
		credentials: 'same-origin',
		headers: new Headers({
			'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
		})
	} );

	// Fetch API.
	fetch( request )
		.then( function( res ) {
			if ( 200 !== res.status ) {
				console.log( 1 );
				return;
			}

			res.json().then( function( data ) {
				console.log( 2 );
				productInfo.value = data.item;
			});
		} );
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
		if ( 'function' === typeof quantity ) {
			quantity();
		}
	} ).on( 'removed_from_cart', function() {
		getProductItemInCart();
	} );
} );
