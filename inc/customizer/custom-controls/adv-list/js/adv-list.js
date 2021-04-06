/**
 * Load media uploader on pages with our custom metabox
 */

( function( $ ) {

	'use strict';

	jQuery( document ).ready(
		function($){

			'use strict';

			// Instantiates the variable that holds the media library frame.
			var metaImageFrame;

			// Runs when the media button is clicked.
			$( 'body' ).click(
				function(e) {

					// Get the btn
					var btn = e.target;

					// Check if it's the upload button
					if ( ! btn || ! $( btn ).attr( 'data-media-uploader-target' ) ) {
						return;
					}

					// Get the field target
					var field = $( btn ).data( 'media-uploader-target' );

					// Prevents the default action from occuring.
					e.preventDefault();

					// Sets up the media library frame
					metaImageFrame = wp.media.frames.metaImageFrame = wp.media();

					// Runs when an image is selected.
					metaImageFrame.on(
						'select',
						function() {

							// Grabs the attachment selection and creates a JSON representation of the model.
							var media_attachment = metaImageFrame.state().get( 'selection' ).first().toJSON();

							// Sends the attachment URL to our custom image input field.
							$( field ).val( media_attachment.url );

						}
					);

					// Opens the media library frame.
					metaImageFrame.open();

				}
			);
		}
	);

	wp.customize.bind(
		'ready',
		function() {
			function update_value( $el, trigger_change ) {
				var value = {};
				$el.find( '.woostify-sortable-list-item-wrap' ).each( function( item_idx, item_obj ) {
					var item_wrap = $( item_obj );
					value[item_idx] = {};
					item_wrap.each( function( control_idx, control_obj ) {
						var control = $( control_obj );
						var is_visibility = control.find('.woostify-adv-list-checkbox').is(':checked');
						value[item_idx]['hidden'] = ! is_visibility;
						control.find( '.woostify-adv-list-control' ).each( function( input_idx, input_obj ) {
							var field_name = $( input_obj ).data('field_name');
							value[item_idx][field_name] = $( input_obj ).find('.woostify-adv-list-input').val();
						} )
					} );
				} );

				if ( trigger_change ) {
					wp.customize( 'woostify_setting[sticky_footer_bar_items]', function ( obj ) {
						obj.set( JSON.stringify( value ) );
					} );
				}
			}

			$( document ).on( 'change', '.woostify-adv-list-select', function () {
				update_value($('.woostify-adv-list-items'), true)
			} );
			$( document ).on( 'keyup', '.woostify-adv-list-input--name', function () {
				var item_wrap = $(this).closest( '.woostify-sortable-list-item-wrap' );
				item_wrap.find( '.sortable-item-name' ).text( $(this).val() );
			} );
			$( document ).on( 'click', '.woostify-sortable-control-list input[type=checkbox]', function() {
				var checkbox = $(this);
				var item = checkbox.closest('.woostify-sortable-list-item');
				var item_wrap = checkbox.closest('.woostify-sortable-list-item-wrap');
				var label = checkbox.parent();
				if ( ! checkbox.is(':checked') ) {
					item.removeClass('checked');
					item_wrap.removeClass('checked');
					label.removeClass('dashicons-visibility');
					label.addClass('dashicons-hidden');
				} else {
					item.addClass('checked');
					item_wrap.addClass('checked');
					label.removeClass('dashicons-hidden');
					label.addClass('dashicons-visibility');
				}
				update_value($('.woostify-adv-list-items'), true)
			} );
			$( document ).on( 'blur', '.woostify-adv-list-input', function() {
				update_value($('.woostify-adv-list-items'), true)
			} )
			$( document ).on( 'click', '.sortable-item-icon-expand', function() {
				var btn = $(this);
				var item_wrap = btn.closest('.woostify-sortable-list-item-wrap');
				var item_content = item_wrap.find( '.adv-list-item-content' );
				item_content.slideToggle();
			} );
		}
	);

} )( jQuery );
