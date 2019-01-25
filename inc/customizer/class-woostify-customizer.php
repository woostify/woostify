<?php
/**
 * Woostify Customizer Class
 *
 * @package  woostify
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
			add_action( 'customize_register', array( $this, 'woostify_customize_register' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'woostify_customize_controls_scripts' ) );
		}

		/**
		 * Add script for customize controls
		 */
		public function woostify_customize_controls_scripts() {
			wp_enqueue_script(
				'woostify-condition-control',
				WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/conditional/js/condition.js',
				array( 'jquery' ),
				woostify_version(),
				true
			);
		}

		/**
		 * Returns an array of the desired default Woostify Options
		 *
		 * @return array
		 */
		public static function woostify_get_woostify_default_setting_values() {
			return apply_filters(
				'woostify_setting_default_values',
				$args = array(
					// Site.
					'default_container'                    => 'normal',

					// Logo.
					'retina_logo'                          => '',
					'logo_mobile'                          => '',
					'logo_width'                           => '',
					'tablet_logo_width'                    => '',
					'mobile_logo_width'                    => '',

					// Color.
					'theme_color'                          => '#1346af',
					'primary_menu_color'                   => '#2b2b2b',
					'primary_sub_menu_color'               => '#2b2b2b',
					'heading_color'                        => '#2b2b2b',
					'text_color'                           => '#8f8f8f',
					'accent_color'                         => '#2b2b2b',

					// Topbar.
					'topbar_text_color'                    => '#ffffff',
					'topbar_background_color'              => '#292f34',
					'topbar_space'                         => 0,
					'topbar_left'                          => '',
					'topbar_center'                        => '',
					'topbar_right'                         => '',

					// Header.
					'header_layout'                        => 'layout-1',
					'header_background_color'              => '#ffffff',
					'header_primary_menu'                  => true,
					'header_search_icon'                   => true,
					'header_wishlist_icon'                 => false,
					'header_search_only_product'           => false,
					'header_account_icon'                  => false,
					'header_shop_cart_icon'                => false,

					// Footer.
					'scroll_to_top'                        => true,
					'footer_disable'                       => false,
					'footer_space'                         => 100,
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
					'blog_list_layout'                     => 'list',
					'blog_list_limit_exerpt'               => 20,
					'blog_list_feature_image'              => true,
					'blog_list_title'                      => true,
					'blog_single_author_box'               => false,
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
					'shop_page_title'                      => true,
					'shop_page_breadcrumb'                 => true,
					'shop_page_product_title'              => true,
					'shop_page_product_category'           => false,
					'shop_page_product_rating'             => true,
					'shop_page_product_add_to_cart_button' => true,
					'shop_page_product_price'              => true,

					// Product style.
					'product_style'                        => 'layout-1',

					// Shop single.
					'shop_single_content_background'       => '#f3f3f3',
					'shop_single_gallery_layout'           => 'vertical',
					'shop_single_breadcrumb'               => true,
					'shop_single_skus'                     => true,
					'shop_single_categories'               => true,
					'shop_single_tags'                     => true,

					// Sidebar.
					'sidebar_default'                      => is_rtl() ? 'left' : 'right',
					'sidebar_blog'                         => 'default',
					'sidebar_blog_single'                  => 'default',
					'sidebar_shop'                         => 'default',
					'sidebar_shop_single'                  => 'full',

					// 404.
					'error_404_text'                       => __( 'Opps! The page you’re looking for is missing for some reasons. Please come back to homepage', 'woostify' ),
					'error_404_image'                      => '',
				)
			);
		}

		/**
		 * Get all of the Woostify theme option.
		 *
		 * @return array $woostify_options The Woostify Theme Options.
		 */
		public function woostify_get_woostify_options() {
			$woostify_options = wp_parse_args(
				get_option( 'woostify_setting', array() ),
				self::woostify_get_woostify_default_setting_values()
			);

			return apply_filters( 'woostify_options', $woostify_options );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function woostify_customize_register( $wp_customize ) {

			// Custom default section, panel.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/override-defaults.php';

			// Add customizer custom controls.
			$customizer_controls = glob( WOOSTIFY_THEME_DIR . 'inc/customizer/custom-controls/**/*.php' );
			foreach ( $customizer_controls as $file ) {
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}

			// Register section & panel.
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/register-sections.php';

			// Add customizer sections.
			$customizer_sections = glob( WOOSTIFY_THEME_DIR . 'inc/customizer/sections/**/*.php' );
			foreach ( $customizer_sections as $file ) {
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}

			// Register Control Type.
			if ( method_exists( $wp_customize, 'register_control_type' ) ) {
				$wp_customize->register_control_type( 'Woostify_Typography_Control' );
				$wp_customize->register_control_type( 'Woostify_Range_Slider_Control' );
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
							'pro_text'   => __( 'Pro Version Is Coming Soon', 'woostify' ),
							'pro_url'    => woostify_get_pro_url(),
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
							'description' => __( 'More options are coming for this section in our pro version.', 'woostify' ),
							'url'         => woostify_get_pro_url(),
							'priority'    => 200,
							'settings'    => isset( $wp_customize->selective_refresh ) ? array() : 'blogname',
						)
					)
				);

				$wp_customize->add_control(
					new Woostify_Get_Pro_Control(
						$wp_customize,
						'woostify_product_style_addon',
						array(
							'section'     => 'woostify_product_style',
							'type'        => 'addon',
							'label'       => __( 'Learn More', 'woostify' ),
							'description' => __( 'More options are coming for this section in our pro version.', 'woostify' ),
							'url'         => woostify_get_pro_url(),
							'priority'    => 200,
							'settings'    => isset( $wp_customize->selective_refresh ) ? array() : 'blogname',
						)
					)
				);

				$wp_customize->add_control(
					new Woostify_Get_Pro_Control(
						$wp_customize,
						'woostify_shop_single_addon',
						array(
							'section'     => 'woostify_shop_single',
							'type'        => 'addon',
							'label'       => __( 'Learn More', 'woostify' ),
							'description' => __( 'More options are coming for this section in our pro version.', 'woostify' ),
							'url'         => woostify_get_pro_url(),
							'priority'    => 200,
							'settings'    => isset( $wp_customize->selective_refresh ) ? array() : 'blogname',
						)
					)
				);

				$wp_customize->add_control(
					new Woostify_Get_Pro_Control(
						$wp_customize,
						'woostify_footer_addon',
						array(
							'section'     => 'woostify_footer',
							'type'        => 'addon',
							'label'       => __( 'Learn More', 'woostify' ),
							'description' => __( 'More options are coming for this section in our pro version.', 'woostify' ),
							'url'         => woostify_get_pro_url(),
							'priority'    => 200,
							'settings'    => isset( $wp_customize->selective_refresh ) ? array() : 'blogname',
						)
					)
				);
			}
		}
	}

endif;

return new Woostify_Customizer();
