<?php
/**
 * Class to create a custom arbitrary html control for dividers etc
 *
 * @package  woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The arbitrary control class
 */
class Woostify_Divider_Control extends WP_Customize_Control {

	/**
	 * The settings var
	 *
	 * @var string $settings the blog name.
	 */
	public $settings = 'blogname';

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
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="woostify-divider-customize-control">
			<?php
			switch ( $this->type ) {
				case 'text':
					echo '<p class="description">' . wp_kses_post( $this->description ) . '</p>';
					break;

				case 'heading':
					echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
					break;

				case 'divider':
					echo '<hr style="margin: 1em 0;" />';
					break;

				case 'space':
				default:
					echo '<div style="margin: 1em 0;"></div>';
					break;
			}
			?>
		</div>
		<?php
	}
}
