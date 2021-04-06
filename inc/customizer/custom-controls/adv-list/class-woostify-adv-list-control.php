<?php
/**
 * Woostify_Advanced_List_Control
 *
 * @package woostify
 */

/**
 * Customize Advanced List Control class.
 */
class Woostify_Adv_List_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'woostify-adv-list';

	/**
	 * Description
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_media();

		wp_enqueue_script(
			'woostify-media-upload',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/adv-list/js/adv-list.js',
			[ 'jquery' ],
			woostify_version(),
			true
		);

		/*wp_enqueue_script(
			'woostify-sortable',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/sortable/js/sortable.js',
			[],
			woostify_version(),
			true
		);

		wp_enqueue_script(
			'woostify-sortable-handle',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/sortable/js/sortable-handle.js',
			[ 'woostify-sortable' ],
			woostify_version(),
			true
		);*/

		wp_enqueue_style(
			'woostify-adv-list',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/adv-list/css/adv-list.css',
			[],
			woostify_version()
		);
	}

	public function render_content(){
		$items = json_decode($this->value());
		?>
		<div class="woostify-adv-list-container">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<span class="description customize-control-description"><?php echo esc_html($this->description ); ?></span>
			<div class="woostify-adv-list-items woostify-sortable-control-list">
				<?php foreach( $items as $k => $val ) { ?>
					<div class="woostify-sortable-list-item-wrap <?php echo ! $val->hidden ? 'checked' : ''; ?>">
						<div class="woostify-sortable-list-item woostify-adv-list-item <?php echo ! $val->hidden ? 'checked' : ''; ?>" data-item_id="<?php echo $k; ?>">
							<label class="sortable-item-icon-visibility dashicons dashicons-<?php echo ! $val->hidden ? 'visibility' : 'hidden'; ?>" for="<?php echo "{$this->id}_{$k}_hidden"; ?>">
								<input class="sortable-item-input woostify-adv-list-checkbox" type="checkbox" name="<?php echo $this->id . '['.$k.'][hidden]'; ?>" id="<?php echo "{$this->id}_{$k}_hidden"; ?>" <?php echo ! $val->hidden ? 'checked="checked"' : ''; ?>>
							</label>
							<span class="sortable-item-name"><?php echo $val->name; ?></span>
							<span class="sortable-item-icon-expand dashicons dashicons-arrow-down-alt2"></span>
						</div>
						<div class="adv-list-item-content" data-item_id="<?php echo $k; ?>">
							<div class="type-field woostify-adv-list-control customize-control-select" data-field_name="type">
								<?php
								$type_field_id = preg_replace('/[\[\]]/', '_', $this->id) . "{$k}_type";
								$type_field_name = "{$this->id}[{$k}][type]";
								?>
								<label for="<?php echo $type_field_id; ?>"><?php esc_html_e( 'Type', 'woostify' ); ?></label>
								<select name="<?php echo $type_field_name; ?>" id="<?php echo $type_field_id; ?>" class="woostify-adv-list-input woostify-adv-list-select">
									<option value="custom" <?php selected( $val->type, 'custom' ); ?>><?php _e( 'Custom', 'woositify' ); ?></option>
									<option value="wishlist" <?php selected( $val->type, 'wishlist' ); ?>><?php _e( 'Wishlist', 'woositify' ); ?></option>
									<option value="compare" <?php selected( $val->type, 'compare' ); ?>><?php _e( 'Compare', 'woositify' ); ?></option>
									<option value="cart" <?php selected( $val->type, 'cart' ); ?>><?php _e( 'Cart', 'woositify' ); ?></option>
									<option value="search" <?php selected( $val->type, 'search' ); ?>><?php _e( 'Search', 'woositify' ); ?></option>
								</select>
							</div>
							<div class="icon-field woostify-adv-list-control customize-control-media" data-field_name="icon">
								<?php
								$icon_field_id = preg_replace('/[\[\]]/', '_', $this->id) . "{$k}_icon";
								$icon_field_name = "{$this->id}[{$k}][icon]";
								?>
								<label for="<?php echo $icon_field_id; ?>"><?php esc_html_e( 'Icon', 'woostify' ); ?></label>
								<input type="hidden" class="woostify-adv-list-input" name="<?php echo $icon_field_name; ?>" id="<?php echo $icon_field_id; ?>" value="<?php echo esc_attr( $val->icon ); ?>">
								<button type="button" class="button" id="<?php echo "{$icon_field_id}_upload_btn"; ?>" data-media-uploader-target="#<?php echo $icon_field_id; ?>"><?php _e( 'Upload Media', 'myplugin' )?></button>
							</div>
							<div class="name-field woostify-adv-list-control customize-control-text" data-field_name="name">
								<?php
								$name_field_id = preg_replace('/[\[\]]/', '_', $this->id) . "{$k}_name";
								$name_field_name = "{$this->id}[{$k}][name]";
								?>
								<label for="<?php echo $name_field_id; ?>"><?php esc_html_e( 'Name', 'woostify' ); ?></label>
								<input type="text" class="woostify-adv-list-input woostify-adv-list-input--name" name="<?php echo $name_field_name; ?>" id="<?php echo $name_field_id; ?>" value="<?php echo esc_attr( $val->name ); ?>">
							</div>
							<div class="link-field woostify-adv-list-control customize-control-text" data-field_name="link">
								<?php
								$link_field_id = preg_replace('/[\[\]]/', '_', $this->id) . "{$k}_link";
								$link_field_name = "{$this->id}[{$k}][link]";
								?>
								<label for="<?php echo $link_field_id; ?>"><?php esc_html_e( 'Link', 'woostify' ); ?></label>
								<input type="url" class="woostify-adv-list-input" name="<?php echo $link_field_name; ?>" id="<?php echo $link_field_id; ?>" value="<?php echo esc_attr( $val->link ); ?>">
							</div>
						</div>
					</div>
			<?php } ?>
				<input type="hidden" class="woostify-adv-list-value" data-customize-setting-link="<?php echo esc_attr($this->id); ?>">
			</div>
		</div>
		<?php
	}
}
