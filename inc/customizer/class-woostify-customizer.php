<?php
/**
 * Woostify Customizer Class
 *
 * @package  woostify
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woostify_Customizer' ) ) :

	/**
	 * The Woostify Customizer class
	 */
	class Woostify_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
		}

		/**
		 * Returns an array of the desired default Woostify Options
		 *
		 * @return array
		 */
		public static function get_woostify_default_setting_values() {
			return apply_filters(
				'woostify_setting_default_values',
				$args = array(
					'woostify_heading_color'               => '#2b2b2b',
					'woostify_text_color'                  => '#8f8f8f',
					'woostify_accent_color'                => '#1346af',
					'woostify_header_background_color'     => '#ffffff',
					'woostify_header_text_color'           => '#404040',
					'woostify_header_link_color'           => '#333333',
					'woostify_footer_background_color'     => '#f0f0f0',
					'woostify_footer_heading_color'        => '#333333',
					'woostify_footer_text_color'           => '#6d6d6d',
					'woostify_footer_link_color'           => '#333333',
					'woostify_button_background_color'     => '#eeeeee',
					'woostify_button_text_color'           => '#333333',
					'woostify_button_alt_background_color' => '#333333',
					'woostify_button_alt_text_color'       => '#ffffff',
					'woostify_shop_layout'                 => 'right',
					'background_color'                     => 'ffffff',
				)
			);
		}

		/**
		 * Get all of the Woostify theme mods.
		 *
		 * @return array $woostify_theme_mods The Woostify Theme Mods.
		 */
		public function get_woostify_theme_mods() {
			$woostify_theme_mods = array(
				'background_color'            => woostify_get_content_background_color(),
				'accent_color'                => get_theme_mod( 'woostify_accent_color' ),
				'header_background_color'     => get_theme_mod( 'woostify_header_background_color' ),
				'header_link_color'           => get_theme_mod( 'woostify_header_link_color' ),
				'header_text_color'           => get_theme_mod( 'woostify_header_text_color' ),
				'footer_background_color'     => get_theme_mod( 'woostify_footer_background_color' ),
				'footer_link_color'           => get_theme_mod( 'woostify_footer_link_color' ),
				'footer_heading_color'        => get_theme_mod( 'woostify_footer_heading_color' ),
				'footer_text_color'           => get_theme_mod( 'woostify_footer_text_color' ),
				'text_color'                  => get_theme_mod( 'woostify_text_color' ),
				'heading_color'               => get_theme_mod( 'woostify_heading_color' ),
				'button_background_color'     => get_theme_mod( 'woostify_button_background_color' ),
				'button_text_color'           => get_theme_mod( 'woostify_button_text_color' ),
				'button_alt_background_color' => get_theme_mod( 'woostify_button_alt_background_color' ),
				'button_alt_text_color'       => get_theme_mod( 'woostify_button_alt_text_color' ),
			);

			return apply_filters( 'woostify_theme_mods', $woostify_theme_mods );
		}

		/**
		 * Adds a value to each Woostify setting if one isn't already present.
		 *
		 * @uses get_woostify_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( self::get_woostify_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value Theme modification value.
		 *
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_woostify_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter woostify_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 *
		 * @uses   get_woostify_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( self::get_woostify_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 *
		 * @since  1.0
		 */
		public function customize_register( $wp_customize ) {

			/**
			 * Custom default section, panel
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/override-defaults.php';

			/**
			 * Custom controls
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/radio-image/class-woostify-customizer-control-radio-image.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/divider/class-woostify-customizer-control-arbitrary.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/typography/class-woostify-typography-customize-control.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/range/class-woostify-range-customize-control.php';

			/**
			 * Register Control Type
			 */
			if ( method_exists( $wp_customize, 'register_control_type' ) ) {
				$wp_customize->register_control_type( 'Woostify_Typography_Customize_Control' );
				$wp_customize->register_control_type( 'Woostify_Range_Customize_Control' );
			}

			/**
			 * Register section & panel
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/register-sections.php';

			/**
			 * Section, settings & control
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/buttons/button.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/footer/footer.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/header/header.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/color/color.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/typography.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/blog/blog.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/shop/shop.php';
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
				li#customize-control-woostify_settings-body_font_size {
					margin-bottom: 25px;
				}

				.customize-control-radio-image input[type=radio] {
					display: none;
				}

				.customize-control-radio-image label {
					margin-right: 10px;
					display: inline-block;
				}
				.customize-control-radio-image label.ui-state-active {
					border: 1px solid #008ec2;
					cursor: default;
				}
				.customize-control-radio-image img{
					display: block;
				}

			</style>
			<?php
		}

		/**
		 * Get site logo.
		 *
		 * @since 1.0
		 * @return string
		 */
		public function get_site_logo() {
			return woostify_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since 1.0
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since 1.0
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}

		/**
		 * Check if current page is using the Homepage template.
		 *
		 * @since 1.0
		 * @return bool
		 */
		public function is_homepage_template() {
			$template = get_post_meta( get_the_ID(), '_wp_page_template', true );

			if ( ! $template || 'template-homepage.php' !== $template || ! has_post_thumbnail( get_the_ID() ) ) {
				return false;
			}

			return true;
		}
	}

endif;

return new Woostify_Customizer();
