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

	var image = jQuery( '.product-images .image-item' );

	if ( ! image.length || document.documentElement.classList.contains( 'quick-view-open' ) ) {
		return;
	}

	image.each( function( ele ){
		jQuery(this).find('a img').css('opacity','1');
	});
	
	if ( jQuery().easyZoom ) {
		var zoom = image.easyZoom(),
			api  = zoom.data( 'easyZoom' );

		api.teardown();
		api._init();
	}
}

window.addEventListener('load', function() {

	// Setup image zoom.
	if ( window.matchMedia( '( min-width: 992px )' ).matches && jQuery().easyZoom ) {
		jQuery( '.ez-zoom' ).easyZoom(
			{
				loadingNotice: ''
			}
		);
	}

	// For Elementor Preview Mode.
	if ( 'function' === typeof( onElementorLoaded ) ) {
		onElementorLoaded(
			function() {
				window.elementorFrontend.hooks.addAction(
					'frontend/element_ready/global',
					function() {
						easyZoomHandle();
					}
				);
			}
		);
	}
	
});
