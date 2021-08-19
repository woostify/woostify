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
			add_action( 'wp', array( $this, 'woostify_woocommerce_wp_action' ) );
			add_action( 'init', array( $this, 'woostify_woocommerce_init_action' ) );
			add_action( 'after_setup_theme', array( $this, 'woostify_woocommerce_setup' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 200 );
			add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );

			// GENERAL.
			add_action( 'wp', 'woostify_breadcrumb_for_product_page' );
			add_action( 'init', 'woostify_detect_clear_cart_submit' );
			add_filter( 'loop_shop_columns', 'woostify_products_per_row' );
			add_filter( 'loop_shop_per_page', 'woostify_products_per_page' );
			add_action( 'elementor/preview/enqueue_scripts', 'woostify_elementor_preview_product_page_scripts' );
			add_filter( 'woocommerce_cross_sells_total', 'woostify_change_cross_sells_total' );
			add_filter( 'woocommerce_cross_sells_columns', 'woostify_change_cross_sells_columns' );
			add_filter( 'woocommerce_show_page_title', 'woostify_remove_woocommerce_shop_title' );
			add_filter( 'woocommerce_available_variation', 'woostify_available_variation_gallery', 90, 3 );

			add_action( 'woocommerce_before_shop_loop', 'woostify_woocommerce_toolbar_left_open_div', 15 );
			add_action( 'woocommerce_before_shop_loop', 'woostify_toggle_sidebar_mobile_button', 15 );
			add_action( 'woocommerce_before_shop_loop', 'woostify_woocommerce_toolbar_left_close_div', 25 );

			add_filter( 'woocommerce_output_related_products_args', 'woostify_related_products_args' );
			add_filter( 'woocommerce_pagination_args', 'woostify_change_woocommerce_arrow_pagination' );
			add_filter( 'woocommerce_add_to_cart_fragments', 'woostify_content_fragments' );
			add_filter( 'woocommerce_update_order_review_fragments', 'woostify_update_order_review_fragments' );
			add_filter( 'woocommerce_product_loop_start', 'woostify_woocommerce_loop_start' );
			add_action( 'woostify_product_loop_item_action_item', 'woostify_product_loop_item_add_to_cart_icon', 10 );
			add_action( 'woostify_product_loop_item_action_item', 'woostify_product_loop_item_wishlist_icon', 30 );
			// Update product quantity in minicart.
			add_action( 'wp_ajax_update_quantity_in_mini_cart', 'woostify_ajax_update_quantity_in_mini_cart' );
			add_action( 'wp_ajax_nopriv_update_quantity_in_mini_cart', 'woostify_ajax_update_quantity_in_mini_cart' );
			// Modified woocommerce breadcrumb.
			add_filter( 'woocommerce_breadcrumb_defaults', 'woostify_modifided_woocommerce_breadcrumb' );

			// MY ACCOUNT PAGE.
			add_filter( 'woocommerce_my_account_edit_address_title', '__return_empty_string' );

			// TERM METABOX.
			// For product category.
			add_action( 'product_cat_add_form_fields', array( $this, 'woostify_add_term_meta_field' ) );
			add_action( 'product_cat_edit_form_fields', array( $this, 'woostify_edit_term_meta_field' ) );
			add_action( 'created_product_cat', array( $this, 'woostify_save_term_meta_field' ) );
			add_action( 'edited_product_cat', array( $this, 'woostify_save_term_meta_field' ) );

			// Woocommerce taxonomy.
			add_action( 'product_cat_add_form_fields', array( $this, 'woostify_add_field_taxonomy' ) );
			add_action( 'product_cat_edit_form_fields', array( $this, 'woostify_edit_field_taxonomy' ) );
			add_action( 'created_product_cat', array( $this, 'woostify_save_term_field' ) );
			add_action( 'edited_product_cat', array( $this, 'woostify_save_term_field' ) );

			// For product tag.
			add_action( 'product_tag_add_form_fields', array( $this, 'woostify_add_term_meta_field' ) );
			add_action( 'product_tag_edit_form_fields', array( $this, 'woostify_edit_term_meta_field' ) );
			add_action( 'created_product_tag', array( $this, 'woostify_save_term_meta_field' ) );
			add_action( 'edited_product_tag', array( $this, 'woostify_save_term_meta_field' ) );

			// SHOP PAGE.
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_wrapper_open', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_print_out_of_stock_label', 15 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_image_wrapper_open', 20 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_change_sale_flash', 23 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_product_loop_item_action', 25 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_link_open', 30 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_hover_image', 40 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_image', 50 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_link_close', 60 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_add_to_cart_on_image', 70 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_product_loop_item_wishlist_icon_bottom', 80 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_image_wrapper_close', 90 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woostify_loop_product_content_open', 100 );

			add_action( 'woocommerce_shop_loop_item_title', 'woostify_add_template_loop_product_category', 5 );
			add_action( 'woocommerce_shop_loop_item_title', 'woostify_add_template_loop_product_title', 10 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_rating', 2 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_meta_open', 5 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woostify_loop_product_price', 10 );

			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_add_to_cart_button', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_meta_close', 20 );
			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_content_close', 50 );
			add_action( 'woocommerce_after_shop_loop_item', 'woostify_loop_product_wrapper_close', 100 );

			$options = woostify_options( false );
			$gallery = $options['shop_single_product_gallery_layout_select'];

			// PRODUCT PAGE.
			// Product images box.
			if ( 'theme' === $gallery ) {
				add_action( 'woostify_product_images_box_end', 'woostify_change_sale_flash', 10 );
				add_action( 'woostify_product_images_box_end', 'woostify_print_out_of_stock_label', 20 );
				add_action( 'woostify_product_images_box_end', 'woostify_product_video_button_play', 30 );
			}

			// Infinite Scroll.
			$options = woostify_options( false );
			if ( $options['shop_page_infinite_scroll_enable'] ) {
				add_action( 'woocommerce_after_shop_loop', array( $this, 'add_infinite_scroll_button' ) );
			}

			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_container_open', 10 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_open', 20 );

			if ( 'theme' === $gallery ) {
				add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_image_slide', 30 );
				add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_thumb_slide', 40 );
			} else {
				add_action( 'woocommerce_before_single_product_summary', 'woostify_change_sale_flash', 25 );
				add_action( 'woocommerce_before_single_product_summary', 'woostify_print_out_of_stock_label', 30 );
				add_action( 'woocommerce_before_single_product_summary', 'woostify_product_video_button_play', 35 );
				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 40 );
			}

			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_close', 50 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_gallery_dependency', 100 );
			add_action( 'woocommerce_before_single_product_summary', 'woostify_single_product_wrapper_summary_open', 200 );

			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_wrapper_summary_close', 0 );
			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_container_close', 5 );
			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_after_summary_open', 8 );
			add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_after_summary_close', 100 );

			add_action( 'woocommerce_single_product_summary', 'woostify_trust_badge_image', 200 );
			add_action( 'template_redirect', 'woostify_product_recently_viewed', 20 );
			add_action( 'woocommerce_after_single_product', 'woostify_product_recently_viewed_template', 20 );

			// Disable Out of Stock Variations.
			add_filter( 'woocommerce_variation_is_active', 'woostify_disable_variations_out_of_stock', 10, 2 );

			// Modify product quantity.
			add_filter( 'woocommerce_get_stock_html', 'woostify_modified_quantity_stock', 10, 2 );
			add_action( 'woocommerce_after_add_to_cart_quantity', 'woostify_add_to_cart_product_simple' );

			// METABOXS.
			add_action( 'add_meta_boxes', array( $this, 'woostify_add_product_metaboxes' ) );
			add_action( 'save_post', array( $this, 'woostify_save_product_metaboxes' ) );

			// Custom plugin.
			add_action( 'woostify_mini_cart_item_after_price', array( $this, 'woostify_support_german_market_plugin' ) );
		}

		/**
		 * Add view more button
		 */
		public function add_infinite_scroll_button() {
			wp_enqueue_script( 'woostify-infinite-scroll-plugin' );

			$options = woostify_options( false );
			$type    = $options['shop_page_infinite_scroll_type'];
			if ( woocommerce_products_will_display() ) {
				?>
				<div class="woostify-view-more" data-loading_type="<?php esc_attr_e( $type ); ?>">
					<?php if ( 'button' === $type ) { ?>
						<button class="w-view-more-button products-archive button"><span class="w-view-more-label"><?php esc_html_e( 'View more', 'woostify' ); ?></span></button>
					<?php } else { ?>
						<span class="woostify-loading-status"></span>
					<?php } ?>
				</div>
			<?php }
		}

		/**
		 * Add term meta field.
		 */
		public function woostify_add_term_meta_field() {
			$options = woostify_options( false );
			if ( ! $options['shop_single_ajax_add_to_cart'] ) {
				return;
			}
			?>

			<div class="form-field term-display-type-wrap">
				<label for="display_type"><?php esc_html_e( 'Single ajax add to cart', 'woostify' ); ?></label>
				<select name="cat_single_ajax_add_to_cart">
					<option value="enabled"><?php esc_html_e( 'Enabled', 'woostify' ); ?></option>
					<option value="disabled"><?php esc_html_e( 'Disabled', 'woostify' ); ?></option>
				</select>
			</div>
			<?php
		}

		/**
		 * Edit term meta field.
		 *
		 * @param      array $term The term.
		 */
		public function woostify_edit_term_meta_field( $term ) {
			$options = woostify_options( false );
			if ( ! $options['shop_single_ajax_add_to_cart'] ) {
				return;
			}

			$single_ajax = get_term_meta( $term->term_id, 'cat_single_ajax_add_to_cart', true );
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label><?php esc_html_e( 'Single ajax add to cart', 'woostify' ); ?></label>
				</th>
				<td class="theme-form-field">
					<select name="cat_single_ajax_add_to_cart">
						<option value="enabled" <?php selected( $single_ajax, 'enabled', true ); ?>><?php esc_html_e( 'Enabled', 'woostify' ); ?></option>
						<option value="disabled" <?php selected( $single_ajax, 'disabled', true ); ?>><?php esc_html_e( 'Disabled', 'woostify' ); ?></option>
					</select>
				</td>
			</tr>
			<?php
		}

		/**
		 * Save a taxonomy meta field.
		 *
		 * @param      array $term_id The term identifier.
		 */
		public function woostify_save_term_meta_field( $term_id ) {
			$options = woostify_options( false );
			if ( ! $options['shop_single_ajax_add_to_cart'] ) {
				return;
			}

			$single_ajax = isset( $_POST['cat_single_ajax_add_to_cart'] ) ? $_POST['cat_single_ajax_add_to_cart'] : 'enabled'; // phpcs:ignore
			update_term_meta( $term_id, 'cat_single_ajax_add_to_cart', $single_ajax );
		}

		/**
		 * Add term meta field.
		 */
		public function woostify_add_field_taxonomy() {
			?>
				<div class="form-field term-display-type-image">
					<label for="display_type_image"><?php esc_html_e( 'Enable thumbnail for page header BG', 'woostify' ); ?></label>
					<select id="display_type_image" name="display_type_image" class="postform">
						<option value=""><?php esc_html_e( 'Disable', 'woostify' ); ?></option>
						<option value="enable"><?php esc_html_e( 'Enable', 'woostify' ); ?></option>
					</select>
				</div>
			<?php
		}

		/**
		 * Edit term meta field.
		 *
		 * @param      array $term The term.
		 */
		public function woostify_edit_field_taxonomy( $term ) {
			$display_type_image = get_term_meta( $term->term_id, 'display_type_image', true );
			?>
				<tr class="form-field term-display-type-image">
					<th scope="row" valign="top"><label><?php esc_html_e( 'Enable thumbnail for page header BG', 'woostify' ); ?></label></th>
					<td>
						<select id="display_type_image" name="display_type_image" class="postform">
							<option value="" <?php selected( '', $display_type_image ); ?>><?php esc_html_e( 'Disable', 'woostify' ); ?></option>
							<option value="enable" <?php selected( 'enable', $display_type_image ); ?>><?php esc_html_e( 'Enable', 'woostify' ); ?></option>
						</select>
					</td>
				</tr>
			<?php
		}

		/**
		 * Save a taxonomy meta field.
		 *
		 * @param      array $term_id The term identifier.
		 */
		public function woostify_save_term_field( $term_id ) {

			$display_type_image = isset( $_POST['display_type_image'] ) ? $_POST['display_type_image'] : ''; // phpcs:ignore
			update_term_meta( $term_id, 'display_type_image', $display_type_image );
		}

		/**
		 * Demo
		 *
		 * @param  object $product The product.
		 */
		public function woostify_support_german_market_plugin( $product ) {
			if ( class_exists( 'WGM_Tax' ) ) {
				echo wp_kses_post( WGM_Tax::text_including_tax( $product ) );
			}
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 */
		public function woostify_woocommerce_setup() {
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

			add_theme_support(
				'woocommerce',
				apply_filters(
					'woostify_woocommerce_args',
					array(
						'product_grid' => array(
							'default_columns' => 4,
							'default_rows'    => 3,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						),
					)
				)
			);
		}

		/**
		 * Woocommerce enqueue scripts and styles.
		 */
		public function woocommerce_scripts() {
			$product_id = woostify_get_product_id();
			$product    = $product_id ? wc_get_product( $product_id ) : false;
			$options    = woostify_options( false );

			// Remove Divi css on TI wishlist page.
			if ( function_exists( 'is_wishlist' ) && is_wishlist() && function_exists( 'et_is_builder_plugin_active' ) && et_is_builder_plugin_active() ) {
				wp_dequeue_style( 'et-builder-modules-style' );
			}

			// Main woocommerce js file.
			wp_enqueue_script( 'woostify-woocommerce' );
			// Quantity minicart.
			wp_localize_script(
				'woostify-woocommerce',
				'woostify_woocommerce_general',
				array(
					'ajax_url'            => admin_url( 'admin-ajax.php' ),
					'ajax_nonce'          => wp_create_nonce( 'woostify_woocommerce_general_nonce' ),
					'ajax_error'          => __( 'Sorry, something went wrong. Please try again!', 'woostify' ),
					'qty_warning'         => __( 'Please enter a valid quantity for this product', 'woostify' ),
					'shipping_text'       => __( 'Shipping', 'woostify' ),
					'shipping_next'       => __( 'Calculated at next step', 'woostify' ),
					'sticky_top_space'    => $options['shop_single_product_sticky_top_space'],
					'sticky_bottom_space' => $options['shop_single_product_sticky_bottom_space'],
					'currency_symbol'     => get_woocommerce_currency_symbol(),
					'currency_pos'        => get_option( 'woocommerce_currency_pos' ),
				)
			);

			// Product variations.
			wp_enqueue_script( 'woostify-product-variation' );

			// Quantity button.
			wp_enqueue_script( 'woostify-quantity-button' );

			// Sticky sidebar.
			if ( in_array( $options['shop_single_gallery_layout'], array( 'column', 'grid' ), true ) ) {
				wp_enqueue_script( 'sticky-sidebar' );
			}

			// Lightbox.
			wp_enqueue_script( 'lity' );

			// Tiny slider: product images.
			wp_enqueue_script( 'woostify-product-images' );
			wp_localize_script(
				'woostify-product-images',
				'woostify_product_images_slider_options',
				apply_filters(
					'woostify_product_images_slider_options',
					array(
						'main'  => array(
							'container'            => '#product-images',
							'navContainer'         => '#product-thumbnail-images',
							'loop'                 => false,
							'rewind'               => true,
							'items'                => 1,
							'navAsThumbnails'      => true,
							'autoHeight'           => true,
							'preventScrollOnTouch' => true,
						),
						'thumb' => array(
							'loop'      => false,
							'rewind'    => true,
							'container' => '#product-thumbnail-images',
							'gutter'    => 10,
							'nav'       => false,
							'controls'  => true,
							'items'     => 4,
						),
					)
				)
			);

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

			// Multi step checkout.
			if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) && $options['checkout_multi_step'] ) {
				wp_enqueue_script( 'woostify-multi-step-checkout' );
			}

			// Single add to cart script.
			if ( $options['shop_single_ajax_add_to_cart'] && woostify_single_ajax_add_to_cart_status() && ! woostify_get_term_setting( 'cat_single_ajax_add_to_cart', 'disabled', false ) ) {
				wp_enqueue_script( 'woostify-single-add-to-cart' );
			}

			// For variable product.
			if ( $product && $product->is_type( 'variable' ) ) {
				wp_localize_script(
					'woostify-woocommerce',
					'woostify_woocommerce_variable_product_data',
					array(
						'ajax_url'             => admin_url( 'admin-ajax.php' ),
						// Sale tag.
						'sale_tag_percent'     => $options['shop_page_sale_percent'],
						// Out of stock.
						'out_of_stock_display' => $options['shop_page_out_of_stock_position'],
						'out_of_stock_square'  => $options['shop_page_out_of_stock_square'] ? 'is-square' : '',
						'out_of_stock_text'    => $options['shop_page_out_of_stock_text'],
						/* translators: %s number of product */
						'stock_label'          => apply_filters( 'woostify_stock_message', __( 'Hurry! only %s left in stock.', 'woostify' ) ),
					)
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
			$options            = woostify_options( false );
			$disable_multi_step = woostify_is_multi_checkout();

			// Disabled Add to cart button icon.
			if ( ! $options['shop_product_add_to_cart_icon'] ) {
				$classes[] = 'disabled-icon-add-cart-button';
			}

			// Disabled side cart if user use elementor mini cart.
			if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
				if ( 'no' !== get_option( 'elementor_use_mini_cart_template' ) ) {
					$classes[] = 'disabled-sidebar-cart';
				} else {
					$classes[] = 'hide-added-to-cart';
				}
			}

			// Product gallery.
			$page_id = woostify_get_page_id();
			$product = wc_get_product( $page_id );
			$gallery = $product ? $product->get_gallery_image_ids() : false;

			if ( in_array( $options['shop_single_gallery_layout'], array( 'vertical', 'horizontal' ), true ) ) {
				$classes[] = 'has-gallery-slider-layout';
			} else {
				$classes[] = 'has-gallery-list-layout';
			}

			if ( $gallery || is_singular( 'elementor_library' ) || is_singular( 'woo_builder' ) ) {
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

				$classes[] = apply_filters( 'woostify_cart_page_layout_class_name', 'cart-page-' . $options['cart_page_layout'] );
			}

			// Checkout page.
			if ( is_checkout() ) {
				$order_button     = $options['checkout_sticky_place_order_button'];
				$distraction_free = $options['checkout_distraction_free'];
				$multi_step       = $options['checkout_multi_step'];

				if ( $order_button ) {
					$classes[] = 'has-order-sticky-button';
				}

				if ( $distraction_free ) {
					$classes[] = 'has-distraction-free-checkout';
				}

				if ( $multi_step && $disable_multi_step ) {
					$classes[] = 'has-multi-step-checkout';
				}
			}

			// Dokan support.
			if ( class_exists( 'WeDevs_Dokan' ) && woostify_is_woocommerce_activated() && dokan_is_store_page() ) {
				$classes[] = 'off' === dokan_get_option( 'enable_theme_store_sidebar', 'dokan_appearance', 'off' ) ? 'has-dokan-sidebar' : 'dokan-with-theme-sidebar';
			}

			// Elementor theme builder shop archive.
			if ( is_shop() && woostify_elementor_has_location( 'archive' ) ) {
				$classes[] = 'has-elementor-location-shop-archive';
			}

			return array_filter( $classes );
		}

		/**
		 * WP action
		 */
		public function woostify_woocommerce_wp_action() {
			$options             = woostify_options( false );
			$multi_step_checkout = woostify_is_multi_checkout();

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
			// Product tab additional information.
			if ( ! $options['shop_single_additional_information'] ) {
				add_filter( 'woocommerce_product_tabs', 'woostify_remove_additional_information_tabs', 98 );
			}

			// Related product.
			if ( ! $options['shop_single_related_product'] ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}

			// Multi step checkout. Replace default Page header.
			$is_checkout = is_checkout() && ! is_wc_endpoint_url( 'order-received' ); // Is Checkout page only, not Thank you page.

			// Remove default Place Order button.
			if ( $options['checkout_multi_step'] ) {
				add_filter( 'woocommerce_order_button_html', '__return_empty_string' );
			}

			if ( $is_checkout && $options['checkout_multi_step'] && $multi_step_checkout ) {
				// Remove default woocommerce template.
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
				remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
				remove_action( 'woocommerce_checkout_before_customer_details', 'wc_get_pay_buttons', 30 );

				// Theme multi step.
				add_action( 'woostify_after_header', 'woostify_multi_step_checkout', 10 );

				add_action( 'woocommerce_checkout_before_customer_details', 'woostify_multi_checkout_wrapper_start', 10 ); // Wrapper start.

				add_action( 'woocommerce_checkout_before_customer_details', 'woostify_multi_checkout_first_wrapper_start', 20 ); // First step.
				add_action( 'woocommerce_checkout_after_customer_details', 'woostify_multi_checkout_first_wrapper_end', 10 );

				add_action( 'woocommerce_checkout_after_customer_details', 'woostify_multi_checkout_second', 20 ); // Second.
				add_action( 'woocommerce_checkout_after_customer_details', 'woostify_multi_checkout_third', 30 ); // Third.

				// Payment content, move to step 3 of multi step.
				add_action( 'woostify_multi_step_checkout_third', 'woocommerce_checkout_payment', 10 );
				add_action( 'woostify_multi_step_checkout_third', 'wc_get_pay_buttons', 40 );

				add_action( 'woocommerce_checkout_after_customer_details', 'woostify_multi_checkout_button_action', 40 ); // Button action.

				add_action( 'woocommerce_checkout_after_customer_details', 'woostify_multi_checkout_wrapper_end', 100 ); // Wrapper end.

				add_action( 'woocommerce_checkout_after_order_review', 'woostify_checkout_before_order_review', 10 );
			}

			// Add product thumbnail to review order.
			add_filter( 'woocommerce_cart_item_name', 'woostify_add_product_thumbnail_to_checkout_order', 10, 3 );

			if ( ! is_cart() ) {
				remove_action( 'woostify_page_header_breadcrumb', 'woostify_breadcrumb', 10 );
				add_action( 'woostify_page_header_breadcrumb', 'woocommerce_breadcrumb', 10 );
			}
		}

		/**
		 * Init action
		 */
		public function woostify_woocommerce_init_action() {
			// Remove default add to wishlist button TI wishlist plugin.
			remove_action( 'woocommerce_after_shop_loop_item', 'tinvwl_view_addto_htmlloop', 10 );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

			// Shop page.
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

			// Single product.
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

			add_action( 'woocommerce_single_product_summary', 'custom_template_single_title', 5 );
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
			// Swap position price and rating star.
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}

		/**
		 * Metaboxs
		 */
		public function woostify_add_product_metaboxes() {
			add_meta_box(
				'woostify-product-video-metabox',
				__( 'Product video url', 'woostify' ),
				array( $this, 'woostify_product_metabox_content' ),
				'product',
				'side'
			);
		}

		/**
		 * Product metabox content
		 *
		 * @param      object $post The post.
		 */
		public function woostify_product_metabox_content( $post ) {
			// Add a nonce field so we can check for it later.
			wp_nonce_field( basename( __FILE__ ), 'woostify_product_video_metabox_nonce' );
			$value = get_post_meta( $post->ID, 'woostify_product_video_metabox', true );
			?>

			<div class="woostify-metabox-setting">
				<div class="woostify-metabox-option-content">
					<label for="woostify-product-video-url" style="margin-top: 10px; display: block;">
						<textarea class="widefat" id="woostify-product-video-url" name="woostify_product_video_metabox" rows="4" placeholder="<?php esc_attr_e( 'Enter Youtube or Vimeo video url', 'woostify' ); ?>" ><?php echo esc_html( $value ); ?></textarea>
					</label>
				</div>
			</div>
			<?php
		}

		/**
		 * Save metaboxs
		 *
		 * @param      int $post_id The post identifier.
		 */
		public function woostify_save_product_metaboxes( $post_id ) {
			$is_autosave    = wp_is_post_autosave( $post_id );
			$is_revision    = wp_is_post_revision( $post_id );
			$is_valid_nonce = ( isset( $_POST['woostify_product_video_metabox_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woostify_product_video_metabox_nonce'] ) ), basename( __FILE__ ) ) ) ? true : false;

			// Exits script depending on save status.
			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return;
			}

			// Sanitize user input.
			$video = empty( $_POST['woostify_product_video_metabox'] ) ? '' : sanitize_text_field( wp_unslash( $_POST['woostify_product_video_metabox'] ) );
			update_post_meta( $post_id, 'woostify_product_video_metabox', $video );
		}
	}
	Woostify_WooCommerce::get_instance();
}
