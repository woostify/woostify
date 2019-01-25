/**
 * Elementor preview
 *
 * @package Woostify Pro
 */

'use strict';

// Run scripts only elementor loaded.
var onElementorLoaded = function( callback ) {
	if ( undefined === window.elementorFrontend || undefined === window.elementorFrontend.hooks ) {
		setTimeout( function() {
			onElementorLoaded( callback )
		} );

		return;
	}

	callback();
}

// Elementor not print a 'product' class for product item. We add this. Please fix it.
var pleaseFixIt = function() {
	var products = document.querySelectorAll( '.products > li' );
	if ( ! products.length ) {
		return;
	}

	products.forEach( function( el ) {
		el.classList.add( 'product' );
	} );
}

// DOM loaded.
document.addEventListener( 'DOMContentLoaded', function() {
	// Only for Preview mode.
	onElementorLoaded( function() {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function() {
			pleaseFixIt();
		} );
	} );
} );
