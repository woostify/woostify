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
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_scripts' ) );
		}

		/**
		 * Add script for customize controls
		 */
		public function customize_controls_scripts() {
			global $woostify_version;

			wp_enqueue_script(
				'woostify-conditio-control',
				WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/conditional/js/condition.js',
				array( 'jquery' ),
				$woostify_version,
				true
			);
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
					// Site.
					'default_container'                    => 'normal',

					// Logo.
					'retina_logo'                          => '',
					'logo_mobile'                          => '',
					'logo_width'                           => '',

					// Color.
					'theme_color'                          => '#1346af',
					'primary_menu_color'                   => '#2b2b2b',
					'primary_sub_menu_color'               => '#2b2b2b',
					'heading_color'                        => '#2b2b2b',
					'text_color'                           => '#8f8f8f',
					'accent_color'                         => '#2b2b2b',

					// Header.
					'header_layout'                        => 'layout-1',
					'header_background_color'              => '#ffffff',
					'header_search_form'                   => false,
					'header_search_only_product'           => false,
					'header_account_icon'                  => true,
					'header_shop_cart_icon'                => true,

					// Footer.
					'footer_column'                        => 0,
					'footer_background_color'              => '#eeeeec',
					'footer_heading_color'                 => '#2b2b2b',
					'footer_link_color'                    => '#8f8f8f',
					'footer_text_color'                    => '#8f8f8f',
					'footer_custom_text'                   => woostify_footer_custom_text(),

					// Button.
					'button_text_color'                    => '#ffffff',
					'button_background_color'              => '#1346af',
					'button_hover_text_color'              => '#ffffff',
					'button_hover_background_color'        => '#3a3a3a',

					// Blog.
					'blog_list_feature_image'              => true,
					'blog_list_title'                      => true,
					'blog_list_publish_date'               => true,
					'blog_list_author'                     => true,
					'blog_list_category'                   => false,
					'blog_list_comment'                    => true,

					// Blog single.
					'blog_single_feature_image'            => true,
					'blog_single_title'                    => true,
					'blog_single_publish_date'             => true,
					'blog_single_author'                   => true,
					'blog_single_category'                 => false,
					'blog_single_comment'                  => true,
					'blog_single_related_post'             => true,

					// Shop.
					'shop_columns'                         => 3,
					'shop_product_per_page'                => 9,
					'shop_page_product_title'              => true,
					'shop_page_product_category'           => false,
					'shop_page_product_rating'             => true,
					'shop_page_product_add_to_cart_button' => true,
					'shop_page_product_price'              => true,

					// Shop single.
					'single_add_to_cart_ajax'              => true,
					'single_content_background'            => '#f3f3f3',

					// Sidebar.
					'sidebar_default'                      => is_rtl() ? 'left' : 'right',
					'sidebar_blog'                         => 'default',
					'sidebar_blog_single'                  => 'default',
					'sidebar_shop'                         => 'default',
					'sidebar_shop_single'                  => 'full',
				)
			);
		}

		/**
		 * Get all of the Woostify theme option.
		 *
		 * @return array $woostify_options The Woostify Theme Options.
		 */
		public function get_woostify_options() {
			$woostify_options = wp_parse_args(
				get_option( 'woostify_setting', array() ),
				self::get_woostify_default_setting_values()
			);

			return apply_filters( 'woostify_options', $woostify_options );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
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
						'woostify_header_addon',
						array(
							'section'     => 'woostify_header',
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
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/wordpress/title-tagline.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/wordpress/background-image.php';

			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/header/header.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/sidebar/sidebar.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/footer/footer.php';

			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/color/color.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/buttons/button.php';

			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/body.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/primary-menu.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/typography/heading.php';

			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/blog/blog.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/blog/blog-single.php';

			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/shop/shop-page.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/shop/shop-single.php';
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
