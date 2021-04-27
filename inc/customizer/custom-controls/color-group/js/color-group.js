/**
 * Sticky Footer Bar js
 *
 * @package woostify
 */
const $ = jQuery;
wp.customize.controlConstructor['woostify-color-group'] = wp.customize.Control.extend(
	{
		ready: function() {
			'use strict'
			let control              = this
			let control_wrap         = control.container.find( '.woostify-color-group-control' )
			let control_id           = control_wrap.data( 'control_id' )
			$.each(
				control.params.settings,
				(idx, obj) => {
					let btn_id_arr       = obj.split( '[' );
					let btn_id           = btn_id_arr[1].split( ']' )[0];
					let args             = {
						el: '.btn-' + btn_id,
						theme: 'monolith',
						autoReposition: false,
						inline: false,
						container: '.woostify-color-group-control-' + control_id,
						comparison: false,
						default: '#000',
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
							'rgba(255, 193, 7, 1)'
							],
							useAsButton: true,

							components: {

								// Main components
								preview: false,
								opacity: true,
								hue: true,

								// Input / output Options
								interaction: {
									hex: true,
									rgba: true,

									input: true,
									clear: true,
								}
							}
					}

					wp.customize(
						obj,
						function( value ) {
							args.default = value.get();
						}
					)
					let pickr                                     = new Pickr( args )
					document.querySelector( args.el ).style.color = args.default
					pickr.on(
						'change',
						(color, source, instance) => {
                        control.settings[idx].set( color.toRGBA().toString( 1 ) );
						}
					).on(
						'clear',
						instance => {
                        instance.options.el.style.color       = 'rgba(255,255,255,0)'
							control.settings[idx].set( 'rgba(255,255,255,0)' );
						}
					)
				}
			)
		},
	},
);

(
	function( api ) {
		api.bind(
			'ready',
			function() {
				/*let updateOpacityColor = (control_wrap, color) => {
					let pr_app         = control_wrap.querySelectorAll( '.pcr-app' );
					pr_app.forEach(
						function(prEl) {
							if (prEl.classList.contains( 'visible' )) {
								prEl.querySelector( '.pcr-opacity' ).style.background = 'linear-gradient(90deg,transparent,' + color + ')';
							}
						}
					)
				}

				let color_pickrs = document.querySelectorAll( '.woostify-color-group-btn' )
				color_pickrs.forEach(
					function(el) {
						let control_wrap = el.closest( '.woostify-color-group-control' )
						let control_id = control_wrap.getAttribute('data-control-id');
						let pickr        = new Pickr(
							{
								el: el,
								theme: 'monolith',
								autoReposition: false,
								inline: false,
								container: '.woostify-color-group-control-' + control_id,
								comparison: false,
								default: '#f90',
								defaultRepresentation: 'RGBA',
								adjustableNumbers: true,
								swatches: [],

								components: {

									// Main components
									preview: false,
									opacity: true,
									hue: true,

									// Input / output Options
									interaction: {
										hex: true,
										rgba: true,

										input: true,
										clear: true,
									}
								}
							}
						)
						pickr.on(
							'init',
							instance => {
								console.log('Event: "init"', instance);
							}
						)
					}
				);*/
			},
		);
	}( wp.customize )
);
