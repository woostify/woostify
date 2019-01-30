<?php
/**
 * Woostify NUX Admin Class
 *
 * @package  woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woostify_NUX_Admin' ) ) :

	/**
	 * The Woostify NUX Admin class
	 */
	class Woostify_NUX_Admin {
		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'woostify_enqueue_scripts' ) );
			add_action( 'wp_ajax_woostify_dismiss_notice', array( $this, 'woostify_dismiss_nux' ) );
			add_action( 'admin_post_woostify_starter_content', array( $this, 'woostify_redirect_customizer' ) );
			add_action( 'init', array( $this, 'woostify_log_fresh_site_state' ) );
			add_filter( 'admin_body_class', array( $this, 'woostify_admin_body_class' ) );
		}

		/**
		 * Enqueue scripts.
		 */
		public function woostify_enqueue_scripts() {
			global $wp_customize;

			if ( isset( $wp_customize ) || true === (bool) get_option( 'woostify_nux_dismissed' ) ) {
				return;
			}

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style(
				'woostify-admin-nux',
				WOOSTIFY_THEME_URI . 'assets/css/admin/admin.css',
				'',
				woostify_version()
			);

			wp_enqueue_script(
				'woostify-admin-nux',
				WOOSTIFY_THEME_URI . 'assets/js/admin/admin' . $suffix . '.js',
				array( 'jquery' ),
				woostify_version(),
				true
			);

			$woostify_nux = array(
				'nonce' => wp_create_nonce( 'woostify_notice_dismiss' ),
			);

			wp_localize_script(
				'woostify-admin-nux',
				'woostifyNUX',
				$woostify_nux
			);
		}

		/**
		 * Output admin notices.
		 */
		public function woostify_admin_notices() {
			global $pagenow;

			if ( true === (bool) get_option( 'woostify_nux_dismissed' ) ) {
				return;
			}

			// Coming from the WooCommerce Wizard?
			if (
				wp_get_referer() &&
				'index.php?page=wc-setup&step=next_steps' === basename( wp_get_referer() ) &&
				'post-new.php' === $pagenow
			) {
				return;
			}
			?>

			<div class="notice notice-info woostify-notice-nux is-dismissible">
				<div class="woostify-icon">
					<span class="dashicons dashicons-store"></span>
				</div>

				<div class="notice-content">
				<?php if ( ! woostify_is_woocommerce_activated() && current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) : ?>
					<h2><?php esc_html_e( 'Thanks for installing Woostify, you rock! 🤘', 'woostify' ); ?></h2>
					<p><?php esc_html_e( 'To enable eCommerce features you need to install the WooCommerce plugin.', 'woostify' ); ?></p>
					<p><?php Woostify_Plugin_Install::install_plugin_button( 'woocommerce', 'woocommerce.php', 'WooCommerce', array( 'woostify-nux-button' ), __( 'WooCommerce activated', 'woostify' ), __( 'Activate WooCommerce', 'woostify' ), __( 'Install WooCommerce', 'woostify' ) ); ?></p>
				<?php endif; ?>

				<?php if ( woostify_is_woocommerce_activated() ) : ?>
					<h2><?php esc_html_e( 'Design your store 🎨', 'woostify' ); ?></h2>
					<p>
					<?php
					if ( true === (bool) get_option( 'woostify_nux_fresh_site' ) && 'post-new.php' === $pagenow ) {
						esc_html_e( 'Before you add your first product let\'s design your store. We\'ll add some example products for you. When you\'re ready let\'s get started by adding your logo.', 'woostify' );
					} else {
						esc_html_e( 'You\'ve set up WooCommerce, now it\'s time to give it some style! Let\'s get started by entering the Customizer and adding your logo.', 'woostify' );
					}
					?>
					</p>

					<a class="woostify-nux-button" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bcontrol%5D=custom_logo' ); ?>">
						<?php esc_html_e( 'Let\'s go!', 'woostify' ); ?>
					</a>
				<?php endif; ?>
				</div>
			</div>
			<?php
		}

		/**
		 * AJAX dismiss notice.
		 */
		public function woostify_dismiss_nux() {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['nonce'] ) ), 'woostify_notice_dismiss' ) || ! current_user_can( 'manage_options' ) ) {
				die();
			}

			update_option( 'woostify_nux_dismissed', true );
		}

		/**
		 * Redirects to the customizer with the correct variables.
		 */
		public function woostify_redirect_customizer() {
			check_admin_referer( 'woostify_starter_content' );

			if ( current_user_can( 'manage_options' ) ) {

				// Dismiss notice.
				update_option( 'woostify_nux_dismissed', true );
			}

			$args = array( 'woostify_starter_content' => '1' );

			$tasks = array();

			if ( ! empty( $_REQUEST['homepage'] ) && 'on' === $_REQUEST['homepage'] ) {
				if ( current_user_can( 'edit_pages' ) && 'page' === get_option( 'show_on_front' ) ) {
					$this->_assign_page_template( get_option( 'page_on_front' ), 'template-homepage.php' );
				} else {
					$tasks[] = 'homepage';
				}
			}

			if ( ! empty( $_REQUEST['products'] ) && 'on' === $_REQUEST['products'] ) {
				$tasks[] = 'products';
			}

			if ( ! empty( $tasks ) ) {
				$args['woostify_tasks'] = implode( ',', $tasks );

				if ( current_user_can( 'manage_options' ) ) {

					// Make sure the fresh_site flag is set to true.
					update_option( 'fresh_site', true );

					if ( current_user_can( 'edit_pages' ) && true === (bool) get_option( 'woostify_nux_fresh_site' ) ) {
						$this->_set_woocommerce_pages_full_width();
					}
				}
			}

			// Redirect to the Woostify Welcome screen when exiting the Customizer.
			$args['return'] = urlencode( admin_url( 'themes.php?page=woostify-welcome' ) );

			wp_safe_redirect( add_query_arg( $args, admin_url( 'customize.php' ) ) );

			die();
		}

		/**
		 * Get WooCommerce page ids.
		 */
		public static function woostify_get_woocommerce_pages() {
			$woocommerce_pages = array();

			$wc_pages_options = apply_filters(
				'woostify_page_option_names', array(
					'woocommerce_cart_page_id',
					'woocommerce_checkout_page_id',
					'woocommerce_myaccount_page_id',
					'woocommerce_shop_page_id',
					'woocommerce_terms_page_id',
				)
			);

			foreach ( $wc_pages_options as $option ) {
				$page_id = get_option( $option );

				if ( ! empty( $page_id ) ) {
					$page_id = intval( $page_id );

					if ( null !== get_post( $page_id ) ) {
						$woocommerce_pages[ $option ] = $page_id;
					}
				}
			}

			return $woocommerce_pages;
		}

		/**
		 * Update Woostify fresh site flag.
		 */
		public function woostify_log_fresh_site_state() {
			if ( null === get_option( 'woostify_nux_fresh_site', null ) ) {
				update_option( 'woostify_nux_fresh_site', get_option( 'fresh_site' ) );
			}
		}

		/**
		 * Add custom classes to the list of admin body classes.
		 *
		 * @param string $classes Classes for the admin body element.
		 * @return string
		 */
		public function woostify_admin_body_class( $classes ) {
			if ( true === (bool) get_option( 'woostify_nux_dismissed' ) ) {
				return $classes;
			}

			$classes .= ' woostify-nux ';

			return $classes;
		}

		/**
		 * Check if WooCommerce is installed.
		 */
		private function woostify_is_woocommerce_installed() {
			if ( file_exists( WP_PLUGIN_DIR . '/woocommerce' ) ) {
				$plugins = get_plugins( '/woocommerce' );

				if ( ! empty( $plugins ) ) {
					$keys        = array_keys( $plugins );
					$plugin_file = 'woocommerce/' . $keys[0];
					$url         = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'activate',
								'plugin' => $plugin_file,
							), admin_url( 'plugins.php' )
						), 'activate-plugin_' . $plugin_file
					);

					return $url;
				}
			}

			return false;
		}

		/**
		 * Set WooCommerce pages to use the full width template.
		 */
		private function woostify_set_woocommerce_pages_full_width() {
			$wc_pages = $this->get_woocommerce_pages();

			foreach ( $wc_pages as $option => $page_id ) {
				$this->_assign_page_template( $page_id, 'template-fullwidth.php' );
			}
		}

		/**
		 * Given a page id assign a given page template to it.
		 *
		 * @param int    $page_id  Page id.
		 * @param string $template Template file name.
		 * @return void|bool Returns false if $page_id or $template is empty.
		 */
		private function woostify_assign_page_template( $page_id, $template ) {
			if ( empty( $page_id ) || empty( $template ) || '' === locate_template( $template ) ) {
				return false;
			}

			update_post_meta( $page_id, '_wp_page_template', $template );
		}

		/**
		 * Check if WooCommerce is empty.
		 *
		 * @return bool
		 */
		private function woostify_is_woocommerce_empty() {
			$products = wp_count_posts( 'product' );

			if ( 0 < $products->publish ) {
				return false;
			}

			return true;
		}
	}

endif;

return new Woostify_NUX_Admin();
