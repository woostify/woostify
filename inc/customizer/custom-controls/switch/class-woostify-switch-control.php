<?php
/**
 * Switch for Customizer.
 *
 * @package woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Create a range slider control.
 * This control allows you to add responsive settings.
 */
class Woostify_Switch_Control extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @var string
	 */
	public $type = 'switch';

	/**
	 * Enqueue scripts and styles for the custom control.
	 */
	public function enqueue() {
		global $woostify_version;

		wp_enqueue_style(
			'woostify-switch-control',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/switch/css/switch.css',
			array(),
			$woostify_version
		);

		wp_enqueue_script(
			'woostify-switch-control',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/switch/js/switch.js',
			array(),
			$woostify_version,
			true
		);
	}

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		$name    = '_customize-radio-' . $this->id;
		$id      = $this->id;
		$label   = $this->label;
		$value   = $this->value();
		$desc    = $this->description;
		$choices = $this->choices;
		?>
		<div>
			<div>
				<?php if ( ! empty( $label ) ) { ?>
					<span class="customize-control-title">
						<?php echo esc_html( $label ); ?>
					</span>
				<?php } ?>

				<input
					id="<?php echo esc_attr( $id ); ?>"
					type="checkbox"
					name="<?php echo esc_attr( $name ); ?>"
					class="switch-control"
					value="<?php echo esc_attr( $value ); ?>"
					<?php
						$this->link();
						checked( $value );
					?>
					/>

				<label for="<?php echo esc_attr( $id ); ?>" class="switch-control-label">
					<span class="switch-off"><?php echo esc_attr( $choices[0] ); ?></span>
					<span class="switch-on"><?php echo esc_attr( $choices[1] ); ?></span>
				</label>
			</div>

			<?php if ( ! empty( $description ) ) { ?>
				<span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
			<?php } ?>
		</div>
		<?php
	}
}

