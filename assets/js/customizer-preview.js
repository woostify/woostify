/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package woostify
 */

'use strict';

// Remove class with prefix.
jQuery.fn.removeClassPrefix = function ( prefix ) {
	this.each( function ( i, it ) {
		var classes = it.className.split( ' ' ).map( function ( item ) {
			var j = 0 === item.indexOf( prefix ) ? '' : item;
			return j;
		});

		it.className = jQuery.trim( classes.join( ' ' ) );
	});

	return this;
};

// Colors.
function woostify_colors_live_update( id, selector, property ) {
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
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
function woostify_unit_live_update( id, selector, property, unit ) {
	// Default parameters.
	var unit = 'undefined' !== typeof( unit ) ? unit : 'px';

	// Wordpress customize.
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {

			// Sometime 'unit' is not use.
			if ( ! unit ) {
				unit = '';
			}

			// Get style.
			var data = '';
			if ( Array.isArray( property ) ) {
				for ( var i = 0, j = property.length; i < j; i ++ ) {
					data += newval ? selector + '{ ' + property[i] + ': ' + newval + unit + '}' : '';
				}
			} else {
				data += newval ? selector + '{ ' + property + ': ' + newval + unit + '}' : '';
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
		} );
	} );
}

// Append data.
function woostify_append_data( id, selector, property ) {
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + ';}</style>' );

			setTimeout( function() {
				jQuery( 'style#' + id ).not( ':last' ).remove();
			}, 100 );
		} );
	} );
}

// Html.
function woostify_html_live_update( id, selector, fullId ) {
	var fullId  = ( arguments.length > 0 && undefined !== arguments[2] ) ? arguments[2] : false,
		setting = 'woostify_setting[' + id + ']';

	if ( fullId ) {
		setting = id;
	}

	wp.customize( setting, function( value ) {
		value.bind( function( newval ) {
			var element = document.querySelectorAll( selector );
			if ( ! element.length ) {
				return;
			}

			element.forEach( function( ele ) {
				ele.innerHTML = newval;
			});
		} );
	} );
}

// Hidden product meta.
function woostify_hidden_product_meta( id, selector ) {
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				document.body.classList.add( selector );
			} else {
				document.body.classList.remove( selector );
			}
		} );
	} );
}

// Update element class.
function woostify_update_element_class( id, selector, prefix ) {
	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			var newClass = '';
			switch ( newval ) {
				case true:
					newClass = prefix;
					break;
				case false:
					newClass = '';
					break;
				default:
					newClass = prefix + newval;
					break;
			}
			jQuery( selector ).removeClassPrefix( prefix ).addClass( newClass );
		} );
	} );
}

/**
 * Upload background image.
 *
 * @param      string  id  The setting id
 * @param      string  dependencies  The dependencies with background image.
 * Must follow: Size -> Repeat -> Position -> Attachment.
 * @param      string  selector      The css selector
 */
function woostify_background_image_live_upload( id, dependencies, selector ) {
	var dep     = ( arguments.length > 0 && undefined !== arguments[1] ) ? arguments[1] : false,
		element = document.querySelector( selector );

	if ( ! element ) {
		return;
	}

	wp.customize( 'woostify_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				element.style.backgroundImage = 'url(' + newval + ')';
			} else {
				element.style.backgroundImage = 'none';
			}
		} );
	} );

	if ( dep ) {
		dep.forEach( function( el, i ) {
			wp.customize( 'woostify_setting[' + el + ']', function( value ) {
				value.bind( function( newval ) {
					switch ( i ) {
						case 0:
							// Set background size.
							element.style.backgroundSize = newval;
							break;
						case 1:
							// Set background repeat.
							element.style.backgroundRepeat = newval;
							break;
						case 2:
							// Set background position.
							element.style.backgroundPosition = newval.replace( '-', ' ' );
							break;
						default:
							// Set background attachment.
							element.style.backgroundAttachment = newval;
							break;
					}
				} );
			} );
		} );
	}
}

/**
 * Multi device slider update
 *
 * @param      array   array     The Array of settings id. Follow Desktop -> Tablet -> Mobile
 * @param      string  selector  The selector: css selector
 * @param      string  property  The property: background-color, display...
 * @param      string  unit      The css unit: px, em, pt...
 */
function woostify_range_slider_update( arr, selector, property, unit ) {
	arr.forEach( function( el, i ) {

		wp.customize( 'woostify_setting[' + el + ']', function( value ) {
			value.bind( function( newval ) {

				var styles = '';
				if ( arr.length > 1 ) {
					if ( 0 == i ) {
						styles = '@media ( min-width: 769px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
					} else if ( 1 == i ) {
						styles = '@media ( min-width: 321px ) and ( max-width: 768px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
					} else {
						styles = '@media ( max-width: 320px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
					}
				} else {
					styles = selector + ' { ' + property + ': ' + newval + unit + ' }';
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
			} );
		} );
	} );
}

document.addEventListener( 'DOMContentLoaded', function() {
	// Refresh Preview when remove Custom Logo.
	wp.customize( 'custom_logo', function( value ) {
		value.bind( function( newval ) {
			if ( ! newval ) {
				wp.customize.preview.send( 'refresh' );
			}
		} );
	} );

	// Update the site title in real time...
	woostify_html_live_update( 'blogname', '.site-title.beta a', true );

	// Update the site description in real time...
	woostify_html_live_update( 'blogdescription', '.site-description', true );

	// Topbar.
	woostify_colors_live_update( 'topbar_text_color', '.topbar *', 'color' );
	woostify_colors_live_update( 'topbar_background_color', '.topbar', 'background-color' );
	woostify_range_slider_update( ['topbar_space'], '.topbar', 'padding', 'px 0' );
	woostify_html_live_update( 'topbar_left', '.topbar .topbar-left' );
	woostify_html_live_update( 'topbar_center', '.topbar .topbar-center' );
	woostify_html_live_update( 'topbar_right', '.topbar .topbar-right' );

	// HEADER.
	// Header background.
	woostify_colors_live_update( 'header_background_color', '.site-header-inner, .has-header-layout-7 .sidebar-menu', 'background-color' );
	// Header transparent: border bottom width.
	woostify_unit_live_update( 'header_transparent_border_width', '.has-header-transparent .site-header-inner', 'border-bottom-width' );
	// Header transparent: border bottom color.
	woostify_colors_live_update( 'header_transparent_border_color', '.has-header-transparent .site-header-inner', 'border-bottom-color' );

	// Logo width.
	woostify_range_slider_update( ['logo_width', 'tablet_logo_width', 'mobile_logo_width'], '.site-branding img', 'max-width', 'px' );

	// Header transparent enable on...
	woostify_update_element_class( 'header_transparent_enable_on', 'body', 'header-transparent-for-' );

	// PAGE HEADER.
	// Text align.
	woostify_update_element_class( 'page_header_text_align', '.page-header .woostify-container', 'content-align-' );

	// Title color.
	woostify_colors_live_update( 'page_header_title_color', '.page-header .entry-title', 'color' );

	// Breadcrumb text color.
	woostify_colors_live_update( 'page_header_breadcrumb_text_color', '.woostify-breadcrumb, .woostify-breadcrumb a', 'color' );

	// Background color.
	woostify_colors_live_update( 'page_header_background_color', '.page-header', 'background-color' );

	// Background image.
	woostify_background_image_live_upload(
		'page_header_background_image',
		[
			'page_header_background_image_size',
			'page_header_background_image_repeat',
			'page_header_background_image_position',
			'page_header_background_image_attachment'
		],
		'.page-header'
	);

	// Padding top.
	woostify_range_slider_update( ['page_header_padding_top'], '.page-header', 'padding-top', 'px' );

	// Padding bottom.
	woostify_range_slider_update( ['page_header_padding_bottom'], '.page-header', 'padding-bottom', 'px' );

	// Margin bottom.
	woostify_range_slider_update( ['page_header_margin_bottom'], '.page-header', 'margin-bottom', 'px' );

	// BODY.
	// Body font size.
	woostify_unit_live_update( 'body_font_size', 'body, button, input, select, textarea, .woocommerce-loop-product__title', 'font-size' );

	// Body line height.
	woostify_unit_live_update( 'body_line_height', 'body', 'line-height' );

	// Body font weight.
	woostify_append_data( 'body_font_weight', 'body, button, input, select, textarea', 'font-weight' );

	// Body text transform.
	woostify_append_data( 'body_font_transform', 'body, button, input, select, textarea', 'text-transform' );

	// MENU.
	// Menu font weight.
	woostify_append_data( 'menu_font_weight', '.primary-navigation a', 'font-weight' );

	// Menu text transform.
	woostify_append_data( 'menu_font_transform', '.primary-navigation a', 'text-transform' );

	// Parent menu font size.
	woostify_unit_live_update( 'parent_menu_font_size', '.site-header .primary-navigation > li > a', 'font-size' );

	// Parent menu line-height.
	woostify_unit_live_update( 'parent_menu_line_height', '.site-header .primary-navigation > li > a', 'line-height' );

	// Sub-menu font-size.
	woostify_unit_live_update( 'sub_menu_font_size', '.site-header .primary-navigation .sub-menu a', 'font-size' );

	// Sub-menu line-height.
	woostify_unit_live_update( 'sub_menu_line_height', '.site-header .primary-navigation .sub-menu a', 'line-height' );

	// HEADING.
	// Heading line height.
	woostify_unit_live_update( 'heading_line_height', 'h1, h2, h3, h4, h5, h6', 'line-height', false );

	// Heading font weight.
	woostify_append_data( 'heading_font_weight', 'h1, h2, h3, h4, h5, h6', 'font-weight' );

	// Heading text transform.
	woostify_append_data( 'heading_font_transform', 'h1, h2, h3, h4, h5, h6', 'text-transform' );

	// H1 font size.
	woostify_unit_live_update( 'heading_h1_font_size', 'h1', 'font-size' );

	// H2 font size.
	woostify_unit_live_update( 'heading_h2_font_size', 'h2', 'font-size' );

	// H3 font size.
	woostify_unit_live_update( 'heading_h3_font_size', 'h3', 'font-size' );

	// H4 font size.
	woostify_unit_live_update( 'heading_h4_font_size', 'h4', 'font-size' );

	// H5 font size.
	woostify_unit_live_update( 'heading_h5_font_size', 'h5', 'font-size' );

	// H6 font size.
	woostify_unit_live_update( 'heading_h6_font_size', 'h6', 'font-size' );

	// BUTTONS.
	// Color.
	// Background color.
	// Hover color
	// Hover background color.
	// Border radius.
	woostify_unit_live_update(
		'buttons_border_radius',
		'.cart .quantity, .button, .woocommerce-widget-layered-nav-dropdown__submit, .clear-cart-btn, .form-submit .submit, .elementor-button-wrapper .elementor-button, .has-woostify-contact-form input[type="submit"], #secondary .widget a.button, .product-loop-meta.no-transform .button',
		'border-radius'
	);

	// SHOP PAGE.
	// Out of stock label.
	woostify_update_element_class( 'shop_page_out_of_stock_position', '.woostify-out-of-stock-label', 'position-' );
	woostify_html_live_update( 'shop_page_out_of_stock_text', '.woostify-out-of-stock-label' );
	woostify_colors_live_update( 'shop_page_out_of_stock_color', '.woostify-out-of-stock-label', 'color' );
	woostify_colors_live_update( 'shop_page_out_of_stock_bg_color', '.woostify-out-of-stock-label', 'background-color' );
	woostify_unit_live_update( 'shop_page_out_of_stock_border_radius', '.woostify-out-of-stock-label', 'border-radius' );
	woostify_update_element_class( 'shop_page_out_of_stock_square', '.woostify-out-of-stock-label', 'is-square' );
	woostify_unit_live_update( 'shop_page_out_of_stock_size', '.woostify-out-of-stock-label.is-square', [ 'width', 'height' ] );

	// SHOP SINGLE.
	// Hidden product meta.
	woostify_hidden_product_meta( 'shop_single_skus', 'hid-skus' );
	woostify_hidden_product_meta( 'shop_single_categories', 'hid-categories' );
	woostify_hidden_product_meta( 'shop_single_tags', 'hid-tags' );

	// Footer.
	woostify_range_slider_update( ['footer_space'], '.site-footer', 'margin-top', 'px' );
} );
