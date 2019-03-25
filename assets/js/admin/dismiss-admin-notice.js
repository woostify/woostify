/**
 * Dismiss admin notice
 *
 * @package woostify
 */

'use strict';

// Show theme option notice.
var optionsNotice = function() {
	var notice = document.getElementsByClassName( 'woostify-options-notice' )[0];
	if ( ! notice ) {
		return;
	}

	var dismissButton = notice.getElementsByClassName( 'notice-dismiss' )[0];
	if ( ! dismissButton ) {
		return;
	}

	dismissButton.addEventListener( 'click', function() {
		// Fetch API.
		fetch( woostify_dismiss_admin_notice.option_notice_url );
	} );
}

// Show pro version release notice.
var proReleaseNotice = function() {
	var notice = document.getElementsByClassName( 'woostify-pro-release-notice' )[0];
	if ( ! notice ) {
		return;
	}

	var dismissButton = notice.getElementsByClassName( 'notice-dismiss' )[0];
	if ( ! dismissButton ) {
		return;
	}

	dismissButton.addEventListener( 'click', function() {
		// Fetch API.
		fetch( woostify_dismiss_admin_notice.pro_release_notice_url );
	} );
}

document.addEventListener( 'DOMContentLoaded', function() {
	optionsNotice();
	proReleaseNotice();
} );
