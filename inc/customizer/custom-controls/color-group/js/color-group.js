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
			let control      = this;
			let control_wrap = control.container.find( '.woostify-color-group-control' );
			let control_id   = control_wrap.data( 'control_id' );
			let args         = {
				el: '.btn',
				theme: 'monolith',
				autoReposition: false,
				inline: false,
				container: '.woostify-color-group-control',
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
					let btn_id_arr = obj.split( '[' );
					let btn_id     = btn_id_arr[1].split( ']' )[0];
					args.el        = '.btn-' + btn_id
					args.container = '.woostify-color-group-control-' + control_id
					args.default   = control.settings[idx].get();
					let pickr      = new Pickr( args );
					$( args.el ).css( 'color', '' !== args.default ? args.default : 'rgba(255,255,255,0)' );
					pickr.on(
						'change',
						function( color, source, instance ) {
							control.settings[idx].set( color.toRGBA().toString( 0 ) );
						},
					).on(
						'clear',
						function( instance ) {
							instance.options.el.style.color = 'rgba(255,255,255,0)';
							control.settings[idx].set( 'rgba(255,255,255,0)' );
						},
					);
					pickr.applyColor();
				},
			);
			control.container.find( '.woostify-reset' ).on(
				'click',
				function() {
					control.container.find( 'div.pcr-app' ).remove();
					let icon            = $( this );
					let inputs          = control.container.find( 'input.color-group-value' );
					let buttons         = control.container.find( '.woostify-color-group-btn' );
					let container       = $( this ).closest( '.woostify-color-group-control' );
					let container_class = container.attr( 'class' ).split( ' ' )[2];
					$.each(
						control.params.settings,
						function( idx, obj ) {
							let reset_value = $( inputs[idx] ).data( 'reset_value' );
							$( buttons[idx] ).css( 'color', reset_value );
							control.settings[idx].set( reset_value );

							args.el        = buttons[idx]
							args.container = '.' + container_class
							args.default   = reset_value
							let pickr      = new Pickr( args );
							$( args.el ).css( 'color', '' !== args.default ? args.default : 'rgba(255,255,255,0)' );
							pickr.on(
								'change',
								function( color, source, instance ) {
									control.settings[idx].set( color.toRGBA().toString( 1 ) );
								},
							).on(
								'clear',
								function( instance ) {
									instance.options.el.style.color = 'rgba(255,255,255,0)';
									control.settings[idx].set( 'rgba(255,255,255,0)' );
								},
							);
							pickr.applyColor();
						}
					);
				}
			)
		},
	},
);
