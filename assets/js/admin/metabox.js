/**
 * Metabox script
 *
 * @package woostify
 */

'use strict';

// Restore $ to its original state.
jQuery.noConflict();

jQuery( function( $ ) {
	$( document ).ready( function() {
		var metabox = $( '.woostify-metabox-setting' );

		// Return first.
		if ( ! metabox.length ) {
			return;
		}

		// Add `current` class for first Content Tab.
		metabox.find( '.woostify-metabox-content-box .woostify-metabox-content' ).first().addClass( 'current' );

		// Tab setting.
		$( '.woostify-metabox-tabs a' ).on( 'click', function( e ) {
			e.preventDefault();

			var t      = $( this ),
				tab_id = t.attr( 'href' );

			$( '.woostify-metabox-tabs a' ).removeClass( 'current' );
			$( '.woostify-metabox-content' ).removeClass( 'current' );

			t.addClass( 'current' );
			$( tab_id ).addClass( 'current' );
		} )
	} );
} );
