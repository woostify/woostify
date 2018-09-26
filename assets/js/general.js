/**
 * General js
 *
 * @package woostify
 */

'use strict';


// Disable popup/sidebar/menumobile.
function closeAll() {

	// Use ESC key.
	document.body.addEventListener( 'keyup', function( e ) {
		if ( 27 === e.keyCode ) {
			document.body.classList.remove( 'cart-sidebar-open' );
		}
	} );

	// Use `X` close button.
	var closeCartSidebarBtn = document.getElementById( 'close-cart-sidebar-btn' );

	if ( closeCartSidebarBtn ) {
		closeCartSidebarBtn.addEventListener( 'click', function() {
			document.body.classList.remove( 'cart-sidebar-open' );
		} );
	}

	// Use overlay.
	var overlay = document.getElementById( 'woostify-overlay' );
	console.log( 1 );

	if ( overlay ) {
		console.log( 2 );
		overlay.addEventListener( 'click', function() {
			console.log( 3 );
			document.body.classList.remove( 'cart-sidebar-open', 'mobile-menu-open' );
		} );
	}
}
