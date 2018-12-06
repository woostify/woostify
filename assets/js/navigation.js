/**
 * Navigation.js
 *
 * @package woostify
 */

'use strict';



( function() {
	document.addEventListener( 'DOMContentLoaded', function() {
		var menuToggleBtn = document.getElementsByClassName( 'toggle-sidebar-menu-btn' );

		if ( ! menuToggleBtn ) {
			return;
		}

		for ( var i = 0, j = menuToggleBtn.length; i < j; i++ ) {
			menuToggleBtn[i].addEventListener( 'click', function() {
				document.body.classList.add( 'sidebar-menu-open' );
				closeAll();
			} );
		}

		jQuery( document.body ).on( 'click', '.sidebar-menu ul a', function( e ) {

			e.preventDefault();

			var t         = jQuery( this ),
				next      = t.next(),
				nextAlias = t.parent().parent().find( 'li .sub-menu' );

			// Go to url if not have sub-menu.
			if ( ! t.siblings().length ) {
				// hash.
				window.location.href = t.prop( 'href' );
			}

			if ( next.hasClass( 'show' ) ) {
				next.removeClass( 'show' );
				next.slideUp( 200 );
			} else {
				nextAlias.removeClass( 'show' );
				nextAlias.slideUp( 200 );
				next.toggleClass( 'show' );
				next.slideToggle( 200 );
			}
		});
	} );
} )();
