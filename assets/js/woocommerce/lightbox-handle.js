/**
 * Lightbox handle
 *
 * @package woostify
 */

'use strict';

// Lightbox.
var woostifyLightbox = function() {
	var selector = document.querySelectorAll( '.woostify-lightbox-button' );
	if ( ! selector.length ) {
		return;
	}

	var lightbox = GLightbox({
	    loop: false,
	    autoplayVideos: true,
	    selector: 'woostify-lightbox-button'
	});
}

document.addEventListener( 'DOMContentLoaded', function() {
	woostifyLightbox();
} );
