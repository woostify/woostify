/**
 * Woostify condition control
 *
 * @package woostify
 */

( function( api ) {
	'use strict';

	api.bind( 'ready', function() {

		/**
		 * Condition controls.
		 *
		 * @param string  id            Setting id.
		 * @param array   dependencies  Setting id dependencies.
		 * @param string  value         Setting value.
		 * @param array   parentvalue   Parent setting id and value.
		 * @param boolean operator      Operator.
		 */
		var condition = function( id, dependencies, value, operator ) {
			var value    = undefined !== arguments[2] ? arguments[2] : false,
				operator = undefined !== arguments[3] ? arguments[3] : false;

			api( id, function( setting ) {

				/**
				 * Update a control's active setting value.
				 *
				 * @param {api.Control} control
				 */
				var dependency = function( control ) {
					var visibility = function() {
						// wp.customize.control( parentValue[0] ).setting.get();.
						if ( operator ) {
							if ( value === setting.get() ) {
								control.container.show( 200 );
							} else {
								control.container.hide( 200 );
							}
						} else {
							if ( value === setting.get() ) {
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

				// Call dependency on the setting controls when they exist.
				for ( var i = 0, j = dependencies.length; i < j; i++ ) {
					api.control( dependencies[i], dependency );
				}
			} );
		}

		/**
		 * Condition controls.
		 *
		 * @param string  id            Setting id.
		 * @param array   dependencies  Setting id dependencies.
		 * @param string  value         Setting value.
		 * @param array   parentvalue   Parent setting id and value.
		 * @param boolean operator      Operator.
		 * @param array   arr           The parent setting value.
		 */
		var subCondition = function( id, dependencies, value, operator, arr ) {
			var value    = undefined !== arguments[2] ? arguments[2] : false,
				operator = undefined !== arguments[3] ? arguments[3] : false,
				arr      = undefined !== arguments[4] ? arguments[4] : false;

			api( id, function( setting ) {

				/**
				 * Update a control's active setting value.
				 *
				 * @param {api.Control} control
				 */
				var dependency = function( control ) {
					var visibility = function() {
						// arr[0] = control setting id.
						// arr[1] = control setting value.
						if ( ! arr || arr[1] !== wp.customize.control( arr[0] ).setting.get() ) {
							return;
						}

						if ( operator ) {
							if ( value === setting.get() ) {
								control.container.show( 200 );
							} else {
								control.container.hide( 200 );
							}
						} else {
							if ( value === setting.get() ) {
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

				// Call dependency on the setting controls when they exist.
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
			'woostify_setting[product_style]',
			['woostify_setting[product_style_defaut_add_to_cart]'],
			'layout-1',
			true
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
				'woostify_setting[header_transparent_disable_shop]',
				'woostify_setting[header_transparent_enable_on]',
				'header_transparent_border_divider',
				'woostify_setting[header_transparent_border_width]',
				'woostify_setting[header_transparent_border_color]'
			]
		);

		// PAGE HEADER
		// Enable page header.
		condition(
			'woostify_setting[page_header_display]',
			[
				'woostify_setting[page_header_breadcrumb]',
				'woostify_setting[page_header_text_align]',
				'woostify_setting[page_header_title_color]',
				'woostify_setting[page_header_background_color]',
				'woostify_setting[page_header_background_image]',
				'woostify_setting[page_header_background_image_size]',
				'woostify_setting[page_header_background_image_position]',
				'woostify_setting[page_header_background_image_repeat]',
				'woostify_setting[page_header_background_image_attachment]',
				'page_header_breadcrumb_divider',
				'page_header_title_color_divider',
				'page_header_spacing_divider',
				'woostify_setting[page_header_breadcrumb_text_color]',
				'woostify_setting[page_header_padding_top]',
				'woostify_setting[page_header_padding_bottom]',
				'woostify_setting[page_header_margin_bottom]'
			]
		);

		// Background image.
		subCondition(
			'woostify_setting[page_header_background_image]',
			[
				'woostify_setting[page_header_background_image_size]',
				'woostify_setting[page_header_background_image_position]',
				'woostify_setting[page_header_background_image_repeat]',
				'woostify_setting[page_header_background_image_attachment]'
			],
			'',
			false,
			[
				'woostify_setting[page_header_display]',
				true
			]
		);
		// And trigger if parent control update.
		wp.customize( 'woostify_setting[page_header_display]', function( value ) {
			value.bind( function( newval ) {
				if ( newval ) {
					subCondition(
						'woostify_setting[page_header_background_image]',
						[
							'woostify_setting[page_header_background_image_size]',
							'woostify_setting[page_header_background_image_position]',
							'woostify_setting[page_header_background_image_repeat]',
							'woostify_setting[page_header_background_image_attachment]'
						],
						'',
						false,
						[
							'woostify_setting[page_header_display]',
							true
						]
					);
				}
			} );
		} );

		// FOOTER SECTION.
		// Disable footer.
		condition(
			'woostify_setting[footer_display]',
			[
				'woostify_setting[footer_space]',
				'woostify_setting[footer_column]',
				'woostify_setting[footer_background_color]',
				'woostify_setting[footer_heading_color]',
				'woostify_setting[footer_link_color]',
				'woostify_setting[footer_text_color]',
				'woostify_setting[footer_custom_text]',
				'footer_text_divider',
				'footer_background_color_divider'
			]
		);

	} );

}( wp.customize ) );
