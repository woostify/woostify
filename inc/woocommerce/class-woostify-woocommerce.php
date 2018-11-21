<?php
/**
 * Woostify WooCommerce Class
 *
 * @package  woostify
 * @since    1.0
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
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 200 );
			add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_cross_sells_columns', array( $this, 'change_cross_sells_columns' ) );

			// GENERAL.
			// Product related.
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			// Shop columns.
			add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ) );
			add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ) );
			// Beadcrumbs.
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
			// Pagination arrow.
			add_filter( 'woocommerce_pagination_args', array( $this, 'change_woocommerce_arrow_pagination' ) );
			// Change sale flash.
			add_filter( 'woocommerce_sale_flash', array( $this, 'change_sale_flash' ) );
			// Cart fragment.
			add_filter( 'add_to_cart_fragments', array( $this, 'woostify_cart_sidebar_content_fragments' ) );
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woostify_cart_total_number_fragments' ) );
			// Clear shop cart.
			add_action( 'init', array( $this, 'detect_clear_cart_submit' ) );

			// SHOP PAGE.
			// Open wrapper product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_image_wrapper_open' ), 20 );
			// Product link open.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_link_open' ), 30 );
			// Product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_image' ), 40 );
			// Product loop hover image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_hover_image' ), 50 );
			// Product link close.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_link_close' ), 60 );
			// Close wrapper product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_image_wrapper_close' ), 70 );

			// Add product category.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'add_template_loop_product_category' ), 5 );
			// Add url inside product title.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'add_template_loop_product_title' ), 10 );

			// Product rating.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'loop_product_rating' ), 2 );

			// Product loop meta open.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'loop_product_meta_open' ), 5 );

			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'loop_product_price' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'loop_product_add_to_cart_button' ), 15 );
			// Product loop meta close.
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'loop_product_meta_close' ), 20 );

			// PRODUCT PAGE.
			// Product container open.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_container_open' ), 10 );
			// Product gallery open.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_gallery_open' ), 20 );
			// Product gallery image slider.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_gallery_image_slide' ), 30 );
			// Product gallery thumbnail slider.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_gallery_thumb_slide' ), 40 );
			// Product gallery close.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_gallery_close' ), 50 );
			// Product galley script and style.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_gallery_dependency' ), 100 );
			// Product container close.
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'single_product_container_close' ), 5 );
			// Container after summary.
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'single_product_after_summary_open' ), 8 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'single_product_after_summary_close' ), 100 );

			// Removed on cart action.
			add_action( 'wp_ajax_get_product_item_incart', array( $this, 'woostify_get_product_item_incart' ) );
			add_action( 'wp_ajax_nopriv_get_product_item_incart', array( $this, 'woostify_get_product_item_incart' ) );

			// CART PAGE.
			add_action( 'woocommerce_after_cart_table', array( $this, 'clear_shop_cart' ) );

			// Star rating for Woo < 2.5.
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer', array( $this, 'star_rating_script' ) );
			}
		}

		/**
		 * Theme options
		 *
		 * @return array $options All theme options
		 */
		public function options() {
			$options = woostify_options( false );
			return $options;
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 */
		public function setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'woostify_woocommerce_args',
					array(
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 4,
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
			$options = self::options();

			// Main woocommerce js file.
			wp_enqueue_script( 'woostify-woocommerce' );

			// Product variations.
			wp_enqueue_script( 'woostify-product-variation' );

			// Quantity button.
			wp_enqueue_script( 'woostify-quantity-button' );

			// Add to cart variation.
			if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) && ! wp_script_is( 'wc-add-to-cart-variation', 'enqueued' ) ) {
				wp_enqueue_script( 'wc-add-to-cart-variation' );
			}
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$classes[] = 'woocommerce-active';

			// Product page.
			if ( is_singular( 'product' ) ) {

				// Product gallery.
				$page_id = get_queried_object_id();
				$product = wc_get_product( $page_id );
				$gallery = $product->get_gallery_image_ids();

				if ( $gallery ) {
					$classes[] = 'has-product-gallery';
				}
			}

			return $classes;
		}


		/**
		 * Change cross sell column
		 *
		 * @param      int $columns  The columns.
		 */
		public function change_cross_sells_columns( $columns ) {
			return 3;
		}

		/**
		 * Star rating backwards compatibility script (WooCommerce <2.5).
		 */
		public function star_rating_script() {
			if ( is_product() ) {
				?>
			<script type="text/javascript">
				var starsEl = document.querySelector( '#respond p.stars' );

				if ( starsEl ) {
					starsEl.addEventListener( 'click', function( event ) {
						if ( 'A' === event.target.tagName ) {
							starsEl.classList.add( 'selected' );
						}
					} );
				}
			</script>
				<?php
			}
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @return  array $args related products args
		 */
		public function related_products_args( $args ) {
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
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns
		 */
		public function shop_columns() {
			$options = self::options();
			$columns = $options['shop_columns'];

			return absint( apply_filters( 'woostify_shop_columns', $columns ) );
		}

		/**
		 * Products per page
		 *
		 * @return integer number of products
		 */
		public function products_per_page() {
			$options  = self::options();
			$per_page = $options['shop_product_per_page'];

			return absint( apply_filters( 'woostify_shop_products_per_page', $per_page ) );
		}

		/**
		 * Remove the breadcrumb delimiter
		 *
		 * @param  array $defaults The breadcrumb defaults.
		 * @return array           The breadcrumb defaults.
		 */
		public function change_breadcrumb_delimiter( $defaults ) {
			$defaults['delimiter'] = '<span class="breadcrumb-separator"> / </span>';
			$container             = woostify_site_container();

			if ( is_singular( 'product' ) ) {
				$defaults['wrap_before'] = '<div class="wc-breadcrumb breadcrumb"><div class="' . esc_attr( $container ) . '"><nav class="woostify-breadcrumb">';
				$defaults['wrap_after']  = '</nav></div></div>';
			} else {
				$defaults['wrap_before'] = '<div class="wc-breadcrumb breadcrumb"><nav class="woostify-breadcrumb">';
				$defaults['wrap_after']  = '</nav></div>';
			}

			return $defaults;
		}

		/**
		 * Change arrow for pagination
		 *
		 * @param array $args Woocommerce pagination.
		 */
		public function change_woocommerce_arrow_pagination( $args ) {
			$args['prev_text'] = __( 'Prev', 'woostify' );
			$args['next_text'] = __( 'Next', 'woostify' );
			return $args;
		}

		/**
		 * Change sale flash
		 */
		public function change_sale_flash() {
			global $product;

			$sale       = $product->is_on_sale();
			$price_sale = $product->get_sale_price();
			$price      = $product->get_regular_price();
			$simple     = $product->is_type( 'simple' );

			if ( $sale ) {
				?>
				<span class="onsale">
					<?php
					if ( $simple ) {
						$final_price = esc_html( ( ( $price - $price_sale ) / $price ) * 100 );
						echo '-' . round( $final_price ) . '%'; // WPCS: XSS ok.
					} else {
						esc_html_e( 'Sale!', 'woostify' );
					}
					?>
				</span>
				<?php
			}
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
		public function detect_clear_cart_submit() {
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
		public function add_template_loop_product_category() {
			$options = self::options();
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
		public function loop_product_rating() {
			$options = self::options();
			if ( false == $options['shop_page_product_rating'] ) {
				return;
			}

			global $product;
			echo wc_get_rating_html( $product->get_average_rating() ); // WPCS: XSS OK.
		}

		/**
		 * Loop product title.
		 */
		public function add_template_loop_product_title() {
			$options = self::options();
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
		public function loop_product_image_wrapper_open() {
			echo '<div class="product-loop-image-wrapper">';
		}

		/**
		 * Loop product link open
		 */
		public function loop_product_link_open() {
			// open tag <a>.
			woocommerce_template_loop_product_link_open();
		}

		/**
		 * Loop product image
		 */
		public function loop_product_image() {
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
		public function loop_product_hover_image() {
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
		public function loop_product_link_close() {
			// close tag </a>.
			woocommerce_template_loop_product_link_close();
		}

		/**
		 * Loop product image wrapper close tag
		 */
		public function loop_product_image_wrapper_close() {
			echo '</div>';
		}

		/**
		 * Loop product meta open
		 */
		public function loop_product_meta_open() {
			$options = self::options();

			$condi = apply_filters( 'woostify_product_loop_add_to_cart_animate', true );

			$class = (
				false == $options['shop_page_product_price'] ||
				false == $options['shop_page_product_add_to_cart_button'] ||
				false == $condi
			) ? 'no-transform' : '';

			echo '<div class="product-loop-meta ' . esc_attr( $class ) . '">';
			echo '<div class="animated-meta">';
		}

		/**
		 * Loop product price
		 */
		public function loop_product_price() {
			$options = self::options();
			if ( false == $options['shop_page_product_price'] ) {
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
		public function loop_product_add_to_cart_button() {
			$options = self::options();
			if ( false == $options['shop_page_product_add_to_cart_button'] ) {
				return;
			}

			$args = woostify_modify_loop_add_to_cart_class();
			woocommerce_template_loop_add_to_cart( $args );
		}

		/**
		 * Loop product meta close
		 */
		public function loop_product_meta_close() {
			echo '</div></div>';
		}


		/**
		 * Product container open
		 */
		public function single_product_container_open() {
			$container = woostify_site_container();
			?>
				<div class="product-page-container">
					<div class="<?php echo esc_attr( $container ); ?>">
			<?php
		}

		/**
		 * Single gallery product open
		 */
		public function single_product_gallery_open() {
			?>
			<div class="product-gallery">
			<?php
		}


		/**
		 * Product gallery product image slider
		 */
		public function single_product_gallery_image_slide() {
			global $product;
			$image_id   = $product->get_image_id();
			$image_alt  = woostify_image_alt( $image_id, esc_attr__( 'Product image', 'woostify' ) );
			$get_size   = wc_get_image_size( 'shop_catalog' );
			$image_size = $get_size['width'] . 'x' . ( ! empty( $get_size['height'] ) ? $get_size['height'] : $get_size['width'] );

			if ( $image_id ) {
				$image_small_src  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
				$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
				$image_size       = $image_medium_src[1] . 'x' . $image_medium_src[2];
			} else {
				$image_small_src[0]  = wc_placeholder_img_src();
				$image_medium_src[0] = wc_placeholder_img_src();
				$image_full_src[0]   = wc_placeholder_img_src();
			}

			$gallery_id = $product->get_gallery_image_ids();
			?>
			<div class="product-images">
				<div id="product-images" itemscope itemtype="http://schema.org/ImageGallery">
					<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
						<a href="<?php echo esc_url( $image_full_src[0] ); ?>" data-size="<?php echo esc_attr( $image_size ); ?>" itemprop="contentUrl">
							<img src="<?php echo esc_url( $image_medium_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" itemprop="thumbnail">
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
							<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
								<a href="<?php echo esc_url( $g_full_img_src[0] ); ?>" data-size="<?php echo esc_attr( $g_image_size ); ?>" itemprop="contentUrl">
									<img src="<?php echo esc_url( $g_medium_img_src[0] ); ?>" alt="<?php echo esc_attr( $g_img_alt ); ?>" itemprop="thumbnail">
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
		public function single_product_gallery_thumb_slide() {
			global $product;
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

			if ( ! empty( $gallery_id ) ) {
				?>
				<div class="product-thumbnail-images">
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
				</div>
				<?php
			}
		}


		/**
		 * Single gallery product gallery script and style dependency
		 */
		public function single_product_gallery_dependency() {
			global $product;
			$gallery_id = $product->get_gallery_image_ids();

			// Tiny slider.
			if ( ! empty( $gallery_id ) ) {
				wp_enqueue_script( 'tiny-slider' );
				wp_add_inline_script(
					'tiny-slider',
					"document.addEventListener( 'DOMContentLoaded', function(){
						var imageCarousel = tns({
							loop: false,
							container: '#product-images',
							navContainer: '#product-thumbnail-images',
							items: 1,
							navAsThumbnails: true,
							autoHeight: true
						});

						var options = {
							loop: false,
							container: '#product-thumbnail-images',
							gutter: 10,
							items: 5,
							mouseDrag: true,
							nav: false,
							controls: false,
							axis: 'vertical'
						}

						if ( window.matchMedia( '( min-width: 768px )' ).matches ) {
							var thumbCarousel = tns( options );
						} else {
							var thumbCarousel = tns({
								loop: false,
								container: '#product-thumbnail-images',
								fixedWidth: 80,
								items: 4,
								mouseDrag: true,
								nav: false,
								controls: false,
							});
						}

						var resetSlider = function(){
							imageCarousel.goTo( 'first' );
							thumbCarousel.goTo( 'first' );
						}

						jQuery( document.body ).on( 'found_variation', 'form.variations_form', function( event, variation ) {
							resetSlider();
						});

						jQuery( '.reset_variations' ).on( 'click', function(){
							resetSlider();
						});
					});",
					'after'
				);
			}

			// Easyzoom.
			wp_enqueue_script( 'easyzoom' );
			wp_enqueue_script( 'easyzoom-handle' );
			wp_add_inline_script(
				'easyzoom',
				"document.addEventListener( 'DOMContentLoaded', function(){
					if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
						jQuery( '.ez-zoom' ).easyZoom();
					}
				} );",
				'after'
			);

			// Photoswipe.
			wp_enqueue_script( 'photoswipe' );
			wp_enqueue_script( 'photoswipe-ui-default' );
			wp_enqueue_script( 'photoswipe-init' );

			// Photoswipe markup html.
			?>
			<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

				<!-- Background of PhotoSwipe. 
					 It's a separate element, as animating opacity is faster than rgba(). -->
				<div class="pswp__bg"></div>

				<!-- Slides wrapper with overflow:hidden. -->
				<div class="pswp__scroll-wrap">

					<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
					<!-- don't modify these 3 pswp__item elements, data is added later on. -->
					<div class="pswp__container">
						<div class="pswp__item"></div>
						<div class="pswp__item"></div>
						<div class="pswp__item"></div>
					</div>

					<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
					<div class="pswp__ui pswp__ui--hidden">

						<div class="pswp__top-bar">

							<!--  Controls are self-explanatory. Order can be changed. -->

							<div class="pswp__counter"></div>

							<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

							<button class="pswp__button pswp__button--share" title="Share"></button>

							<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

							<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

							<!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
							<!-- element will get class pswp__preloader--active when preloader is running -->
							<div class="pswp__preloader">
								<div class="pswp__preloader__icn">
									<div class="pswp__preloader__cut">
										<div class="pswp__preloader__donut"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
							<div class="pswp__share-tooltip"></div> 
						</div>

						<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
						</button>

						<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
						</button>

						<div class="pswp__caption">
							<div class="pswp__caption__center"></div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}


		/**
		 * Single product gallery close
		 */
		public function single_product_gallery_close() {
			echo '</div>';
		}

		/**
		 * Product container close.
		 */
		public function single_product_container_close() {
			?>
				</div>
			</div>
			<?php
		}

		/**
		 * Container after summary open
		 */
		public function single_product_after_summary_open() {
			$container = woostify_site_container();
			echo '<div class="' . esc_attr( $container ) . '">';
		}

		/**
		 * Container after summary close
		 */
		public function single_product_after_summary_close() {
			echo '</div>';
		}

		/**
		 * Get product item in cart
		 */
		public function woostify_get_product_item_incart() {
			$response = array(
				'item' => 0,
			);

			if ( ! isset( $_POST['product_id'] )
				|| ! isset( $_POST['nonce'] )
				|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'woostify_product_nonce' )
			) {
				echo json_encode( $response );
				exit();
			}

			$product_id = intval( $_POST['product_id'] );
			$item       = woostify_product_check_in( $product_id, $in_cart = false, $qty_in_cart = true );

			ob_start();

			$response['item'] = $item;

			ob_get_clean();

			echo json_encode( $response );
			exit();
		}

		/**
		 * Add clear shop cart button
		 */
		public function clear_shop_cart() {
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

endif;

$woostify_woocommerce = new Woostify_WooCommerce();
