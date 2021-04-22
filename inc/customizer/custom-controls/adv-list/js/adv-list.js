/**
 * Advanced List JS
 *
 * @package woostify
 */

(
	function( $ ) {

		'use strict'

		wp.customize.bind(
			'ready',
			function() {
				function woostify_customizer_media() {
					'use strict'

					// Instantiates the variable that holds the media library frame.
					var metaImageFrame

					// Runs when the media button is clicked.
					$( 'body' ).click(
						function( e ) {

							// Get the btn.
							var btn = e.target

							// Check if it's the upload button.
							if ( ! btn || ! $( btn ).attr( 'data-media-uploader-target' ) ) {
								return
							}

							// Get the field target.
							var field = $( btn ).data( 'media-uploader-target' )

							var iconPrevWrap = $( btn ).closest( '.woostify-adv-list-control' ).find( '.icon-prev' )

							// Prevents the default action from occuring.
							e.preventDefault()

							// Sets up the media library frame.
							metaImageFrame = wp.media.frames.metaImageFrame = wp.media()

							// Runs when an image is selected.
							metaImageFrame.on(
								'select',
								function() {

									// Grabs the attachment selection and creates a JSON representation of the model.
									var media_attachment = metaImageFrame.state().get( 'selection' ).first().toJSON()

									// Sends the attachment URL to our custom image input field.
									$( field ).val( media_attachment.url )
									iconPrevWrap.find( 'img' ).attr( 'src', media_attachment.url )
									iconPrevWrap.removeClass( 'hide' )
									update_value( $( '.woostify-adv-list-items' ) )
								},
							)

							// Opens the media library frame.
							metaImageFrame.open()

						},
					)
				}

				function update_value( $el ) {
					var value = {}
					$el.find( '.woostify-sortable-list-item-wrap' ).each(
						function( item_idx, item_obj ) {
							var item_wrap   = $( item_obj )
							value[item_idx] = {}
							item_wrap.each(
								function( control_idx, control_obj ) {
									var control               = $( control_obj )
									var is_visibility         = control.find( '.woostify-adv-list-checkbox' ).is( ':checked' )
									value[item_idx]['hidden'] = ! is_visibility
									control.find( '.woostify-adv-list-control' ).each(
										function( input_idx, input_obj ) {
											var field_name              = $( input_obj ).data( 'field_name' )
											value[item_idx][field_name] = $( input_obj ).find( '.woostify-adv-list-input' ).val()
										},
									)
								},
							)
						},
					)
					wp.customize(
						'woostify_setting[sticky_footer_bar_items]',
						function( obj ) {
							obj.set( JSON.stringify( value ) )
						},
					)
				}

				function display_item_options( el ) {
					el.each(
						function() {
							var options_wrap = $( this ).closest( '.adv-list-item-content' )
							var type         = $( this ).val()
							switch ( type ) {
								case 'custom':
									options_wrap.find( '.woostify-adv-list-control' ).removeClass( 'hide' )
									options_wrap.find( '.woostify-adv-list-control.shortcode-field' ).addClass( 'hide' )
									break
								case 'wishlist':
								case 'cart':
								case 'search':
									options_wrap.find( '.woostify-adv-list-control:not(.type-field)' ).addClass( 'hide' )
									options_wrap.find( '.woostify-adv-list-control.name-field' ).removeClass( 'hide' )
									options_wrap.find( '.woostify-adv-list-control.icon-field' ).removeClass( 'hide' )
									break
								case 'shortcode':
									options_wrap.find( '.woostify-adv-list-control:not(.type-field)' ).addClass( 'hide' )
									options_wrap.find( '.woostify-adv-list-control.shortcode-field' ).removeClass( 'hide' )
									break
								default:
									options_wrap.find( '.woostify-adv-list-control' ).removeClass( 'hide' )
							}
						},
					)
				}

				display_item_options( $( '.woostify-adv-list-select' ) )

				$( document ).on(
					'change',
					'.woostify-adv-list-select',
					function() {
						update_value( $( '.woostify-adv-list-items' ) )

						display_item_options( $( this ) )
					},
				)
				$( document ).on(
					'keyup',
					'.woostify-adv-list-input--name',
					function() {
						var item_wrap = $( this ).closest( '.woostify-sortable-list-item-wrap' )
						item_wrap.find( '.sortable-item-name' ).text( $( this ).val() )
					},
				)
				$( document ).on(
					'click',
					'.woostify-sortable-control-list input[type=checkbox]',
					function() {
						var checkbox  = $( this )
						var item      = checkbox.closest( '.woostify-sortable-list-item' )
						var item_wrap = checkbox.closest( '.woostify-sortable-list-item-wrap' )
						var label     = checkbox.parent()
						if ( ! checkbox.is( ':checked' ) ) {
							item.removeClass( 'checked' )
							item_wrap.removeClass( 'checked' )
							label.removeClass( 'dashicons-visibility' )
							label.addClass( 'dashicons-hidden' )
							item_wrap.find( '.adv-list-item-content' ).hide()
						} else {
							item.addClass( 'checked' )
							item_wrap.addClass( 'checked' )
							label.removeClass( 'dashicons-hidden' )
							label.addClass( 'dashicons-visibility' )
						}
						update_value( $( '.woostify-adv-list-items' ) )
					},
				)
				$( document ).on(
					'blur',
					'.woostify-adv-list-input',
					function() {
						update_value( $( '.woostify-adv-list-items' ) )
					},
				)
				$( document ).on(
					'click',
					'.sortable-item-icon-expand',
					function() {
						var btn          = $( this )
						var item_wrap    = btn.closest( '.woostify-sortable-list-item-wrap' )
						var item_content = item_wrap.find( '.adv-list-item-content' )
						if ( item_wrap.hasClass( 'checked' ) ) {
							item_content.slideToggle()
						}
					},
				)

				$( document ).on(
					'click',
					'.woostify-icon-remove-btn',
					function() {
						var control = $( this ).closest( '.woostify-adv-list-control' )
						$( this ).parent().addClass( 'hide' )
						$( this ).parent().find( 'img' ).attr( 'src', '' )
						control.find( 'input.woostify-adv-list-input' ).val( '' )
						update_value( $( '.woostify-adv-list-items' ) )
					},
				)

				$( '.woostify-adv-list-items' ).sortable(
					{
						handle: '.woostify-sortable-list-item',
						update: function( event, ui ) {
							update_value( $( '.woostify-adv-list-items' ) )
						},
					},
				)
				$( '.woostify-adv-list-items' ).disableSelection()

				$( document ).on(
					'click',
					'.icon-list__icon',
					function() {
						var icon           = $( this ).data( 'icon' )
						var icon_container = $( this ).parent()
						var control        = $( this ).closest( '.woostify-adv-list-control' )
						var input          = control.find( '.woostify-adv-list-input' )

						input.val( icon )
						icon_container.find( '.icon-list__icon' ).removeClass( 'active' )
						$( this ).addClass( 'active' )
						control.find( '.selected-icon' ).html( $( this ).html() )
						update_value( $( '.woostify-adv-list-items' ) )
					},
				)

				$( document ).on(
					'click',
					'.select-icon-act .open-icon-list',
					function() {
						var control   = $( this ).closest( '.woostify-adv-list-control' )
						var icon_list = control.find( '.icon-list' );
						control.find( '.icon-list' ).slideToggle(
							500,
							function() {
								if ( $( this ).hasClass( 'open' ) ) {
									$( this ).delay( 500 ).removeClass( 'open' );
								} else {
									$( this ).delay( 500 ).addClass( 'open' );
								}
							}
						)
					},
				)

				$( document ).on(
					'keyup search',
					'.icon-list__search input',
					function() {
						var value          = $( this ).val().toLowerCase()
						var icon_list      = $( this ).closest( '.icon-list' )
						var icon_list_wrap = icon_list.find( '.icon-list-wrap' )
						icon_list_wrap.find( '.icon-list__icon' ).filter(
							function() {
								var icon_name = $( this ).data( 'icon' ).toLowerCase().replaceAll( '-', ' ' )
								var check     = icon_name.indexOf( value ) > - 1
								$( this ).toggle( check )
							},
						)
					},
				)

				$( document ).on(
					'click',
					'.select-icon-act .remove-icon',
					function() {
						var control = $( this ).closest( '.woostify-adv-list-control' )
						var input   = control.find( '.woostify-adv-list-input' )

						input.val( '' )
						control.find( '.icon-list__icon' ).removeClass( 'active' )
						control.find( '.selected-icon' ).html( '' )
						update_value( $( '.woostify-adv-list-items' ) )
					},
				)

				$( document ).on(
					'click',
					'body',
					function(e) {
						var icon_list     = $( '.icon-list.open' );
						var icon_list_btn = $( '.select-icon-act .open-icon-list' );
						// if the target of the click isn't the container nor a descendant of the container.
						if ( ! icon_list.is( e.target ) && icon_list.has( e.target ).length === 0 && ! icon_list_btn.is( e.target ) ) {
							icon_list.slideUp( 500 );
							icon_list.delay( 500 ).removeClass( 'open' );
						}
					}
				)
			},
		)

	}
)( jQuery )
