<?php
/**
 * Woostify Jetpack Class
 *
 * @package  woostify
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woostify_Jetpack' ) ) :

	/**
	 * The Woostify Jetpack integration class
	 */
	class Woostify_Jetpack {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'jetpack_setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'jetpack_scripts' ), 10 );

			if ( woostify_is_woocommerce_activated() ) {
				add_action( 'init', array( $this, 'jetpack_infinite_scroll_wrapper_columns' ) );
			}
		}

		/**
		 * Add theme support for Infinite Scroll.
		 * See: http://jetpack.me/support/infinite-scroll/
		 */
		public function jetpack_setup() {
			add_theme_support(
				'infinite-scroll', apply_filters(
					'woostify_jetpack_infinite_scroll_args', array(
						'container'      => 'main',
						'footer'         => 'page',
						'render'         => array( $this, 'jetpack_infinite_scroll_loop' ),
						'footer_widgets' => array(
							'footer',
						),
					)
				)
			);
		}

		/**
		 * A loop used to display content appended using Jetpack infinite scroll
		 *
		 * @return void
		 */
		public function jetpack_infinite_scroll_loop() {
			do_action( 'woostify_jetpack_infinite_scroll_before' );

			if ( woostify_is_product_archive() ) {
				do_action( 'woostify_jetpack_product_infinite_scroll_before' );
				woocommerce_product_loop_start();
			}

			while ( have_posts() ) :
				the_post();
				if ( woostify_is_product_archive() ) {
					wc_get_template_part( 'content', 'product' );
				} else {
					get_template_part( 'template-parts/content', get_post_format() );
				}
			endwhile; // end of the loop.

			if ( woostify_is_product_archive() ) {
				woocommerce_product_loop_end();
				do_action( 'woostify_jetpack_product_infinite_scroll_after' );
			}

			do_action( 'woostify_jetpack_infinite_scroll_after' );
		}

		/**
		 * Adds columns wrapper to content appended by Jetpack infinite scroll
		 *
		 * @return void
		 */
		public function jetpack_infinite_scroll_wrapper_columns() {
			add_action( 'woostify_jetpack_product_infinite_scroll_before', 'woostify_product_columns_wrapper' );
			add_action( 'woostify_jetpack_product_infinite_scroll_after', 'woostify_product_columns_wrapper_close' );
		}

		/**
		 * Enqueue jetpack styles.
		 *
		 * @since  1.6.1
		 */
		public function jetpack_scripts() {
			global $woostify_version;

			wp_enqueue_style( 'woostify-jetpack-style', get_template_directory_uri() . '/assets/css/jetpack/jetpack.css', '', $woostify_version );
			wp_style_add_data( 'woostify-jetpack-style', 'rtl', 'replace' );
		}
	}

endif;

return new Woostify_Jetpack();
