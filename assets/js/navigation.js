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

		var hasChild = jQuery( '.sidebar-menu .primary-navigation .menu-item-has-children' );
		if ( hasChild.length ) {
			hasChild.prepend( '<span class="arrow-icon"></span>' );
		}

		jQuery( document.body ).on( 'click', '.sidebar-menu .primary-navigation .arrow-icon', function( e ) {

			e.preventDefault();

			var t        = jQuery( this ),
				siblings = t.siblings( 'ul' ),
				arrow    = t.parent().parent().find( '.arrow-icon' ),
				subMenu  = t.parent().parent().find( 'li .sub-menu' );

			if ( siblings.hasClass( 'show' ) ) {
				siblings.slideUp( 200, function() {
					jQuery( this ).removeClass( 'show' );
				} );

				// Remove active state.
				t.removeClass( 'active' );
			} else {
				subMenu.slideUp( 200, function() {
					jQuery( this ).removeClass( 'show' );
				} );
				siblings.slideToggle( 200, function() {
					jQuery( this ).toggleClass( 'show' );
				} );

				// Add active state for current arrow.
				arrow.removeClass( 'active' );
				t.addClass( 'active' );
			}
		});
	} );
} )();
