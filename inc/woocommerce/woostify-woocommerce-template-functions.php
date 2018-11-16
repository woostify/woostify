<?php
/**
 * WooCommerce Template Functions.
 *
 * @package woostify
 */

if ( ! function_exists( 'woostify_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return  void
	 */
	function woostify_before_content() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
		<?php
	}
}

if ( ! function_exists( 'woostify_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @return  void
	 */
	function woostify_after_content() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php
		do_action( 'woostify_sidebar' );
	}
}

if ( ! function_exists( 'woostify_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @return  void
	 */
	function woostify_sorting_wrapper() {
		echo '<div class="woostify-sorting">';
	}
}

if ( ! function_exists( 'woostify_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @return  void
	 */
	function woostify_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper
	 *
	 * @return  void
	 */
	function woostify_product_columns_wrapper() {
		$columns = woostify_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}

if ( ! function_exists( 'woostify_loop_columns' ) ) {
	/**
	 * Default loop columns on product archives
	 *
	 * @return integer products per row
	 * @since  1.0
	 */
	function woostify_loop_columns() {
		$options = woostify_options( false );
		$columns = $options['shop_columns'];

		if ( function_exists( 'wc_get_default_products_per_row' ) ) {
			$columns = wc_get_default_products_per_row();
		}

		return apply_filters( 'woostify_loop_columns', $columns );
	}
}

if ( ! function_exists( 'woostify_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close
	 *
	 * @return  void
	 */
	function woostify_product_columns_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_shop_messages' ) ) {
	/**
	 * Woostify shop messages
	 *
	 * @uses    woostify_do_shortcode
	 */
	function woostify_shop_messages() {
		if ( ! is_checkout() ) {
			?>
			<div class="woostify-message">
				<div class="container">
					<?php echo wp_kses_post( woostify_do_shortcode( 'woocommerce_messages' ) ); ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_woocommerce_pagination' ) ) {
	/**
	 * Woostify WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since Woostify adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @since 1.0
	 */
	function woostify_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		}
	}
}

if ( ! function_exists( 'woostify_woocommerce_cart_sidebar' ) ) {
	/**
	 * Cart sidebar
	 */
	function woostify_woocommerce_cart_sidebar() {
		global $woocommerce;
		$total = $woocommerce->cart->cart_contents_count;
		?>
			<div id="shop-cart-sidebar">
				<div class="cart-sidebar-head">
					<h4 class="cart-sidebar-title"><?php esc_html_e( 'Shopping cart', 'woostify' ); ?></h4>
					<span class="shop-cart-count"><?php echo esc_html( $total ); ?></span>
					<button id="close-cart-sidebar-btn" class="ti-close"></button>
				</div>

				<div class="cart-sidebar-content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_modify_loop_add_to_cart_class' ) ) {
	/**
	 * Modify loop add to cart class name
	 */
	function woostify_modify_loop_add_to_cart_class() {
		global $product;

		$args = array(
			'class' => implode(
				' ',
				array_filter(
					array(
						apply_filters( 'woostify_pro_loop_add_to_cart_icon', 'ti-shopping-cart' ),
						'loop-add-to-cart-btn',
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
					)
				)
			),
		);

		return $args;
	}
}
