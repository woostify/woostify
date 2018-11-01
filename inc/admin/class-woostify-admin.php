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
			add_action( 'admin_enqueue_scripts', array( $this, 'welcome_static' ) );
		}

		/**
		 * Load welcome screen script and css
		 */
		public function welcome_static() {
			wp_enqueue_style(
				'woostify-welcome-screen',
				WOOSTIFY_THEME_URI . 'assets/css/admin/welcome-screen/welcome.css',
				array(),
				woostify_version()
			);

			wp_style_add_data(
				'woostify-welcome-screen',
				'rtl',
				'replace'
			);
		}

		/**
		 * Creates the dashboard page
		 *
		 * @see  add_theme_page()
		 * @since 1.0
		 */
		public function welcome_register_menu() {
			$page = add_theme_page( 'Woostify Panel', 'Woostify Panel', 'activate_plugins', 'woostify-welcome', array( $this, 'woostify_welcome_screen' ) );
			add_action( 'admin_print_styles-' . $page, array( $this, 'welcome_static' ) );
		}

		/**
		 * Customizer settings link
		 */
		public function welcome_customizer_settings() {
			$customizer_settings = apply_filters(
				'woostify_panel_customizer_settings',
				array(
					'upload_logo' => array(
						'icon'     => 'dashicons dashicons-format-image',
						'name'     => __( 'Upload Logo', 'woostify' ),
						'type'     => 'control',
						'setting'  => 'custom_logo',
						'required' => '',
					),
					'set_color' => array(
						'icon'     => 'dashicons dashicons-admin-appearance',
						'name'     => __( 'Set Colors', 'woostify' ),
						'type'     => 'section',
						'setting'  => 'woostify_color',
						'required' => '',
					),
					'layout' => array(
						'icon'     => 'dashicons dashicons-layout',
						'name'     => __( 'Layout', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_layout',
						'required' => '',
					),
					'button' => array(
						'icon'     => 'dashicons dashicons-admin-customizer',
						'name'     => __( 'Buttons', 'woostify' ),
						'type'     => 'section',
						'setting'  => 'woostify_buttons',
						'required' => '',
					),
					'typo' => array(
						'icon'     => 'dashicons dashicons-editor-paragraph',
						'name'     => __( 'Typography', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_typography',
						'required' => '',
					),
					'shop' => array(
						'icon'     => 'dashicons dashicons-cart',
						'name'     => __( 'Shop', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_shop',
						'required' => 'woocommerce',
					),
				)
			);

			return $customizer_settings;
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
			?>

			<div class="woostify-wrap">
				
				<section class="woostify-welcome-nav">
					<div class="woostify-welcome-container">
						<a class="woostify-welcome-theme-brand" href="https://woostify.com/" target="_blank" rel="noopener">
							<img class="woostify-welcome-theme-icon" src="<?php echo esc_url( WOOSTIFY_THEME_URI . '/assets/images/logo.svg' ); ?>" alt="<?php esc_attr_e( 'Woostify Logo', 'woostify' ); ?>">
							<span class="woostify-welcome-theme-title">Woostify</span>
							<span class="woostify-welcome-theme-version"><?php echo woostify_version(); // WPCS: XSS ok. ?></span>
						</a>

						<ul class="woostify-welcome-nav_link">
							<li><a href="//woostify.com/contact/" target="_blank"><?php esc_html_e( 'Support', 'woostify' ); ?></a></li>
							<li><a href="//woostify.com/docs/" target="_blank"><?php esc_html_e( 'Documentation', 'woostify' ); ?></a></li>
							<li><a href="//woostify.com/pricing/" target="_blank"><?php esc_html_e( 'Development Blog', 'woostify' ); ?></a></li>
							<?php if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) : ?>
								<li><a href="//woostify.com/pricing/" target="_blank"><strong>Go Pro Version.</strong></a></li>
							<?php endif; ?>
						</ul>
					</div>
				</section>

				<div class="woostify-enhance">
					<div class="woostify-welcome-container">
						<div class="woostify-enhance-content">
							<div class="woostify-enhance__column woostify-bundle">
								<h3><?php esc_html_e( 'Link to Customizer Settings', 'woostify' ); ?></h3>
								<div class="wf-quick-setting-section">
									<ul class="wst-flex">
									<?php
									foreach ( $this->welcome_customizer_settings() as $key ) {
										$url = get_admin_url() . 'customize.php?autofocus[' . $key['type'] . ']=' . $key['setting'];

										$disabled = '';
										$title    = '';
										if ( '' !== $key['required'] && ! class_exists( $key['required'] ) ) {
											$disabled = 'disabled';

											/* translators: 1: Class name */
											$title = sprintf( __( 'You need activate %s plugin to use this feature.', 'woostify' ), ucfirst( $key['required'] ) );

											$url = '#';
										}
										?>

										<li class="link-to-customie-item <?php echo esc_attr( $disabled ); ?>" title="<?php echo esc_attr( $title ); ?>">
											<a class="wst-quick-setting-title wp-ui-text-highlight" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
												<span class="<?php echo esc_attr( $key['icon'] ); ?>"></span>
												<?php echo esc_html( $key['name'] ); ?>
											</a>
										</li>

									<?php } ?>
									</ul>
									
									<?php if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) : ?>
										<p>
											<a href="//woostify.com/pricing/" class="woostify-button" target="_blank"><?php esc_html_e( 'Read more and purchase', 'woostify' ); ?></a>
										</p>
									<?php endif; ?>
								</div>
							</div>

							<?php if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) : ?>
								<div class="woostify-enhance__column woostify-pro-featured">
									<h3>
										<?php esc_html_e( 'More Features Avaiable with Woostify Pro', 'woostify' ); ?>
										<a class="woostify-learn-more wp-ui-text-highlight" href="//woostify.com/pricing/" target="_blank"><?php esc_html_e( 'Learn more!', 'woostify' ); ?></a>
									</h3>

									<div class="wf-quick-setting-section">
										<p>
											<?php esc_html_e( 'Quickly and easily transform your shops appearance with Woostify child themes.', 'woostify' ); ?>
										</p>

										<p>
											<?php esc_html_e( 'Each has been designed to serve a different industry - from fashion to food.', 'woostify' ); ?>
										</p>

										<p>
											<?php esc_html_e( 'Of course they are all fully compatible with each Woostify extension.', 'woostify' ); ?>
										</p>

										<p>
											<a href="//woostify.com/pricing/" class="woostify-button button-primary" target="_blank"><?php esc_html_e( 'Check \'em out', 'woostify' ); ?></a>
										</p>
									</div>
								</div>
							<?php endif; ?>

							<?php do_action( 'woostify_pro_panel_column' ); ?>
						</div>

						<div class="woostify-enhance-sidebar">
							<?php do_action( 'woostify_pro_panel_sidebar' ); ?>

							<div class="woostify-enhance__column">
								<h3><?php esc_html_e( 'Import Demo', 'woostify' ); ?></h3>							

								<div class="wf-quick-setting-section">
									<img src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/admin/welcome-screen/child-themes.jpg' ); ?>" alt="woostify Powerpack" />

									<p>
										<?php esc_html_e( 'Quickly and easily transform your shops appearance with Woostify child themes.', 'woostify' ); ?>
									</p>

									<p>
										<?php esc_html_e( 'Each has been designed to serve a different industry - from fashion to food.', 'woostify' ); ?>
									</p>

									<p>
										<?php esc_html_e( 'Of course they are all fully compatible with each Woostify extension.', 'woostify' ); ?>
									</p>

									<p>
											<a href="//woostify.com/pricing/" class="woostify-button button-primary" target="_blank"><?php esc_html_e( 'Check \'em out', 'woostify' ); ?></a>
										</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<?php
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
						'message' => esc_html__( 'Activated', 'woostify' ),
						'url'     => '#',
						'classes' => 'disabled',
					);
				} elseif ( $this->_is_plugin_installed( $plugin_slug ) ) {
					$url = $this->_is_plugin_installed( $plugin_slug );

					// The plugin exists but isn't activated yet.
					$button = array(
						'message' => esc_html__( 'Activate', 'woostify' ),
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
						'message' => esc_html__( 'Install now', 'woostify' ),
						'url'     => $url,
						'classes' => ' install-now install-' . $plugin_slug,
					);
				}
				?>
				<a href="<?php echo esc_url( $button['url'] ); ?>" class="woostify-button button-primary <?php echo esc_attr( $button['classes'] ); ?>" data-originaltext="<?php echo esc_attr( $button['message'] ); ?>" data-slug="<?php echo esc_attr( $plugin_slug ); ?>" aria-label="<?php echo esc_attr( $button['message'] ); ?>"><?php echo esc_html( $button['message'] ); ?></a>
				<a href="//wordpress.org/plugins/<?php echo esc_attr( $plugin_slug ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
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
