/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package woostify
 */

'use strict';

// Colors.
function woostify_colors_live_update( id, selector, property, default_value ) {
	default_value = 'undefined' !== typeof default_value ? default_value : 'initial';

	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			newval = ( '' !== newval ) ? newval : default_value;

			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + ';}' );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + '}</style>' );

				setTimeout( function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 1000 );
			}
		} );
	} );
}

// Units.
function woostify_unit_live_update( id, selector, property, default_value, unit, default_unit ) {
	// Default parameters.
	unit         = 'undefined' !== typeof unit ? unit : 'px';
	default_unit = 'undefined' !== typeof default_unit ? default_unit : 'px';

	// Wordpress customize.
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
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
			if ( ! newval && 'undefined' !== typeof default_value && '' != default_value ) {
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

// Html.
function woostify_html_live_update( id, selector ) {
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			$( selector ).html( newval );
		} );
	} );
}

/**
 * Multi device slider update
 *
 * @param      array   array     The array: array of settings Desktop -> Tablet -> Mobile
 * @param      string  selector  The selector: css selector
 * @param      string  property  The property: background-color, display...
 * @param      string  unit      The css unit: px, em, pt...
 */
function woostify_range_slider_update( arr, selector, property, unit ) {
	arr.forEach( function( el, i ) {

		wp.customize( 'woostify_setting[' + el + ']', function( value ) {
			value.bind( function( newval ) {

				var styles = '';
				if ( 0 == i ) {
					styles = '@media ( min-width: 769px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
				} else if ( 1 == i ) {
					styles = '@media ( min-width: 321px ) and ( max-width: 768px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
				} else {
					styles = '@media ( max-width: 320px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
				}

				// Append style.
				if ( jQuery( 'style#woostify_setting-' + el ).length ) {
					jQuery( 'style#woostify_setting-' + el ).html( styles );
				} else {
					jQuery( 'head' ).append( '<style id="woostify_setting-' + el + '">' + styles + ' }</style>' );

					setTimeout( function() {
						jQuery( 'style#woostify_setting-' + el ).not( ':last' ).remove();
					}, 100 );
				}

				// Trigger event.
				setTimeout( "jQuery( document.body ).trigger( 'woostify_spacing_updated' );", 1000 );
			} );
		} );
	} );
}

( function( $ ) {

	// Update the site title in real time...
	woostify_html_live_update( 'blogname', '.main-title a' );

	// Update the site description in real time...
	woostify_html_live_update( 'blogdescription', '.site-description' );

	// Topbar.
	woostify_colors_live_update( 'topbar_text_color', '.topbar .topbar-item', 'color' );
	woostify_colors_live_update( 'topbar_background_color', '.topbar', 'background-color' );
	woostify_range_slider_update( ['topbar_space'], '.topbar', 'padding', 'px 0' );
	woostify_html_live_update( 'topbar_left', '.topbar .topbar-left' );
	woostify_html_live_update( 'topbar_center', '.topbar .topbar-center' );
	woostify_html_live_update( 'topbar_right', '.topbar .topbar-right' );

	// Header.
	woostify_colors_live_update( 'header_background_color', '.site-header', 'background-color' )

	// Logo width.
	woostify_range_slider_update( ['logo_width', 'tablet_logo_width', 'mobile_logo_width'], '.site-header .site-branding img', 'max-width', 'px' );

	// Body.
	// Body font size.
	woostify_unit_live_update( 'body_font_size', 'body, button, input, select, textarea, .woocommerce-loop-product__title', 'font-size', 14 );

	// Body line height.
	woostify_unit_live_update( 'body_line_height', 'body', 'line-height', 28 );

	// Body font weight.
	wp.customize( 'body_font_weight', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="body_font_weight">body, button, input, select, textarea{font-weight:' + newval + ';}</style>' );
			setTimeout( function() {
				jQuery( 'style#body_font_weight' ).not( ':last' ).remove();
			}, 100 );
		} );
	} );

	// Body text transform.
	wp.customize( 'body_font_transform', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="body_font_transform">body, button, input, select, textarea{text-transform:' + newval + ';}</style>' );
			setTimeout( function() {
				jQuery( 'style#body_font_transform' ).not( ':last' ).remove();
			}, 100 );
		} );
	} );

	// Menu.
	// Parent menu font size.
	woostify_unit_live_update( 'parent_menu_font_size', '.site-header .primary-navigation > li > a', 'font-size', 14 );

	// Parent menu line-height.
	woostify_unit_live_update( 'parent_menu_line_height', '.site-header .primary-navigation > li > a', 'line-height', 90 );

	// Sub-menu font-size.
	woostify_unit_live_update( 'sub_menu_font_size', '.site-header .primary-navigation .sub-menu a', 'font-size', 12 );

	// Sub-menu line-height.
	woostify_unit_live_update( 'sub_menu_line_height', '.site-header .primary-navigation .sub-menu a', 'line-height', 24 );

	// Heading.
	// Heading line height.
	woostify_unit_live_update( 'heading_line_height', 'h1, h2, h3, h4, h5, h6', 'line-height', '1.5', false, false );

	// Heading font weight.
	wp.customize( 'heading_font_weight', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="heading_font_weight">h1, h2, h3, h4, h5, h6{font-weight:' + newval + ';}</style>' );
			setTimeout( function() {
				jQuery( 'style#heading_font_weight' ).not( ':last' ).remove();
			}, 100 );
		} );
	} );

	// Heading text transform.
	wp.customize( 'heading_font_transform', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="heading_font_transform">h1, h2, h3, h4, h5, h6{text-transform:' + newval + ';}</style>' );
			setTimeout( function() {
				jQuery( 'style#heading_font_transform' ).not( ':last' ).remove();
			}, 100 );
		} );
	} );

	// H1 font size.
	woostify_unit_live_update( 'heading_h1_font_size', 'h1', 'font-size', 48 );

	// H2 font size.
	woostify_unit_live_update( 'heading_h2_font_size', 'h2', 'font-size', 36 );

	// H3 font size.
	woostify_unit_live_update( 'heading_h3_font_size', 'h3', 'font-size', 30 );

	// H4 font size.
	woostify_unit_live_update( 'heading_h4_font_size', 'h4', 'font-size', 28 );

	// H5 font size.
	woostify_unit_live_update( 'heading_h5_font_size', 'h5', 'font-size', 26 );

	// H6 font size.
	woostify_unit_live_update( 'heading_h6_font_size', 'h6', 'font-size', 18 );

} )( jQuery );
