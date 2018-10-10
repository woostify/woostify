/**
 * Woostify condition control
 *
 * @package woostify
 */

'use strict';

( function( $ ) {
	wp.customize.bind( 'ready', function() {

		// Variables.
		var parentConditionControl = 'woostify_setting[header_search_form]',
			childConditionControl  = 'woostify_setting[header_search_only_product]',
			childConditionControl  = childConditionControl.replace( ']', '' ),
			childConditionControl  = childConditionControl.replace( '[', '-' ),
			conditionControl       = $( '#customize-control-' + childConditionControl );

		function check( condition ) {
			if ( true == condition ) {
				$( conditionControl ).show( 200 );
			} else {
				$( conditionControl ).hide( 200 );
			}
		}

		// Check condition on page load.
		check( wp.customize.instance( parentConditionControl ).get() );

		// ... and on value change.
		wp.customize.control( parentConditionControl, function( control ) {
			control.setting.bind( function( value ) {
				check( value );
			} );
		} );

	} );
} )( jQuery );
