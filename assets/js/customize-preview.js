/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package woostify
 */

'use strict';

function woostify_colors_live_update( id, selector, property, default_value ) {
	default_value = typeof default_value !== 'undefined' ? default_value : 'initial';

	wp.customize( 'woostify_settings[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			newval = ( '' !== newval ) ? newval : default_value;

			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + ';}' );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + '}</style>' );

				setTimeout(function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 1000);
			}
		} );
	} );
}

function woostify_unit_live_update( id, selector, property, default_value, unit, default_unit ) {
	// Default parameters.
	unit         = typeof unit != 'undefined' ? unit : 'px';
	default_unit = typeof default_unit != 'undefined' ? default_unit : 'px';

	// Wordpress customize.
	wp.customize( id, function( value ) {
		value.bind( function( newval ) {

			// Sometime `unit` and `default_unit` are not use.
			if ( false == unit ) {
				unit = '';
			}

			if ( false == default_unit ) {
				default_unit = '';
			}

			// Get style.
			var data = ! newval ? '' : selector + '{ ' + property + ': ' + newval + unit + '}';

			// Default value.
			if ( ! newval && typeof default_value != 'undefined' && '' != default_value ) {
				data = selector + '{ ' + property + ': ' + default_value + default_unit + '}';
			}

			// Append style.
			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( data );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + data + ' }</style>' );

				setTimeout( function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 100 );
			}

			// Trigger event.
			setTimeout( "jQuery( document.body ).trigger( 'woostify_spacing_updated' );", 1000 );
		} );
	} );
}

( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.main-title a' ).html( newval );
		} );
	} );

	// Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );

	// Logo width.
	woostify_unit_live_update( 'woostify_logo_width', '.site-branding img', 'max-width', 100, 'px', '%' );

	// Body.
	// Body font size.
	woostify_unit_live_update( 'woostify_settings[body_font_size]', 'body, button, input, select, textarea', 'font-size', 14 );

	// Body line height.
	woostify_unit_live_update( 'woostify_settings[body_line_height]', 'body', 'line-height', 28 );

	// Body font weight.
	wp.customize( 'woostify_settings[body_font_weight]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="body_font_weight">body, button, input, select, textarea{font-weight:' + newval + ';}</style>' );
			setTimeout(function() {
				jQuery( 'style#body_font_weight' ).not( ':last' ).remove();
			}, 100);
		} );
	} );

	// Body text transform.
	wp.customize( 'woostify_settings[body_font_transform]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="body_font_transform">body, button, input, select, textarea{text-transform:' + newval + ';}</style>' );
			setTimeout(function() {
				jQuery( 'style#body_font_transform' ).not( ':last' ).remove();
			}, 100);
		} );
	} );

	// Menu.
	// Parent menu font size.
	woostify_unit_live_update( 'woostify_settings[parent_menu_font_size]', '.site-header .primary-navigation > li > a', 'font-size', 14 );

	// Parent menu line-height.
	woostify_unit_live_update( 'woostify_settings[parent_menu_line_height]', '.site-header .primary-navigation > li > a', 'line-height', 90 );

	// Sub-menu font-size.
	woostify_unit_live_update( 'woostify_settings[sub_menu_font_size]', '.site-header .primary-navigation .sub-menu a', 'font-size', 12 );

	// Sub-menu line-height.
	woostify_unit_live_update( 'woostify_settings[sub_menu_line_height]', '.site-header .primary-navigation .sub-menu a', 'line-height', 24 );

	// Heading.
	// Heading line height.
	woostify_unit_live_update( 'woostify_settings[heading_line_height]', 'h1, h2, h3, h4, h5, h6', 'line-height', '1.5', false, false );

	// Heading font weight.
	wp.customize( 'woostify_settings[heading_font_weight]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="heading_font_weight">h1, h2, h3, h4, h5, h6{font-weight:' + newval + ';}</style>' );
			setTimeout(function() {
				jQuery( 'style#heading_font_weight' ).not( ':last' ).remove();
			}, 100);
		} );
	} );

	// Heading text transform.
	wp.customize( 'woostify_settings[heading_font_transform]', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="heading_font_transform">h1, h2, h3, h4, h5, h6{text-transform:' + newval + ';}</style>' );
			setTimeout(function() {
				jQuery( 'style#heading_font_transform' ).not( ':last' ).remove();
			}, 100);
		} );
	} );

	// H1 font size.
	woostify_unit_live_update( 'woostify_settings[heading_h1_font_size]', 'h1', 'font-size', 48 );

	// H2 font size.
	woostify_unit_live_update( 'woostify_settings[heading_h2_font_size]', 'h2', 'font-size', 36 );

	// H3 font size.
	woostify_unit_live_update( 'woostify_settings[heading_h3_font_size]', 'h3', 'font-size', 30 );

	// H4 font size.
	woostify_unit_live_update( 'woostify_settings[heading_h4_font_size]', 'h4', 'font-size', 28 );

	// H5 font size.
	woostify_unit_live_update( 'woostify_settings[heading_h5_font_size]', 'h5', 'font-size', 26 );

	// H6 font size.
	woostify_unit_live_update( 'woostify_settings[heading_h6_font_size]', 'h6', 'font-size', 18 );

} )( jQuery );
