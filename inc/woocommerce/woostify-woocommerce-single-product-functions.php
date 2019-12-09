<?php
/**
 * Single Product template functions
 *
 * @package woostify
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'woostify_remove_additional_information_tabs' ) ) {
	/**
	 * Remove additional informaltion
	 *
	 * @param      array $tabs The tabs.
	 */
	function woostify_remove_additional_information_tabs( $tabs ) {
		unset( $tabs['additional_information'] );
		return $tabs;
	}
}

if ( ! function_exists( 'woostify_single_product_container_open' ) ) {
	/**
	 * Product container open
	 */
	function woostify_single_product_container_open() {
		$container = woostify_site_container();
		?>
			<div class="product-page-container">
				<div class="<?php echo esc_attr( $container ); ?>">
		<?php
	}
}

if ( ! function_exists( 'woostify_single_product_gallery_open' ) ) {
	/**
	 * Single gallery product open
	 */
	function woostify_single_product_gallery_open() {
		global $product;

		if ( ! is_object( $product ) ) {
			$id = woostify_get_last_product_id();
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
		woostify_global_for_vartiation_gallery( $product );
		?>
		<div class="product-gallery <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php
	}
}

if ( ! function_exists( 'woostify_get_default_gallery' ) ) {
	/**
	 * Get variation gallery
	 *
	 * @param object $product The product.
	 */
	function woostify_get_default_gallery( $product ) {
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
}

if ( ! function_exists( 'woostify_available_variation_gallery' ) ) {
	/**
	 * Available Gallery
	 *
	 * @param array  $available_variation Avaiable Variations.
	 * @param object $variation_product_object Product object.
	 * @param array  $variation Variations.
	 */
	function woostify_available_variation_gallery( $available_variation, $variation_product_object, $variation ) {
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
}

if ( ! function_exists( 'woostify_get_variation_gallery' ) ) {
	/**
	 * Get variation gallery
	 *
	 * @param object $product The product.
	 */
	function woostify_get_variation_gallery( $product ) {
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
}

if ( ! function_exists( 'woostify_global_for_vartiation_gallery' ) ) {
	/**
	 * Add global variation
	 *
	 * @param object $product The Product.
	 */
	function woostify_global_for_vartiation_gallery( $product ) {

		// Woostify Variation gallery.
		wp_localize_script(
			'woostify-product-variation',
			'woostify_variation_gallery',
			woostify_get_variation_gallery( $product )
		);

		// Woostify default gallery.
		wp_localize_script(
			'woostify-product-variation',
			'woostify_default_gallery',
			woostify_get_default_gallery( $product )
		);
	}
}

if ( ! function_exists( 'woostify_single_product_gallery_image_slide' ) ) {
	/**
	 * Product gallery product image slider
	 */
	function woostify_single_product_gallery_image_slide() {
		global $product;

		if ( ! is_object( $product ) ) {
			$id = woostify_get_last_product_id();
			if ( ! $id ) {
				return;
			}

			$product = wc_get_product( $id );
		}

		$product_id          = $product->get_id();
		$image_id            = $product->get_image_id();
		$image_alt           = woostify_image_alt( $image_id, esc_attr__( 'Product image', 'woostify' ) );
		$get_size            = wc_get_image_size( 'shop_catalog' );
		$image_size          = $get_size['width'] . 'x' . ( ! empty( $get_size['height'] ) ? $get_size['height'] : $get_size['width'] );
		$image_medium_src[0] = wc_placeholder_img_src();
		$image_full_src[0]   = wc_placeholder_img_src();
		$image_srcset        = '';


		if ( $image_id ) {
			$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
			$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
			$image_size       = $image_full_src[1] . 'x' . $image_full_src[2];
			$image_srcset    = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $image_id, 'woocommerce_single' ) : '';
		}

		$gallery_id = $product->get_gallery_image_ids();
		?>

		<div class="product-images">
			<div id="product-images">
				<figure class="image-item ez-zoom">
					<a href="<?php echo esc_url( $image_full_src[0] ); ?>" data-size="<?php echo esc_attr( $image_size ); ?>" data-elementor-open-lightbox="no">
						<img src="<?php echo esc_url( $image_medium_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" srcset="<?php echo wp_kses_post( $image_srcset ); ?>">
					</a>
				</figure>
				<?php

				if ( ! empty( $gallery_id ) ) {
					foreach ( $gallery_id as $key ) {
						$g_full_img_src   = wp_get_attachment_image_src( $key, 'full' );
						$g_medium_img_src = wp_get_attachment_image_src( $key, 'woocommerce_single' );
						$g_image_size     = $g_full_img_src[1] . 'x' . $g_full_img_src[2];
						$g_img_alt        = woostify_image_alt( $key, esc_attr__( 'Product image', 'woostify' ) );
						$g_img_srcset     = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $key, 'woocommerce_single' ) : '';
						?>
						<figure class="image-item ez-zoom">
							<a href="<?php echo esc_url( $g_full_img_src[0] ); ?>" data-size="<?php echo esc_attr( $g_image_size ); ?>" data-elementor-open-lightbox="no">
								<img src="<?php echo esc_url( $g_medium_img_src[0] ); ?>" alt="<?php echo esc_attr( $g_img_alt ); ?>" srcset="<?php echo wp_kses_post( $g_img_srcset ); ?>">
							</a>
						</figure>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_single_product_gallery_thumb_slide' ) ) {
	/**
	 * Product gallery product thumbnail slider
	 */
	function woostify_single_product_gallery_thumb_slide() {
		$options = woostify_options( false );
		if ( ! in_array( $options['shop_single_gallery_layout'], [ 'vertical', 'horizontal' ] ) ) {
			return;
		}

		global $product;
		if ( ! is_object( $product ) ) {
			$id = woostify_get_last_product_id();
			if ( ! $id ) {
				return;
			}

			$product = wc_get_product( $id );
		}

		$image_id        = $product->get_image_id();
		$image_alt       = woostify_image_alt( $image_id, esc_attr__( 'Product image', 'woostify' ) );
		$image_small_src = $image_id ? wp_get_attachment_image_src( $image_id, 'thumbnail' ) : wc_placeholder_img_src();
		$gallery_id      = $product->get_gallery_image_ids();
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
}

if ( ! function_exists( 'woostify_single_product_gallery_dependency' ) ) {
	/**
	 * Single gallery product gallery script and style dependency
	 */
	function woostify_single_product_gallery_dependency() {
		$options = woostify_options( false );
		if ( ! $options['shop_single_image_lightbox'] ) {
			return;
		}

		// Photoswipe markup html.
		get_template_part( 'template-parts/content', 'photoswipe' );
	}
}

if ( ! function_exists( 'woostify_single_product_gallery_close' ) ) {
	/**
	 * Single product gallery close
	 */
	function woostify_single_product_gallery_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_single_product_container_close' ) ) {
	/**
	 * Product container close.
	 */
	function woostify_single_product_container_close() {
		?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_single_product_after_summary_open' ) ) {
	/**
	 * Container after summary open
	 */
	function woostify_single_product_after_summary_open() {
		$container = woostify_site_container();
		echo '<div class="' . esc_attr( $container ) . '">';
	}
}

if ( ! function_exists( 'woostify_single_product_after_summary_close' ) ) {
	/**
	 * Container after summary close
	 */
	function woostify_single_product_after_summary_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'woostify_product_info' ) ) {
	/**
	 * Product info
	 */
	function woostify_product_info() {
		global $product;
		$pid = $product->get_id();

		// Return `yes` || `no`.
		$in_stock = get_post_meta( $pid, '_manage_stock', true );

		// Return INT value.
		$stock_qty = $product->get_stock_quantity();

		/*CHECK PRODUCT IN CART && CHECK QUANTITY IF IT ALREADY IN CART*/
		$in_cart_qty  = woostify_product_check_in( $pid, $in_cart = true, $qty_in_cart = false ) ? woostify_product_check_in( $pid, $in_cart = false, $qty_in_cart = true ) : 0;
		$not_enough   = __( 'You cannot add that amount of this product to the cart because there is not enough stock.', 'woostify' );

		/* translators: %1$d: stock quantity */
		$out_stock    = sprintf( __( 'You cannot add that amount to the cart - we have %1$d in stock and you already have %1$d in your cart', 'woostify' ), $stock_qty );
		$valid_qty    = __( 'Please enter a valid quantity for this product', 'woostify' );
		?>

		<input class="additional-product" type="hidden" value="<?php echo esc_attr( $in_cart_qty ); ?>"
			data-in_stock="<?php echo esc_attr( $in_stock ); ?>"
			data-out_of_stock="<?php echo esc_attr( $out_stock ); ?>"
			data-valid_quantity="<?php echo esc_attr( $valid_qty ); ?>"
			data-not_enough="<?php echo esc_attr( $not_enough ); ?>">
		<?php
	}
}

if ( ! function_exists( 'woostify_trust_badge_image' ) ) {
	/**
	 * Trust badge image
	 */
	function woostify_trust_badge_image() {
		$options   = woostify_options( false );
		$image_url = $options['shop_single_trust_badge_image'];

		if ( ! $image_url ) {
			return;
		}
		?>
		<div class="woostify-trust-badge-box">
			<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_attr_e( 'Trust Badge Image', 'woostify' ); ?>">
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_product_recently_viewed' ) ) {
	/**
	 * Product recently viewed
	 */
	function woostify_product_recently_viewed() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		global $post;
		$options         = woostify_options( false );
		$viewed_products = [];

		if ( ! empty( $_COOKIE['woostify_product_recently_viewed'] ) ) {
			$viewed_products = (array) explode( '|', $_COOKIE['woostify_product_recently_viewed'] );
		}

		if ( ! in_array( $post->ID, $viewed_products ) ) {
			$viewed_products[] = $post->ID;
		}

		if ( sizeof( $viewed_products ) > $options['shop_single_recently_viewed_count'] ) {
			array_shift( $viewed_products );
		}

		// Store for session only.
		wc_setcookie( 'woostify_product_recently_viewed', implode( '|', array_filter( $viewed_products ) ) );
	}
}

if ( ! function_exists( 'woostify_product_recently_viewed_template' ) ) {
	/**
	 * Display product recently viewed
	 */
	function woostify_product_recently_viewed_template() {
		$options = woostify_options( false );
		$cookies = isset( $_COOKIE['woostify_product_recently_viewed'] ) ? $_COOKIE['woostify_product_recently_viewed'] : false;
		if ( ! $cookies || ! $options['shop_single_product_recently_viewed'] || ! is_singular( 'product' ) ) {
			return;
		}

		$ids       = explode( '|', $cookies );
		$container = woostify_site_container();
		$args      = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'post__in'       => $ids,
		];

		$products_query = new WP_Query( $args );
		if ( ! $products_query->have_posts() ) {
			return;
		}
		?>

		<div class="woostify-product-recently-viewed-section">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="woostify-product-recently-viewed-inner">
					<h2 class="woostify-product-recently-viewed-title"><?php echo esc_html( $options['shop_single_recently_viewed_title'] ); ?></h2>
					<?php
						global $woocommerce_loop;
						woocommerce_product_loop_start();

						while ( $products_query->have_posts() ) :
							$products_query->the_post();

							wc_get_template_part( 'content', 'product' );
						endwhile;

						woocommerce_product_loop_end();
					?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woostify_ajax_single_add_to_cart' ) ) {
	/**
	 * Ajax single add to cart
	 */
	function woostify_ajax_single_add_to_cart() {
		check_ajax_referer( 'woostify_ajax_single_add_to_cart', 'ajax_nonce', false );

		$response = [];

		if ( ! isset( $_POST['product_id'] ) || ! isset( $_POST['product_qty'] ) ) {
			wp_send_json_error();
		}

		global $woocommerce;

		$product_id        = absint( $_POST['product_id'] );
		$product_qty       = absint( $_POST['product_qty'] );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $product_qty );

		if ( isset( $_POST['variation_id'] ) ) {
			$variation_id = absint( $_POST['variation_id'] );
		}

		if ( isset( $_POST['variations'] ) ) {
			$variations = (array) json_decode( sanitize_text_field( wp_unslash( $_POST['variations'] ) ), true );
		}

		if ( $variation_id && $passed_validation ) {
			WC()->cart->add_to_cart( $product_id, $product_qty, $variation_id, $variations );
		} else {
			WC()->cart->add_to_cart( $product_id, $product_qty );
		}

		$count = WC()->cart->get_cart_contents_count();

		ob_start();
		woocommerce_mini_cart();
		$response['item']    = $count;
		$response['total']   = $woocommerce->cart->get_cart_total();
		$response['content'] = ob_get_clean();

		wp_send_json( $response );
	}
}
