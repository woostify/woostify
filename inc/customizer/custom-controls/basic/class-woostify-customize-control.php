<?php
/**
 * Woositfy Custom Customize Control Params
 *
 * @package woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Create a extend control with custom params.
 * This control allows you to add responsive settings.
 */
class Woostify_Customize_Control extends WP_Customize_Control {

	/**
	 * Declare the custom param: tab.
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
		?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>" <?php echo esc_attr( ! empty( $this->tab ) ? 'data-tab="' .esc_attr( $this->tab ) . '"' : '' ); //phpcs:ignore ?>>
		<?php
		$this->render_content();
		echo '</li>';
	}

	/**
	 * To json data
	 */
	public function to_json() {
		parent::to_json();

		$this->json['tab'] = $this->tab;
	}
}
