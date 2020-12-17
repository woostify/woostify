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
		 * Instance
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'woostify_admin_notice' ) );
			add_action( 'wp_ajax_dismiss_admin_notice', array( $this, 'woostify_dismiss_admin_notice' ) );
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
			$wp_version = version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ? 'gutenberg-version' : 'old-version';
			$classes   .= " $wp_version";

			return $classes;
		}

		/**
		 * Add admin notice
		 */
		public function woostify_admin_notice() {
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			// For theme options box.
			if ( is_admin() && ! get_user_meta( get_current_user_id(), 'welcome_box' ) ) {
				?>
				<div class="woostify-admin-notice woostify-options-notice notice is-dismissible" data-notice="welcome_box">
					<div class="woostify-notice-content">
						<div class="woostify-notice-img">
							<img src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/logo.svg' ); ?>" alt="<?php esc_attr_e( 'logo', 'woostify' ); ?>">
						</div>

						<div class="woostify-notice-text">
							<div class="woostify-notice-heading"><?php esc_html_e( 'Thanks for installing Woostify!', 'woostify' ); ?></div>
							<p>
								<?php
								echo wp_kses_post(
									sprintf(
										/* translators: Theme options */
										__( 'To fully take advantage of the best our theme can offer please make sure you visit our <a href="%1$s">Woostify Options</a>.', 'woostify' ),
										esc_url( admin_url( 'admin.php?page=woostify-welcome' ) )
									)
								);
								?>
							</p>
						</div>
					</div>

					<button type="button" class="notice-dismiss">
						<span class="spinner"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'woostify' ); ?></span>
					</button>
				</div>
				<?php
			}
		}

		/**
		 * Dismiss admin notice
		 */
		public function woostify_dismiss_admin_notice() {

			// Nonce check.
			check_ajax_referer( 'woostify_dismiss_admin_notice', 'nonce' );

			// Bail if user can't edit theme options.
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_send_json_error();
			}

			$notice = isset( $_POST['notice'] ) ? sanitize_text_field( wp_unslash( $_POST['notice'] ) ) : '';

			if ( $notice ) {
				update_user_meta( get_current_user_id(), $notice, true );
				wp_send_json_success();
			}

			wp_send_json_error();
		}

		/**
		 * Load welcome screen script and css
		 *
		 * @param  obj $hook Hooks.
		 */
		public function woostify_welcome_static( $hook ) {
			$is_welcome = false !== strpos( $hook, 'woostify-welcome' );

			// Dismiss admin notice.
			wp_enqueue_style(
				'woostify-admin-general',
				WOOSTIFY_THEME_URI . 'assets/css/admin/general.css',
				array(),
				woostify_version()
			);

			// Dismiss admin notice.
			wp_enqueue_script(
				'woostify-dismiss-admin-notice',
				WOOSTIFY_THEME_URI . 'assets/js/admin/dismiss-admin-notice' . woostify_suffix() . '.js',
				array(),
				woostify_version(),
				true
			);

			wp_localize_script(
				'woostify-dismiss-admin-notice',
				'woostify_dismiss_admin_notice',
				array(
					'nonce' => wp_create_nonce( 'woostify_dismiss_admin_notice' ),
				)
			);

			// Welcome screen style.
			if ( $is_welcome ) {
				wp_enqueue_style(
					'woostify-welcome-screen',
					WOOSTIFY_THEME_URI . 'assets/css/admin/welcome.css',
					array(),
					woostify_version()
				);
			}

			// Install plugin import demo.
			wp_enqueue_script(
				'woostify-install-demo',
				WOOSTIFY_THEME_URI . 'assets/js/admin/install-demo' . woostify_suffix() . '.js',
				array( 'updates' ),
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
			// Filter to remove Admin menu.
			$admin_menu = apply_filters( 'woostify_options_admin_menu', false );
			if ( true === $admin_menu ) {
				return;
			}

			$page = add_theme_page( 'Woostify Theme Options', 'Woostify Options', 'manage_options', 'woostify-welcome', array( $this, 'woostify_welcome_screen' ) );
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
					'set_color'   => array(
						'icon'     => 'dashicons dashicons-admin-appearance',
						'name'     => __( 'Set Colors', 'woostify' ),
						'type'     => 'section',
						'setting'  => 'woostify_color',
						'required' => '',
					),
					'layout'      => array(
						'icon'     => 'dashicons dashicons-layout',
						'name'     => __( 'Layout', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_layout',
						'required' => '',
					),
					'button'      => array(
						'icon'     => 'dashicons dashicons-admin-customizer',
						'name'     => __( 'Buttons', 'woostify' ),
						'type'     => 'section',
						'setting'  => 'woostify_buttons',
						'required' => '',
					),
					'typo'        => array(
						'icon'     => 'dashicons dashicons-editor-paragraph',
						'name'     => __( 'Typography', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_typography',
						'required' => '',
					),
					'shop'        => array(
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
		 * The welcome screen Header
		 */
		public function woostify_welcome_screen_header() {
			$woostify_url = 'https://woostify.com';
			$facebook_url = 'https://facebook.com/groups/2245150649099616/';
			?>
				<section class="woostify-welcome-nav">
					<div class="woostify-welcome-container">
						<a class="woostify-welcome-theme-brand" href="<?php echo esc_url( $woostify_url ); ?>" target="_blank" rel="noopener">
							<img class="woostify-welcome-theme-icon" src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/logo.svg' ); ?>" alt="<?php esc_attr_e( 'Woostify Logo', 'woostify' ); ?>">
							<span class="woostify-welcome-theme-title"><?php esc_html_e( 'Woostify', 'woostify' ); ?></span>
							<span class="woostify-welcome-theme-version"><?php echo esc_html( woostify_version() ); ?></span>
						</a>

						<ul class="woostify-welcome-nav_link">
							<li><a href="<?php echo esc_url( $woostify_url ); ?>/changelog/" target="_blank"><?php esc_html_e( 'Changelog', 'woostify' ); ?></a></li>
							<li><a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank"><strong><?php esc_html_e( 'Join FB Group', 'woostify' ); ?></strong></a></li>
						</ul>
					</div>
				</section>
			<?php
		}

		/**
		 * The welcome screen
		 */
		public function woostify_welcome_screen() {
			$woostify_url = 'https://woostify.com';
			$facebook_url = 'https://facebook.com';
			?>
			<div class="woostify-options-wrap admin-welcome-screen">

				<?php $this->woostify_welcome_screen_header(); ?>

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
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/" class="woostify-button button-primary" target="_blank"><?php esc_html_e( 'Read more', 'woostify' ); ?></a>
										</p>
									<?php endif; ?>
								</div>
							</div>

							<?php if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) : ?>
								<div class="woostify-enhance__column woostify-pro-featured pro-featured-list">
									<h3>
										<a class="woostify-learn-more wp-ui-text-highlight" href="<?php echo esc_url( $woostify_url ); ?>" target="_blank"><?php esc_html_e( 'Get Woostify  Pro Extensions!', 'woostify' ); ?></a>
									</h3>

									<div class="wf-quick-setting-section">
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Multiple Headers', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/multiple-headers/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Mega Menu', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/elementor-mega-menu/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Elementor Bundle', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/elementor-addons/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Header & Footer Builder', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/header-footer-builder/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Ajax WooCommerce Search', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/woocommerce-product-search/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Size Guide', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/size-guide/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Advanced Shop Widgets', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/advanced-widgets/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Buy Now Button', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/buy-now-button/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Sticky Header', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/sticky-header/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Sticky Button', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/sticky-add-to-cart-button/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Quick View', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/quick-view/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Countdown Urgency', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/countdown/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'Sale Notification', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/sale-notification/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>

										<div class="pro-featured-item">
											<strong class="pro-featured-name">
												<?php esc_html_e( 'WooBuilder', 'woostify' ); ?>
											</strong>
											<a href="<?php echo esc_url( $woostify_url ); ?>/docs/pro-modules/woobuider/" class="learn-more-featured" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
										</div>
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
									$redirect    = admin_url( 'admin.php?page=woostify-sites' );
									$nonce       = add_query_arg(
										array(
											'action'   => 'activate',
											'_wpnonce' => wp_create_nonce( 'activate-plugin_' . $slug ),
											'plugin'   => rawurlencode( $slug ),
											'paged'    => '1',
											'plugin_status' => 'all',
										),
										network_admin_url( 'plugins.php' )
									);

									// Check Woostify Sites status.
									$type = 'install';
									if ( file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_slug ) ) {
										$activate = is_plugin_active( $plugin_slug . '/woostify-sites.php' ) ? 'activate' : 'deactivate';
										$type     = $activate;
									}

									// Generate button.
									$button = '<a href="' . esc_url( admin_url( 'admin.php?page=woostify-sites' ) ) . '" class="woostify-button button-primary" target="_blank">' . esc_html__( 'Import Demo', 'woostify' ) . '</a>';

									// If Woostifu Site install.
									if ( ! defined( 'WOOSTIFY_SITES_VER' ) ) {
										if ( 'deactivate' === $type ) {
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
											'installing' => esc_html__( 'Installing', 'woostify' ),
										)
									);
									?>

									<p>
										<?php echo wp_kses_post( $button ); ?>
									</p>
								</div>
							</div>

							<div class="woostify-enhance__column list-section-wrapper">
								<h3><?php esc_html_e( 'Learn More', 'woostify' ); ?></h3>

								<div class="wf-quick-setting-section">
									<p>
										<?php esc_html_e( 'How it works. Learn Woostify.', 'woostify' ); ?>
									</p>

									<p>
										<a href="<?php echo esc_url( $woostify_url ); ?>/docs" class="woostify-button"><?php esc_html_e( 'Visit Documentation', 'woostify' ); ?></a>
									</p>
								</div>

								<div class="wf-quick-setting-section">
									<p>
										<?php esc_html_e( 'Woostify Community', 'woostify' ); ?>
									</p>

									<p>
										<a href="<?php echo esc_url( $facebook_url ); ?>/groups/2245150649099616/" class="woostify-button"><?php esc_html_e( 'Join Our Facebook Group', 'woostify' ); ?></a>
									</p>
								</div>

								<div class="wf-quick-setting-section">
									<p>
										<?php esc_html_e( 'Customer Support', 'woostify' ); ?>
									</p>

									<p>
										<a href="<?php echo esc_url( $woostify_url ); ?>/contact/" class="woostify-button"><?php esc_html_e( 'Submit a Ticket', 'woostify' ); ?></a>
									</p>
								</div>

								<div class="wf-quick-setting-section">
									<p>
										<?php esc_html_e( 'Love Woostify?', 'woostify' ); ?>
									</p>

									<p>
										<a href="<?php echo esc_url( '//wordpress.org/support/theme/woostify/reviews/#new-post' ); ?>/contact/" class="woostify-button"><?php esc_html_e( 'Give us 5 stars!', 'woostify' ); ?></a>
									</p>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}

	Woostify_Admin::get_instance();

endif;
