<?php
/**
 * WooCommerce Template Functions.
 *
 * @package woostify
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'woostify_get_last_product_id' ) ) {
	/**
	 * Get the last ID of product
	 */
	function woostify_get_last_product_id() {
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

if ( ! function_exists( 'woostify_elementor_preview_product_page_scripts' ) ) {
	/**
	 * Global variation gallery
	 */
	function woostify_elementor_preview_product_page_scripts() {
		$product = wc_get_product( woostify_get_last_product_id() );
		if ( ! is_object( $product ) ) {
			woostify_global_for_vartiation_gallery( $product );
		}
	}
}

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


if ( ! function_exists( 'woostify_related_products_args' ) ) {
	/**
	 * Related Products Args
	 *
	 * @param  array $args related products args.
	 * @return  array $args related products args
	 */
	function woostify_related_products_args( $args ) {
		$args = apply_filters(
			'woostify_related_products_args',
			array(
				'posts_per_page' => 4,
				'columns'        => 4,
			)
		);

		return $args;
	}
}

if ( ! function_exists( 'woostify_change_woocommerce_arrow_pagination' ) ) {
	/**
	 * Change arrow for pagination
	 *
	 * @param array $args Woocommerce pagination.
	 */
	function woostify_change_woocommerce_arrow_pagination( $args ) {
		$args['prev_text'] = __( 'Prev', 'woostify' );
		$args['next_text'] = __( 'Next', 'woostify' );
		return $args;
	}
}

if ( ! function_exists( 'woostify_change_sale_flash' ) ) {
	/**
	 * Change sale flash
	 */
	function woostify_change_sale_flash() {
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
}

if ( ! function_exists( 'woostify_cart_total_number_fragments' ) ) {
	/**
	 * Update cart total item via ajax
	 *
	 * @param      array $fragments Fragments to refresh via AJAX.
	 * @return     array $fragments Fragments to refresh via AJAX
	 */
	function woostify_cart_total_number_fragments( $fragments ) {
		global $woocommerce;
		$total = $woocommerce->cart->cart_contents_count;

		ob_start();
		?>
			<span class="shop-cart-count"><?php echo esc_html( $total ); ?></span>
		<?php
		$fragments['span.shop-cart-count'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'woostify_cart_sidebar_content_fragments' ) ) {
	/**
	 * Update cart sidebar content via ajax
	 *
	 * @param      array $fragments Fragments to refresh via AJAX.
	 * @return     array $fragments Fragments to refresh via AJAX
	 */
	function woostify_cart_sidebar_content_fragments( $fragments ) {
		ob_start();
		?>
			<div class="cart-sidebar-content">
				<?php woocommerce_mini_cart(); ?>
			</div>
		<?php

		$fragments['div.cart-sidebar-content'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'woostify_woocommerce_loop_start' ) ) {
	/**
	 * Modify: Loop start
	 */
	function woostify_woocommerce_loop_start() {
		$options = woostify_options( false );
		$class[] = 'products';
		$class[] = apply_filters( 'woostify_product_columns_desktop', 'columns-' . wc_get_loop_prop( 'columns' ) );
		$class[] = apply_filters( 'woostify_product_columns_tablet', 'tablet-columns-' . $options['tablet_products_per_row'] );
		$class[] = apply_filters( 'woostify_product_columns_mobile', 'mobile-columns-' . $options['mobile_products_per_row'] );
		$class   = implode( ' ', $class );
		?>
		<ul class="<?php echo esc_attr( $class ); ?>">
		<?php

		// If displaying categories, append to the loop.
		$loop_html = woocommerce_maybe_show_product_subcategories();
		echo $loop_html; // WPCS: XSS ok.
	}
}

if ( ! function_exists( 'woostify_products_per_row' ) ) {
	/**
	 * Products per row
	 */
	function woostify_products_per_row() {
		$options = woostify_options( false );

		return $options['products_per_row'];
	}
}

if ( ! function_exists( 'woostify_products_per_page' ) ) {
	/**
	 * Products per page
	 */
	function woostify_products_per_page() {
		$options = woostify_options( false );

		return $options['products_per_page'];
	}
}

if ( ! function_exists( 'woostify_product_loop_item_add_to_cart_icon' ) ) {
	/**
	 * Add to cart icon
	 */
	function woostify_product_loop_item_add_to_cart_icon() {
		$options = woostify_options( false );
		if ( 'icon' != $options['shop_page_add_to_cart_button_position'] ) {
			return;
		}

		woostify_modified_add_to_cart_button();
	}
}

if ( ! function_exists( 'woostify_product_loop_item_wishlist_icon' ) ) {
	/**
	 * Product loop wishlist icon
	 */
	function woostify_product_loop_item_wishlist_icon() {
		$options = woostify_options( false );
		if ( 'top-right' != $options['shop_page_wishlist_position'] || ! defined( 'YITH_WCWL' ) ) {
			return;
		}

		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	}
}

if ( ! function_exists( 'woostify_detect_clear_cart_submit' ) ) {
	/**
	 * Clear cart button.
	 */
	function woostify_detect_clear_cart_submit() {
		global $woocommerce;

		if ( isset( $_GET['empty-cart'] ) ) {
			$woocommerce->cart->empty_cart();
		}
	}
}

if ( ! function_exists( 'woostify_remove_woocommerce_shop_title' ) ) {
	/**
	 * Removes a woocommerce shop title.
	 */
	function woostify_remove_woocommerce_shop_title() {
		return false;
	}
}

if ( ! function_exists( 'woostify_change_cross_sells_columns' ) ) {
	/**
	 * Change cross sell column
	 *
	 * @param      int $columns  The columns.
	 */
	function woostify_change_cross_sells_columns( $columns ) {
		return 3;
	}
}

if ( ! function_exists( 'woostify_clear_shop_cart' ) ) {
	/**
	 * Add clear shop cart button
	 */
	function woostify_clear_shop_cart() {
		$clear = wc_get_cart_url() . '?empty-cart';
		?>
		<div class="clear-cart-box">
			<a class="clear-cart-btn" href="<?php echo esc_url( $clear ); ?>">
				<?php esc_html_e( 'Clear cart', 'woostify' ); ?>
			</a>
		</div>
		<?php
	}
}
