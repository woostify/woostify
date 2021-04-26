/**
 * Sticky Footer Bar js
 *
 * @package woostify
 */

(
	function( api ) {
		api.bind(
			'ready',
			function() {
				let color_pickrs = document.querySelectorAll( '.woostify-color-group-btn' )
				color_pickrs.forEach(
					function(el) {
						let control_wrap = el.closest( '.woostify-color-group-control' )
						let pickr        = new Pickr(
							{
								el: el,
								theme: 'monolith',
								autoReposition: false,
								inline: false,
								container: '.woostify-color-group-control',
								comparison: false,
								default: '#f90',
									swatches: [
									'rgba(244, 67, 54, 1)',
									'rgb(233, 30, 99)',
									'rgba(156, 39, 176, 1)',
									'rgb(103, 58, 183)',
									],

									components: {

										// Main components
										preview: false,
										opacity: true,
										hue: true,

										// Input / output Options
										interaction: {
											input: true,
											clear: true,
											save: false
										}
								}
							}
						)
					}
				);
			}
		)
	}( wp.customize )
)
