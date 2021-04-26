<?php
/**
 * Woostify_Color_Group_Control
 *
 * @package woostify
 */

/**
 * Customize Color Group Control class.
 */
class Woostify_Color_Group_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'woostify-color-group';

	/**
	 * Tab
	 *
	 * @var string
	 */
	public $tab = '';

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
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script(
			'woostify-color-picker-group',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/color-group/js/pickr.min.js',
			array(),
			woostify_version(),
			true
		);

		wp_enqueue_script(
			'woostify-color-group',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/color-group/js/color-group.js',
			array(),
			woostify_version(),
			true
		);

		/*
		wp_enqueue_style(
			'woostify-color-picker-group-classic',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/color-group/css/classic.min.css',
			array(),
			woostify_version()
		);*/

		wp_enqueue_style(
			'woostify-color-picker-group-monolith',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/color-group/css/monolith.min.css',
			array(),
			woostify_version()
		);

		/*
		wp_enqueue_style(
			'woostify-color-picker-group-nano',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/color-group/css/nano.min.css',
			array(),
			woostify_version()
		);*/

		wp_enqueue_style(
			'woostify-color-group',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/color-group/css/color-group.css',
			array(),
			woostify_version()
		);
	}

	/**
	 * Renter the control
	 *
	 * @return void
	 */
	protected function render_content() {
		$control_id = explode( '[', $this->id )[1];
		$control_id = explode( ']', $control_id )[0];
		?>
		<div class="woostify-control-wrap woostify-color-group-control" data-control-id="<?php echo esc_attr( $control_id ); ?>">
			<div class="color-group-wrap">
				<?php if ( '' !== $this->label ) { ?>
					<label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
				<?php } ?>
				<div class="woostify-color-buttons">
					<span class="woostify-color-group-btn"></span>
					<div id="root"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
