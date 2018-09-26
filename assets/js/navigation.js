/**
 * Navigation.js
 *
 * @package woostify
 */

'use strict';



( function() {
	document.addEventListener( 'DOMContentLoaded', function() {
		var menuToggleBtn = document.getElementsByClassName( 'menu-toggle-btn' );

		if ( ! menuToggleBtn ) {
			return;
		}

		for ( var i = 0, j = menuToggleBtn.length; i < j; i++ ) {
			menuToggleBtn[i].addEventListener( 'click', function() {
				document.body.classList.add( 'mobile-menu-open' );
				closeAll();
			} );
		}

		jQuery( document.body ).on( 'click', '.sidebar-menu .primary-navigation a', function( e ) {

			// This script only run only mobile devices.
			if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
				return;
			}

			e.preventDefault();

			var t = jQuery( this );

			// Go to url if not have sub-menu.
			if ( ! t.siblings().length ) {
				window.location.href = t.prop( 'href' );
			}

			if ( t.next().hasClass( 'show' ) ) {
				t.next().removeClass( 'show' );
				t.next().slideUp( 200 );
			} else {
				t.parent().parent().find( 'li .sub-menu' ).removeClass( 'show' );
				t.parent().parent().find( 'li .sub-menu' ).slideUp( 200 );
				t.next().toggleClass( 'show' );
				t.next().slideToggle( 200 );
			}
		});
	} );
} )();
