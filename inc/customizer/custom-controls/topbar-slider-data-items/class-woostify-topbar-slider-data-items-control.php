<?php
/**
 * Woostify_Topbar_Slider_Data_Items_Control
 *
 * @package woostify
 */

/**
 * Customize Topbar Slider Data Item class.
 */
class Woostify_Topbar_Slider_Data_Items_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'woostify-topbar-slider-data-items';

	/**
	 * Description
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Declare the custom param: tab.
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
			'woostify-customize-topbar-slider-data-items',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/topbar-slider-data-items/script.js',
			array( 'jquery' ),
			woostify_version(),
			true
		);

		wp_enqueue_style(
			'woostify-customize-topbar-slider-data-items',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/topbar-slider-data-items/style.css',
			array(),
			woostify_version()
		);

		wp_enqueue_editor();
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @since 3.4.0
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . $this->type;

		printf( '<li id="%s" class="%s" data-tab="%s">', esc_attr( $id ), esc_attr( $class ), esc_attr( $this->tab ) );
		$this->render_content();
		echo '</li>';
	}

	/**
	 * Renter the control
	 *
	 * @return void
	 */
	public function render_content() {
		$items = json_decode( $this->value() );
		?>
		<div class="woostify-slider-list-container">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<div class="woostify-slider-list-items woostify-sortable-control-list">
				<?php foreach ( $items as $k => $val ) {  ?>
					<?php
					$tab_name = __( 'Item', 'woostify' );
					?>
					<div class="woostify-sortable-list-item-wrap checked">
						<div class="woostify-sortable-list-item woostify-slider-list-item checked" data-item_id="<?php echo esc_attr( $k ); ?>">
							<span class="sortable-item-icon-del dashicons dashicons-no-alt"></span>
							<span class="sortable-item-name"><?php echo esc_html( $tab_name ); ?></span>
							<span class="sortable-item-icon-expand dashicons dashicons-arrow-down-alt2"></span>
						</div>
						<div class="slider-list-item-content" data-item_id="<?php echo esc_attr( $k ); ?>">
							<div class="name-field woostify-slider-list-control customize-control-text" data-field_name="name">
								<?php
								$name_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . $k . '_name';
								$name_field_name = "{$this->id}[{$k}][name]";
								?>
								<label for="<?php echo esc_attr( $name_field_id ); ?>"><?php esc_html_e( 'Text', 'woostify' ); ?></label>
								<input type="text" class="woostify-slider-list-input woostify-slider-list-input--name" name="<?php echo esc_attr( $name_field_name ); ?>" id="<?php echo esc_attr( $name_field_id ); ?>" value="<?php echo __( esc_html( $val->name ), 'woostify' ); ?>">
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="woostify-sortable-list-item-wrap checked example-item-tmpl">
					<div class="woostify-sortable-list-item woostify-slider-list-item checked" data-item_id="{{ITEM_ID}}">
						<span class="sortable-item-icon-del dashicons dashicons-no-alt"></span>
						<span class="sortable-item-name"></span>
						<span class="sortable-item-icon-expand dashicons dashicons-arrow-down-alt2"></span>
					</div>
					<div class="slider-list-item-content" data-item_id="{{ITEM_ID}}">
						<div class="name-field woostify-slider-list-control customize-control-text" data-field_name="name">
							<?php
							$name_field_id   = preg_replace( '/[\[\]]/', '_', $this->id ) . '{{ITEM_ID}}_name';
							$name_field_name = "{$this->id}[{{ITEM_ID}}][name]";
							?>
							<label for="<?php echo esc_attr( $name_field_id ); ?>"><?php esc_html_e( 'Text', 'woostify' ); ?></label>
							<input type="text" class="woostify-slider-list-input woostify-slider-list-input--name" name="<?php echo esc_attr( $name_field_name ); ?>" id="<?php echo esc_attr( $name_field_id ); ?>" value="">
						</div>
					</div>
				</div>
			</div>
			<button class="button button-primary slider-list-add-item-btn"><?php esc_html_e( 'Add Item', 'woostify' ); ?></button>
			<input type="hidden" class="woostify-slider-list-value" <?php $this->link(); ?> value='<?php echo esc_attr( json_encode( $this->value() ) ) ; //phpcs:ignore ?>'/>
		</div>
		<?php
	}
}
