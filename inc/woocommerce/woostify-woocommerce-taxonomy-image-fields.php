<?php
/**
 * Add image taxonomy functions.
 *
 * @package woostify
 */

add_action( 'product_cat_add_form_fields', 'woostify_add_image_taxonomy', 20, 2 );

if ( ! function_exists( 'woostify_add_image_taxonomy' ) ) {
	/**
	 * Add image product taxonomy
	 *
	 * @param string $taxonomy The image size.
	 */
	function woostify_add_image_taxonomy( $taxonomy ) {
		?>
			<div class="form-field">
				<label><?php esc_html_e( 'Thumbnail Page Header', 'woostify' ); ?></label>
				<div id="custom_product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="custom_product_cat_thumbnail_id" name="custom_product_cat_thumbnail_id" />
					<button type="button" class="custom_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woostify' ); ?></button>
					<button type="button" class="custom_remove_image_button button"><?php esc_html_e( 'Remove image', 'woostify' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery( '#custom_product_cat_thumbnail_id' ).val() ) {
						jQuery( '.custom_remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.custom_upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'woostify' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'woostify' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

							jQuery( '#custom_product_cat_thumbnail_id' ).val( attachment.id );
							jQuery( '#custom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.custom_remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.custom_remove_image_button', function() {
						jQuery( '#custom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#custom_product_cat_thumbnail_id' ).val( '' );
						jQuery( '.custom_remove_image_button' ).hide();
						return false;
					});

					jQuery( document ).ajaxComplete( function( event, request, options ) {
						if ( request && 4 === request.readyState && 200 === request.status
							&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

							var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
							if ( ! res || res.errors ) {
								return;
							}
							// Clear Thumbnail fields on submit
							jQuery( '#custom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
							jQuery( '#custom_product_cat_thumbnail_id' ).val( '' );
							jQuery( '.custom_remove_image_button' ).hide();

							return;
						}
					} );

				</script>
				<div class="clear"></div>
			</div>
		<?php
	}
}

add_action( 'product_cat_edit_form_fields', 'woostify_edit_image_upload', 20, 2 );

if ( ! function_exists( 'woostify_edit_image_upload' ) ) {
	/**
	 * Edit image product taxonomy
	 *
	 * @param mixed  $term Term ID being saved.
	 * @param string $taxonomy Taxonomy slug.
	 */
	function woostify_edit_image_upload( $term, $taxonomy ) {

		$thumbnail_id = absint( get_term_meta( $term->term_id, 'custom_thumbnail_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
		}
		?>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail Page Header', 'woostify' ); ?></label></th>
				<td>
					<div id="custom_product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
					<div style="line-height: 60px;">
						<input type="hidden" id="custom_product_cat_thumbnail_id" name="custom_product_cat_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
						<button type="button" class="custom_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'woostify' ); ?></button>
						<button type="button" class="custom_remove_image_button button"><?php esc_html_e( 'Remove image', 'woostify' ); ?></button>
					</div>
					<script type="text/javascript">

						// Only show the "remove image" button when needed
						if ( '0' === jQuery( '#custom_product_cat_thumbnail_id' ).val() ) {
							jQuery( '.custom_remove_image_button' ).hide();
						}

						// Uploading files
						var file_frame;

						jQuery( document ).on( 'click', '.custom_upload_image_button', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame ) {
								file_frame.open();
								return;
							}

							// Create the media frame.
							file_frame = wp.media.frames.downloadable_file = wp.media({
								title: '<?php esc_html_e( 'Choose an image', 'woostify' ); ?>',
								button: {
									text: '<?php esc_html_e( 'Use image', 'woostify' ); ?>'
								},
								multiple: false
							});

							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
								var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
								var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

								jQuery( '#custom_product_cat_thumbnail_id' ).val( attachment.id );
								jQuery( '#custom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
								jQuery( '.custom_remove_image_button' ).show();
							});

							// Finally, open the modal.
							file_frame.open();
						});

						jQuery( document ).on( 'click', '.custom_remove_image_button', function() {
							jQuery( '#custom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
							jQuery( '#custom_product_cat_thumbnail_id' ).val( '' );
							jQuery( '.custom_remove_image_button' ).hide();
							return false;
						});

					</script>
					<div class="clear"></div>
				</td>
			</tr>
		<?php
	}
}

add_action( 'created_term', 'woostify_save_term_image', 20, 3 );
add_action( 'edit_term', 'woostify_save_term_image', 20, 3 );

if ( ! function_exists( 'woostify_save_term_image' ) ) {
	/**
	 * Save image product taxonomy
	 *
	 * @param mixed $term_id Term ID being saved.
	 * @param mixed $tt_id Term taxonomy ID.
	 */
	function woostify_save_term_image( $term_id, $tt_id ) {
		if ( isset( $_POST['custom_product_cat_thumbnail_id'] ) ) {
			update_term_meta( $term_id, 'custom_thumbnail_id', absint( $_POST['custom_product_cat_thumbnail_id'] ) ); // WPCS: CSRF ok, input var ok.
		}
	}
}
