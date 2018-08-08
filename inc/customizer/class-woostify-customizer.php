<?php
/**
 * Woostify Customizer Class
 *
 * @package  woostify
 * @since    2.0.0
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
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class', array( $this, 'layout_class' ) );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
		}

		/**
		 * Returns an array of the desired default Woostify Options
		 *
		 * @return array
		 */
		public static function get_woostify_default_setting_values() {
			return apply_filters(
				'woostify_setting_default_values', $args = array(
					'woostify_heading_color'               => '#333333',
					'woostify_text_color'                  => '#6d6d6d',
					'woostify_accent_color'                => '#96588a',
					'woostify_hero_heading_color'          => '#000000',
					'woostify_hero_text_color'             => '#000000',
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
					'woostify_layout'                      => 'right',
					'background_color'                       => 'ffffff',
				)
			);
		}

        /**
         * Get all of the Woostify theme mods.
         *
         * @return array $woostify_theme_mods The Woostify Theme Mods.
         */
        public function get_woostify_theme_mods()
        {
            $woostify_theme_mods = array(
                'background_color' => woostify_get_content_background_color(),
                'accent_color' => get_theme_mod('woostify_accent_color'),
                'hero_heading_color' => get_theme_mod('woostify_hero_heading_color'),
                'hero_text_color' => get_theme_mod('woostify_hero_text_color'),
                'header_background_color' => get_theme_mod('woostify_header_background_color'),
                'header_link_color' => get_theme_mod('woostify_header_link_color'),
                'header_text_color' => get_theme_mod('woostify_header_text_color'),
                'footer_background_color' => get_theme_mod('woostify_footer_background_color'),
                'footer_link_color' => get_theme_mod('woostify_footer_link_color'),
                'footer_heading_color' => get_theme_mod('woostify_footer_heading_color'),
                'footer_text_color' => get_theme_mod('woostify_footer_text_color'),
                'text_color' => get_theme_mod('woostify_text_color'),
                'heading_color' => get_theme_mod('woostify_heading_color'),
                'button_background_color' => get_theme_mod('woostify_button_background_color'),
                'button_text_color' => get_theme_mod('woostify_button_text_color'),
                'button_alt_background_color' => get_theme_mod('woostify_button_alt_background_color'),
                'button_alt_text_color' => get_theme_mod('woostify_button_alt_text_color'),
            );

            return apply_filters('woostify_theme_mods', $woostify_theme_mods);
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
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			/**
			 * Custom default section, panel
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/override-defaults.php';

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/custom-controls/radio-image/class-woostify-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/custom-controls/divider/class-woostify-customizer-control-arbitrary.php';
            require_once dirname( __FILE__ ) . '/custom-controls/typography/class-typography-control.php';

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
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/layout/layout.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/color/color.php';
            require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/typography.php';
			

		}



		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'woostify_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
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
		 * @since  1.5.0
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
				display: block;
				width: 48%;
				float: left;
				margin-right: 4%;
			}

			.customize-control-radio-image label:nth-of-type(2n) {
				margin-right: 0;
			}

			.customize-control-radio-image img {
				opacity: .5;
			}

			.customize-control-radio-image input[type=radio]:checked + label img,
			.customize-control-radio-image img:hover {
				opacity: 1;
			}

			</style>
			<?php
		}

		/**
		 * Get site logo.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_logo() {
			return woostify_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}

		/**
		 * Check if current page is using the Homepage template.
		 *
		 * @since 2.3.0
		 * @return bool
		 */
		public function is_homepage_template() {
			$template = get_post_meta( get_the_ID(), '_wp_page_template', true );

			if ( ! $template || 'template-homepage.php' !== $template || ! has_post_thumbnail( get_the_ID() ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Setup the WordPress core custom header feature.
		 *
		 * @deprecated 2.4.0
		 * @return void
		 */
		public function custom_header_setup() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.4.0' );
			} else {
				_deprecated_function( __FUNCTION__, '2.4.0' );
			}
		}

		/**
		 * Get Customizer css associated with WooCommerce.
		 *
		 * @deprecated 2.4.0
		 * @return void
		 */
		public function get_woocommerce_css() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}

		/**
		 * Assign Woostify styles to individual theme mods.
		 *
		 * @deprecated 2.3.1
		 * @return void
		 */
		public function set_woostify_style_theme_mods() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}
	}

endif;

return new Woostify_Customizer();
