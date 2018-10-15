/* global ajaxurl, woostifyNUX */
( function( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	$( function() {
		// Dismiss notice.
		$( document ).on( 'click', '.woostify-notice-nux .notice-dismiss', function() {
			$.ajax({
				type:     'POST',
				url:      ajaxurl,
				data:     { nonce: woostifyNUX.nonce, action: 'woostify_dismiss_notice' },
				dataType: 'json'
			});
		});
	});
})( window.wp, jQuery );
