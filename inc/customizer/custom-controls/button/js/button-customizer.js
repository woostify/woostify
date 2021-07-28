/**
 * Button js
 *
 * @package woostify
 */

wp.customize.controlConstructor['woostify-button-control'] = wp.customize.Control.extend(
	{
		ready: function () {
			'use strict'
			let control = this,
			button      = control.container.find( '.woostify-clear-font-files' )

			button.on(
				'click',
				function() {
					let _this = jQuery( this )

					setTimeout(
						function() {
							// Send our request to the woostify_regenerate_fonts_folder function.
							jQuery.ajax(
								{
									type: 'POST',
									url: ajaxurl,
									data: {
										action: 'woostify_regenerate_fonts_folder',
										woostify_customize_nonce: woostify_customize.nonce
									},
									async: false,
									dataType: 'json',
									beforeSend: function () {
										_this.parent().find( 'p.message' ).remove();
									},
									success: function() {
										let message = '<p class="message">Clear Successfully!</p>';
										_this.after( message );
									},
									error: function() {
										let message = '<p class="message">Clear Failed!</p>';
										_this.after( message );
									}
								}
							);
						},
						100
					)
				}
			)
		}
	}
)
