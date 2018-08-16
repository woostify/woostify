<?php
/**
 * Woostify Get CSS
 *
 * @package  woostify
 */

/**
 * The Woostify Get CSS class
 */
class Woostify_Get_CSS {
	/**
	 * Wp enqueue scripts
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
	}

	/**
	 * Get Customizer css.
	 *
	 * @see get_woostify_theme_mods()
	 * @return array $styles the css
	 */
	public function get_css() {
		$woostify_settings = wp_parse_args(
			get_option( 'woostify_settings', array() ),
			Woostify_Fonts_Helpers::woostify_get_default_fonts()
		);

		$woostify_customizer = new Woostify_Customizer();
		$woostify_theme_mods = $woostify_customizer->get_woostify_theme_mods();

		$styles = '
			body, select, button, input, textarea{
				font-family: ' . $woostify_settings['body_font_family'] . ';
				font-weight: ' . $woostify_settings['body_font_weight'] . ';
				line-height: ' . $woostify_settings['body_line_height'] . ';
				text-transform: ' . $woostify_settings['body_font_transform'] . ';
				font-size: ' . $woostify_settings['body_font_size'] . 'px;
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			h1, h2, h3, h4, h5, h6{
				font-family: ' . $woostify_settings['heading_font_family'] . ';
				font-weight: ' . $woostify_settings['heading_font_weight'] . ';
				text-transform: ' . $woostify_settings['heading_font_transform'] . ';
				line-height: ' . $woostify_settings['heading_line_height'] . ';
				color: ' . $woostify_theme_mods['heading_color'] . ';
			}

			h1{
				font-size: ' . $woostify_settings['heading_h1_font_size'] . ';
			}
			h2{
				font-size: ' . $woostify_settings['heading_h2_font_size'] . ';
			}
			h3{
				font-size: ' . $woostify_settings['heading_h3_font_size'] . ';
			}
			h4{
				font-size: ' . $woostify_settings['heading_h4_font_size'] . ';
			}
			h5{
				font-size: ' . $woostify_settings['heading_h5_font_size'] . ';
			}
			h6{
				font-size: ' . $woostify_settings['heading_h6_font_size'] . ';
			}

			a{
				color: ' . $woostify_theme_mods['accent_color'] . ';
			}
		';

		return apply_filters( 'woostify_customizer_css', $styles );
	}

	/**
	 * Add CSS in <head> for styles handled by the theme customizer
	 *
	 * @since 1.0
	 * @return void
	 */
	public function add_customizer_css() {
		wp_add_inline_style( 'woostify-style', $this->get_css() );
	}
}

return new Woostify_Get_CSS();
