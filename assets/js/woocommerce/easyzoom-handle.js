/**
 * Easyzoom hanle
 *
 * @package woostify
 */

'use strict';

// Use in product-variation.js.
function easyZoom() {

	if ( window.matchMedia( '( max-width: 991px )' ).matches ) {
		return;
	}

	var image = jQuery( document.body ).find( '.product-images .image-item:eq(0)' );

	if ( ! image.length || document.body.classList.contains( 'quick-view-open' ) ) {
		return;
	}

	var zoom = image.easyZoom(),
		api  = zoom.data( 'easyZoom' );

	api.teardown();
	api._init();
}

// Setup image zoom.
if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
	jQuery( '.ez-zoom' ).easyZoom();
}
