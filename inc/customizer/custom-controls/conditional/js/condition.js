/**
 * Woostify condition control
 *
 * @package woostify
 */

( function( api ) {
	'use strict';

	api.bind( 'ready', function() {

		// Condition controls.
		function condition( id, dependencies, checked ) {
			// If true == `checked`. Hidden dependencies.
			var checked = arguments.length > 0 && arguments[2] !== undefined ? arguments[2] : false;

			api( id, function( setting ) {

				/**
				 * Update a control's active state according to the boxed_body setting's value.
				 *
				 * @param {api.Control} control Boxed body control.
				 */

				function dependency( control ) {
					function visibility() {
						if ( true === checked ) {
							if ( false === setting.get() ) {
								control.container.show( 200 );
							} else {
								control.container.hide( 200 );
							}
						} else {
							if ( false === setting.get() ) {
								control.container.hide( 200 );
							} else {
								control.container.show( 200 );
							}
						}
					}

					// Set initial active state.
					visibility();

					// Update activate state whenever the setting is changed.
					setting.bind( visibility );
				};

				// Call dependency on the border controls when they exist.
				for ( var i = 0, j = dependencies.length; i < j; i++ ) {
					api.control( dependencies[i], dependency );
				}
			} );
		}

		// Search product only.
		condition(
			'woostify_setting[header_search_icon]',
			['woostify_setting[header_search_only_product]']
		);

		// Disable footer.
		condition(
			'woostify_setting[footer_disable]',
			[
				'woostify_setting[footer_column]',
				'woostify_setting[footer_background_color]',
				'woostify_setting[footer_heading_color]',
				'woostify_setting[footer_link_color]',
				'woostify_setting[footer_text_color]',
				'woostify_setting[footer_custom_text]'
			],
			true
		);

	} );

}( wp.customize ) );
