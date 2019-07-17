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
			add_action( 'customize_register', [ $this, 'woostify_customize_register' ] );
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'woostify_customize_controls_scripts' ] );
			add_action( 'customize_controls_print_styles', [ $this, 'woostify_customize_controls_styles' ] );
		}

		/**
		 * Add script for customize controls
		 */
		public function woostify_customize_controls_scripts() {
			wp_enqueue_script(
				'woostify-condition-control',
				WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/conditional/js/condition.js',
				[],
				woostify_version(),
				true
			);
		}

		/**
		 * Add style for customize controls
		 */
		public function woostify_customize_controls_styles() {
			wp_enqueue_style(
				'woostify-condition-control',
				WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/conditional/css/condition.css',
				[],
				woostify_version()
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
				$args = [
					// CONTAINER.
					'default_container'                       => 'normal',
					// LOGO.
					'retina_logo'                             => '',
					'logo_mobile'                             => '',
					'logo_width'                              => '',
					'tablet_logo_width'                       => '',
					'mobile_logo_width'                       => '',
					// COLOR.
					'theme_color'                             => '#1346af',
					'primary_menu_color'                      => '#2b2b2b',
					'primary_sub_menu_color'                  => '#2b2b2b',
					'heading_color'                           => '#2b2b2b',
					'text_color'                              => '#8f8f8f',
					'accent_color'                            => '#2b2b2b',
					// TOPBAR.
					'topbar_text_color'                       => '#ffffff',
					'topbar_background_color'                 => '#292f34',
					'topbar_space'                            => 0,
					'topbar_left'                             => '',
					'topbar_center'                           => '',
					'topbar_right'                            => '',
					// HEADER.
					'header_layout'                           => 'layout-1',
					'header_background_color'                 => '#ffffff',
					'header_primary_menu'                     => true,
					'header_search_icon'                      => true,
					'header_wishlist_icon'                    => false,
					'header_search_only_product'              => true,
					'header_account_icon'                     => false,
					'header_shop_cart_icon'                   => false,
					// Header transparent.
					'header_transparent'                      => false,
					'header_transparent_enable_on'            => 'all-devices',
					'header_transparent_disable_archive'      => true,
					'header_transparent_disable_index'        => false,
					'header_transparent_disable_page'         => false,
					'header_transparent_disable_post'         => false,
					'header_transparent_disable_shop'         => false,
					'header_transparent_disable_product'      => false,
					'header_transparent_border_width'         => 0,
					'header_transparent_border_color'         => '#ffffff',
					'header_transparent_box_shadow'           => false,
					'header_transparent_shadow_type'          => 'outset',
					'header_transparent_shadow_x'             => 0,
					'header_transparent_shadow_y'             => 0,
					'header_transparent_shadow_blur'          => 0,
					'header_transparent_shadow_spread'        => 0,
					'header_transparent_shadow_color'         => '#000000',
					// PAGE HEADER.
					'page_header_display'                     => false,
					'page_header_title'                       => true,
					'page_header_breadcrumb'                  => true,
					'page_header_text_align'                  => 'justify',
					'page_header_title_color'                 => '#4c4c4c',
					'page_header_breadcrumb_text_color'       => '#606060',
					'page_header_background_color'            => '#f2f2f2',
					'page_header_background_image'            => '',
					'page_header_background_image_size'       => 'auto',
					'page_header_background_image_repeat'     => 'repeat',
					'page_header_background_image_position'   => 'center-center',
					'page_header_background_image_attachment' => 'scroll',
					'page_header_padding_top'                 => 50,
					'page_header_padding_bottom'              => 50,
					'page_header_margin_bottom'               => 50,
					// FOOTER.
					'scroll_to_top'                           => true,
					'footer_display'                          => true,
					'footer_space'                            => 100,
					'footer_column'                           => 0,
					'footer_background_color'                 => '#eeeeec',
					'footer_heading_color'                    => '#2b2b2b',
					'footer_link_color'                       => '#8f8f8f',
					'footer_text_color'                       => '#8f8f8f',
					'footer_custom_text'                      => woostify_footer_custom_text(),
					// BUTTONS.
					'button_text_color'                       => '#ffffff',
					'button_background_color'                 => '#1346af',
					'button_hover_text_color'                 => '#ffffff',
					'button_hover_background_color'           => '#3a3a3a',
					'buttons_border_radius'                   => 50,
					// BLOG.
					'blog_list_layout'                        => 'list',
					'blog_list_limit_exerpt'                  => 20,
					'blog_list_structure'                     => [ 'image', 'title-meta', 'post-meta' ],
					'blog_list_post_meta'                     => [ 'date', 'author', 'comments' ],
					// BLOG SINGLE.
					'blog_single_structure'                   => [ 'image', 'title-meta', 'post-meta' ],
					'blog_single_post_meta'                   => [ 'date', 'author', 'category', 'comments' ],
					'blog_single_author_box'                  => false,
					'blog_single_related_post'                => true,
					// SHOP.
					'shop_page_product_alignment'             => 'center',
					'shop_page_title'                         => true,
					'shop_page_breadcrumb'                    => true,
					'shop_page_result_count'                  => true,
					'shop_page_product_filter'                => true,
					// Product card.
					'shop_page_product_card_border_style'     => 'none',
					'shop_page_product_card_border_width'     => 1,
					'shop_page_product_card_border_color'     => '#cccccc',
					// Product content.
					'shop_page_product_title'                 => true,
					'shop_page_product_category'              => false,
					'shop_page_product_rating'                => true,
					'shop_page_product_price'                 => true,
					// Product image.
					'shop_page_product_image_hover'           => 'swap',
					'shop_page_product_image_border_style'    => 'none',
					'shop_page_product_image_border_width'    => 1,
					'shop_page_product_image_border_color'    => '#cccccc',
					'shop_page_product_image_equal_height'    => false,
					'shop_page_product_image_height'          => 300,
					// Sale tag.
					'shop_page_sale_tag_position'             => 'left',
					'shop_page_sale_percent'                  => true,
					'shop_page_sale_text'                     => __( 'Sale!', 'woostify' ),
					'shop_page_sale_border_radius'            => 0,
					'shop_page_sale_square'                   => false,
					'shop_page_sale_size'                     => 40,
					'shop_page_sale_color'                    => '#ffffff',
					// Products per page.
					'products_per_row'                        => 3,
					'tablet_products_per_row'                 => 2,
					'mobile_products_per_row'                 => 1,
					'products_per_page'                       => 12,
					// Add to cart button.
					'shop_page_add_to_cart'                   => true,
					'shop_product_add_to_cart_icon'           => true,
					'shop_page_add_to_cart_button_position'   => 'bottom',
					// SHOP SINGLE.
					'shop_single_content_background'          => '#f3f3f3',
					'shop_single_gallery_layout'              => 'vertical',
					'shop_single_image_zoom'                  => true,
					'shop_single_image_lightbox'              => true,
					'shop_single_breadcrumb'                  => true,
					'shop_single_skus'                        => true,
					'shop_single_categories'                  => true,
					'shop_single_tags'                        => true,
					// SIDEBAR.
					'sidebar_default'                         => is_rtl() ? 'left' : 'right',
					'sidebar_page'                            => 'full',
					'sidebar_blog'                            => 'default',
					'sidebar_blog_single'                     => 'default',
					'sidebar_shop'                            => 'default',
					'sidebar_shop_single'                     => 'full',
					// 404.
					'error_404_image'                         => '',
					'error_404_text'                          => __( 'Opps! The page you’re looking for is missing for some reasons. Please come back to homepage', 'woostify' ),
				]
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

			// Register Control Type - Register for controls has content_template function.
			if ( method_exists( $wp_customize, 'register_control_type' ) ) {
				$wp_customize->register_control_type( 'Woostify_Section_Control' );
				$wp_customize->register_control_type( 'Woostify_Color_Control' );
				$wp_customize->register_control_type( 'Woostify_Typography_Control' );
				$wp_customize->register_control_type( 'Woostify_Range_Slider_Control' );
				$wp_customize->register_control_type( 'Woostify_Sortable_Control' );
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
							'pro_text'   => __( 'Get The Woostify Pro Version!', 'woostify' ),
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
