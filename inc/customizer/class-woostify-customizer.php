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
			add_action( 'customize_controls_print_styles', array( $this, 'woostify_customize_controls_styles' ) );
		}

		/**
		 * Add script for customize controls
		 */
		public function woostify_customize_controls_scripts() {
			wp_enqueue_script(
				'woostify-condition-control',
				WOOSTIFY_THEME_URI . 'inc/customizer/custom-controls/conditional/js/condition.js',
				array(),
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
				array(),
				woostify_version()
			);
		}

		/**
		 * Returns an array of the desired default Woostify Options
		 *
		 * @return array
		 */
		public static function woostify_get_woostify_default_setting_values() {
			$sticky_footer_bar_items = array(
				array(
					'type'      => 'custom',
					'icon'      => 'home',
					'name'      => 'Shop',
					'link'      => '#',
					'shortcode' => '',
					'hidden'    => false,
				),
				array(
					'type'      => 'wishlist',
					'icon'      => 'heart',
					'name'      => 'Wishlist',
					'link'      => '#',
					'hidden'    => false,
					'shortcode' => '',
				),
				array(
					'type'      => 'search',
					'icon'      => 'search',
					'name'      => 'Search',
					'link'      => '#',
					'hidden'    => false,
					'shortcode' => '',
				),
				array(
					'type'      => 'cart',
					'icon'      => 'shopping-cart-2',
					'name'      => 'Cart',
					'link'      => '#',
					'hidden'    => false,
					'shortcode' => '',
				),
				array(
					'type'      => 'shortcode',
					'icon'      => '',
					'name'      => 'Shortcode',
					'link'      => '#',
					'hidden'    => true,
					'shortcode' => '',
				),
			);
			$args                    = array(
				// CONTAINER.
				'container_width'                          => '1200',
				'default_container'                        => 'normal',
				'page_container'                           => 'default',
				'blog_single_container'                    => 'default',
				'archive_container'                        => 'default',
				'shop_container'                           => 'default',
				'shop_single_container'                    => 'default',
				// LOGO.
				'retina_logo'                              => '',
				'logo_mobile'                              => '',
				'logo_width'                               => '',
				'tablet_logo_width'                        => '',
				'mobile_logo_width'                        => '',
				// COLOR.
				'theme_color'                              => '#1346af',
				'primary_menu_color'                       => '#2b2b2b',
				'primary_sub_menu_color'                   => '#2b2b2b',
				'heading_color'                            => '#2b2b2b',
				'text_color'                               => '#8f8f8f',
				'accent_color'                             => '#2b2b2b',
				// TOPBAR.
				'topbar_display'                           => true,
				'topbar_text_color'                        => '#ffffff',
				'topbar_background_color'                  => '#292f34',
				'topbar_space'                             => 0,
				'topbar_left'                              => '',
				'topbar_center'                            => '',
				'topbar_right'                             => '',
				// HEADER.
				'header_layout'                            => 'layout-1',
				'header_background_color'                  => '#ffffff',
				'header_primary_menu'                      => true,
				'header_menu_breakpoint'                   => 992,
				'header_search_icon'                       => true,
				'header_wishlist_icon'                     => true,
				'header_search_only_product'               => true,
				'header_account_icon'                      => true,
				'header_shop_cart_icon'                    => true,
				'header_shop_cart_price'                   => false,
				'header_shop_hide_zero_value_cart_count'   => false,
				'header_shop_hide_zero_value_cart_subtotal' => false,
				// Header transparent.
				'header_transparent'                       => false,
				'header_transparent_enable_on'             => 'all-devices',
				'header_transparent_disable_archive'       => true,
				'header_transparent_disable_index'         => false,
				'header_transparent_disable_page'          => false,
				'header_transparent_disable_post'          => false,
				'header_transparent_disable_shop'          => false,
				'header_transparent_disable_product'       => false,
				'header_transparent_border_width'          => 0,
				'header_transparent_border_color'          => '#ffffff',
				'header_transparent_box_shadow'            => false,
				'header_transparent_shadow_type'           => 'outset',
				'header_transparent_shadow_x'              => 0,
				'header_transparent_shadow_y'              => 0,
				'header_transparent_shadow_blur'           => 0,
				'header_transparent_shadow_spread'         => 0,
				'header_transparent_shadow_color'          => '#000000',
				'header_transparent_logo'                  => '',
				'header_transparent_menu_color'            => '',
				'header_transparent_icon_color'            => '',
				'header_transparent_count_background'      => '',
				// PAGE HEADER.
				'page_header_display'                      => false,
				'page_header_title'                        => true,
				'page_header_breadcrumb'                   => true,
				'page_header_text_align'                   => 'justify',
				'page_header_title_color'                  => '#4c4c4c',
				'page_header_breadcrumb_text_color'        => '#606060',
				'page_header_background_color'             => '#f2f2f2',
				'page_header_background_image'             => '',
				'page_header_background_image_size'        => 'auto',
				'page_header_background_image_repeat'      => 'repeat',
				'page_header_background_image_position'    => 'center-center',
				'page_header_background_image_attachment'  => 'scroll',
				'page_header_padding_top'                  => 50,
				'page_header_padding_bottom'               => 50,
				'page_header_margin_bottom'                => 50,
				// FOOTER.
				'footer_display'                           => true,
				'footer_space'                             => 100,
				'footer_column'                            => 0,
				'footer_background_color'                  => '#eeeeec',
				'footer_heading_color'                     => '#2b2b2b',
				'footer_link_color'                        => '#8f8f8f',
				'footer_text_color'                        => '#8f8f8f',
				'footer_custom_text'                       => woostify_footer_custom_text(),
				// Sticky Footer Bar.
				'sticky_footer_bar_enable'                 => false,
				'sticky_footer_bar_items'                  => wp_json_encode( $sticky_footer_bar_items ),
				'sticky_footer_bar_enable_on'              => 'mobile',
				'sticky_footer_bar_hide_on_product_single' => true,
				'sticky_footer_bar_hide_on_cart_page'      => true,
				'sticky_footer_bar_hide_on_checkout_page'  => true,
				'sticky_footer_bar_text_font_size'         => 13,
				'tablet_sticky_footer_bar_text_font_size'  => 13,
				'mobile_sticky_footer_bar_text_font_size'  => 12,
				'sticky_footer_bar_icon_font_size'         => 20,
				'tablet_sticky_footer_bar_icon_font_size'  => 20,
				'mobile_sticky_footer_bar_icon_font_size'  => 18,
				'sticky_footer_bar_text_color'             => '#111',
				'sticky_footer_bar_text_hover_color'       => '#111',
				'sticky_footer_bar_icon_color'             => '#111',
				'sticky_footer_bar_icon_hover_color'       => '#111',
				'sticky_footer_bar_text_font_weight'       => 600,
				'sticky_footer_bar_background'             => '#fff',
				'sticky_footer_bar_hide_when_scroll'       => false,
				'sticky_footer_bar_icon_spacing'           => 5,
				'tablet_sticky_footer_bar_icon_spacing'    => 5,
				'mobile_sticky_footer_bar_icon_spacing'    => 5,
				'sticky_footer_bar_padding'                => '10 0 10 0',
				'tablet_sticky_footer_bar_padding'         => '10 0 10 0',
				'mobile_sticky_footer_bar_padding'         => '10 0 10 0',
				// Scroll To Top.
				'scroll_to_top'                            => true,
				'scroll_to_top_background'                 => '',
				'scroll_to_top_color'                      => '',
				'scroll_to_top_border_radius'              => 0,
				'scroll_to_top_position'                   => 'right',
				'scroll_to_top_offset_bottom'              => 20,
				'scroll_to_top_on'                         => 'default',
				'scroll_to_top_icon_size'                  => 17,
				// BUTTONS.
				'button_text_color'                        => '#ffffff',
				'button_background_color'                  => '#1346af',
				'button_hover_text_color'                  => '#ffffff',
				'button_hover_background_color'            => '#3a3a3a',
				'buttons_border_radius'                    => 50,
				// BLOG.
				'blog_list_layout'                         => 'list',
				'blog_list_limit_exerpt'                   => 20,
				'blog_list_structure'                      => array( 'image', 'title-meta', 'post-meta' ),
				'blog_list_post_meta'                      => array( 'date', 'author', 'comments' ),
				// BLOG SINGLE.
				'blog_single_structure'                    => array( 'image', 'title-meta', 'post-meta' ),
				'blog_single_post_meta'                    => array( 'date', 'author', 'category', 'comments' ),
				'blog_single_author_box'                   => false,
				'blog_single_related_post'                 => true,
				// SHOP.
				'shop_page_product_alignment'              => 'center',
				'shop_page_title'                          => true,
				'shop_page_breadcrumb'                     => true,
				'shop_page_result_count'                   => true,
				'shop_page_product_filter'                 => true,
				// Infinite scroll
				'shop_page_infinite_scroll_enable'         => false,
				'shop_page_infinite_scroll_type'           => 'button',
				// Product catalog.
				'products_per_row'                         => 3,
				'tablet_products_per_row'                  => 2,
				'mobile_products_per_row'                  => 1,
				'products_per_page'                        => 12,
				// Product card.
				'shop_page_product_card_border_style'      => 'none',
				'shop_page_product_card_border_width'      => 1,
				'shop_page_product_card_border_color'      => '#cccccc',
				// Product content.
				'shop_page_product_content_equal'          => false,
				'shop_page_product_content_min_height'     => 160,
				'shop_page_product_title'                  => true,
				'shop_page_product_category'               => false,
				'shop_page_product_rating'                 => true,
				'shop_page_product_price'                  => true,
				// Product image.
				'shop_page_product_image_hover'            => 'swap',
				'shop_page_product_image_border_style'     => 'none',
				'shop_page_product_image_border_width'     => 1,
				'shop_page_product_image_border_color'     => '#cccccc',
				'shop_page_product_image_equal_height'     => false,
				'shop_page_product_image_height'           => 300,
				// Add to cart button.
				'shop_page_add_to_cart_button_position'    => 'bottom',
				'shop_product_add_to_cart_icon'            => true,
				'shop_page_button_cart_background'         => '',
				'shop_page_button_cart_color'              => '',
				'shop_page_button_background_hover'        => '',
				'shop_page_button_color_hover'             => '',
				'shop_page_button_border_radius'           => '',
				// Wishlist.
				'shop_page_wishlist_support_plugin'        => 'ti',
				'shop_page_wishlist_position'              => 'top-right',
				// Sale tag.
				'shop_page_sale_tag_position'              => 'left',
				'shop_page_sale_percent'                   => true,
				'shop_page_sale_text'                      => __( 'Sale!', 'woostify' ),
				'shop_page_sale_border_radius'             => 0,
				'shop_page_sale_square'                    => false,
				'shop_page_sale_size'                      => 40,
				'shop_page_sale_color'                     => '#ffffff',
				'shop_page_sale_bg_color'                  => '#1346af',
				// Out of stock label.
				'shop_page_out_of_stock_position'          => 'left',
				'shop_page_out_of_stock_text'              => __( 'Out Of Stock', 'woostify' ),
				'shop_page_out_of_stock_border_radius'     => 0,
				'shop_page_out_of_stock_square'            => false,
				'shop_page_out_of_stock_size'              => 40,
				'shop_page_out_of_stock_color'             => '#ffffff',
				'shop_page_out_of_stock_bg_color'          => '#818486',
				// SHOP SINGLE.
				'shop_single_breadcrumb'                   => true,
				'shop_single_product_navigation'           => true,
				'shop_single_ajax_add_to_cart'             => true,
				'shop_single_stock_label'                  => true,
				'shop_single_stock_product_limit'          => 0,
				'shop_single_loading_bar'                  => true,
				'shop_single_additional_information'       => true,
				'shop_single_content_background'           => '#f3f3f3',
				'shop_single_trust_badge_image'            => '',
				'shop_single_product_gallery_layout_select' => 'theme',
				'shop_single_gallery_layout'               => 'vertical',
				'shop_single_image_load'                   => true,
				'shop_single_image_zoom'                   => true,
				'shop_single_image_lightbox'               => true,
				'shop_single_product_sticky_top_space'     => 50,
				'shop_single_product_sticky_bottom_space'  => 50,
				// Meta.
				'shop_single_skus'                         => true,
				'shop_single_categories'                   => true,
				'shop_single_tags'                         => true,
				// Related.
				'shop_single_related_product'              => true,
				'shop_single_product_related_total'        => 4,
				'shop_single_product_related_columns'      => 4,
				// Recently view.
				'shop_single_product_recently_viewed'      => false,
				'shop_single_recently_viewed_title'        => __( 'Recently Viewed Products', 'woostify' ),
				'shop_single_recently_viewed_count'        => 4,
				// Single Product Add To Cart.
				'shop_single_button_cart_background'       => '',
				'shop_single_button_cart_color'            => '',
				'shop_single_button_background_hover'      => '',
				'shop_single_button_color_hover'           => '',
				'shop_single_button_border_radius'         => '',
				// CART PAGE.
				'cart_page_layout'                         => 'layout-2',
				'cart_page_sticky_proceed_button'          => true,
				// CHECKOUT PAGE.
				'checkout_distraction_free'                => false,
				'checkout_multi_step'                      => false,
				'checkout_sticky_place_order_button'       => true,
				// SIDEBAR.
				'sidebar_default'                          => is_rtl() ? 'left' : 'right',
				'sidebar_page'                             => 'full',
				'sidebar_blog'                             => 'default',
				'sidebar_blog_single'                      => 'default',
				'sidebar_shop'                             => 'default',
				'sidebar_shop_single'                      => 'full',
				'sidebar_width'                            => 20,
				// 404.
				'error_404_image'                          => '',
				'error_404_text'                           => __( 'Opps! The page you are looking for is missing for some reasons. Please come back to homepage', 'woostify' ),
			);

			return apply_filters( 'woostify_setting_default_values', $args );
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

			// Get Pro Extensions area.
			if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) {
				// Add get Pro Extensions section.
				$wp_customize->add_section(
					new Woostify_Get_Pro_Section(
						$wp_customize,
						'woostify_get_pro_section',
						array(
							'pro_text'   => __( 'Get Woostify  Pro Extensions!', 'woostify' ),
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
							'description' => __( 'More options are coming for this section in our Pro Extensions.', 'woostify' ),
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
							'description' => __( 'More options are coming for this section in our Pro Extensions.', 'woostify' ),
							'url'         => woostify_get_pro_url(),
							'priority'    => 200,
							'settings'    => isset( $wp_customize->selective_refresh ) ? array() : 'blogname',
						)
					)
				);

				$wp_customize->add_control(
					new Woostify_Get_Pro_Control(
						$wp_customize,
						'woostify_shop_addon',
						array(
							'section'     => 'woostify_shop_page',
							'type'        => 'addon',
							'label'       => __( 'Learn More', 'woostify' ),
							'description' => __( 'More options are coming for this section in our Pro Extensions.', 'woostify' ),
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
							'description' => __( 'More options are coming for this section in our Pro Extensions.', 'woostify' ),
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
							'description' => __( 'More options are coming for this section in our Pro Extensions.', 'woostify' ),
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
