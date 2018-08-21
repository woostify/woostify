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

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer', array( $this, 'star_rating_script' ) );
			}

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
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$classes[] = 'woocommerce-active';

			// Remove `no-wc-breadcrumb` body class.
			$key = array_search( 'no-wc-breadcrumb', $classes );

			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}

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
	}

endif;

$woostify_woocommerce = new Woostify_WooCommerce();
