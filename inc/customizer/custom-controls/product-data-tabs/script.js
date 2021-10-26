/**
 * Product Data Tabs JS
 *
 * @package woostify
 */

wp.customize.controlConstructor['woostify-product-data-tabs'] = wp.customize.Control.extend(
	{
		ready: function() {
			'use strict';
			var control        = this;
			var list_item_wrap = control.container.find( '.woostify-adv-list-items' );

			function update_value() {
				var value = {}
				list_item_wrap.find( '.woostify-sortable-list-item-wrap' ).each(
					function( item_idx, item_obj ) {
						var item_wrap   = jQuery( item_obj )
						value[item_idx] = {}
						item_wrap.each(
							function( control_idx, control_obj ) {
								var item_control          = jQuery( control_obj )
								var is_visibility         = item_control.find( '.woostify-adv-list-checkbox' ).is( ':checked' )
								value[item_idx]['hidden'] = ! is_visibility
								item_control.find( '.woostify-adv-list-control' ).each(
									function( input_idx, input_obj ) {
										var field_name              = jQuery( input_obj ).data( 'field_name' )
										value[item_idx][field_name] = jQuery( input_obj ).find( '.woostify-adv-list-input' ).val()
									},
								)
							},
						)
					},
				)
				control.settings['default'].set( JSON.stringify( value ) );
			}

			function display_item_options( el ) {
				el.each(
					function() {
						var options_wrap = jQuery( this ).closest( '.adv-list-item-content' )
						var type         = jQuery( this ).val()
						switch ( type ) {
							case 'custom':
								options_wrap.find( '.woostify-adv-list-control' ).removeClass( 'hide' )
								break
							case 'description':
							case 'additional_information':
							case 'reviews':
								options_wrap.find( '.woostify-adv-list-control:not(.type-field)' ).addClass( 'hide' )
								break
							default:
								options_wrap.find( '.woostify-adv-list-control' ).removeClass( 'hide' )
						}
					},
				)
			}

			display_item_options( list_item_wrap.find( '.woostify-adv-list-select' ) );

			control.container.find( '.woostify-adv-list-select' ).on(
				'change',
				function() {
					update_value()

					display_item_options( jQuery( this ) )
				},
			)

			control.container.find( '.woostify-adv-list-input--name' ).on(
				'keyup',
				function() {
					var item_wrap = jQuery( this ).closest( '.woostify-sortable-list-item-wrap' )
					item_wrap.find( '.sortable-item-name' ).text( jQuery( this ).val() )
				},
			)

			control.container.find( '.woostify-adv-list-items input[type=checkbox]' ).on(
				'click',
				function() {
					var checkbox  = jQuery( this )
					var item      = checkbox.closest( '.woostify-adv-list-item' )
					var item_wrap = checkbox.closest( '.woostify-sortable-list-item-wrap' )
					var label     = checkbox.parent()
					if ( ! checkbox.is( ':checked' ) ) {
					} else {
					}
					update_value()
				},
			)

			control.container.find( '.woostify-adv-list-input' ).on(
				'blur',
				function() {
					update_value()
				},
			)

			control.container.find( '.sortable-item-icon-expand' ).on(
				'click',
				function() {
					var btn          = jQuery( this )
					var item_wrap    = btn.closest( '.woostify-sortable-list-item-wrap' )
					var item_content = item_wrap.find( '.adv-list-item-content' )
					if ( item_wrap.hasClass( 'checked' ) ) {
						item_content.slideToggle()
					}
				},
			)

			control.container.find( '.woostify-adv-list-items' ).sortable(
				{
					handle: '.woostify-adv-list-item',
					update: function( event, ui ) {
						update_value()
					},
				},
			)

			control.container.find( '.woostify-adv-list-items' ).disableSelection()

			jQuery( document ).on(
				'click',
				'body',
				function(e) {
					var icon_list     = jQuery( '.icon-list.open' );
					var icon_list_btn = jQuery( '.select-icon-act .open-icon-list' );
					// if the target of the click isn't the container nor a descendant of the container.
					if ( ! icon_list.is( e.target ) && icon_list.has( e.target ).length === 0 && ! icon_list_btn.is( e.target ) ) {
						icon_list.slideUp( 500 );
						icon_list.delay( 500 ).removeClass( 'open' );
					}
				}
			)
		}
	}
)
