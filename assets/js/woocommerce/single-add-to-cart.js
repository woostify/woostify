/**
 * Single add to cart ajax
 *
 * @package woostify
 */

/* global woostify_ajax */

'use strict';

function singleAddToCartButton() {
	var cart   = document.getElementsByClassName( 'cart' )[0],
		button = cart ? cart.getElementsByClassName( 'single_add_to_cart_button' )[0] : false;

	if ( ! cart || ! button || 'A' == button.tagName || cart.classList.contains( 'grouped_form' ) ) {
		return;
	}

	var overlay       = document.getElementById( 'woocommerce-overlay' ),
		addToCart     = cart.querySelector( '[name="add-to-cart"]' ),
		productId     = addToCart ? addToCart.value : false,
		input         = cart.getElementsByClassName( 'qty' )[0],
		inputMax      = input ? parseInt( input.getAttribute( 'max' ) ) : 0,
		productInfo   = cart.getElementsByClassName( 'additional-product' )[0],
		inStock       = productInfo.getAttribute( 'data-in_stock' ),
		outStock      = productInfo.getAttribute( 'data-out_of_stock' ),
		notEnough     = productInfo.getAttribute( 'data-not_enough' ),
		quantityValid = productInfo.getAttribute( 'data-valid_quantity' );

	// Check this product available.
	if ( ! productId ) {
		return;
	}

	button.addEventListener( 'click', function( e ) {
		e.preventDefault();

		// Elements.
		var cartSidebar    = document.getElementsByClassName( 'cart-sidebar-content' )[0],
			productCount   = document.getElementsByClassName( 'shop-cart-count' ),
			inCartQuantity = parseInt( productInfo.value ),
			quantity       = parseInt( input.value ),
			variationId    = false,
			items          = {};

		// For variations product.
		if ( cart.classList.contains( 'variations_form' ) ) {
			productId   = cart.querySelector( '[name="product_id"]' ).value;
			variationId = cart.querySelector( '[name="variation_id"]' ).value;

			var productAttr = cart.querySelectorAll( 'select[name^="attribute"]' );
			productAttr.forEach( function( x ) {
				var productName  = x.name,
					productValue = x.value;

				items[productName] = productValue;
			} );
		}

		// Alert if not valid quantity.
		if ( quantity < 1 || isNaN( quantity ) ) {
			alert( quantityValid );
			return;
		}

		// Condition if stock manager enable.
		if ( 'yes' == inStock ) {
			if ( inCartQuantity == inputMax ) {
				alert( outStock );
				return;
			}

			if ( +quantity + +inCartQuantity > inputMax ) {
				alert( notEnough );
				return;
			}
		}

		// Update product infomation value.
		productInfo.value = +productInfo.value + +input.value;

		// Events.
		eventCartSidebarOpen();
		cartSidebarOpen();
		cartSidebarClose();

		// Request.
		var request = new Request( woostify_ajax.url, {
			method: 'POST',
			body: 'action=single_add_to_cart&nonce=' + woostify_ajax.nonce + '&product_id=' + productId + '&product_qty=' + quantity + '&variation_id=' + variationId + '&variations=' + JSON.stringify( items ),
			credentials: 'same-origin',
			headers: new Headers({
				'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
			})
		} );

		// Fetch API.
		fetch( request )
			.then( function( res ) {
				if ( 200 !== res.status ) {
					console.log( 'Looks like there was a problem. Status Code: ' + res.status );
					return;
				}

				res.json().then( function( data ) {
					// Update product count.
					for ( var c = 0, n = productCount.length; c < n; c++ ) {
						productCount[c].innerHTML = data.item;
					}

					// Append content.
					cartSidebar.innerHTML = data.content;

					// Event when added to cart.
					eventCartSidebarClose();
				});
			} )
			.catch( function( err ) {
				alert( 'Sorry, something went wrong. Please refresh this page to try again!' );
				console.log( err );
			});
	} );
}
singleAddToCartButton();
