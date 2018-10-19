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

if ( ! function_exists( 'woostify_product_slider' ) ) {
	/**
	 * Shortcode product slider
	 *
	 * @param array|string $args User defined attributes for this shortcode instance.
	 * @param string|null  $content Content between the opening and closing shortcode elements.
	 * @param string       $shortcode_name Name of the shortcode.
	 */
	function woostify_product_slider( $args, $content, $shortcode_name ) {
		$attrs = shortcode_atts(
			array(
				'posts_per_page'      => 3,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'orderby'             => 'id',
				'order'               => 'ASC',
			),
			$args,
			$shortcode_name
		);

		$attrs['post_type'] = 'product';

		// Ids.
		if ( ! empty( $attrs['ids'] ) ) {
			$ids = array_map( 'trim', explode( ',', $attrs['ids'] ) );

			if ( 1 === count( $ids ) ) {
				$attrs['p'] = $ids[0];
			} else {
				$attrs['post__in'] = $ids;
			}
		}

		// SKU.
		if ( ! empty( $attrs['sku'] ) ) {
			$skus                       = array_map( 'trim', explode( ',', $attrs['skus'] ) );
			$attrs['meta_query'] = array(
				'key'     => '_sku',
				'value'   => 1 === count( $skus ) ? $skus[0] : $skus,
				'compare' => 1 === count( $skus ) ? '=' : 'IN',
			);
		}

		// Category.
		if ( ! empty( $attrs['category'] ) ) {
			$categories = array_map( 'sanitize_title', explode( ',', $attrs['category'] ) );
			$field      = 'slug';

			if ( is_numeric( $categories[0] ) ) {
				$categories = array_map( 'absint', $categories );
				$field      = 'term_id';
			}

			$attrs['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'terms'    => $categories,
				'field'    => $field,
				'operator' => $attrs['cat_operator'],
			);
		}

		ob_start();

		// Query.
		$query = new WP_Query( $attrs );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				echo get_the_title() . '<br>';
			}
		}

		wp_reset_postdata();

		return ob_get_clean();
	}
}
