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
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 10 );
			add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

			// GENERAL.
			// Product related.
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			// Thumbnail columns.
			add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
			// Beadcrumbs.
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
			// Pagination arrow.
			add_filter( 'woocommerce_pagination_args', array( $this, 'change_woocommerce_arrow_pagination' ) );
			// Remove shop title.
			add_filter( 'woocommerce_show_page_title', array( $this, 'remove_shop_title' ) );
			// Change sale flash.
			add_filter( 'woocommerce_sale_flash', array( $this, 'change_sale_flash' ) );

			// SHOP PAGE.
			// Add url inside product title.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'add_template_loop_product_title' ), 10 );
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

			// Product loop meta open.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'loop_product_meta_open' ), 5 );
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

			// Star rating for Woo < 2.5.
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer', array( $this, 'star_rating_script' ) );
			}

			// Products per page for Woo < 3.3.
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
				add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ) );
			}
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 1.0
		 * @return void
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
			wp_enqueue_script( 'woostify-quantity-button' );
			wp_enqueue_script( 'woostify-single-add-to-cart-button' );
			wp_localize_script(
				'woostify-single-add-to-cart-button',
				'woostify_ajax',
				array(
					'url'   => admin_url( 'admin-ajax.php' ),
					'nonce' => wp_create_nonce( 'woostify_product_nonce' ),
				)
			);
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$classes[] = 'woocommerce-active';

			return $classes;
		}

		/**
		 * Star rating backwards compatibility script (WooCommerce <2.5).
		 *
		 * @since 1.6.0
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
		 * @since 1.0.0
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
		 * @since  1.0.0
		 */
		public function thumbnail_columns() {
			$columns = 4;

			if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
				$columns = 5;
			}

			return intval( apply_filters( 'woostify_product_thumbnail_columns', $columns ) );
		}

		/**
		 * Products per page
		 *
		 * @return integer number of products
		 * @since  1.0.0
		 */
		public function products_per_page() {
			return intval( apply_filters( 'woostify_products_per_page', 12 ) );
		}

		/**
		 * Remove the breadcrumb delimiter
		 *
		 * @param  array $defaults The breadcrumb defaults.
		 * @return array           The breadcrumb defaults.
		 * @since 2.2.0
		 */
		public function change_breadcrumb_delimiter( $defaults ) {
			$defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
			$defaults['wrap_before'] = '<div class="woostify-breadcrumb"><div class="container"><nav class="woocommerce-breadcrumb">';
			$defaults['wrap_after']  = '</nav></div></div>';
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
		 * Removes a shop title.
		 *
		 * @return     boolean  true or false
		 */
		public function remove_shop_title() {
			return false;
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
						$final_price = esc_attr( ( ( $price - $price_sale ) / $price ) * 100 );
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
		 * Adds a template loop product title.
		 */
		public function add_template_loop_product_title() {
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
		 * Product loop image wrapper open tag
		 */
		public function loop_product_image_wrapper_open() {
			echo '<div class="product-loop-image-wrapper">';
		}

		/**
		 * Product link open
		 */
		public function loop_product_link_open() {
			// open tag <a>.
			woocommerce_template_loop_product_link_open();
		}

		/**
		 * Product loop image
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
		 * Product loop hover image
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
		 * Product link close
		 */
		public function loop_product_link_close() {
			// close tag </a>.
			woocommerce_template_loop_product_link_close();
		}

		/**
		 * Product loop image wrapper close tag
		 */
		public function loop_product_image_wrapper_close() {
			echo '</div>';
		}

		/**
		 * Product loop meta open
		 */
		public function loop_product_meta_open() {
			echo '<div class="product-loop-meta">';
			echo '<div class="animated-meta">';
		}

		/**
		 * Product loop meta close
		 */
		public function loop_product_meta_close() {
			echo '</div></div>';
		}


		/**
		 * Product container open
		 */
		public function single_product_container_open() {
			?>
				<div class="product-page-container">
					<div class="container">
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
			$image_size = '500x500';

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
					<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" data-zoom="<?php echo esc_attr( $image_full_src[0] ); ?>">
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
							<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" data-zoom="<?php echo esc_attr( $g_full_img_src[0] ); ?>">
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
						var image_carousel = tns({
							loop: false,
							container: '#product-images',
							navContainer: '#product-thumbnail-images',
							items: 1,
							navAsThumbnails: true,
							autoHeight: true
						});

						var thumb_carousel = tns({
							loop: false,
							container: '#product-thumbnail-images',
							gutter: 10,
							items: 5,
							mouseDrag: true,
							nav: false,
							fixedWidth: 0,
							controls: false,
							axis: 'vertical'
						});

						var _prev = document.querySelector( '[data-controls=\'prev\']' ),
							_next = document.querySelector( '[data-controls=\'next\']' );

						_prev.addEventListener( 'click', function () {
							thumb_carousel.goTo( 'prev' );
						});
						_next.addEventListener( 'click', function () {
							thumb_carousel.goTo( 'next' );
						});

						var reset_slider = function(){
							image_carousel.goTo( 'first' );
							thumb_carousel.goTo( 'first' );
						}

						jQuery( document.body ).on( 'found_variation', 'form.variations_form', function( event, variation ) {
							reset_slider();
						});

						jQuery( '.reset_variations' ).on( 'click', function(){
							reset_slider();
						});
					});",
					'after'
				);
			}

			// Easyzoom.
			wp_enqueue_script( 'easyzoom' );
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
			echo '<div class="container">';
		}

		/**
		 * Container after summary close
		 */
		public function single_product_after_summary_close() {
			echo '</div>';
		}
	}

endif;

$woostify_woocommerce = new Woostify_WooCommerce();
