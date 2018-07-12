<?php
/**
 * Woostify WooCommerce Customizer Class
 *
 * @package  woostify
 * @since    2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woostify_WooCommerce_Customizer' ) ) :

	/**
	 * The Woostify Customizer class
	 */
	class Woostify_WooCommerce_Customizer extends Woostify_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 2.4.0
		 * @return void
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
		}

		/**
		 * Returns an array of the desired default Woostify Options
		 *
		 * @since 2.4.0
		 * @return array
		 */
		public static function get_woostify_default_setting_values() {
			return apply_filters(
				'woostify_woocommerce_setting_default_values', $args = array(
					'woostify_sticky_add_to_cart' => true,
					'woostify_product_pagination' => true,
				)
			);
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 2.4.0
		 */
		public function customize_register( $wp_customize ) {

			/**
			 * Product Page
			 */
			$wp_customize->add_section(
				'woostify_single_product_page', array(
					'title'                 => __( 'Product Page', 'Woostify'),
					'priority'              => 60,
				)
			);

			$wp_customize->add_setting(
				'woostify_product_pagination', array(
					'default'               => apply_filters( 'woostify_default_product_pagination', true ),
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_setting(
				'woostify_sticky_add_to_cart', array(
					'default'               => apply_filters( 'woostify_default_sticky_add_to_cart', true ),
					'sanitize_callback'     => 'wp_validate_boolean',
				)
			);

			$wp_customize->add_control(
				'woostify_sticky_add_to_cart', array(
					'type'                  => 'checkbox',
					'section'               => 'woostify_single_product_page',
					'label'                 => __( 'Sticky Add-To-Cart', 'Woostify'),
					'description'           => __( 'A small content bar at the top of the browser window which includes relevant product information and an add-to-cart button. It slides into view once the standard add-to-cart button has scrolled out of view.', 'Woostify'),
					'priority'              => 10,
				)
			);

			$wp_customize->add_control(
				'woostify_product_pagination', array(
					'type'                  => 'checkbox',
					'section'               => 'woostify_single_product_page',
					'label'                 => __( 'Product Pagination', 'Woostify'),
					'description'           => __( 'Displays next and previous links on product pages. A product thumbnail is displayed with the title revealed on hover.', 'Woostify'),
					'priority'              => 20,
				)
			);
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_woostify_theme_mods()
		 * @since 2.4.0
		 * @return string $styles the css
		 */
		public function get_css() {
			$woostify_theme_mods = $this->get_woostify_theme_mods();
			$brighten_factor       = apply_filters( 'woostify_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'woostify_darken_factor', -25 );

			$styles    = '
			a.cart-contents,
			.site-header-cart .widget_shopping_cart a {
				color: ' . $woostify_theme_mods['header_link_color'] . ';
			}

			a.cart-contents:hover,
			.site-header-cart .widget_shopping_cart a:hover,
			.site-header-cart:hover > li > a {
				color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_link_color'], 65 ) . ';
			}

			table.cart td.product-remove,
			table.cart td.actions {
				border-top-color: ' . $woostify_theme_mods['background_color'] . ';
			}

			.woostify-handheld-footer-bar ul li.cart .count {
				background-color: ' . $woostify_theme_mods['header_link_color'] . ';
				color: ' . $woostify_theme_mods['header_background_color'] . ';
				border-color: ' . $woostify_theme_mods['header_background_color'] . ';
			}

			.woocommerce-tabs ul.tabs li.active a,
			ul.products li.product .price,
			.onsale,
			.widget_search form:before,
			.widget_product_search form:before {
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			.woocommerce-breadcrumb a,
			a.woocommerce-review-link,
			.product_meta a {
				color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['text_color'], 5 ) . ';
			}

			.onsale {
				border-color: ' . $woostify_theme_mods['text_color'] . ';
			}

			.star-rating span:before,
			.quantity .plus, .quantity .minus,
			p.stars a:hover:after,
			p.stars a:after,
			.star-rating span:before,
			#payment .payment_methods li input[type=radio]:first-child:checked+label:before {
				color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			.widget_price_filter .ui-slider .ui-slider-range,
			.widget_price_filter .ui-slider .ui-slider-handle {
				background-color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			.order_details {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -7 ) . ';
			}

			.order_details > li {
				border-bottom: 1px dotted ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -28 ) . ';
			}

			.order_details:before,
			.order_details:after {
				background: -webkit-linear-gradient(transparent 0,transparent 0),-webkit-linear-gradient(135deg,' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%),-webkit-linear-gradient(45deg,' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%)
			}

			#order_review {
				background-color: ' . $woostify_theme_mods['background_color'] . ';
			}

			#payment .payment_methods > li .payment_box,
			#payment .place-order {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -5 ) . ';
			}

			#payment .payment_methods > li:not(.woocommerce-notice) {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -10 ) . ';
			}

			#payment .payment_methods > li:not(.woocommerce-notice):hover {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -15 ) . ';
			}

			.woocommerce-pagination .page-numbers li .page-numbers.current {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], $darken_factor ) . ';
				color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['text_color'], -10 ) . ';
			}

			.onsale,
			.woocommerce-pagination .page-numbers li .page-numbers:not(.current) {
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			p.stars a:before,
			p.stars a:hover~a:before,
			p.stars.selected a.active~a:before {
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			p.stars.selected a.active:before,
			p.stars:hover a:before,
			p.stars.selected a:not(.active):before,
			p.stars.selected a.active:before {
				color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger {
				background-color: ' . $woostify_theme_mods['button_background_color'] . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger:hover {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			.button.added_to_cart:focus,
			.button.wc-forward:focus {
				outline-color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			.added_to_cart, .site-header-cart .widget_shopping_cart a.button {
				background-color: ' . $woostify_theme_mods['button_background_color'] . ';
				border-color: ' . $woostify_theme_mods['button_background_color'] . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			.added_to_cart:hover, .site-header-cart .widget_shopping_cart a.button:hover {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			.added_to_cart.alt, .added_to_cart, .widget a.button.checkout {
				background-color: ' . $woostify_theme_mods['button_alt_background_color'] . ';
				border-color: ' . $woostify_theme_mods['button_alt_background_color'] . ';
				color: ' . $woostify_theme_mods['button_alt_text_color'] . ';
			}

			.added_to_cart.alt:hover, .added_to_cart:hover, .widget a.button.checkout:hover {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				border-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				color: ' . $woostify_theme_mods['button_alt_text_color'] . ';
			}

			.button.loading {
				color: ' . $woostify_theme_mods['button_background_color'] . ';
			}

			.button.loading:hover {
				background-color: ' . $woostify_theme_mods['button_background_color'] . ';
			}

			.button.loading:after {
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.site-header-cart .widget_shopping_cart,
				.site-header .product_list_widget li .quantity {
					color: ' . $woostify_theme_mods['header_text_color'] . ';
				}

				.site-header-cart .widget_shopping_cart .buttons,
				.site-header-cart .widget_shopping_cart .total {
					background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_background_color'], -10 ) . ';
				}

				.site-header-cart .widget_shopping_cart {
					background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_background_color'], -15 ) . ';
				}
			}';

			if ( ! class_exists( 'Woostify_Product_Pagination' ) ) {
				$styles .= '
				.woostify-product-pagination a {
					color: ' . $woostify_theme_mods['text_color'] . ';
					background-color: ' . $woostify_theme_mods['background_color'] . ';
				}';
			}

			if ( ! class_exists( 'Woostify_Sticky_Add_to_Cart' ) ) {
				$styles .= '
				.woostify-sticky-add-to-cart {
					color: ' . $woostify_theme_mods['text_color'] . ';
					background-color: ' . $woostify_theme_mods['background_color'] . ';
				}

				.woostify-sticky-add-to-cart a:not(.button) {
					color: ' . $woostify_theme_mods['header_link_color'] . ';
				}';
			}

			return apply_filters( 'woostify_woocommerce_customizer_css', $styles );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 2.4.0
		 * @return void
		 */
		public function add_customizer_css() {
			wp_add_inline_style( 'woostify-woocommerce-style', $this->get_css() );
		}

	}

endif;

return new Woostify_WooCommerce_Customizer();
