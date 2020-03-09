<?php
/**
 * WooCommerce Template Functions.
 *
 * @package woostify
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'woostify_get_last_product_id' ) ) {
	/**
	 * Get the last ID of product, exclude Group and External Product.
	 */
	function woostify_get_last_product_id() {
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'tax_query'      => array( // phpcs:ignore
				array(
					array(
						'taxonomy' => 'product_type',
						'field'    => 'slug',
						'terms'    => array( 'simple', 'variable' ),
						'operator' => 'IN',
					),
				),
			),
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
			( ! in_array( $options['shop_page_add_to_cart_button_position'], array( 'none', 'icon' ), true ) && $options['shop_product_add_to_cart_icon'] ) ||
			'icon' === $options['shop_page_add_to_cart_button_position']
		) {
			$icon_class = apply_filters( 'woostify_pro_loop_add_to_cart_icon', 'ti-shopping-cart' );
		}

		if ( 'image' === $options['shop_page_add_to_cart_button_position'] ) {
			$button_class = 'loop-add-to-cart-on-image';
		} elseif ( 'icon' === $options['shop_page_add_to_cart_button_position'] ) {
			$button_class = 'loop-add-to-cart-icon-btn';
		}

		$args = array(
			'class'      => implode(
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
			if ( get_the_ID() === get_option( $k, 0 ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'woostify_get_product_navigation_data' ) ) {
	/**
	 * Get ID of prev and next product
	 */
	function woostify_get_product_navigation_data() {
		global $post;
		$product_id = woostify_is_elementor_editor() ? woostify_get_last_product_id() : woostify_get_page_id();
		$post       = get_post( $product_id ); // phpcs:ignore
		if ( ! $post ) {
			return false;
		}

		$prev = get_previous_post();
		$next = get_next_post();

		$prev_id = $prev ? $prev->ID : false;
		$next_id = $next ? $next->ID : false;

		$data = array(
			'prev_id' => $prev_id,
			'next_id' => $next_id,
		);

		return $data;
	}
}

if ( ! function_exists( 'woostify_product_navigation' ) ) {
	/**
	 * Product navigation
	 */
	function woostify_product_navigation() {
		$data = woostify_get_product_navigation_data();
		if ( ! $data ) {
			return;
		}

		$prev_id = $data['prev_id'];
		$next_id = $data['next_id'];

		if ( ! $prev_id && ! $next_id ) {
			return;
		}

		$content = '';
		$classes = '';

		if ( $prev_id ) {
			$classes        = ! $next_id ? 'product-nav-last' : '';
			$prev_product   = wc_get_product( $prev_id );
			$prev_icon      = apply_filters( 'woostify_product_navigation_prev_icon', 'ti-arrow-circle-left' );
			$prev_image_id  = $prev_product->get_image_id();
			$prev_image_src = wp_get_attachment_image_src( $prev_image_id );
			$prev_image_alt = woostify_image_alt( $prev_image_id, __( 'Previous Product Image', 'woostify' ) );

			ob_start();
			?>
				<div class="prev-product-navigation product-nav-item">
					<a class="product-nav-item-text" href="<?php echo esc_url( get_permalink( $prev_id ) ); ?>"><span class="product-nav-icon <?php echo esc_attr( $prev_icon ); ?>"></span><?php esc_html_e( 'Previous', 'woostify' ); ?></a>
					<div class="product-nav-item-content">
						<a class="product-nav-item-link" href="<?php echo esc_url( get_permalink( $prev_id ) ); ?>"></a>
						<?php if ( $prev_image_src ) { ?>
							<img src="<?php echo esc_url( $prev_image_src[0] ); ?>" alt="<?php echo esc_attr( $prev_image_alt ); ?>">
						<?php } ?>
						<div class="product-nav-item-inner">
							<h4 class="product-nav-item-title"><?php echo esc_html( get_the_title( $prev_id ) ); ?></h4>
							<span class="product-nav-item-price"><?php echo wp_kses_post( $prev_product->get_price_html() ); ?></span>
						</div>
					</div>
				</div>
			<?php
			$content .= ob_get_clean();

		}

		if ( $next_id ) {
			$classes        = ! $prev_id ? 'product-nav-first' : '';
			$next_product   = wc_get_product( $next_id );
			$next_icon      = apply_filters( 'woostify_product_navigation_next_icon', 'ti-arrow-circle-right' );
			$next_image_id  = $next_product->get_image_id();
			$next_image_src = wp_get_attachment_image_src( $next_image_id );
			$next_image_alt = woostify_image_alt( $next_image_id, __( 'Next Product Image', 'woostify' ) );

			ob_start();
			?>
				<div class="next-product-navigation product-nav-item">
					<a class="product-nav-item-text" href="<?php echo esc_url( get_permalink( $next_id ) ); ?>"><?php esc_html_e( 'Next', 'woostify' ); ?><span class="product-nav-icon <?php echo esc_attr( $next_icon ); ?>"></span></a>
					<div class="product-nav-item-content">
						<a class="product-nav-item-link" href="<?php echo esc_url( get_permalink( $next_id ) ); ?>"></a>
						<div class="product-nav-item-inner">
							<h4 class="product-nav-item-title"><?php echo esc_html( get_the_title( $next_id ) ); ?></h4>
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
			<?php echo $content; // phpcs:ignore ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_modifided_woocommerce_breadcrumb' ) ) {
	/**
	 * Modify breadcrumb item
	 *
	 * @param      array $default The breadcrumb item.
	 */
	function woostify_modifided_woocommerce_breadcrumb( $default ) {
		$default['delimiter']   = '<span class="item-bread delimiter">' . apply_filters( 'woostify_breadcrumb_delimiter', '&#47;' ) . '</span>';
		$default['wrap_before'] = '<nav class="woostify-breadcrumb">';
		$default['wrap_after']  = '</nav>';
		$default['before']      = '<span class="item-bread">';
		$default['after']       = '</span>';

		return $default;
	}
}

if ( ! function_exists( 'woostify_get_modifided_woocommerce_breadcrumb' ) ) {
	/**
	 * Woocommerce crumbs
	 *
	 * @param      array $crumbs The woocommerce crumbs.
	 */
	function woostify_get_modifided_woocommerce_breadcrumb( $crumbs ) {
		$home = array(
			0 => apply_filters( 'woostify_breadcrumb_home', get_bloginfo( 'name' ) ),
			1 => get_home_url( '/' ),
		);

		$blog = array(
			0 => apply_filters( 'woostify_breadcrumb_blog', __( 'Blog', 'woostify' ) ),
			1 => get_permalink( get_option( 'page_for_posts' ) ),
		);

		$shop = array(
			0 => apply_filters( 'woostify_breadcrumb_shop', __( 'Shop', 'woostify' ) ),
			1 => woostify_is_woocommerce_activated() ? wc_get_page_permalink( 'shop' ) : '#',
		);

		if ( is_tag() || is_category() || is_singular( 'post' ) ) {
			// For all blog page.
			array_splice( $crumbs, 0, 1, array( $home, $blog ) );
		} elseif ( woostify_is_woocommerce_activated() && ( is_product_tag() || is_singular( 'product' ) || is_product_category() ) ) {
			// For all shop page.
			array_splice( $crumbs, 0, 1, array( $home, $shop ) );
		}

		return $crumbs;
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
			add_action( 'woostify_content_top', 'woocommerce_breadcrumb', 40 );
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
		$options = woostify_options( false );
		$args    = apply_filters(
			'woostify_related_products_args',
			array(
				'posts_per_page' => $options['shop_single_product_related_total'],
				'columns'        => $options['shop_single_product_related_columns'],
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

if ( ! function_exists( 'woostify_product_out_of_stock' ) ) {
	/**
	 * Check product out of stock
	 *
	 * @param      object $product The product.
	 */
	function woostify_product_out_of_stock( $product ) {
		if ( ! $product || ! is_object( $product ) ) {
			return false;
		}

		$in_stock     = $product->is_in_stock();
		$manage_stock = $product->managing_stock();
		$quantity     = $product->get_stock_quantity();

		if (
			( $product->is_type( 'simple' ) && ( ! $in_stock || ( $manage_stock && 0 === $quantity ) ) ) ||
			( $product->is_type( 'variable' ) && $manage_stock && 0 === $quantity )
		) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'woostify_print_out_of_stock_label' ) ) {
	/**
	 * Print out of stock label
	 */
	function woostify_print_out_of_stock_label() {
		global $product;
		$out_of_stock = woostify_product_out_of_stock( $product );
		$options      = woostify_options( false );

		if ( ! $out_of_stock || 'none' === $options['shop_page_out_of_stock_position'] ) {
			return;
		}

		$is_square = $options['shop_page_out_of_stock_square'] ? 'is-square' : '';
		?>
		<span class="woostify-out-of-stock-label position-<?php echo esc_attr( $options['shop_page_out_of_stock_position'] ); ?> <?php echo esc_attr( $is_square ); ?>"><?php echo esc_html( $options['shop_page_out_of_stock_text'] ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'woostify_change_sale_flash' ) ) {
	/**
	 * Change sale flash
	 */
	function woostify_change_sale_flash() {
		global $product;
		if ( empty( $product ) ) {
			return;
		}
		$options      = woostify_options( false );
		$sale         = $product->is_on_sale();
		$price_sale   = $product->get_sale_price();
		$price        = $product->get_regular_price();
		$simple       = $product->is_type( 'simple' );
		$variable     = $product->is_type( 'variable' );
		$external     = $product->is_type( 'external' );
		$sale_text    = $options['shop_page_sale_text'];
		$sale_percent = $options['shop_page_sale_percent'];
		$final_price  = '';
		$out_of_stock = woostify_product_out_of_stock( $product );

		// Out of stock.
		if ( $out_of_stock ) {
			return;
		}

		if ( $sale ) {
			// For simple product.
			if ( $simple || $external ) {
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

			$classes[] = 'woostify-tag-on-sale onsale';
			$classes[] = 'sale-' . $options['shop_page_sale_tag_position'];
			$classes[] = $options['shop_page_sale_square'] ? 'is-square' : '';
			?>
			<span class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>">
				<?php echo esc_html( $final_price ); ?>
			</span>
			<?php
		}
	}
}

if ( ! function_exists( 'woostify_product_video_button_play' ) ) {
	/**
	 * Add button play video lightbox for product
	 */
	function woostify_product_video_button_play() {
		global $product;
		if ( ! $product || ! is_object( $product ) ) {
			return;
		}

		$product_id = $product->get_id();
		$video_url  = woostify_get_metabox( $product_id, 'woostify_product_video_metabox' );

		if ( 'default' !== $video_url ) {
			?>
			<a href="<?php echo esc_url( $video_url ); ?>" data-lity class="ti-control-play woostify-lightbox-button"></a>
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
		echo $loop_html; // phpcs:ignore
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
		if ( 'icon' !== $options['shop_page_add_to_cart_button_position'] ) {
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
		if ( 'top-right' !== $options['shop_page_wishlist_position'] || ! woostify_support_wishlist_plugin() ) {
			return;
		}

		$shortcode = '[yith_wcwl_add_to_wishlist]';

		if ( 'ti' === $options['shop_page_wishlist_support_plugin'] ) {
			$shortcode = '[ti_wishlists_addtowishlist]';
		}

		echo do_shortcode( $shortcode );
	}
}

if ( ! function_exists( 'woostify_detect_clear_cart_submit' ) ) {
	/**
	 * Clear cart button.
	 */
	function woostify_detect_clear_cart_submit() {
		global $woocommerce;

		if ( isset( $_GET['empty-cart'] ) ) { // phpcs:ignore
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

if ( ! function_exists( 'woostify_change_cross_sells_total' ) ) {
	/**
	 * Change cross sell total
	 *
	 * @param      int $limit  The total product.
	 */
	function woostify_change_cross_sells_total( $limit ) {
		return 4;
	}
}

if ( ! function_exists( 'woostify_change_cross_sells_columns' ) ) {
	/**
	 * Change cross sell column
	 *
	 * @param      int $columns  The columns.
	 */
	function woostify_change_cross_sells_columns( $columns ) {
		return 2;
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
				<?php esc_html_e( 'Clear Shopping Cart', 'woostify' ); ?>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_add_product_thumbnail_to_checkout_order' ) ) {
	/**
	 * Add thumbnail image for checkout detail
	 *
	 * @param      string       $product_name   The product name.
	 * @param      array|object $cart_item      The cartesian item.
	 * @param      string       $cart_item_key  The cartesian item key.
	 */
	function woostify_add_product_thumbnail_to_checkout_order( $product_name, $cart_item, $cart_item_key ) {
		if ( ! is_checkout() ) {
			return $product_name;
		}

		$data      = $cart_item['data'];
		$image_id  = ! empty( $data ) ? $data->get_image_id() : false;
		$image_alt = woostify_image_alt( $image_id, __( 'Product Image', 'woostify' ) );
		$image_src = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : wc_placeholder_img_src();

		ob_start();
		?>
		<img class="review-order-product-image" src="<?php echo esc_url( wp_get_attachment_image_url( $image_id ) ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">

		<span class="review-order-product-name">
			<?php echo esc_html( $product_name ); ?>
		</span>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woostify_check_shipping_method' ) ) {
	/**
	 * Check shipping method
	 */
	function woostify_check_shipping_method() {
		if ( ! woostify_is_woocommerce_activated() ) {
			return false;
		}

		return WC()->cart->needs_shipping() && WC()->cart->show_shipping();
	}
}

if ( ! function_exists( 'woostify_multi_step_checkout' ) ) {
	/**
	 * Multi step checkout
	 */
	function woostify_multi_step_checkout() {
		$container = woostify_site_container();
		?>
		<div class="multi-step-checkout">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="multi-step-inner">
					<span class="multi-step-item active">
						<span class="item-text"><?php esc_html_e( 'Billing Details', 'woostify' ); ?></span>
					</span>

					<?php if ( woostify_check_shipping_method() ) { ?>
						<span class="multi-step-item">
							<span class="item-text"><?php esc_html_e( 'Delivery', 'woostify' ); ?></span>
						</span>
					<?php } ?>

					<span class="multi-step-item">
						<span class="item-text"><?php esc_html_e( 'Payment', 'woostify' ); ?></span>
					</span>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_wrapper_start' ) ) {
	/**
	 * Wrapper start
	 */
	function woostify_multi_checkout_wrapper_start() {
		?>
		<div class="multi-step-checkout-wrapper first">
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_wrapper_end' ) ) {
	/**
	 * First step end
	 */
	function woostify_multi_checkout_wrapper_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_first_wrapper_start' ) ) {
	/**
	 * First wrapper start
	 */
	function woostify_multi_checkout_first_wrapper_start() {
		?>
		<div class="multi-step-checkout-content active" data-step="first">
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_first_wrapper_end' ) ) {
	/**
	 * First wrapper end
	 */
	function woostify_multi_checkout_first_wrapper_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_second' ) ) {
	/**
	 * Second step
	 */
	function woostify_multi_checkout_second() {
		if ( ! woostify_check_shipping_method() ) {
			return;
		}
		?>
		<div class="multi-step-checkout-content" data-step="second">
			<div class="multi-step-review-information">
				<div class="multi-step-review-information-row" data-type="email">
					<div class="review-information-inner">
						<div class="review-information-label"><?php esc_html_e( 'Contact', 'woostify' ); ?></div>
						<div class="review-information-content"></div>
					</div>
					<span class="review-information-link"><?php esc_html_e( 'Change', 'woostify' ); ?></span>
				</div>

				<div class="multi-step-review-information-row" data-type="address">
					<div class="review-information-inner">
						<div class="review-information-label"><?php esc_html_e( 'Ship to', 'woostify' ); ?></div>
						<div class="review-information-content"></div>
					</div>
					<span class="review-information-link"><?php esc_html_e( 'Change', 'woostify' ); ?></span>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_third' ) ) {
	/**
	 * Third step
	 */
	function woostify_multi_checkout_third() {
		?>
		<div class="multi-step-checkout-content" data-step="last">
			<div class="multi-step-review-information">
				<div class="multi-step-review-information-row" data-type="email">
					<div class="review-information-inner">
						<div class="review-information-label"><?php esc_html_e( 'Contact', 'woostify' ); ?></div>
						<div class="review-information-content"></div>
					</div>
					<span class="review-information-link"><?php esc_html_e( 'Change', 'woostify' ); ?></span>
				</div>

				<div class="multi-step-review-information-row" data-type="address">
					<div class="review-information-inner">
						<div class="review-information-label"><?php esc_html_e( 'Ship to', 'woostify' ); ?></div>
						<div class="review-information-content"></div>
					</div>
					<span class="review-information-link"><?php esc_html_e( 'Change', 'woostify' ); ?></span>
				</div>

				<?php if ( woostify_check_shipping_method() ) { ?>
					<div class="multi-step-review-information-row" data-type="shipping">
						<div class="review-information-inner">
							<div class="review-information-label"><?php esc_html_e( 'Method', 'woostify' ); ?></div>
							<div class="review-information-content"></div>
						</div>
						<span class="review-information-link"><?php esc_html_e( 'Change', 'woostify' ); ?></span>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_multi_checkout_button_action' ) ) {
	/**
	 * First step end
	 */
	function woostify_multi_checkout_button_action() {
		?>
			<div class="multi-step-checkout-button-wrapper">
				<span class="multi-step-checkout-button ti-angle-left" data-action="back"><?php esc_html_e( 'Back', 'woostify' ); ?></span>
				<span class="multi-step-checkout-button button" data-action="continue"><?php esc_html_e( 'Continue to shipping', 'woostify' ); ?></span>
				<span class="multi-step-checkout-button button" data-action="place_order"><?php esc_html_e( 'Place Order', 'woostify' ); ?></span>
			</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_checkout_before_order_review' ) ) {
	/**
	 * Before order review
	 */
	function woostify_checkout_before_order_review() {
		$cart = WC()->cart->get_cart();
		if ( empty( $cart ) ) {
			return;
		}

		$cart_count = sprintf( /* translators: 1: single item, 2: plural items */ _n( '%s item', '%s items', count( $cart ), 'woostify' ), count( $cart ) );
		?>

		<div class="woostify-before-order-review">
			<div class="woostify-before-order-review-summary">
				<strong><?php esc_html_e( 'Order Summary', 'woostify' ); ?></strong>
				<span class="woostify-before-order-review-cart-count">(<?php echo esc_html( $cart_count ); ?>)</span>
			</div>
			<span class="woostify-before-order-review-total-price"><?php wc_cart_totals_order_total_html(); ?></span>
			<span class="woostify-before-order-review-icon ti-angle-down"></span>
		</div>
		<?php
	}
}
