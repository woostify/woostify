/**
 * Section
 *
 * @package woostify
 */

'use strict';

wp.customize.controlConstructor['woostify-section'] = wp.customize.Control.extend({
	/**
	 * Ready
	 */
	ready: function() {
		var control    = this,
			selector   = document.querySelector( control.selector ),
			arrow      = selector.querySelector( '.woostify-section-control-arrow' ),
			state      = 1;

		if ( ! arrow ) {
			return;
		}

		// Trigger.
		wp.customize.bind( 'ready', function() {
			control.dependencies( state );
		} );

		// Arrow event.
		arrow.addEventListener( 'click', function() {
			if ( 1 === state ) {
				arrow.classList.add( 'active' );
				state = 2;
			} else {
				arrow.classList.remove( 'active' );
				state = 1;
			}

			control.dependencies( state );
		} );
	},

	/**
	 * Dependency
	 */
	dependencies: function( state ) {
		var control    = this,
			dependency = control.params.dependency;

		if ( ! dependency.length ) {
			return;
		}

		for ( var i = 0, j = dependency.length; i < j; i ++ ) {
			var depen         = wp.customize.control( dependency[i] ),
				depenSelector = document.querySelector( depen.selector );

			if ( 1 === state ) {
				depenSelector.classList.add( 'hide' );
			} else {
				depenSelector.classList.remove( 'hide' );
			}
		}
	}
} );

