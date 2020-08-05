/**
 * Navigation.js
 *
 * @package woostify
 */

'use strict';

// Open Menu mobile.
function nav() {
	var menuToggleBtn = document.getElementsByClassName( 'toggle-sidebar-menu-btn' );

	if ( ! menuToggleBtn.length ) {
		return;
	}

	for ( var i = 0, j = menuToggleBtn.length; i < j; i++ ) {
		menuToggleBtn[i].addEventListener(
			'click',
			function() {
				document.documentElement.classList.add( 'sidebar-menu-open' );
				closeAll();
			}
		);
	}
}

// Accordion menu on sidebar.
function sidebarMenu( node ) {
	var selector = ( arguments.length > 0 && undefined !== arguments[0] ) ? jQuery( node ) : jQuery( '.sidebar-menu .primary-navigation' ),
		arrow    = selector.find( '.arrow-icon' );

	jQuery( arrow ).on(
		'click',
		function( e ) {
			e.preventDefault();

			var t        = jQuery( this ),
				siblings = t.parent().siblings( 'ul' ),
				arrow    = t.parent().parent().parent().find( '.arrow-icon' ),
				subMenu  = t.parent().parent().parent().find( 'li .sub-menu, li .sub-mega-menu' );

			if ( siblings.hasClass( 'show' ) ) {
				siblings.slideUp(
					200,
					function() {
						jQuery( this ).removeClass( 'show' );
					}
				);

				// Remove active state.
				t.removeClass( 'active' );
			} else {
				subMenu.slideUp(
					200,
					function() {
						jQuery( this ).removeClass( 'show' );
					}
				);
				siblings.slideToggle(
					200,
					function() {
						jQuery( this ).toggleClass( 'show' );
					}
				);

				// Add active state for current arrow.
				arrow.removeClass( 'active' );
				t.addClass( 'active' );
			}
		}
	);
}

// Fallback for other dev.
function navFallback() {
	if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
		return;
	}

	var userArgent = navigator.userAgent;

	if ( userArgent && ( userArgent.includes( 'Android' ) || userArgent.includes( 'Mobile' ) ) ) {
		return;
	}

	document.documentElement.classList.remove( 'cart-sidebar-open', 'sidebar-menu-open' );
}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		nav();
		sidebarMenu();
	}
);

window.addEventListener( 'resize', navFallback );