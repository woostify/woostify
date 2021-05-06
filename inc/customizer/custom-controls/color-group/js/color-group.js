/**
 * Sticky Footer Bar js
 *
 * @package woostify
 */

const $ = jQuery;
wp.customize.controlConstructor['woostify-color-group'] = wp.customize.Control.extend(
	{
		ready: function() {
			'use strict';
			let control        = this;
			let selector       = document.querySelector( control.selector );
			let control_wrap   = control.container.find( '.woostify-color-group-control' );
			let control_id     = control_wrap.data( 'control_id' );
			let color_format   = control.params.color_format;
			let enable_opacity = control.params.enable_opacity;
			let spacing        = 15;
			let args           = {
				el: '.btn',
				theme: 'monolith',
				autoReposition: false,
				inline: false,
				container: '.woostify-color-group-control',
				lockOpacity: false,
				comparison: false,
				default: 'rgba(255,255,255,0)',
					defaultRepresentation: 'RGBA',
					adjustableNumbers: true,
					swatches: [
					'rgba(244, 67, 54, 1)',
					'rgba(233, 30, 99, 0.95)',
					'rgba(156, 39, 176, 0.9)',
					'rgba(103, 58, 183, 0.85)',
					'rgba(63, 81, 181, 0.8)',
					'rgba(33, 150, 243, 0.75)',
					'rgba(3, 169, 244, 0.7)',
					'rgba(0, 188, 212, 0.7)',
					'rgba(0, 150, 136, 0.75)',
					'rgba(76, 175, 80, 0.8)',
					'rgba(139, 195, 74, 0.85)',
					'rgba(205, 220, 57, 0.9)',
					'rgba(255, 235, 59, 0.95)',
					'rgba(255, 193, 7, 1)',
					],
					useAsButton: true,
					components: {
						// Main components.
						preview: false,
						opacity: true,
						hue: true,
						// Input / output Options.
						interaction: {
							hex: true,
							rgba: true,
							input: true,
							clear: true,
						},
				},
			};
			$.each(
				control.params.settings,
				function( idx, obj ) {
					let btn_id_arr             = obj.split( '[' );
					let btn_id                 = ('undefined' === typeof btn_id_arr[1]) ? btn_id_arr[0] : btn_id_arr[1].split( ']' )[0];
					args.el                    = '.btn-' + btn_id
					args.container             = '.woostify-color-group-control-' + control_id
					args.default               = control.settings[idx].get();
					args.defaultRepresentation = color_format.toUpperCase();
					args.lockOpacity           = ! enable_opacity;
					let pickr                  = new Pickr( args );
					$( args.el ).css( 'color', '' !== args.default ? args.default : ( enable_opacity ? 'rgba(255,255,255,0)' : 'rgb(255,255,255)' ) );
					pickr.on(
						'init',
						function( instance ) {
							let pane                    = selector.closest( 'ul.customize-pane-child' );
							let control_wrap_dom        = control_wrap.get( 0 );
							let control_wrap_dom_offset = control_wrap_dom.querySelector( '.color-group-wrap' ).getBoundingClientRect().bottom;
							let pane_height             = pane.scrollHeight > pane.clientHeight ? pane.scrollHeight : pane.clientHeight;

							setPopupPickerPosition( instance, pane_height, control_wrap_dom_offset );
						}
					)
					pickr.on(
						'show',
						function( color, instance ) {
							let pane                    = selector.closest( 'ul.customize-pane-child' );
							let control_wrap_dom        = control_wrap.get( 0 );
							let control_wrap_dom_offset = control_wrap_dom.querySelector( '.color-group-wrap' ).getBoundingClientRect().bottom;
							let pane_height             = pane.scrollHeight > pane.clientHeight ? pane.scrollHeight : pane.clientHeight;

							setPopupPickerPosition( instance, pane_height, control_wrap_dom_offset );
						}
					).on(
						'change',
						function( color ) {
							control.settings[idx].set( colorFormat( color, color_format ).toString( 0 ) );
						},
					).on(
						'clear',
						function( instance ) {
							instance.options.el.style.color = 'rgba(255,255,255,0)';
							control.settings[idx].set( instance.options.default );
						},
					);
					pickr.applyColor();
				},
			);
			control.container.find( '.woostify-reset' ).on(
				'click',
				function() {
					control.container.find( 'div.pcr-app' ).remove();
					let inputs          = control.container.find( 'input.color-group-value' );
					let buttons         = control.container.find( '.woostify-color-group-btn' );
					let container       = $( this ).closest( '.woostify-color-group-control' );
					let container_class = container.attr( 'class' ).split( ' ' )[2];
					$.each(
						control.params.settings,
						function( idx ) {
							let reset_value = $( inputs[idx] ).data( 'reset_value' );
							$( buttons[idx] ).css( 'color', reset_value );
							control.settings[idx].set( reset_value );

							args.el                    = buttons[idx]
							args.container             = '.' + container_class
							args.default               = reset_value
							args.defaultRepresentation = color_format.toUpperCase()
							args.lockOpacity           = ! enable_opacity
							let pickr2                 = new Pickr( args );
							$( args.el ).css( 'color', '' !== args.default ? args.default : ( enable_opacity ? 'rgba(255,255,255,0)' : 'rgb(255,255,255)' ) );
							pickr2.on(
								'init',
								function( instance ) {
									let pane                    = selector.closest( 'ul.customize-pane-child' );
									let control_wrap_dom        = control_wrap.get( 0 );
									let control_wrap_dom_offset = control_wrap_dom.querySelector( '.color-group-wrap' ).getBoundingClientRect().bottom;
									let pane_height             = pane.scrollHeight > pane.clientHeight ? pane.scrollHeight : pane.clientHeight;

									setPopupPickerPosition( instance, pane_height, control_wrap_dom_offset );
								}
							)
							pickr2.on(
								'show',
								function( color, instance ) {
									let pane                    = selector.closest( 'ul.customize-pane-child' );
									let control_wrap_dom        = control_wrap.get( 0 );
									let control_wrap_dom_offset = control_wrap_dom.querySelector( '.color-group-wrap' ).getBoundingClientRect().bottom;
									let pane_height             = pane.scrollHeight > pane.clientHeight ? pane.scrollHeight : pane.clientHeight;

									setPopupPickerPosition( instance, pane_height, control_wrap_dom_offset );
								}
							).on(
								'change',
								function( color ) {
									control.settings[idx].set( colorFormat( color, color_format ).toString( 0 ) );
								},
							).on(
								'clear',
								function( instance ) {
									instance.options.el.style.color = 'rgba(255,255,255,0)';
									control.settings[idx].set( instance.options.default );
								},
							);
							pickr2.applyColor();
						}
					);
				}
			)

			function setPopupPickerPosition( instance, panel_height, control_wrap_offset) {
				let app_node = instance._root.app;
				let eb       = app_node.getBoundingClientRect();
				if ( ( panel_height - ( control_wrap_offset + eb.height ) ) > 0 ) {
					app_node.style.top          = '100%';
					app_node.style.bottom       = 'auto';
					app_node.style.marginTop    = '15px';
					app_node.style.marginBottom = '0';
				} else {
					app_node.style.top          = 'auto';
					app_node.style.bottom       = '100%';
					app_node.style.marginTop    = '0';
					app_node.style.marginBottom = '15px';
				}
				app_node.style.left = '0';
			}

			function colorFormat( color, format = 'rgba' ) {
				// hsva.toHSVA() - Converts the object to a hsva array.
				// hsva.toHSLA() - Converts the object to a hsla array.
				// hsva.toRGBA() - Converts the object to a rgba array.
				// hsva.toHEXA() - Converts the object to a hexa-decimal array.
				// hsva.toCMYK() - Converts the object to a cmyk array.
				// hsva.clone() - Clones the color object.
				let new_color;
				switch ( format ) {
					case 'rgba':
						new_color = color.toRGBA();
						break;
					case 'hex':
						new_color = color.toHEXA();
						break;
					case 'hsva':
						new_color = color.toHSVA();
						break;
					case 'hsla':
						new_color = color.toHSLA();
						break;
					case 'cmyk':
						new_color = color.toCMYK();
						break;
					default:
						new_color = color.clone();
				}
				return new_color;
			}

			control_wrap.find( '.pcr-app' ).css(
				{
					'top': '100%',
					'left': '0'
				}
			)
		},
	},
);
