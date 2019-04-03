/**
 * Easyzoom hanle
 *
 * @package woostify
 */

'use strict';

// Use in product-variation.js.
function easyZoomHandle() {

	if ( window.matchMedia( '( max-width: 991px )' ).matches ) {
		return;
	}

	var image = jQuery( document.body ).find( '.product-images .image-item:eq(0)' );

	if ( ! image.length || document.documentElement.classList.contains( 'quick-view-open' ) ) {
		return;
	}

	var zoom = image.easyZoom(),
		api  = zoom.data( 'easyZoom' );

	api.teardown();
	api._init();
}

document.addEventListener( 'DOMContentLoaded', function() {
	// Setup image zoom.
	if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
		jQuery( '.ez-zoom' ).easyZoom();
	}

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded( function() {
			window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
				easyZoomHandle();
			} );
		} );
	}
} );
