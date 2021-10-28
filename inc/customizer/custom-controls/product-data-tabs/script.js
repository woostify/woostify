/**
 * Product Data Tabs JS
 *
 * @package woostify
 */

( function ( api ) {
	// Editor control.
	jQuery( window ).load(
		function () {
			jQuery( 'textarea.wp-editor-area' ).each(
				function () {
					var $this = jQuery( this ),
					id        = $this.attr( 'id' ),
					$input    = jQuery( 'input[data-editor-id="' + id + '"]' ),
					editor    = tinyMCE.get( id ),
					setChange,
					content;

					if ( editor ) {
						editor.on(
							'change',
							function ( e ) {
								editor.save();
								content = editor.getContent();
								clearTimeout( setChange );
								setChange = setTimeout(
									function ()  {
										$input.val( content ).trigger( 'change' );
									},
									500
								);
							}
						);
					}

					$this.css( 'visibility', 'visible' ).on(
						'keyup',
						function () {
							content = $this.val();
							clearTimeout( setChange );
							setChange = setTimeout(
								function () {
									$input.val( content ).trigger( 'change' );
								},
								500
							);
						}
					);
				}
			);
		}
	);
	api.controlConstructor['woostify-product-data-tabs'] = api.Control.extend(
		{
			ready: function() {
				'use strict';
				var control           = this;
				var list_item_wrap    = control.container.find( '.woostify-adv-list-items' );
				var latest_item_index = list_item_wrap.find( '.woostify-sortable-list-item-wrap:not(.example-item-tmpl)' ).length - 1;

				function update_value() {
					var value = {};

					list_item_wrap = control.container.find( '.woostify-adv-list-items' );
					list_item_wrap.find( '.woostify-sortable-list-item-wrap:not(.example-item-tmpl)' ).each(
						function( item_idx, item_obj ) {
							var item_wrap   = jQuery( item_obj )
							value[item_idx] = {}
							item_wrap.each(
								function( control_idx, control_obj ) {
									var item_control = jQuery( control_obj )
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

				function add_custom_tab() {
					control.container.find( '.adv-list-add-item-btn' ).on(
						'click',
						function( e ) {
							e.preventDefault();

							var example_item_tmpl = control.container.find( '.woostify-sortable-list-item-wrap.example-item-tmpl' );
							var new_item_tmpl     = example_item_tmpl.clone();

							++latest_item_index;

							new_item_tmpl.removeClass( 'example-item-tmpl' );
							new_item_tmpl.find( '.sortable-item-name' ).text( 'Custom Tab' );
							new_item_tmpl.find( 'input.woostify-adv-list-input--name' ).attr( 'value', 'Custom Tab' );
							new_item_tmpl.html(
								function( i, oldHTML ) {
									return oldHTML.replace( /{{ITEM_ID}}/g, latest_item_index );
								}
							)

							// Append new item to list.
							list_item_wrap = control.container.find( '.woostify-adv-list-items' );
							list_item_wrap.append( new_item_tmpl );

							update_value();
						}
					)
				}

				display_item_options( list_item_wrap.find( '.woostify-adv-list-select' ) );

				add_custom_tab();

				jQuery( document ).on(
					'change',
					'.woostify-adv-list-select',
					function() {
						var currVal  = jQuery( this ).val();
						var currText = jQuery( this ).find( 'option:selected' ).text();
						if ( 'custom' !== currVal ) {
							var item_wrap = jQuery( this ).closest( '.woostify-sortable-list-item-wrap' )
							item_wrap.find( '.sortable-item-name' ).text( currText )
						}

						update_value()

						display_item_options( jQuery( this ) )
					}
				)

				jQuery( document ).on(
					'click',
					'.woostify-adv-list-items .sortable-item-icon-del',
					function() {
						var currBtn = jQuery( this );
						var result  = confirm( "Are you sure delete this item?" );
						if ( result ) {
							currBtn.closest( '.woostify-sortable-list-item-wrap' ).remove();
							update_value()
						}
					}
				)

				jQuery( document ).on(
					'keyup',
					'.adv-list-item-content .woostify-adv-list-input--name',
					function() {
						var item_wrap = jQuery( this ).closest( '.woostify-sortable-list-item-wrap' )
						item_wrap.find( '.sortable-item-name' ).text( jQuery( this ).val() )
					}
				)

				jQuery( document ).on(
					'blur change',
					'.adv-list-item-content .woostify-adv-list-input',
					function() {
						update_value()
					}
				)

				jQuery( document ).on(
					'click',
					'.woostify-adv-list-items .sortable-item-icon-expand',
					function() {
						var btn          = jQuery( this )
						var item_wrap    = btn.closest( '.woostify-sortable-list-item-wrap' )
						var item_content = item_wrap.find( '.adv-list-item-content' )
						if ( item_wrap.hasClass( 'checked' ) ) {
							item_content.slideToggle()
						}
					}
				)

				control.container.find( '.woostify-adv-list-items' ).sortable(
					{
						handle: '.woostify-sortable-list-item',
						update: function( event, ui ) {
							update_value()
						},
					},
				)

				control.container.find( '.woostify-adv-list-items' ).disableSelection()
			}
		}
	)
	jQuery( window ).load(
		function() {
			console.log( 'test' );
		}
	)
})( wp.customize );
