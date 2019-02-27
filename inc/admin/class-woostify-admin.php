<?php
/**
 * Woostify Admin Class
 *
 * @package  woostify
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
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'woostify_admin_notice' ) );
			add_action( 'admin_init', array( $this, 'woostify_dismiss_admin_notice' ) );
			add_action( 'admin_menu', array( $this, 'woostify_welcome_register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'woostify_welcome_static' ) );
			add_action( 'admin_body_class', array( $this, 'woostify_admin_classes' ) );
		}

		/**
		 * Admin body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function woostify_admin_classes( $classes ) {
			$classes .= version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ? 'gutenberg-version' : 'old-version';

			return $classes;
		}

		/**
		 * Add admin notice
		 */
		public function woostify_admin_notice() {
			global $current_user;
			$user_id = $current_user->ID;

			if ( is_admin() && ! get_user_meta( $user_id, 'woostify_print_admin_notice' ) ) {
				?>
			<div class="woostify-admin-notice notice is-dismissible">
				<div class="woostify-notice-content">
					<div class="woostify-notice-img">
						<img src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/logo.svg' ); ?>" alt="<?php esc_attr_e( 'logo', 'woostify' ); ?>">
					</div>
					<div class="woostify-notice-text">
						<div class="woostify-notice-heading"><?php esc_html_e( 'Thanks for installing Woostify!', 'woostify' ); ?></div>
						<p>
							<?php
							printf( // WPCS: XSS OK.
								/* translators: Theme options */
								__( 'To fully take advantage of the best our theme can offer please make sure you visit our <a href="%1$s">Woostify Options</a>.', 'woostify' ),
								esc_url( admin_url( 'themes.php?page=woostify-welcome' ) )
							);
							?>
						</p>
					</div>
				</div>
			</div>
				<?php
			}
		}

		/**
		 * Dismiss admin notice
		 */
		public function woostify_dismiss_admin_notice() {

			global $current_user;
			$user_id = $current_user->ID;

			if ( isset( $_GET['woostify-dismiss-admin-notice'] ) ) {
				add_user_meta( $user_id, 'woostify_print_admin_notice', 'true', true );
			}
		}

		/**
		 * Load welcome screen script and css
		 */
		public function woostify_welcome_static() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// Dismiss admin notice.
			wp_enqueue_script(
				'woostify-dismiss-admin-notice',
				WOOSTIFY_THEME_URI . 'assets/js/admin/dismiss-admin-notice' . $suffix . '.js',
				array(),
				woostify_version(),
				true
			);

			wp_localize_script(
				'woostify-dismiss-admin-notice',
				'woostify_dismiss_admin_notice',
				array(
					'url' => get_admin_url() . '?woostify-dismiss-admin-notice',
				)
			);

			// Welcome screen style.
			wp_enqueue_style(
				'woostify-welcome-screen',
				WOOSTIFY_THEME_URI . 'assets/css/admin/welcome-screen/welcome.css',
				array(),
				woostify_version()
			);

			// Install plugin import demo.
			wp_enqueue_script(
				'woostify-install-demo',
				WOOSTIFY_THEME_URI . 'assets/js/admin/install-demo' . $suffix . '.js',
				array(),
				woostify_version(),
				true
			);
		}

		/**
		 * Creates the dashboard page
		 *
		 * @see  add_theme_page()
		 */
		public function woostify_welcome_register_menu() {
			$page = add_theme_page( 'Woostify Options', 'Woostify Options', 'activate_plugins', 'woostify-welcome', array( $this, 'woostify_welcome_screen' ) );
			add_action( 'admin_print_styles-' . $page, array( $this, 'woostify_welcome_static' ) );
		}

		/**
		 * Customizer settings link
		 */
		public function woostify_welcome_customizer_settings() {
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
							<span class="woostify-welcome-theme-title"><?php esc_html_e( 'Woostify', 'woostify' ); ?></span>
							<span class="woostify-welcome-theme-version"><?php echo woostify_version(); // WPCS: XSS ok. ?></span>
						</a>

						<ul class="woostify-welcome-nav_link">
							<li><a href="https://woostify.com/contact/" target="_blank"><?php esc_html_e( 'Support', 'woostify' ); ?></a></li>
							<li><a href="https://woostify.com/docs/" target="_blank"><?php esc_html_e( 'Documentation', 'woostify' ); ?></a></li>
							<li><strong><a href="https://www.facebook.com/WoostifyWP" target="_blank"><?php esc_html_e( 'Join FB Page', 'woostify' ); ?></a></strong></li>
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
									foreach ( $this->woostify_welcome_customizer_settings() as $key ) {
										$url = get_admin_url() . 'customize.php?autofocus[' . $key['type'] . ']=' . $key['setting'];

										$disabled = '';
										$title    = '';
										if ( '' !== $key['required'] && ! class_exists( $key['required'] ) ) {
											$disabled = 'disabled';

											/* translators: 1: Class name */
											$title = sprintf( __( '%s not activated.', 'woostify' ), ucfirst( $key['required'] ) );

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
											<a href="https://woostify.com/docs/" class="woostify-button button-primary" target="_blank"><?php esc_html_e( 'Read more', 'woostify' ); ?></a>
										</p>
									<?php endif; ?>
								</div>
							</div>

							<?php if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) : ?>
								<div class="woostify-enhance__column woostify-pro-featured">
									<h3>
										<?php esc_html_e( 'More Features are coming with Woostify Pro', 'woostify' ); ?>
										<a class="woostify-learn-more wp-ui-text-highlight" href="https://www.facebook.com/WoostifyWP" target="_blank"><?php esc_html_e( 'Follow here!', 'woostify' ); ?></a>
									</h3>

									<div class="wf-quick-setting-section">
										<p>
											<?php esc_html_e( 'Optimize website with our powerful Pro Modules.', 'woostify' ); ?>
										</p>

										<p>
											<?php esc_html_e( 'All the tools you need to define your style and customize your Woostify store.', 'woostify' ); ?>
										</p>

										<p>
											<a href="https://www.facebook.com/WoostifyWP" class="woostify-button button-primary" target="_blank"><?php esc_html_e( 'Follow here', 'woostify' ); ?></a>
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
									<img src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/admin/welcome-screen/demo-sites.jpg' ); ?>" alt="woostify Powerpack" />

									<p>
										<?php esc_html_e( 'Quickly and easily transform your shops appearance with Woostify Demo Sites.', 'woostify' ); ?>
									</p>

									<p>
										<?php esc_html_e( 'It will require other 3rd party plugins such as Elementor, Woocommerce, Contact form 7, etc.', 'woostify' ); ?>
									</p>

									<?php
									$plugin_slug = 'woostify-sites-library';
									$slug        = 'woostify-sites-library/woostify-sites.php';
									$redirect    = admin_url( 'themes.php?page=woostify-sites' );
									$nonce       = add_query_arg(
										array(
											'action'        => 'activate',
											'plugin'        => rawurlencode( $slug ),
											'plugin_status' => 'all',
											'paged'         => '1',
											'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug ),
										),
										network_admin_url( 'plugins.php' )
									);

									// Check Woostify Sites status.
									$type = 'install';
									if ( file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_slug ) ) {
										$activate = is_plugin_active( $plugin_slug . '/woostify-sites.php' ) ? 'activate' : 'deactivate';
										$type = $activate;
									}

									// Generate button.
									$button = '<a href="' . esc_url( admin_url( 'themes.php?page=woostify-sites' ) ) . '" class="woostify-button button-primary" target="_blank">' . esc_html__( 'Import Demo', 'woostify' ) . '</a>';

									// If Woostifu Site install.
									if ( ! defined( 'WOOSTIFY_SITES_VER' ) ) {
										if ( 'deactivate' == $type ) {
											$button = '<a data-redirect="' . esc_url( $redirect ) . '" data-slug="' . esc_attr( $slug ) . '" class="woostify-button button woostify-active-now" href="' . esc_url( $nonce ) . '">' . esc_html__( 'Activate', 'woostify' ) . '</a>';
										} else {
											$button = '<a data-redirect="' . esc_url( $redirect ) . '" data-slug="' . esc_attr( $plugin_slug ) . '" href="' . esc_url( $nonce ) . '" class="woostify-button install-now button woostify-install-demo">' . esc_html__( 'Install Woostify Library', 'woostify' ) . '</a>';
										}
									}

									// Data.
									wp_localize_script(
										'woostify-install-demo',
										'woostify_install_demo',
										array(
											'activating' => esc_html__( 'Activating', 'woostify' ),
										)
									);
									?>

									<p>
										<?php echo $button; // WPCS: XSS ok. ?>
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
		public function woostify_install_plugin_button( $plugin_slug, $plugin_file ) {
			if ( current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) {
				if ( is_plugin_active( $plugin_slug . '/' . $plugin_file ) ) {
					// The plugin is already active.
					$button = array(
						'message' => esc_html__( 'Activated', 'woostify' ),
						'url'     => '#',
						'classes' => 'disabled',
					);
				} elseif ( $this->woostify_is_plugin_installed( $plugin_slug ) ) {
					$url = $this->woostify_is_plugin_installed( $plugin_slug );

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
		public function woostify_is_plugin_installed( $plugin_slug ) {
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
		 */
		public function woostify_welcome_enhance() {
			require_once( WOOSTIFY_THEME_DIR . 'inc/admin/welcome-screen/component-enhance.php' );
		}

		/**
		 * Welcome screen contribute section
		 */
		public function woostify_welcome_contribute() {
			require_once( WOOSTIFY_THEME_DIR . 'inc/admin/welcome-screen/component-contribute.php' );
		}

		/**
		 * Get product data from json
		 *
		 * @param  string $url       URL to the json file.
		 * @param  string $transient Name the transient.
		 * @return [type]            [description]
		 */
		public function woostify_get_woostify_product_data( $url, $transient ) {
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
