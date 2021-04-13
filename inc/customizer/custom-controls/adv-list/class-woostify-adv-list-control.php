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
	 * Tab
	 *
	 * @var string
	 */
	public $tab = '';

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
			array( 'jquery', 'jquery-ui-sortable' ),
			woostify_version(),
			true
		);

		wp_enqueue_style(
			'woostify-adv-list',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/adv-list/css/adv-list.css',
			array(),
			woostify_version()
		);
	}

	/**
	 * TO json data
	 */
	public function to_json()
	{
		parent::to_json();

		$this->json['tab'] = $this->tab;
	}

	/**
	 * Renter the control
	 *
	 * @return void
	 */
	public function render_content() {
		$items = json_decode( $this->value() );
		?>
		<div class="woostify-adv-list-container">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<div class="woostify-adv-list-items woostify-sortable-control-list">
				<?php foreach ( $items as $k => $val ) { ?>
					<div class="woostify-sortable-list-item-wrap <?php echo ! $val->hidden ? 'checked' : ''; ?>">
						<div class="woostify-sortable-list-item woostify-adv-list-item <?php echo ! $val->hidden ? 'checked' : ''; ?>" data-item_id="<?php echo esc_attr( $k ); ?>">
							<label class="sortable-item-icon-visibility dashicons dashicons-<?php echo ! $val->hidden ? 'visibility' : 'hidden'; ?>" for="<?php echo $this->id . '_' . $k . '_hidden'; //phpcs:ignore ?>">
								<input class="sortable-item-input woostify-adv-list-checkbox" type="checkbox" name="<?php echo $this->id . '[' . $k . '][hidden]'; ?>" id="<?php echo $this->id . '_' . $k . '_hidden'; ?>" <?php echo ! $val->hidden ? 'checked="checked"' : '';//phpcs:ignore ?>>
							</label>
							<span class="sortable-item-name"><?php echo esc_html( $val->name ); ?></span>
							<span class="sortable-item-icon-expand dashicons dashicons-arrow-down-alt2"></span>
						</div>
						<div class="adv-list-item-content" data-item_id="<?php echo esc_attr( $k ); ?>">
							<div class="type-field woostify-adv-list-control customize-control-select" data-field_name="type">
								<?php
								$type_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . $k . '_type';
								$type_field_name = "{$this->id}[{$k}][type]";
								?>
								<label for="<?php echo esc_attr( $type_field_id ); ?>"><?php echo esc_html__( 'Type', 'woostify' ); ?></label>
								<select name="<?php echo esc_attr( $type_field_name ); ?>" id="<?php echo esc_attr( $type_field_id ); ?>" class="woostify-adv-list-input woostify-adv-list-select">
									<option value="custom" <?php selected( $val->type, 'custom' ); ?>><?php esc_html_e( 'Custom', 'woositify' ); ?></option>
									<?php if ( woostify_support_wishlist_plugin() ) { ?>
										<option value="wishlist" <?php selected( $val->type, 'wishlist' ); ?>><?php esc_html_e( 'Wishlist', 'woositify' ); ?></option>
									<?php } ?>
									<?php if ( woostify_is_woocommerce_activated() ) { ?>
										<option value="cart" <?php selected( $val->type, 'cart' ); ?>><?php esc_html_e( 'Cart', 'woositify' ); ?></option>
									<?php } ?>
									<option value="shortcode" <?php selected( $val->type, 'shortcode' ); ?>><?php esc_html_e( 'Shortcode', 'woositify' ); ?></option>
									<option value="search" <?php selected( $val->type, 'search' ); ?>><?php esc_html_e( 'Search', 'woositify' ); ?></option>
								</select>
							</div>
							<div class="shortcode-field woostify-adv-list-control customize-control-text" data-field_name="shortcode">
								<?php
								$shortcode_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . $k . '_shortcode';
								$shortcode_field_name = "{$this->id}[{$k}][shortcode]";
								?>
								<label for="<?php echo esc_attr( $shortcode_field_id ); ?>"><?php esc_html_e( 'Shortcode', 'woostify' ); ?></label>
								<input type="text" class="woostify-adv-list-input woostify-adv-list-input--shortcode" name="<?php echo esc_attr( $shortcode_field_name ); ?>" id="<?php echo esc_attr( $shortcode_field_id ); ?>" value="<?php echo esc_html( $val->shortcode ); ?>">
							</div>
							<div class="icon-field woostify-adv-list-control customize-control-text" data-field_name="icon">
								<?php
								$icon_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . $k . '_icon';
								$icon_field_name = "{$this->id}[{$k}][icon]";
								?>
								<label for="<?php echo esc_attr( $icon_field_id ); ?>">
									<?php esc_html_e( 'Icon', 'woostify' ); ?>
									<?php /* translators: %s: icons class */ ?>
									<span class="woostify-control-desc"><?php echo sprintf( esc_html__( 'Get icons class %s', 'woostify' ), '<a href="https://themify.me/themify-icons" target="_blank">here</a>' ); ?></label></span>
								<input type="text" class="woostify-adv-list-input woostify-adv-list-input--icon" name="<?php echo esc_attr( $icon_field_name ); ?>" id="<?php echo esc_attr( $icon_field_id ); ?>" value="<?php echo esc_html( $val->icon ); ?>">
							</div>
							<div class="name-field woostify-adv-list-control customize-control-text" data-field_name="name">
								<?php
								$name_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . $k . '_name';
								$name_field_name = "{$this->id}[{$k}][name]";
								?>
								<label for="<?php echo esc_attr( $name_field_id ); ?>"><?php esc_html_e( 'Name', 'woostify' ); ?></label>
								<input type="text" class="woostify-adv-list-input woostify-adv-list-input--name" name="<?php echo esc_attr( $name_field_name ); ?>" id="<?php echo esc_attr( $name_field_id ); ?>" value="<?php echo esc_html( $val->name ); ?>">
							</div>
							<div class="link-field woostify-adv-list-control customize-control-text" data-field_name="link">
								<?php
								$link_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . "{$k}_link";
								$link_field_name = "{$this->id}[{$k}][link]";
								?>
								<label for="<?php echo esc_attr( $link_field_id ); ?>"><?php esc_html_e( 'Link', 'woostify' ); ?></label>
								<input type="url" class="woostify-adv-list-input" name="<?php echo esc_attr( $link_field_name ); ?>" id="<?php echo esc_attr( $link_field_id ); ?>" value="<?php echo esc_url( $val->link ); ?>">
							</div>
						</div>
					</div>
			<?php } ?>
				<input type="hidden" class="woostify-adv-list-value" <?php $this->link(); ?> value='<?php echo $this->value(); //phpcs:ignore ?>' />
			</div>
		</div>
		<?php
	}
}
