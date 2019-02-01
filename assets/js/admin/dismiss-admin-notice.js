/**
 * Dismiss admin notice
 *
 * @package woostify
 */

'use strict';

document.addEventListener( 'DOMContentLoaded', function() {
	( function() {
		var notice = document.getElementsByClassName( 'woostify-admin-notice' )[0];
		if ( ! notice ) {
			return;
		}

		var dismissButton = notice.getElementsByClassName( 'notice-dismiss' )[0];
		if ( ! dismissButton ) {
			return;
		}

		dismissButton.addEventListener( 'click', function() {
			// Fetch API.
			fetch( woostify_dismiss_admin_notice.url );
		} );
	} )();
} );
