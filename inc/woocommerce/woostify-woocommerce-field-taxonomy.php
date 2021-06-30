<?php
/**
 * Add field taxonomy functions.
 *
 * @package woostify
 */

add_action( 'product_cat_add_form_fields', 'woostify_add_field_taxonomy', 10, 2 );

if ( ! function_exists( 'woostify_add_field_taxonomy' ) ) {
	/**
	 * Add field product taxonomy
	 *
	 * @param string $taxonomy The image size.
	 */
	function woostify_add_field_taxonomy( $taxonomy ) {
		?>
			<div class="form-field term-display-type-image">
				<label for="display_type_image"><?php esc_html_e( 'Thumbnail Page Header', 'woostify' ); ?></label>
				<select id="display_type_image" name="display_type_image" class="postform">
					<option value=""><?php esc_html_e( 'Disable', 'woostify' ); ?></option>
					<option value="enable"><?php esc_html_e( 'Enable', 'woostify' ); ?></option>
				</select>
			</div>
		<?php
	}
}

add_action( 'product_cat_edit_form_fields', 'woostify_edit_field_taxonomy', 10, 2 );

if ( ! function_exists( 'woostify_edit_field_taxonomy' ) ) {
	/**
	 * Edit field product taxonomy
	 *
	 * @param mixed  $term Term ID being saved.
	 * @param string $taxonomy Taxonomy slug.
	 */
	function woostify_edit_field_taxonomy( $term, $taxonomy ) {
		$display_type_image = get_term_meta( $term->term_id, 'display_type_image', true );
		?>
			<tr class="form-field term-display-type-image">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail Page Header', 'woostify' ); ?></label></th>
				<td>
					<select id="display_type_image" name="display_type_image" class="postform">
						<option value="" <?php selected( '', $display_type_image ); ?>><?php esc_html_e( 'Disable', 'woostify' ); ?></option>
						<option value="enable" <?php selected( 'enable', $display_type_image ); ?>><?php esc_html_e( 'Enable', 'woostify' ); ?></option>
					</select>
				</td>
			</tr>
		<?php
	}
}

add_action( 'created_term', 'woostify_save_term_field', 10, 3 );
add_action( 'edit_term', 'woostify_save_term_field', 10, 3 );

if ( ! function_exists( 'woostify_save_term_field' ) ) {
	/**
	 * Save field product taxonomy
	 *
	 * @param mixed $term_id Term ID being saved.
	 * @param mixed $tt_id Term taxonomy ID.
	 */
	function woostify_save_term_field( $term_id, $tt_id ) {
		if ( isset( $_POST['display_type_image'] ) ) { // WPCS: CSRF ok, input var ok.
			update_term_meta( $term_id, 'display_type_image', esc_attr( $_POST['display_type_image'] ) ); // WPCS: CSRF ok, sanitization ok, input var ok.
		}
	}
}
