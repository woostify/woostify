<?php
/**
 * Woostify Admin Class
 *
 * @package  woostify
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Woostify_Admin' ) ) :
	/**
	 * The Woostify admin class
	 */
	class Woostify_Admin {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'welcome_register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'welcome_style' ) );
		}

		/**
		 * Load welcome screen css
		 *
		 * @param string $hook_suffix the current page hook suffix.
		 * @return void
		 * @since  1.0
		 */
		public function welcome_style( $hook_suffix ) {
			global $woostify_version;

			if ( 'appearance_page_woostify-welcome' === $hook_suffix ) {
				wp_enqueue_style(
					'woostify-welcome-screen',
					WOOSTIFY_THEME_URI . 'assets/css/admin/welcome-screen/welcome.css',
					array(),
					$woostify_version
				);

				wp_style_add_data(
					'woostify-welcome-screen',
					'rtl',
					'replace'
				);
			}
		}

		/**
		 * Creates the dashboard page
		 *
		 * @see  add_theme_page()
		 * @since 1.0
		 */
		public function welcome_register_menu() {
			add_theme_page( 'Woostify Panel', 'Woostify Panel', 'activate_plugins', 'woostify-welcome', array( $this, 'woostify_welcome_screen' ) );
		}

		/**
		 * The welcome screen
		 *
		 * @since 1.0
		 */
		public function woostify_welcome_screen() {
			require_once( ABSPATH . 'wp-load.php' );
			require_once( ABSPATH . 'wp-admin/admin.php' );
			require_once( ABSPATH . 'wp-admin/admin-header.php' );

			global $woostify_version;
			?>

			<div class="woostify-wrap">
				<section class="woostify-welcome-nav">
					<span class="woostify-welcome-nav__version">Woostify <?php echo esc_attr( $woostify_version ); ?></span>
					<ul>
						<li><a href="//woostify.com/contact/" target="_blank"><?php esc_attr_e( 'Support', 'woostify' ); ?></a></li>
						<li><a href="//woostify.com/docs/" target="_blank"><?php esc_attr_e( 'Documentation', 'woostify' ); ?></a></li>
						<li><a href="//woostify.com/pricing/" target="_blank"><?php esc_attr_e( 'Development Blog', 'woostify' ); ?></a></li>
					</ul>
				</section>

				<div class="woostify-logo">
					<span class="dashicons dashicons-store"></span>
				</div>

				<div class="woostify-intro">
					<?php
					/**
					 * Display a different message when the user visits this page when returning from the guided tour
					 */
					$referrer = wp_get_referer();

					if ( false !== strpos( $referrer, 'woostify_starter_content' ) ) {
						/* translators: 1: HTML, 2: HTML */
						echo '<h1>' . sprintf( esc_attr__( 'Setup complete %1$sYour Woostify adventure begins now 🚀%2$s ', 'woostify' ), '<span>', '</span>' ) . '</h1>';
						echo '<p>' . esc_attr__( 'One more thing... You might be interested in the following Woostify extensions and designs.', 'woostify' ) . '</p>';
					} else {
						echo '<p>' . esc_attr__( 'Hello! You might be interested in the following Woostify extensions and designs.', 'woostify' ) . '</p>';
					}
					?>
				</div>

				<div class="woostify-enhance">
					<div class="woostify-enhance-content">
						<div class="woostify-enhance__column woostify-bundle">
							<h3><?php esc_attr_e( 'Link to Customizer Settings', 'woostify' ); ?></h3>
							<div class="wst-quick-setting-section">
								<ul class="wst-flex">
									<li class="link-to-customie-item">
										<span class="dashicons dashicons-format-image"></span>
										<a class="wst-quick-setting-title" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bcontrol%5D=custom_logo' ); ?>" target="_blank" rel="noopener">
											<?php esc_html_e( 'Upload Logo', 'woostify' ); ?>
										</a>
									</li>
									<li class="link-to-customie-item">
										<span class="dashicons dashicons-admin-appearance"></span>
										<a class="wst-quick-setting-title" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bsection%5D=woostify_color' ); ?>" target="_blank" rel="noopener">
										<?php esc_html_e( 'Set Colors', 'woostify' ); ?>
									</a>
									</li>
									<li class="link-to-customie-item">
										<span class="dashicons dashicons-layout"></span>
										<a class="wst-quick-setting-title" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bpanel%5D=woostify_layout' ); ?>" target="_blank" rel="noopener">
											<?php esc_html_e( 'Layout', 'woostify' ); ?>
										</a>
									</li>
									<li class="link-to-customie-item">
										<span class="dashicons dashicons-admin-customizer"></span>
										<a class="wst-quick-setting-title" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bsection%5D=woostify_buttons' ); ?>" target="_blank" rel="noopener">
										<?php esc_html_e( 'Buttons', 'woostify' ); ?>
									</a>
									<li class="link-to-customie-item">
										<span class="dashicons dashicons-editor-paragraph"></span>
										<a class="wst-quick-setting-title" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bpanel%5D=woostify_typography' ); ?>" target="_blank" rel="noopener">
											<?php esc_html_e( 'Typography', 'woostify' ); ?>
										</a>
									</li>
									<?php if ( class_exists( 'woocommerce' ) ) { ?>
										<li class="link-to-customie-item">
											<span class="dashicons dashicons-cart"></span>
											<a class="wst-quick-setting-title" href="<?php echo esc_url( get_admin_url() . 'customize.php?autofocus%5Bpanel%5D=woostify_shop' ); ?>" target="_blank" rel="noopener">
												<?php esc_html_e( 'Shop', 'woostify' ); ?>
											</a>
										</li>
									<?php } ?>
								</ul>

								<p>
									<a href="//woostify.com/pricing/" class="woostify-button" target="_blank"><?php esc_attr_e( 'Read more and purchase', 'woostify' ); ?></a>
								</p>
							</div>
						</div>
						<div class="woostify-enhance__column woostify-child-themes">
							<h3>
								<?php esc_attr_e( 'More Features Avaiable with Woostify Pro', 'woostify' ); ?>
								<a class="woostify-learn-more" href="//woostify.com/pricing/" target="_blank"><?php esc_html_e( 'Learn more!', 'woostify' ); ?></a>
							</h3>

							<div class="wst-quick-setting-section">
								<p>
									<?php esc_attr_e( 'Quickly and easily transform your shops appearance with Woostify child themes.', 'woostify' ); ?>
								</p>

								<p>
									<?php esc_attr_e( 'Each has been designed to serve a different industry - from fashion to food.', 'woostify' ); ?>
								</p>

								<p>
									<?php esc_attr_e( 'Of course they are all fully compatible with each Woostify extension.', 'woostify' ); ?>
								</p>

								<p>
									<a href="//woostify.com/pricing/" class="woostify-button" target="_blank"><?php esc_attr_e( 'Check \'em out', 'woostify' ); ?></a>
								</p>
							</div>
						</div>
					</div>

					<div class="woostify-enhance-sidebar">
						<div class="woostify-enhance__column">
							<h3><?php esc_attr_e( 'Alternate designs', 'woostify' ); ?></h3>
							

							<div class="wst-quick-setting-section">
								<img src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/admin/welcome-screen/child-themes.jpg' ); ?>" alt="woostify Powerpack" />

								<p>
									<?php esc_attr_e( 'Quickly and easily transform your shops appearance with Woostify child themes.', 'woostify' ); ?>
								</p>

								<p>
									<?php esc_attr_e( 'Each has been designed to serve a different industry - from fashion to food.', 'woostify' ); ?>
								</p>

								<p>
									<?php esc_attr_e( 'Of course they are all fully compatible with each Woostify extension.', 'woostify' ); ?>
								</p>

								<p>
										<a href="//woostify.com/pricing/" class="woostify-button" target="_blank"><?php esc_attr_e( 'Check \'em out', 'woostify' ); ?></a>
									</p>
							</div>
						</div>
					</div>
				</div>

			</div>
			<?php
		}

		/**
		 * Welcome screen intro
		 *
		 * @since 1.0
		 */
		public function welcome_intro() {
			require_once( WOOSTIFY_THEME_DIR . 'inc/admin/welcome-screen/component-intro.php' );
		}

		/**
		 * Output a button that will install or activate a plugin if it doesn't exist, or display a disabled button if the
		 * plugin is already activated.
		 *
		 * @param string $plugin_slug The plugin slug.
		 * @param string $plugin_file The plugin file.
		 */
		public function install_plugin_button( $plugin_slug, $plugin_file ) {
			if ( current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) {
				if ( is_plugin_active( $plugin_slug . '/' . $plugin_file ) ) {
					// The plugin is already active.
					$button = array(
						'message' => esc_attr__( 'Activated', 'woostify' ),
						'url'     => '#',
						'classes' => 'disabled',
					);
				} elseif ( $this->_is_plugin_installed( $plugin_slug ) ) {
					$url = $this->_is_plugin_installed( $plugin_slug );

					// The plugin exists but isn't activated yet.
					$button = array(
						'message' => esc_attr__( 'Activate', 'woostify' ),
						'url'     => $url,
						'classes' => 'activate-now',
					);
				} else {
					// The plugin doesn't exist.
					$url = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $plugin_slug,
							), self_admin_url( 'update.php' )
						), 'install-plugin_' . $plugin_slug
					);
					$button = array(
						'message' => esc_attr__( 'Install now', 'woostify' ),
						'url'     => $url,
						'classes' => ' install-now install-' . $plugin_slug,
					);
				}
				?>
				<a href="<?php echo esc_url( $button['url'] ); ?>" class="woostify-button <?php echo esc_attr( $button['classes'] ); ?>" data-originaltext="<?php echo esc_attr( $button['message'] ); ?>" data-slug="<?php echo esc_attr( $plugin_slug ); ?>" aria-label="<?php echo esc_attr( $button['message'] ); ?>"><?php echo esc_attr( $button['message'] ); ?></a>
				<a href="//wordpress.org/plugins/<?php echo esc_attr( $plugin_slug ); ?>" target="_blank"><?php esc_attr_e( 'Learn more', 'woostify' ); ?></a>
				<?php
			}
		}

		/**
		 * Check if a plugin is installed and return the url to activate it if so.
		 *
		 * @param string $plugin_slug The plugin slug.
		 */
		public function _is_plugin_installed( $plugin_slug ) {
			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
				$plugins = get_plugins( '/' . $plugin_slug );
				if ( ! empty( $plugins ) ) {
					$keys        = array_keys( $plugins );
					$plugin_file = $plugin_slug . '/' . $keys[0];
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
		 * Welcome screen enhance section
		 *
		 * @since 1.0
		 */
		public function welcome_enhance() {
			require_once( WOOSTIFY_THEME_DIR . 'inc/admin/welcome-screen/component-enhance.php' );
		}

		/**
		 * Welcome screen contribute section
		 *
		 * @since 1.0
		 */
		public function welcome_contribute() {
			require_once( WOOSTIFY_THEME_DIR . 'inc/admin/welcome-screen/component-contribute.php' );
		}

		/**
		 * Get product data from json
		 *
		 * @param  string $url       URL to the json file.
		 * @param  string $transient Name the transient.
		 * @return [type]            [description]
		 */
		public function get_woostify_product_data( $url, $transient ) {
			$raw_products = wp_safe_remote_get( $url );
			$products     = json_decode( wp_remote_retrieve_body( $raw_products ) );

			if ( ! empty( $products ) ) {
				set_transient( $transient, $products, DAY_IN_SECONDS );
			}

			return $products;
		}
	}

endif;

return new Woostify_Admin();
