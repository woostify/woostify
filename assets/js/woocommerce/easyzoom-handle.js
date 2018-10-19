/**
 * Easyzoom hanle
 *
 * @package woostify
 */

'use strict';

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
