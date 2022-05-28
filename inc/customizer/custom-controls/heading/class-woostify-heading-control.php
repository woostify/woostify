<?php
/**
 * Heading control class
 *
 * @package  woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The heading control class
 */
class Woostify_Heading_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'woostify-heading';

	/**
	 * The description var
	 *
	 * @var string $description the control description.
	 */
	public $description = '';


	/**
	 * The tab var
	 *
	 * @var string $tab
	 */
	public $tab = '';

	/**
	 * To json data
	 */
	public function to_json() {
		parent::to_json();

		$this->json['tab'] = $this->tab;
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_style(
			'woostify-heading-control',
			WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/heading/style.css',
			array(),
			woostify_version()
		);
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @since 3.4.0
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . $this->type;

		?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>" <?php echo esc_attr( ! empty( $this->tab ) ? 'data-tab="' .esc_attr( $this->tab ) . '"' : '' ); //phpcs:ignore ?>>
		<?php
		$this->render_content();
		echo '</li>';
	}

	/**
	 * Renter the control
	 */
	public function content_template() {
		?>
		<div class="woostify-heading-control">
			<# if ( data.label ) { #>
			<span class="woostify-section-control-label">{{ data.label }}</span>
			<# } #>
		</div>
		<?php
	}
}
