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
		$columns = wc_get_loop_prop( 'columns' );
		echo '<div class="columns-' . esc_attr( $columns ) . '">';
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
		if ( is_checkout() ) {
			return;
		}

		echo do_shortcode( '[woocommerce_messages]' );
	}
}

if ( ! function_exists( 'woostify_woocommerce_pagination' ) ) {
	/**
	 * Woostify WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since Woostify adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
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
		$options      = woostify_options( false );
		$button_class = 'loop-add-to-cart-btn';
		$icon_class   = '';
		if (
			( ! in_array( $options['shop_page_add_to_cart_button_position'], [ 'none', 'icon' ] ) && $options['shop_product_add_to_cart_icon'] ) ||
			'icon' == $options['shop_page_add_to_cart_button_position']
		) {
			$icon_class = apply_filters( 'woostify_pro_loop_add_to_cart_icon', 'ti-shopping-cart' );
		}

		if ( 'image' == $options['shop_page_add_to_cart_button_position'] ) {
			$button_class = 'loop-add-to-cart-on-image';
		} elseif ( 'icon' == $options['shop_page_add_to_cart_button_position'] ) {
			$button_class = 'loop-add-to-cart-icon-btn';
		}

		$args = array(
			'class' => implode(
				' ',
				array_filter(
					array(
						$icon_class,
						$button_class,
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
					)
				)
			),
			'attributes' => array(
				'data-product_id'  => $product->get_id(),
				'data-product_sku' => $product->get_sku(),
				'title'            => $product->add_to_cart_description(),
				'rel'              => 'nofollow',
			),
		);

		return $args;
	}
}

if ( ! function_exists( 'woostify_is_woocommerce_page' ) ) {
	/**
	 * Returns true if on a page which uses WooCommerce templates
	 * Cart and Checkout are standard pages with shortcodes and which are also included
	 */
	function woostify_is_woocommerce_page() {
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			return true;
		}

		$keys = array(
			'woocommerce_shop_page_id',
			'woocommerce_terms_page_id',
			'woocommerce_cart_page_id',
			'woocommerce_checkout_page_id',
			'woocommerce_pay_page_id',
			'woocommerce_thanks_page_id',
			'woocommerce_myaccount_page_id',
			'woocommerce_edit_address_page_id',
			'woocommerce_view_order_page_id',
			'woocommerce_change_password_page_id',
			'woocommerce_logout_page_id',
			'woocommerce_lost_password_page_id',
		);

		foreach ( $keys as $k ) {
			if ( get_the_ID() == get_option( $k, 0 ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'woostify_product_navigation' ) ) {
	/**
	 * Product navigation
	 */
	function woostify_product_navigation() {
		global $post;
		$prev = get_previous_post();
		$next = get_next_post();

		if ( ! $prev && ! $next ) {
			return;
		}

		$content = '';
		$classes = '';

		if ( $prev ) {
			$classes        = ! $next ? 'product-nav-last' : '';
			$prev_id        = $prev->ID;
			$prev_product   = wc_get_product( $prev_id );
			$prev_icon      = apply_filters( 'woostify_product_navigation_prev_icon', 'ti-arrow-circle-left' );
			$prev_image_id  = $prev_product->get_image_id();
			$prev_image_src = wp_get_attachment_image_src( $prev_image_id );
			$prev_image_alt = woostify_image_alt( $prev_image_id, __( 'Previous Product Image', 'woostify' ) );

			ob_start();
			?>
				<div class="prev-product-navigation product-nav-item">
					<a class="product-nav-item-text" href="<?php echo get_permalink( $prev_id ) ?>"><span class="product-nav-icon <?php echo esc_attr( $prev_icon ); ?>"></span><?php esc_html_e( 'Previous', 'woostify' ); ?></a>
					<div class="product-nav-item-content">
						<a class="product-nav-item-link" href="<?php echo get_permalink( $prev_id ) ?>"></a>
						<?php if ( $prev_image_src ) { ?>
							<img src="<?php echo esc_url( $prev_image_src[0] ); ?>" alt="<?php echo esc_attr( $prev_image_alt ); ?>">
						<?php } ?>
						<div class="product-nav-item-inner">
							<h4 class="product-nav-item-title"><?php echo get_the_title( $prev_id ); ?></h4>
							<span class="product-nav-item-price"><?php echo wp_kses_post( $prev_product->get_price_html() ); ?></span>
						</div>
					</div>
				</div>
			<?php
			$content .= ob_get_clean();

		}

		if ( $next ) {
			$classes        = ! $prev ? 'product-nav-first' : '';
			$next_id        = $next->ID;
			$next_product   = wc_get_product( $next_id );
			$next_icon      = apply_filters( 'woostify_product_navigation_next_icon', 'ti-arrow-circle-right' );
			$next_image_id  = $next_product->get_image_id();
			$next_image_src = wp_get_attachment_image_src( $next_image_id );
			$next_image_alt = woostify_image_alt( $next_image_id, __( 'Next Product Image', 'woostify' ) );

			ob_start();
			?>
				<div class="next-product-navigation product-nav-item">
					<a class="product-nav-item-text" href="<?php echo get_permalink( $next_id ) ?>"><?php esc_html_e( 'Next', 'woostify' ); ?><span class="product-nav-icon <?php echo esc_attr( $next_icon ); ?>"></span></a>
					<div class="product-nav-item-content">
						<a class="product-nav-item-link" href="<?php echo get_permalink( $next_id ) ?>"></a>
						<div class="product-nav-item-inner">
							<h4 class="product-nav-item-title"><?php echo get_the_title( $next_id ); ?></h4>
							<span class="product-nav-item-price"><?php echo wp_kses_post( $next_product->get_price_html() ); ?></span>
						</div>
						<?php if ( $next_image_src ) { ?>
							<img src="<?php echo esc_url( $next_image_src[0] ); ?>" alt="<?php echo esc_attr( $next_image_alt ); ?>">
						<?php } ?>
					</div>
				</div>
			<?php
			$content .= ob_get_clean();
		}
		?>

		<div class="woostify-product-navigation <?php echo esc_attr( $classes ); ?>">
			<?php echo $content; // WPCS: XSS ok. ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_breadcrumb_for_product_page' ) ) {
	/**
	 * Add breadcrumb for Product page
	 */
	function woostify_breadcrumb_for_product_page() {
		// Hooked to `woostify_content_top` only Product page.
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		$options = woostify_options( false );

		if ( $options['shop_single_breadcrumb'] ) {
			add_action( 'woostify_content_top', 'woostify_breadcrumb', 40 );
		}

		if ( $options['shop_single_product_navigation'] ) {
			add_action( 'woostify_content_top', 'woostify_product_navigation', 50 );
		}
	}
}

