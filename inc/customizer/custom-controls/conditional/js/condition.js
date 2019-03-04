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

		// HEADER SECTION.
		// Search product only.
		condition(
			'woostify_setting[header_search_icon]',
			['woostify_setting[header_search_only_product]']
		);

		// Always show add to cart button.
		condition(
			'woostify_setting[shop_page_product_add_to_cart_button]',
			['woostify_setting[shop_page_always_show_add_to_cart]']
		);

		// HEADER TRANSPARENT SECTION.
		// Enable transparent header.
		condition(
			'woostify_setting[header_transparent]',
			[
			'woostify_setting[header_transparent_disable_archive]',
			'woostify_setting[header_transparent_disable_index]',
			'woostify_setting[header_transparent_disable_page]',
			'woostify_setting[header_transparent_disable_post]',
			'woostify_setting[header_transparent_enable_on]',
			'woostify_setting[header_transparent_border_divider]',
			'woostify_setting[header_transparent_border_width]',
			'woostify_setting[header_transparent_border_color]'
			]
		);

		// FOOTER SECTION.
		// Disable footer.
		condition(
			'woostify_setting[footer_disable]',
			[
				'woostify_setting[footer_space]',
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
