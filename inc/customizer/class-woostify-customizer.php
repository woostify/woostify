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
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
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
					// Color.
					'woostify_theme_color'                   => '#1346af',
					'woostify_primary_menu_color'            => '#2b2b2b',
					'woostify_primary_sub_menu_color'        => '#2b2b2b',
					'woostify_heading_color'                 => '#2b2b2b',
					'woostify_text_color'                    => '#8f8f8f',
					'woostify_accent_color'                  => '#2b2b2b',

					// Header.
					'woostify_header_background_color'       => '#ffffff',

					// Footer.
					'woostify_footer_background_color'       => '#eeeeec',
					'woostify_footer_heading_color'          => '#2b2b2b',
					'woostify_footer_link_color'             => '#8f8f8f',
					'woostify_footer_text_color'             => '#8f8f8f',

					// Button.
					'woostify_button_text_color'             => '#ffffff',
					'woostify_button_background_color'       => '#1346af',
					'woostify_button_hover_text_color'       => '#ffffff',
					'woostify_button_hover_background_color' => '#3a3a3a',

					// Shop single.
					'woostify_single_add_to_cart_ajax'       => true,
					'woostify_single_content_background'     => '#f3f3f3',
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
				// Color.
				'theme_color'                    => get_theme_mod( 'woostify_theme_color' ),
				'primary_menu_color'             => get_theme_mod( 'woostify_primary_menu_color' ),
				'primary_sub_menu_color'         => get_theme_mod( 'woostify_primary_sub_menu_color' ),
				'heading_color'                  => get_theme_mod( 'woostify_heading_color' ),
				'text_color'                     => get_theme_mod( 'woostify_text_color' ),
				'accent_color'                   => get_theme_mod( 'woostify_accent_color' ),

				// Header color.
				'header_background_color'        => get_theme_mod( 'woostify_header_background_color' ),

				// Footer color.
				'footer_background_color'        => get_theme_mod( 'woostify_footer_background_color' ),
				'footer_heading_color'           => get_theme_mod( 'woostify_footer_heading_color' ),
				'footer_link_color'              => get_theme_mod( 'woostify_footer_link_color' ),
				'footer_text_color'              => get_theme_mod( 'woostify_footer_text_color' ),

				// Button color.
				'button_text_color'              => get_theme_mod( 'woostify_button_text_color' ),
				'button_background_color'        => get_theme_mod( 'woostify_button_background_color' ),
				'button_hover_text_color'        => get_theme_mod( 'woostify_button_hover_text_color' ),
				'button_hover_background_color'  => get_theme_mod( 'woostify_button_hover_background_color' ),

				// Shop single.
				'shop_sinlge_add_to_cart_ajax'   => get_theme_mod( 'woostify_single_add_to_cart_ajax' ),
				'shop_single_content_background' => get_theme_mod( 'woostify_single_content_background' ),
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

			// Custom default section, panel.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/override-defaults.php';

			// Custom controls.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/radio-image/class-woostify-customizer-control-radio-image.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/divider/class-woostify-customizer-control-arbitrary.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/typography/class-woostify-typography-customize-control.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/range/class-woostify-range-customize-control.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/woostify-pro/class-woostify-get-pro-control.php';

			// Custom section.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/woostify-pro/class-woostify-get-pro-section.php';

			// Register Control Type.
			if ( method_exists( $wp_customize, 'register_control_type' ) ) {
				$wp_customize->register_control_type( 'Woostify_Typography_Customize_Control' );
				$wp_customize->register_control_type( 'Woostify_Range_Customize_Control' );
				$wp_customize->register_control_type( 'Woostify_Get_Pro_Control' );
			}

			// Register Section Type.
			if ( method_exists( $wp_customize, 'register_section_type' ) ) {
				$wp_customize->register_section_type( 'Woostify_Get_Pro_Section' );
			}

			// Get pro version area.
			if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) {
				// Add get pro version section.
				$wp_customize->add_section(
					new Woostify_Get_Pro_Section(
						$wp_customize,
						'woostify_get_pro_section',
						array(
							'pro_text'   => __( 'Pro Version Available', 'woostify' ),
							'pro_url'    => woostify_get_pro_url( 'https://woostify.com/pricing/' ),
							'capability' => 'edit_theme_options',
							'priority'   => 0,
							'type'       => 'woostify-pro-section',
						)
					)
				);

				// Add get pro control.
				$wp_customize->add_control(
					new Woostify_Get_Pro_Control(
						$wp_customize,
						'header_image_addon',
						array(
							'section'     => 'header_image',
							'type'        => 'addon',
							'label'       => __( 'Learn More', 'woostify' ),
							'description' => __( 'More options are available for this section in our pro version.', 'woostify' ),
							'url'         => woostify_get_pro_url( 'https://woostify.com/pricing/' ),
							'priority'    => 200,
							'settings'    => isset( $wp_customize->selective_refresh ) ? array() : 'blogname',
						)
					)
				);
			}

			// Register section & panel.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/register-sections.php';

			// Section, settings & control.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/title-tagline/title-tagline.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/buttons/button.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/footer/footer.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/header/header.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/color/color.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/body.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/primary-menu.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/heading.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/blog/blog.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/shop/shop-single.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/shop/woocommerce-shop-single.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/sidebar/sidebar.php';
		}

		/**
		 * Get site logo.
		 *
		 * @return string
		 */
		public function get_site_logo() {
			return woostify_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}
	}

endif;

return new Woostify_Customizer();
