/**
 * Woocommerce js
 *
 * @package woostify
 */

'use strict';

function cartSidebarOpen() {
	document.body.classList.add( 'cart-sidebar-open' );
}

// Action for close cart sidebar.
function cartSidebarClose() {
	// Use ESC key.
	document.body.addEventListener( 'keyup', function( e ) {
		if ( 27 === e.keyCode ) {
			document.body.classList.remove( 'cart-sidebar-open' );
		}
	} );

	// Use `X` close button.
	var closeCartSidebarBtn = document.getElementById( 'close-cart-sidebar-btn' );
	closeCartSidebarBtn.addEventListener( 'click', function() {
		document.body.classList.remove( 'cart-sidebar-open' );
	} );

	// Use overlay.
	var overlay = document.getElementById( 'woocommerce-overlay' );
	overlay.addEventListener( 'click', function() {
		document.body.classList.remove( 'cart-sidebar-open' );
	} );
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
( function() {
	var shoppingBag = document.getElementsByClassName( 'shopping-bag-button' );
	if ( ! shoppingBag || document.body.classList.contains( 'woocommerce-cart' ) ) {
		return;
	}

	for ( var i = 0, j = shoppingBag.length; i < j; i++ ) {
		shoppingBag[i].addEventListener( 'click', function( e ) {
			e.preventDefault();

			cartSidebarOpen();
			cartSidebarClose();
		} );
	}
} )();

// Get product item in cart.
function getProductItemInCart(){
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
	console.log( productId );
	// Request.
	var request = new Request( woostify_ajax.url, {
		method: 'POST',
		body: 'action=get_product_item_incart&nonce=' + woostify_ajax.nonce + '&product_id=' + productId,
		credentials: 'same-origin',
		headers: new Headers({
			'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
		})
	} );

	// Fetch API.
	fetch( request )
	.then( function( res ) {
		if ( 200 !== res.status ) {
			return;
		}

		res.json().then( function( data ) {
			productInfo.value = data.item;
		});
	} );
}
jQuery( document.body ).on( 'adding_to_cart', function() {
	// Event `adding_to_cart`.
	eventCartSidebarOpen();
	cartSidebarOpen();
} ).on( 'added_to_cart', function() {
	// Event `added_to_cart`.
	eventCartSidebarClose();
	cartSidebarClose();
} ).on( 'removed_from_cart', function( event, fragments, cart_hash ) {
	// Event `removed_from_cart`.
	getProductItemInCart();
} );
