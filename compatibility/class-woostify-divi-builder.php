<?php
/**
 * Divi Builder File.
 *
 * @package woostify
 */

// If plugin - 'Divi Builder' not exist then return.
if ( ! class_exists( 'ET_Builder_Plugin' ) ) {
	return;
}

if ( ! class_exists( 'Woostify_Divi_Builder' ) ) {
	/**
	 * Main class
	 */
	class Woostify_Divi_Builder {
		/**
		 * Instance
		 *
		 * @var object instance
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function init() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'woostify_divi_builder_hooks' ) );
		}

		/**
		 * Hooks and filters
		 */
		public function woostify_divi_builder_hooks() {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'et_divi_builder_template_loop_product_thumbnail', 10 );
		}
	}
}

Woostify_Divi_Builder::init();
