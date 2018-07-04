/* global ajaxurl, storefrontNUX */
( function( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	$( function() {
		// Dismiss notice
		$( document ).on( 'click', '.sf-notice-nux .notice-dismiss', function() {
			$.ajax({
				type:     'POST',
				url:      ajaxurl,
				data:     { nonce: storefrontNUX.nonce, action: 'woostify_dismiss_notice' },
				dataType: 'json'
			});
		});
	});
})( window.wp, jQuery );