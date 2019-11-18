<?php
/**
 * Woostify WooCommerce Class
 *
 * @package  woostify
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woostify_WooCommerce' ) ) {
	/**
	 * The Woostify WooCommerce Integration class
	 */
	class Woostify_WooCommerce {
		/**
		 * Instance
		 *
		 * @var object instance
		 */
		public static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'wp', [ $this, 'woostify_woocommerce_wp_action' ] );
			add_action( 'init', [ $this, 'woostify_woocommerce_init_action' ] );
			add_action( 'after_setup_theme', [ $this, 'woostify_woocommerce_setup' ] );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_scripts' ], 200 );
			add_filter( 'body_class', [ $this, 'woocommerce_body_class' ] );

			// GENERAL.
			add_action( 'wp', 'woostify_breadcrumb_for_product_page' );
			add_action( 'init', 'woostify_detect_clear_cart_submit' );
			add_filter( 'loop_shop_columns', 'woostify_products_per_row' );
			add_filter( 'loop_shop_per_page', 'woostify_products_per_page' );
			add_action( 'elementor/preview/enqueue_scripts', 'woostify_elementor_preview_product_page_scripts' );
			add_filter( 'woocommerce_cross_sells_columns', 'woostify_change_cross_sells_columns' );
			add_filter( 'woocommerce_show_page_title', 'woostify_remove_woocommerce_shop_title' );
			add_filter( 'woocommerce_available_variation', 'woostify_available_variation_gallery', 90, 3 );
			add_action( 'woocommerce_before_shop_loop', 'woostify_toggle_sidebar_mobile_button', 25 );
			add_filter( 'woocommerce_output_related_products_args', 'woostify_related_products_args' );
			add_filter( 'woocommerce_pagination_args', 'woostify_change_woocommerce_arrow_pagination' );
			add_filter( 'woocommerce_sale_flash', 'woostify_change_sale_flash' );
			add_filter( 'woocommerce_add_to_cart_fragments', 'woostify_cart_sidebar_content_fragments' );
			add_filter( 'woocommerce_add_to_cart_fragments', 'woostify_cart_total_number_fragments' );
			add_filter( 'woocommerce_product_loop_start', 'woostify_woocommerce_loop_start' );
			add_action( 'woostify_product_loop_item_action_item', 'woostify_product_loop_item_add_to_cart_icon', 10 );
			add_action( 'woostify_product_loop_item_action_item', 'woostify_product_loop_item_wishlist_icon', 30 );
			// Ajax single add to cart.
			add_action( 'wp_ajax_single_add_to_cart', 'woostify_ajax_single_add_to_cart' );
			add_action( 'wp_ajax_nopriv_single_add_to_cart', 'woostify_ajax_single_add_to_cart' );

			// SHOP PAGE.
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_wrapper_open', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_image_wrapper_open', 20 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_product_loop_item_action', 25 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_link_open', 30 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_hover_image', 40 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_image', 50 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_link_close', 60 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_add_to_cart_on_image', 70 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_product_loop_item_wishlist_icon_bottom', 80 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_image_wrapper_close', 90 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_content_open', 100 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_rating', 2 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_meta_open', 5 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_price', 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_add_to_cart_button', 15 );

			add_action( 'woocommerce_shop_loop_item_title', 'woostify_add_template_loop_product_category', 5 );
			add_action( 'woocommerce_shop_loop_item_title', 'woostify_add_template_loop_product_title', 10 );

			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_meta_close', 20 );
			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_content_close', 50 );
			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_wrapper_close', 100 );

			// PRODUCT PAGE.
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_container_open', 10 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_open', 20 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_image_slide', 30 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_thumb_slide', 40 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_close', 50 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_dependency', 100 );

			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_container_close', 5 );
			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_after_summary_open', 8 );
			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_after_summary_close', 100 );

			add_action( 'woocommerce_after_add_to_cart_button', 'woostify_product_info', 20 );
			add_action( 'woocommerce_single_product_summary', 'woostify_trust_badge_image', 200 );
			add_action( 'template_redirect', 'woostify_product_recently_viewed', 20 );
			add_action( 'woocommerce_after_single_product', 'woostify_product_recently_viewed_template', 20 );

			// CART PAGE.
			add_action( 'woocommerce_after_cart_table', 'woostify_clear_shop_cart' );
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 */
		public function woostify_woocommerce_setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'woostify_woocommerce_args',
					[
						'product_grid' => [
							'default_columns' => 4,
							'default_rows'    => 3,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						],
					]
				)
			);
		}

		/**
		 * Woocommerce enqueue scripts and styles.
		 */
		public function woocommerce_scripts() {
			$options = woostify_options( false );

			// Main woocommerce js file.
			wp_enqueue_script( 'woostify-woocommerce' );

			// Product variations.
			wp_enqueue_script( 'woostify-product-variation' );

			// Quantity button.
			wp_enqueue_script( 'woostify-quantity-button' );

			// Tiny slider: product images.
			wp_enqueue_script( 'woostify-product-images' );

			// Easyzoom.
			wp_enqueue_script( 'easyzoom-handle' );

			// Photoswipe.
			wp_enqueue_script( 'photoswipe-init' );

			// Woocommerce sidebar.
			wp_enqueue_script( 'woostify-woocommerce-sidebar' );

			// Add to cart variation.
			if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) && ! wp_script_is( 'wc-add-to-cart-variation', 'enqueued' ) ) {
				wp_enqueue_script( 'wc-add-to-cart-variation' );
			}

			// Single add to cart script.
			if ( $options['shop_single_ajax_add_to_cart'] ) {
				wp_enqueue_script( 'woostify-single-add-to-cart' );
				wp_localize_script(
					'woostify-single-add-to-cart',
					'woostify_ajax_single_add_to_cart_data',
					[
						'ajax_url'     => admin_url( 'admin-ajax.php' ),
						'ajax_error'   => __( 'Sorry, something went wrong. Please try again!', 'woostify-pro' ),
						'ajax_nonce'   => wp_create_nonce( 'woostify_ajax_single_add_to_cart' ),
					]
				);
			}
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$options = woostify_options( false );

			// Product gallery.
			$page_id = woostify_get_page_id();
			$product = wc_get_product( $page_id );
			$gallery = $product ? $product->get_gallery_image_ids() : false;
			if ( $gallery || is_singular( 'elementor_library' ) ) {
				$classes[] = 'has-gallery-layout-' . $options['shop_single_gallery_layout'];
			}

			// Product meta.
			$sku        = $options['shop_single_skus'];
			$categories = $options['shop_single_categories'];
			$tags       = $options['shop_single_tags'];

			if ( ! $sku ) {
				$classes[] = 'hid-skus';
			}

			if ( ! $categories ) {
				$classes[] = 'hid-categories';
			}

			if ( ! $tags ) {
				$classes[] = 'hid-tags';
			}

			// Ajax single add to cart button.
			if ( $options['shop_single_ajax_add_to_cart'] ) {
				$classes[] = 'ajax-single-add-to-cart';
			}

			// Cart page.
			if ( is_cart() ) {
				$proceed_button = $options['cart_page_sticky_proceed_button'];
				if ( $proceed_button ) {
					$classes[] = 'has-proceed-sticky-button';
				}

				$classes[] = 'cart-page-' . $options['cart_page_layout'];
			}

			// Checkout page.
			$order_button = $options['checkout_sticky_place_order_button'];
			if ( is_checkout() && $order_button ) {
				$classes[] = 'has-order-sticky-button';
			}

			return array_filter( $classes );
		}

		/**
		 * WP action
		 */
		public function woostify_woocommerce_wp_action() {
			$options = woostify_options( false );

			// SHOP PAGE.
			// Result count.
			if ( ! $options['shop_page_result_count'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Product filter.
			if ( ! $options['shop_page_product_filter'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

			// SHOP SINGLE.
			// Stock label.
			if ( ! $options['shop_single_stock_label'] ) {
				add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
			}

			// Product tab additional information.
			if ( ! $options['shop_single_additional_information'] ) {
				add_filter( 'woocommerce_product_tabs', [ $this, 'woostify_remove_additional_information_tabs' ], 98 );
			}

			// Related product.
			if ( ! $options['shop_single_related_product'] ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}

			// Multi step checkout. Replace default Page header.
			if ( is_cart() || is_checkout() || ( is_checkout() && ! empty( is_wc_endpoint_url( 'order-received' ) ) ) ) {
				add_action( 'woostify_after_header', 'woostify_multi_step_checkout', 10 );
			}
		}

		/**
		 * Remove additional informaltion
		 */
		function woostify_remove_additional_information_tabs( $tabs ) {
			unset( $tabs['additional_information'] );
			return $tabs;
		}

		/**
		 * Init action
		 */
		public function woostify_woocommerce_init_action() {
			// Remove wc notice on checkout page, when login error.
			remove_action( 'woocommerce_before_checkout_form_cart_notices', 'woocommerce_output_all_notices', 10 );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

			add_action( 'woocommerce_before_main_content', 'woostify_before_content', 10 );
			add_action( 'woocommerce_after_main_content', 'woostify_after_content', 10 );
			add_action( 'woostify_content_top', 'woostify_shop_messages', 30 );

			add_action( 'woocommerce_before_shop_loop', 'woostify_sorting_wrapper', 9 );
			add_action( 'woocommerce_before_shop_loop', 'woostify_sorting_wrapper_close', 31 );

			// Woocommerce sidebar.
			add_action( 'woostify_theme_footer', 'woostify_woocommerce_cart_sidebar', 120 );

			// Legacy WooCommerce columns filter.
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
				add_action( 'woocommerce_before_shop_loop', 'woostify_product_columns_wrapper', 40 );
				add_action( 'woocommerce_after_shop_loop', 'woostify_product_columns_wrapper_close', 40 );
			}

			// SHOP SINGLE.
			// Sale flash.
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 25 );

			// Swap position price and rating star.
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}
	}
	Woostify_WooCommerce::get_instance();
}
