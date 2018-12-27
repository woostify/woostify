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

	if ( overlay ) {
		overlay.addEventListener( 'click', function() {
			document.body.classList.remove( 'cart-sidebar-open', 'sidebar-menu-open' );
		} );
	}
}

// Dialog search form.
function dialogSearch() {
	var headerSearchIcon = document.getElementsByClassName( 'header-search-icon' ),
		dialogSearchForm = document.getElementsByClassName( 'site-dialog-search' ),
		closeBtn         = dialogSearchForm.length ? dialogSearchForm[0].getElementsByClassName( 'dialog-search-close-icon' )[0] : false;

	if ( ! headerSearchIcon.length || ! dialogSearchForm.length || ! closeBtn ) {
		return;
	}

	var fieldFocus = function() {
		if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
			var searchField = dialogSearchForm[0].getElementsByClassName( 'search-field' )[0];
			searchField.focus();
		}
	}

	var dialogOpen = function() {
		document.body.classList.add( 'dialog-search-open' );
		document.body.classList.remove( 'dialog-search-close' );

		fieldFocus();
	}

	var dialogClose = function() {
		document.body.classList.add( 'dialog-search-close' );
		document.body.classList.remove( 'dialog-search-open' );
	}

	for ( var i = 0, j = headerSearchIcon.length; i < j; i++ ) {
		headerSearchIcon[i].addEventListener( 'click', function() {
			dialogOpen();

			// Use ESC key.
			document.body.addEventListener( 'keyup', function( e ) {
				if ( 27 === e.keyCode ) {
					dialogClose();
				}
			} );

			// Use dialog overlay.
			dialogSearchForm[0].addEventListener( 'click', function( e ) {
				if ( this !== e.target ) {
					return;
				}

				dialogClose();
			} );

			// Use closr button.
			closeBtn.addEventListener( 'click', function() {
				dialogClose();
			} );
		} );
	}
}

// Footer action.
function footerAction() {
	var scroll = function() {
		var item = document.getElementsByClassName( 'footer-action' )[0];
		if ( ! item ) {
			return;
		}

		var pos = arguments.length > 0 && undefined !== arguments[0] ? arguments[0] : window.scrollY;

		if ( pos > 200 ) {
			item.classList.add( 'active' );
		} else {
			item.classList.remove( 'active' );
		}
	}

	window.addEventListener( 'load', function() {
		scroll();
	} );

	window.addEventListener( 'scroll', function() {
		scroll();
	} );
}

// Scroll to top.
function scrollToTop() {
	var top = jQuery( '#scroll-to-top' );
	if ( ! top.length ) {
		return;
	}

	top.on( 'click', function() {
		jQuery( 'html, body' ).animate( { scrollTop: 0 }, 300 );
	} );
}

document.addEventListener( 'DOMContentLoaded', function() {
	dialogSearch();
	footerAction();
	scrollToTop();
} );
