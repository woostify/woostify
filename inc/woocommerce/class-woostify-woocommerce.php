<?php
/**
 * Woostify WooCommerce Class
 *
 * @package  woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woostify_WooCommerce' ) ) :

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
			add_action( 'after_setup_theme', array( $this, 'woostify_woocommerce_setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 200 );
			add_action( 'elementor/preview/enqueue_scripts', array( $this, 'woostify_elementor_preview_product_page_scripts' ) );
			add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_cross_sells_columns', array( $this, 'woostify_change_cross_sells_columns' ) );
			add_filter( 'woocommerce_show_page_title', array( $this, 'woostify_remove_woocommerce_shop_title' ) );
			add_filter( 'woocommerce_available_variation', array( $this, 'woostify_available_variation_gallery' ), 90, 3 );

			// Remove Woo-Commerce Default actions.
			add_action( 'init', array( $this, 'woostify_woocommerce_init_action' ) );
			add_action( 'wp', array( $this, 'woostify_woocommerce_wp_action' ) );
			// Custom breadcrumb for Product page.
			add_action( 'wp', 'woostify_breadcrumb_for_product_page' );

			add_action( 'woocommerce_before_shop_loop', array( $this, 'woostify_toggle_sidebar_mobile_button' ), 25 );

			// GENERAL.
			// Product related.
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'woostify_related_products_args' ) );
			// Pagination arrow.
			add_filter( 'woocommerce_pagination_args', array( $this, 'woostify_change_woocommerce_arrow_pagination' ) );
			// Change sale flash.
			add_filter( 'woocommerce_sale_flash', array( $this, 'woostify_change_sale_flash' ) );
			// Cart fragment.
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woostify_cart_sidebar_content_fragments' ) );
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woostify_cart_total_number_fragments' ) );
			// Loop start.
			add_filter( 'woocommerce_product_loop_start', array( $this, 'woostify_woocommerce_loop_start' ) );
			// Products per row.
			add_filter( 'loop_shop_columns', array( $this, 'woostify_products_per_row' ) );
			// Products per page.
			add_filter( 'loop_shop_per_page', array( $this, 'woostify_products_per_page' ) );
			// Add add to cart icon into Loop action area.
			add_action( 'woostify_product_loop_item_action_item', array( $this, 'woostify_product_loop_item_add_to_cart_icon' ), 10 );
			// Add wishlist icon into Loop action area.
			add_action( 'woostify_product_loop_item_action_item', array( $this, 'woostify_product_loop_item_wishlist_icon' ), 30 );
			// Clear shop cart.
			add_action( 'init', array( $this, 'woostify_detect_clear_cart_submit' ) );

			// SHOP PAGE.
			// Open wrapper product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_image_wrapper_open' ), 20 );
			// Add product Loop action area.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_product_loop_item_action' ), 25 );
			// Product link open.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_link_open' ), 30 );
			// Product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_image' ), 40 );
			// Product loop hover image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_hover_image' ), 50 );
			// Product link close.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_link_close' ), 60 );
			// Product add to cart ( Display on image ).
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_add_to_cart_on_image' ), 70 );
			// Wishlist icon on bottom right.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_product_loop_item_wishlist_icon_bottom' ), 80 );
			// Close wrapper product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_image_wrapper_close' ), 90 );
			// Open product loop content.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woostify_loop_product_content_open' ), 100 );
			// Close product loop content.
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'woostify_loop_product_content_close' ), 50 );

			// Add product category.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'woostify_add_template_loop_product_category' ), 5 );
			// Add url inside product title.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'woostify_add_template_loop_product_title' ), 10 );

			// Product rating.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'woostify_loop_product_rating' ), 2 );

			// Product loop meta open.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'woostify_loop_product_meta_open' ), 5 );

			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'woostify_loop_product_price' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'woostify_loop_product_add_to_cart_button' ), 15 );
			// Product loop meta close.
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'woostify_loop_product_meta_close' ), 20 );

			// PRODUCT PAGE.
			// Product container open.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'woostify_single_product_container_open' ), 10 );
			// Product gallery open.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'woostify_single_product_gallery_open' ), 20 );
			// Product gallery image slider.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'woostify_single_product_gallery_image_slide' ), 30 );
			// Product gallery thumbnail slider.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'woostify_single_product_gallery_thumb_slide' ), 40 );
			// Product gallery close.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'woostify_single_product_gallery_close' ), 50 );
			// Product galley script and style.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'woostify_single_product_gallery_dependency' ), 100 );
			// Product container close.
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'woostify_single_product_container_close' ), 5 );
			// Container after summary.
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'woostify_single_product_after_summary_open' ), 8 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'woostify_single_product_after_summary_close' ), 100 );

			// CART PAGE.
			add_action( 'woocommerce_after_cart_table', array( $this, 'woostify_clear_shop_cart' ) );
		}

		/**
		 * Theme options
		 *
		 * @return array $options All theme options
		 */
		public function woostify_options() {
			$options = woostify_options( false );
			return $options;
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 */
		public function woostify_woocommerce_setup() {
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
			$options = self::woostify_options();

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
		}

		/**
		 * Global variation gallery
		 */
		public function woostify_elementor_preview_product_page_scripts() {
			$product = wc_get_product( $this->woostify_get_last_product_id() );
			if ( ! is_object( $product ) ) {
				$this->woostify_global_for_vartiation_gallery( $product );
			}
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$options   = woostify_options( false );
			$classes[] = 'woocommerce-active';

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

			if ( true != $sku ) {
				$classes[] = 'hid-skus';
			}

			if ( true != $categories ) {
				$classes[] = 'hid-categories';
			}

			if ( true != $tags ) {
				$classes[] = 'hid-tags';
			}

			return $classes;
		}

		/**
		 * Removes a woocommerce shop title.
		 */
		public function woostify_remove_woocommerce_shop_title() {
			return false;
		}


		/**
		 * Modify: Loop start
		 */
		public function woostify_woocommerce_loop_start() {
			$options = self::woostify_options();
			$class[] = 'products';
			$class[] = 'columns-' . wc_get_loop_prop( 'columns' );
			$class[] = 'tablet-columns-' . $options['tablet_products_per_row'];
			$class[] = 'mobile-columns-' . $options['mobile_products_per_row'];
			$class   = implode( ' ', $class );
			?>
			<ul class="<?php echo esc_attr( $class ); ?>">
			<?php
		}


		/**
		 * Products per row
		 */
		public function woostify_products_per_row() {
			$options = self::woostify_options();

			return $options['products_per_row'];
		}

		/**
		 * Products per page
		 */
		public function woostify_products_per_page() {
			$options = self::woostify_options();

			return $options['products_per_page'];
		}

		/**
		 * Toggle sidebar mobile button
		 */
		public function woostify_toggle_sidebar_mobile_button() {
			$icon = apply_filters( 'woostify_toggle_sidebar_mobile_button_icon', 'ti-filter' );
			?>
			<button id="toggle-sidebar-mobile-button" class="<?php echo esc_attr( $icon ); ?>"><?php esc_html_e( 'Filter', 'woostify' ); ?></button>
			<?php
		}

		/**
		 * WP action
		 */
		public function woostify_woocommerce_wp_action() {
			$options = self::woostify_options();

			// SHOP PAGE.
			// Result count.
			if ( ! $options['shop_page_result_count'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Product filter.
			if ( ! $options['shop_page_product_filter'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		/**
		 * Init action
		 */
		public function woostify_woocommerce_init_action() {
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
			add_action( 'woostify_content_top', 'woostify_shop_messages', 20 );

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

		/**
		 * Change cross sell column
		 *
		 * @param      int $columns  The columns.
		 */
		public function woostify_change_cross_sells_columns( $columns ) {
			return 3;
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @return  array $args related products args
		 */
		public function woostify_related_products_args( $args ) {
			$args = apply_filters(
				'woostify_related_products_args',
				array(
					'posts_per_page' => 4,
					'columns'        => 4,
				)
			);

			return $args;
		}

		/**
		 * Change arrow for pagination
		 *
		 * @param array $args Woocommerce pagination.
		 */
		public function woostify_change_woocommerce_arrow_pagination( $args ) {
			$args['prev_text'] = __( 'Prev', 'woostify' );
			$args['next_text'] = __( 'Next', 'woostify' );
			return $args;
		}

		/**
		 * Change sale flash
		 */
		public function woostify_change_sale_flash() {
			global $product;

			$options       = woostify_options( false );
			$sale          = $product->is_on_sale();
			$price_sale    = $product->get_sale_price();
			$price         = $product->get_regular_price();
			$simple        = $product->is_type( 'simple' );
			$variable      = $product->is_type( 'variable' );
			$sale_text     = $options['shop_page_sale_text'];
			$sale_percent  = $options['shop_page_sale_percent'];
			$sale_position = $options['shop_page_sale_tag_position'];
			$final_price   = '';

			if ( $sale ) {
				// For simple product.
				if ( $simple ) {
					if ( $sale_percent ) {
						$final_price = ( ( $price - $price_sale ) / $price ) * 100;
						$final_price = '-' . round( $final_price ) . '%';
					} elseif ( $sale_text ) {
						$final_price = $sale_text;
					}
				} elseif ( $variable && $sale_text ) {
					// For variable product.
					$final_price = $sale_text;
				}

				if ( ! $final_price ) {
					return;
				}
				?>
				<span class="onsale sale-<?php echo esc_attr( $sale_position ); ?>">
					<?php
						echo esc_html( $final_price );
					?>
				</span>
				<?php
			}
		}

		/**
		 * Product loop action
		 */
		public function woostify_product_loop_item_action() {
			?>
			<div class="product-loop-action"><?php do_action( 'woostify_product_loop_item_action_item' ); ?></div>
			<?php
		}

		/**
		 * Add to cart icon
		 */
		public function woostify_product_loop_item_add_to_cart_icon() {
			$options = self::woostify_options();
			if ( 'icon' != $options['shop_page_add_to_cart_button_position'] ) {
				return;
			}

			$this->woostify_modified_add_to_cart_button();
		}

		/**
		 * Product loop wishlist icon
		 */
		public function woostify_product_loop_item_wishlist_icon() {
			$options = self::woostify_options();
			if ( 'top-right' != $options['shop_page_wishlist_position'] || ! defined( 'YITH_WCWL' ) ) {
				return;
			}

			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}

		/**
		 * Product loop wishlist icon on bottom right
		 */
		public function woostify_product_loop_item_wishlist_icon_bottom() {
			$options = self::woostify_options();
			if ( 'bottom-right' != $options['shop_page_wishlist_position'] || ! defined( 'YITH_WCWL' ) ) {
				return;
			}
			?>
			<div class="loop-wrapper-wishlist">
				<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
			</div>
			<?php
		}

		/**
		 * Update cart total item via ajax
		 *
		 * @param      array $fragments Fragments to refresh via AJAX.
		 * @return     array $fragments Fragments to refresh via AJAX
		 */
		public function woostify_cart_total_number_fragments( $fragments ) {
			global $woocommerce;
			$total = $woocommerce->cart->cart_contents_count;

			ob_start();
			?>
				<span class="shop-cart-count"><?php echo esc_html( $total ); ?></span>
			<?php

			$fragments['span.shop-cart-count'] = ob_get_clean();

			return $fragments;
		}

		/**
		 * Clear cart button.
		 */
		public function woostify_detect_clear_cart_submit() {
			global $woocommerce;

			if ( isset( $_GET['empty-cart'] ) ) {
				$woocommerce->cart->empty_cart();
			}
		}

		/**
		 * Update cart sidebar content via ajax
		 *
		 * @param      array $fragments Fragments to refresh via AJAX.
		 * @return     array $fragments Fragments to refresh via AJAX
		 */
		public function woostify_cart_sidebar_content_fragments( $fragments ) {
			ob_start();
			?>
				<div class="cart-sidebar-content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			<?php

			$fragments['div.cart-sidebar-content'] = ob_get_clean();

			return $fragments;
		}

		/**
		 * Loop product category.
		 */
		public function woostify_add_template_loop_product_category() {
			$options = self::woostify_options();
			if ( false == $options['shop_page_product_category'] ) {
				return;
			}
			?>
			<div class="woocommerce-loop-product__category">
				<?php
				global $product;
				$product_id = $product->get_ID();
				echo wp_kses_post( wc_get_product_category_list( $product_id ) );
				?>
			</div>
			<?php
		}

		/**
		 * Loop product rating
		 */
		public function woostify_loop_product_rating() {
			$options = self::woostify_options();
			if ( false == $options['shop_page_product_rating'] ) {
				return;
			}

			global $product;
			echo wc_get_rating_html( $product->get_average_rating() ); // WPCS: XSS OK.
		}

		/**
		 * Loop product title.
		 */
		public function woostify_add_template_loop_product_title() {
			$options = self::woostify_options();
			if ( false == $options['shop_page_product_title'] ) {
				return;
			}
			?>
			<h2 class="woocommerce-loop-product__title">
				<?php
					woocommerce_template_loop_product_link_open();
					the_title();
					woocommerce_template_loop_product_link_close();
				?>
			</h2>
			<?php
		}

		/**
		 * Loop product image wrapper open tag
		 */
		public function woostify_loop_product_image_wrapper_open() {
			$options = woostify_options( false );
			$class[] = 'product-loop-image-wrapper';
			$class[] = 'zoom' == $options['shop_page_product_image_hover'] ? $options['shop_page_product_image_hover'] . '-hover' : '';
			$class[] = $options['shop_page_product_image_equal_height'] ? 'has-equal-image-height' : '';
			$class   = trim( implode( ' ', $class ) );

			echo '<div class="' . esc_attr( $class ) . '">';
		}

		/**
		 * Loop product link open
		 */
		public function woostify_loop_product_link_open() {
			// open tag <a>.
			woocommerce_template_loop_product_link_open();
		}

		/**
		 * Loop product image
		 */
		public function woostify_loop_product_image() {
			global $product;

			if ( ! $product ) {
				return '';
			}

			$size       = 'woocommerce_thumbnail';
			$img_id     = $product->get_image_id();
			$img_alt    = woostify_image_alt( $img_id, esc_attr__( 'Product image', 'woostify' ) );
			$img_origin = wp_get_attachment_image_src( $img_id, $size );
			$image_attr = array(
				'alt'             => $img_alt,
				'data-origin_src' => $img_origin[0],
			);

			echo $product->get_image( $size, $image_attr ); // WPCS: XSS ok.
		}

		/**
		 * Loop product hover image
		 */
		public function woostify_loop_product_hover_image() {
			$options = woostify_options( false );
			if ( 'swap' != $options['shop_page_product_image_hover'] ) {
				return;
			}

			global $product;
			$gallery    = $product->get_gallery_image_ids();
			$size       = 'woocommerce_thumbnail';
			$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

			// Hover image.
			if ( ! empty( $gallery ) ) {
				$hover = wp_get_attachment_image_src( $gallery[0], $image_size );
				?>
					<span class="product-loop-hover-image" style="background-image: url(<?php echo esc_url( $hover[0] ); ?>);"></span>
				<?php
			}
		}

		/**
		 * Loop product link close
		 */
		public function woostify_loop_product_link_close() {
			// close tag </a>.
			woocommerce_template_loop_product_link_close();
		}

		/**
		 * Woostify add to cart button
		 */
		public function woostify_modified_add_to_cart_button() {
			$args = woostify_modify_loop_add_to_cart_class();
			woocommerce_template_loop_add_to_cart( $args );
		}

		/**
		 * Product add to cart ( On image )
		 */
		public function woostify_loop_product_add_to_cart_on_image() {
			$options = self::woostify_options();
			if ( 'image' != $options['shop_page_add_to_cart_button_position'] ) {
				return;
			}

			$this->woostify_modified_add_to_cart_button();
		}

		/**
		 * Loop product image wrapper close tag
		 */
		public function woostify_loop_product_image_wrapper_close() {
			echo '</div>';
		}

		/**
		 * Product loop content open
		 */
		function woostify_loop_product_content_open() {
			$options = self::woostify_options();
			$class   = 'text-' . $options['shop_page_product_alignment'];

			echo '<div class="product-loop-content ' . esc_attr( $class ) . '">';
		}

		/**
		 * Product loop content close
		 */
		function woostify_loop_product_content_close() {
			echo '</div>';
		}

		/**
		 * Loop product meta open
		 */
		public function woostify_loop_product_meta_open() {
			global $product;
			$options = self::woostify_options();

			$class = (
				! $options['shop_page_product_price'] ||
				( 'external' === $product->get_type() && '' === $product->get_price() ) ||
				'bottom' != $options['shop_page_add_to_cart_button_position'] ||
				defined( 'YITH_WCQV_VERSION' )
			) ? 'no-transform' : '';

			echo '<div class="product-loop-meta ' . esc_attr( $class ) . '">';
			echo '<div class="animated-meta">';
		}

		/**
		 * Loop product price
		 */
		public function woostify_loop_product_price() {
			$options = self::woostify_options();
			if ( ! $options['shop_page_product_price'] ) {
				return;
			}

			global $product;
			$price_html = $product->get_price_html();

			if ( $price_html ) {
				?>
				<span class="price"><?php echo wp_kses_post( $price_html ); ?></span>
				<?php
			}
		}

		/**
		 * Loop product add to cart button
		 */
		public function woostify_loop_product_add_to_cart_button() {
			$options = self::woostify_options();
			if ( in_array( $options['shop_page_add_to_cart_button_position'], [ 'none', 'image', 'icon' ] ) ) {
				return;
			}

			$args = woostify_modify_loop_add_to_cart_class();
			woocommerce_template_loop_add_to_cart( $args );
		}

		/**
		 * Loop product meta close
		 */
		public function woostify_loop_product_meta_close() {
			echo '</div></div>';
		}


		/**
		 * Product container open
		 */
		public function woostify_single_product_container_open() {
			$container = woostify_site_container();
			?>
				<div class="product-page-container">
					<div class="<?php echo esc_attr( $container ); ?>">
			<?php
		}

		/**
		 * Single gallery product open
		 */
		public function woostify_single_product_gallery_open() {
			global $product;

			if ( ! is_object( $product ) ) {
				$id = $this->woostify_get_last_product_id();
				if ( ! $id ) {
					return;
				}

				$product = wc_get_product( $id );
			}

			$options    = woostify_options( false );
			$gallery_id = $product->get_gallery_image_ids();
			$classes[]  = $options['shop_single_gallery_layout'] . '-style';
			if ( ! empty( $gallery_id ) ) {
				$classes[] = 'has-product-thumbnails';
			}

			// Global variation gallery.
			$this->woostify_global_for_vartiation_gallery( $product );
			?>
			<div class="product-gallery <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php
		}

		/**
		 * Get variation gallery
		 *
		 * @param object $product The product.
		 */
		public function woostify_get_default_gallery( $product ) {
			$images = array();
			if ( ! is_object( $product ) ) {
				return $images;
			}

			$product_id             = $product->get_id();
			$gallery_images         = $product->get_gallery_image_ids();
			$has_default_thumbnails = false;

			if ( ! empty( $gallery_images ) ) {
				$has_default_thumbnails = true;
			}

			if ( has_post_thumbnail( $product_id ) ) {
				array_unshift( $gallery_images, get_post_thumbnail_id( $product_id ) );
			}

			if ( ! empty( $gallery_images ) ) {
				foreach ( $gallery_images as $i => $image_id ) {
					$images[ $i ]                           = wc_get_product_attachment_props( $image_id );
					$images[ $i ]['image_id']               = $image_id;
					$images[ $i ]['has_default_thumbnails'] = $has_default_thumbnails;
				}
			}

			return $images;
		}

		/**
		 * Available Gallery
		 *
		 * @param array  $available_variation Avaiable Variations.
		 * @param object $variation_product_object Product object.
		 * @param array  $variation Variations.
		 */
		public function woostify_available_variation_gallery( $available_variation, $variation_product_object, $variation ) {
			$product_id         = absint( $variation->get_parent_id() );
			$variation_id       = absint( $variation->get_id() );
			$variation_image_id = absint( $variation->get_image_id() );
			$product            = wc_get_product( $product_id );

			if ( ! $product->is_type( 'variable' ) || ! class_exists( 'WC_Additional_Variation_Images' ) ) {
				return $available_variation;
			}

			$gallery_images = get_post_meta( $variation_id, '_wc_additional_variation_images', true );
			if ( ! $gallery_images ) {
				return $available_variation;
			}
			$gallery_images = explode( ',', $gallery_images );

			if ( $variation_image_id ) {
				// Add Variation Default Image.
				array_unshift( $gallery_images, $variation->get_image_id() );
			} elseif ( has_post_thumbnail( $product_id ) ) {
				// Add Product Default Image.
				array_unshift( $gallery_images, get_post_thumbnail_id( $product_id ) );
			}

			$available_variation['woostify_variation_gallery_images'] = [];
			foreach ( $gallery_images as $k => $v ) {
				$available_variation['woostify_variation_gallery_images'][ $k ] = wc_get_product_attachment_props( $v );
			}

			return $available_variation;
		}

		/**
		 * Get variation gallery
		 *
		 * @param object $product The product.
		 */
		public function woostify_get_variation_gallery( $product ) {
			$images = array();

			if ( ! is_object( $product ) || ! $product->is_type( 'variable' ) ) {
				return $images;
			}

			$variations = array_values( $product->get_available_variations() );
			$key        = class_exists( 'WC_Additional_Variation_Images' ) ? 'woostify_variation_gallery_images' : 'variation_gallery_images';

			$images = array();
			foreach ( $variations as $k ) {
				if ( ! isset( $k[ $key ] ) ) {
					break;
				}

				array_unshift( $k[ $key ], array( 'variation_id' => $k['variation_id'] ) );
				array_push( $images, $k[ $key ] );
			}

			return $images;
		}

		/**
		 * Add global variation
		 *
		 * @param object $product The Product.
		 */
		public function woostify_global_for_vartiation_gallery( $product ) {

			// Woostify Variation gallery.
			wp_localize_script(
				'woostify-product-variation',
				'woostify_variation_gallery',
				$this->woostify_get_variation_gallery( $product )
			);

			// Woostify default gallery.
			wp_localize_script(
				'woostify-product-variation',
				'woostify_default_gallery',
				$this->woostify_get_default_gallery( $product )
			);
		}

		/**
		 * Product gallery product image slider
		 */
		public function woostify_single_product_gallery_image_slide() {
			global $product;

			if ( ! is_object( $product ) ) {
				$id = $this->woostify_get_last_product_id();
				if ( ! $id ) {
					return;
				}

				$product = wc_get_product( $id );
			}
			$product_id = $product->get_id();
			$image_id   = $product->get_image_id();
			$image_alt  = woostify_image_alt( $image_id, esc_attr__( 'Product image', 'woostify' ) );
			$get_size   = wc_get_image_size( 'shop_catalog' );
			$image_size = $get_size['width'] . 'x' . ( ! empty( $get_size['height'] ) ? $get_size['height'] : $get_size['width'] );

			if ( $image_id ) {
				$image_small_src  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
				$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
				$image_size       = $image_full_src[1] . 'x' . $image_full_src[2];
			} else {
				$image_small_src[0]  = wc_placeholder_img_src();
				$image_medium_src[0] = wc_placeholder_img_src();
				$image_full_src[0]   = wc_placeholder_img_src();
			}

			$gallery_id        = $product->get_gallery_image_ids();
			?>
			<div class="product-images">
				<div id="product-images">
					<figure class="image-item ez-zoom">
						<a href="<?php echo esc_url( $image_full_src[0] ); ?>" data-size="<?php echo esc_attr( $image_size ); ?>" data-elementor-open-lightbox="no">
							<img src="<?php echo esc_url( $image_medium_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
						</a>
					</figure>

					<?php
					if ( ! empty( $gallery_id ) ) :
						foreach ( $gallery_id as $key ) :
							$g_full_img_src   = wp_get_attachment_image_src( $key, 'full' );
							$g_medium_img_src = wp_get_attachment_image_src( $key, 'woocommerce_single' );
							$g_image_size     = $g_medium_img_src[1] . 'x' . $g_medium_img_src[2];
							$g_img_alt        = woostify_image_alt( $key, esc_attr__( 'Product image', 'woostify' ) );
							?>
							<figure class="image-item ez-zoom">
								<a href="<?php echo esc_url( $g_full_img_src[0] ); ?>" data-size="<?php echo esc_attr( $g_image_size ); ?>" data-elementor-open-lightbox="no">
									<img src="<?php echo esc_url( $g_medium_img_src[0] ); ?>" alt="<?php echo esc_attr( $g_img_alt ); ?>">
								</a>
							</figure>
							<?php
							endforeach;
						endif;
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Product gallery product thumbnail slider
		 */
		public function woostify_single_product_gallery_thumb_slide() {
			global $product;
			if ( ! is_object( $product ) ) {
				$id = $this->woostify_get_last_product_id();
				if ( ! $id ) {
					return;
				}

				$product = wc_get_product( $id );
			}

			$image_id   = $product->get_image_id();
			$image_alt  = woostify_image_alt( $image_id, esc_attr__( 'Product image', 'woostify' ) );

			if ( $image_id ) {
				$image_small_src  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
				$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
			} else {
				$image_small_src[0]  = wc_placeholder_img_src();
				$image_medium_src[0] = wc_placeholder_img_src();
				$image_full_src[0]   = wc_placeholder_img_src();
			}

			$gallery_id = $product->get_gallery_image_ids();
			?>
			<div class="product-thumbnail-images">
				<?php if ( ! empty( $gallery_id ) ) { ?>
				<div id="product-thumbnail-images">
					<div class="thumbnail-item">
						<img src="<?php echo esc_url( $image_small_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
					</div>

					<?php
					foreach ( $gallery_id as $key ) :
						$g_thumb_src = wp_get_attachment_image_src( $key, 'thumbnail' );
						$g_thumb_alt = woostify_image_alt( $key, esc_attr__( 'Product image', 'woostify' ) );
						?>
						<div class="thumbnail-item">
							<img src="<?php echo esc_url( $g_thumb_src[0] ); ?>" alt="<?php echo esc_attr( $g_thumb_alt ); ?>">
						</div>
					<?php endforeach; ?>
				</div>
				<?php } ?>
			</div>
			<?php
		}

		/**
		 * Single gallery product gallery script and style dependency
		 */
		public function woostify_single_product_gallery_dependency() {
			$options = woostify_options( false );
			if ( ! $options['shop_single_image_lightbox'] ) {
				return;
			}

			// Photoswipe markup html.
			get_template_part( 'template-parts/content', 'photoswipe' );
		}

		/**
		 * Single product gallery close
		 */
		public function woostify_single_product_gallery_close() {
			echo '</div>';
		}

		/**
		 * Product container close.
		 */
		public function woostify_single_product_container_close() {
			?>
				</div>
			</div>
			<?php
		}

		/**
		 * Container after summary open
		 */
		public function woostify_single_product_after_summary_open() {
			$container = woostify_site_container();
			echo '<div class="' . esc_attr( $container ) . '">';
		}

		/**
		 * Container after summary close
		 */
		public function woostify_single_product_after_summary_close() {
			echo '</div>';
		}

		/**
		 * Add clear shop cart button
		 */
		public function woostify_clear_shop_cart() {
			$clear = wc_get_cart_url() . '?empty-cart';
			?>
			<div class="clear-cart-box">
				<a class="clear-cart-btn" href="<?php echo esc_url( $clear ); ?>">
					<?php esc_html_e( 'Clear cart', 'woostify' ); ?>
				</a>
			</div>
			<?php
		}

		/**
		 * Get the last ID of product
		 */
		public function woostify_get_last_product_id() {
			$args = array(
				'post_type'           => 'product',
				'posts_per_page'      => 1,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
			);

			$query = new WP_Query( $args );

			$id = false;

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$id = get_the_ID();
				}

				wp_reset_postdata();
			}

			return $id;
		}
	}
	Woostify_WooCommerce::get_instance();

endif;
