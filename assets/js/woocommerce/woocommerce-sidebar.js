/**
 * Woocommerce sidebar
 *
 * @package woostify
 */

'use strict';

// Woocommerce sidebar on mobile.
function sidebar() {
	var sidebar = document.getElementById( 'secondary' ),
		button  = document.getElementById( 'toggle-sidebar-mobile-button' ),
		overlay = document.getElementById( 'woostify-overlay' ),
		html    = document.documentElement;
	if ( ! sidebar || ! sidebar.classList.contains( 'shop-widget' ) || ! button ) {
		return;
	}

	button.addEventListener( 'click', function() {

		sidebar.classList.add( 'active' );
		button.classList.add( 'active' );
		html.classList.add( 'sidebar-mobile-open' );
		if ( overlay ) {
			overlay.classList.add( 'active' );
		}
	} );

	if ( overlay ) {
		overlay.addEventListener( 'click', function() {
			sidebar.classList.remove( 'active' );
			overlay.classList.remove( 'active' );
			button.classList.remove( 'active' );
			html.classList.remove( 'sidebar-mobile-open' );
		} );
	}
}

document.addEventListener( 'DOMContentLoaded', function() {
	sidebar();
} );
