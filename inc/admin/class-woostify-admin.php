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
			add_action( 'in_admin_header', array( $this, 'woostify_hide_all_noticee_page_setting' ) );
			add_action( 'woostify_welcome_panel_sidebar', array( $this, 'woostify_admin_panel_sidebar' ) );
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

			// Admin general scripts.
			wp_enqueue_script(
				'woostify-general',
				WOOSTIFY_THEME_URI . 'assets/js/admin/general' . woostify_suffix() . '.js',
				array(),
				woostify_version(),
				true
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
						'icon'     => 'dashicons-format-image',
						'name'     => __( 'Upload Logo', 'woostify' ),
						'type'     => 'control',
						'setting'  => 'custom_logo',
						'required' => '',
					),
					'set_color'   => array(
						'icon'     => 'dashicons-admin-appearance',
						'name'     => __( 'Set Colors', 'woostify' ),
						'type'     => 'section',
						'setting'  => 'woostify_color',
						'required' => '',
					),
					'layout'      => array(
						'icon'     => 'dashicons-layout',
						'name'     => __( 'Layout', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_layout',
						'required' => '',
					),
					'button'      => array(
						'icon'     => 'dashicons-admin-customizer',
						'name'     => __( 'Buttons', 'woostify' ),
						'type'     => 'section',
						'setting'  => 'woostify_buttons',
						'required' => '',
					),
					'typo'        => array(
						'icon'     => 'dashicons-editor-paragraph',
						'name'     => __( 'Typography', 'woostify' ),
						'type'     => 'panel',
						'setting'  => 'woostify_typography',
						'required' => '',
					),
					'shop'        => array(
						'icon'     => 'dashicons-cart',
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
						</a>

						<span class="woostify-welcome-theme-version"><?php echo esc_html( woostify_version() ); ?></span>
					</div>
				</section>
			<?php
		}

		public function woostify_welcome_screen_changelog()
		{
			$request_changelog = wp_remote_get( 'https://woostify.com/wp-json/wp/v2/changelog?per_page=2&product=95' );

			if( is_wp_error( $request_changelog ) ) {
				return false; 
			}

			$changelog_total = (int) $request_changelog['headers']['x-wp-total'];
			$changelog_totalpages = (int) $request_changelog['headers']['x-wp-totalpages'];
	
			$body = wp_remote_retrieve_body( $request_changelog );
			
			$data = json_decode( $body, true );

			?>
			<div class="changelog-woostify">
				<div class="changelog-woostify-header">
					<h2 class="changelog-woostify-title"><?php esc_html_e( 'Changelog woostify theme', 'woostify' ); ?></h2>
					<a href="#" class="changelog-woostify-link theme-button"><?php esc_html_e( 'Woostify theme', 'woostify' ); ?></a>
				</div>
				<div class="changelog-woostify-content">
					<ul class="changelog-woostify-version">
					<?php foreach ( $data as $key => $value ) : ?>
						<?php 
						$ver_title = $value['title']['rendered'];
						$date = date_create( $value['date'] );
						$ver_date = date_format( $date,"F d, Y" ); 
						$ver_content = $value['content']['rendered'];
						?>
						<li class="changelog-item">
							<div class="changelog-version-heading">
								<span><?php echo( $ver_title ); ?></span>
								<span class="changelog-version-date"><?php echo( $ver_date ); ?></span>
							</div>
							<div class="changelog-version-content">
								<?php echo( $ver_content ); ?>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<div class="changelog-woostify-pagination ">
					<div class="page-numbers" data-total-pages="<?php echo $changelog_totalpages; ?>" data-per-page="2" data-changelog-product="95">
						<span class="page-pre disable" data-page-number="1">
							<svg width="6" height="12" viewBox="0 0 6 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.87226 11.25C4.64531 11.2508 4.43023 11.1487 4.28726 10.9725L0.664757 6.47248C0.437269 6.19573 0.437269 5.79673 0.664757 5.51998L4.41476 1.01998C4.67985 0.701035 5.15331 0.657383 5.47226 0.92248C5.7912 1.18758 5.83485 1.66104 5.56976 1.97998L2.21726 5.99998L5.45726 10.02C5.64453 10.2448 5.68398 10.5579 5.55832 10.8222C5.43265 11.0864 5.16481 11.2534 4.87226 11.25Z" fill="#212B36"/>
							</svg>
						</span>
						<?php for ( $page = 1; $page <= $changelog_totalpages; $page++ ) {
							$class_active = ($page == 1) ? 'active' : '';
							if ($page <= 5) {
								$class_active .= ' actived';
							}
							echo '<span class="page-number ' . $class_active . '" data-page-number="' . $page . '">' . $page . '</span>';
						} ?>
						<span class="dots">...</span>
						<span class="page-next">
							<svg width="6" height="12" viewBox="0 0 6 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.0001 11.25C0.824863 11.2503 0.655036 11.1893 0.520102 11.0775C0.366721 10.9503 0.270241 10.7673 0.251949 10.5689C0.233657 10.3705 0.295057 10.173 0.422602 10.02L3.7826 5.99996L0.542602 1.97246C0.416774 1.81751 0.3579 1.6188 0.379015 1.42032C0.40013 1.22184 0.499492 1.03996 0.655102 0.914959C0.811977 0.776929 1.01932 0.710602 1.22718 0.731958C1.43504 0.753313 1.62457 0.860415 1.7501 1.02746L5.3726 5.52746C5.60009 5.80421 5.60009 6.20321 5.3726 6.47996L1.6226 10.98C1.47 11.164 1.23878 11.2643 1.0001 11.25Z" fill="#212B36"/>
							</svg>
						</span>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * The welcome screen
		 */
		public function woostify_welcome_screen() {			
			$woostify_url = 'https://woostify.com';
			$facebook_url = 'https://facebook.com';
			$pro_modules  = array(
				array(
					'name'        => 'woostify_multiphe_header',
					'title'       => __( 'Multiple Headers', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/multiple-headers/',
				),
				array(
					'name'        => 'woostify_sticky_header',
					'title'       => __( 'Sticky Header', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/sticky-header/',
				),
				array(
					'name'        => 'woostify_mega_menu',
					'title'       => __( 'Mega Menu', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/elementor-mega-menu/',
				),
				array(
					'name'        => 'woostify_elementor_widgets',
					'title'       => __( 'Elementor Bundle', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/elementor-addons/',
				),
				array(
					'name'        => 'woostify_header_footer_builder',
					'title'       => __( 'Header Footer Builder', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/header-footer-builder/',
				),
				array(
					'name'        => 'woostify_woo_builder',
					'title'       => __( 'WooBuilder', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/woobuider/',
				),
				array(
					'name'        => 'woostify_wc_ajax_shop_filter',
					'title'       => __( 'Ajax Product Filter', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ),
				),
				array(
					'name'        => 'woostify_wc_ajax_product_search',
					'title'       => __( 'Ajax Product Search', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ),
				),
				array(
					'name'        => 'woostify_size_guide',
					'title'       => __( 'Size Guide', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/size-guide/',
				),
				array(
					'name'        => 'woostify_wc_advanced_shop_widgets',
					'title'       => __( 'Advanced Shop Widgets', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/advanced-widgets/',
				),
				array(
					'name'        => 'woostify_wc_buy_now_button',
					'title'       => __( 'Buy Now Button', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/buy-now-button/',
				),
				array(
					'name'        => 'woostify_wc_sticky_button',
					'title'       => __( 'Sticky Single Add To Cart', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/sticky-add-to-cart-button/',
				),
				array(
					'name'        => 'woostify_wc_quick_view',
					'title'       => __( 'Quick View', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/quick-view/',
				),
				array(
					'name'        => 'woostify_wc_countdown_urgency',
					'title'       => __( 'Countdown Urgency', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/countdown/',
				),
				array(
					'name'        => 'woostify_wc_variation_swatches',
					'title'       => __( 'Variation Swatches', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/variation-swatches/',
				),
				array(
					'name'        => 'woostify_wc_sale_notification',
					'title'       => __( 'Sale Notification', 'woostify' ),
					'desc'        => '',
					'setting_url' => esc_url( $woostify_url ) . '/docs/pro-modules/sale-notification/',
				),
			)
			?>
			<div class="woostify-options-wrap admin-welcome-screen woostify-welcome-settings-section-tab woostify-enhance-settings-section-tab">

				<?php //$this->woostify_welcome_screen_header(); ?>

				<section class="woostify-welcome-nav">
					<div class="woostify-welcome-container">
						<a class="woostify-welcome-theme-brand" href="<?php echo esc_url( $woostify_url ); ?>" target="_blank" rel="noopener">
							<img class="woostify-welcome-theme-icon" src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/logo.svg' ); ?>" alt="<?php esc_attr_e( 'Woostify Logo', 'woostify' ); ?>">
							<span class="woostify-welcome-theme-title"><?php esc_html_e( 'Woostify', 'woostify' ); ?></span>
						</a>

						<div class="woostify-setting-tab-head">
							<a href="#dashboard" class="tab-head-button active"><?php esc_html_e( 'Dashboard', 'woostify' ); ?></a>
							<a href="#add-ons" class="tab-head-button"><?php esc_html_e( 'Add-ons', 'woostify' ); ?></a>
							<a href="#starter-sites" class="tab-head-button"><?php esc_html_e( 'Starter sites', 'woostify' ); ?></a>
							<a href="#changelog" class="tab-head-button"><?php esc_html_e( 'Changelog', 'woostify' ); ?></a>
						</div>

						<!-- <span class="woostify-welcome-theme-version"><?php //echo esc_html( woostify_version() ); ?></span> -->
						<a class="woostify-welcome-theme-support" href="<?php echo esc_url( $woostify_url ); ?>/contact/">
							<img class="woostify-welcome-theme-icon-support" src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/admin/welcome-screen/support.png' ); ?>" alt="<?php esc_attr_e( 'Woostify Support', 'woostify' ); ?>">
							<?php esc_attr_e( 'Support', 'woostify' ); ?>
						</a>
					</div>
				</section>
				<section class="woostify-welcome-content">
					<div class="woostify-welcome-settings-section-tab woostify-enhance-settings-section-tab">
						<div class="woostify-setting-tab-content-wrapper">
							<div class="woostify-setting-tab-content active" data-tab="dashboard">
								<div class="woostify-welcome-container">
									<div class="woostify-enhance-content">
										<div class="woostify-enhance__column">
											<h2 class="section-header"><?php esc_html_e( 'Customizer Settings', 'woostify' ); ?> <a class="section-header-link" target="_blank" href="<?php echo esc_url( get_admin_url() ); ?>customize.php"><?php esc_attr_e( 'Go to Customizer', 'woostify' ); ?></a></h2>
											<div class="woostify-grid-box">
												<?php
												foreach ( $this->woostify_welcome_customizer_settings() as $key ) {
													$url = get_admin_url() . 'customize.php?autofocus[' . $key['type'] . ']=' . $key['setting'];

													$disabled = '';
													$title    = '';
													if ( '' !== $key['required'] && ! class_exists( $key['required'] ) ) {
														$disabled = ' disabled';

														/* translators: 1: Class name */
														$title = sprintf( __( '%s not activated.', 'woostify' ), ucfirst( $key['required'] ) );

														$url = '#';
													}
													?>

													<div class="box-item<?php echo esc_attr( $disabled ); ?>" title="<?php echo esc_attr( $title ); ?>">
														<span class="box-item__icon <?php //echo esc_attr( $key['icon'] ); ?>"><img class="woostify-welcome-theme-icon-support" src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/admin/welcome-screen/'.esc_attr( $key['icon'] ).'.png' ); ?>" alt="<?php esc_attr_e( 'Woostify Support', 'woostify' ); ?>"></span>
														<h4 class="box-item__name"><?php echo esc_html( $key['name'] ); ?></h4>
														<a class="box-item__link" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Go to option', 'woostify' ); ?></a>
													</div>
												<?php } ?>
											</div>
										</div>
										<div class="woostify-enhance__column">
											<div class="woostify-pro-featured pro-featured-list">
												<?php if ( ! defined( 'WOOSTIFY_PRO_VERSION' ) ) : ?>
													<h2 class="section-header">
														<a class="woostify-learn-more wp-ui-text-highlight" href="<?php echo esc_url( $woostify_url ); ?>" target="_blank"><?php esc_html_e( 'Get Woostify  Pro Extensions!', 'woostify' ); ?></a>
													</h2>
													<div class="woostify-grid-box">
														<?php foreach ( $pro_modules as $module ) { ?>
															<div class="box-item box-item--text box-item--disabled">
																<span class="box-item__icon dashicons dashicons-lock"></span>
																<h4 class="box-item__name">
																	<?php echo esc_html( $module['title'] ); ?>
																</h4>
																<?php if ( '' !== $module['desc'] ) { ?>
																	<p class="box-item__desc"><?php echo esc_html( $module['desc'] ); ?></p>
																<?php } ?>
																<a href="<?php echo esc_url( $module['setting_url'] ); ?>" class="learn-more-featured box-item__link" target="_blank"><?php esc_html_e( 'Learn more', 'woostify' ); ?></a>
															</div>
														<?php } ?>
													</div>
												<?php endif; ?>

												<?php do_action( 'woostify_pro_panel_column' ); ?>
											</div>
										</div>
									</div>

									<div class="woostify-enhance-sidebar">
										<?php do_action( 'woostify_pro_panel_sidebar' ); ?>

										<?php do_action( 'woostify_welcome_panel_sidebar' ); ?>
									</div>
								</div>
								
							</div>
							<div class="woostify-setting-tab-content" data-tab="add-ons">
								<div class="woostify-pro-featured pro-featured-list">
									<?php do_action( 'woostify_pro_panel_addons' ); ?>
								</div>
							</div>
							<div class="woostify-setting-tab-content" data-tab="starter-sites">
								<div class="starter-sites-wrap">
									<img src="<?php echo esc_url( WOOSTIFY_THEME_URI . 'assets/images/admin/welcome-screen/wt-demo-sites.png' ); ?>" alt="woostify Powerpack" />
									<div class="starter-sites-content">
										<h2><?php esc_html_e( 'Import Demo', 'woostify' ); ?></h2>
										<p>
											<?php esc_html_e( 'Quickly and easily transform your shops appearance with Woostify Demo Sites.', 'woostify' ); ?>
										</p>
										<p>
											<?php esc_html_e( 'It will require other 3rd party plugins such as Elementor, WooCommerce, Contact form 7, etc.', 'woostify' ); ?>
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
										$button = '<a href="' . esc_url( admin_url( 'admin.php?page=woostify-sites' ) ) . '" class="woostify-button button-primary" target="_blank">' . esc_html__( 'Activate Woostify site library', 'woostify' ) . '</a>';

										// If Woostifu Site install.
										if ( ! defined( 'WOOSTIFY_SITES_VER' ) ) {
											if ( 'deactivate' === $type ) {
												$button = '<a data-redirect="' . esc_url( $redirect ) . '" data-slug="' . esc_attr( $slug ) . '" class="woostify-button button button-primary woostify-active-now" href="' . esc_url( $nonce ) . '">' . esc_html__( 'Activate', 'woostify' ) . '</a>';
											} else {
												$button = '<a data-redirect="' . esc_url( $redirect ) . '" data-slug="' . esc_attr( $plugin_slug ) . '" href="' . esc_url( $nonce ) . '" class="woostify-button install-now button button-primary woostify-install-demo">' . esc_html__( 'Install Woostify Library', 'woostify' ) . '</a>';
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
										<div>
											<?php echo wp_kses_post( $button ); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="woostify-setting-tab-content" data-tab="changelog">
								<div class="changelog-woostify-wrapper">
									<div class="woostify-setting-tab-head">
										<a href="#changelog-woostify-theme" class="tab-head-button active"><?php esc_html_e( 'Woostify Theme', 'woostify' ); ?></a>
										<a href="#changelog-woostify-pro" class="tab-head-button"><?php esc_html_e( 'Woostify Pro', 'woostify' ); ?></a>
									</div>
									<div class="woostify-setting-tab-content changelog-woostify-theme active" data-tab="changelog-woostify-theme">
										<?php $this->woostify_welcome_screen_changelog(); ?>
									</div>
									<div class="woostify-setting-tab-content changelog-woostify-pro" data-tab="changelog-woostify-pro">
										<?php do_action( 'woostify_pro_panel_changelog' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>			
				<!-- <div class="wrap woostify-enhance">
					<div class="woostify-notices-wrap" style="display:none;">
						<h2 class="notices" style="display:none;"></h2>
					</div>
					
					
				</div> -->
			</div>
			<?php
		}

		/**
		 * Add admin setting hide all notice
		 */
		public function woostify_hide_all_noticee_page_setting(){
			$screen = get_current_screen();
			if ( $screen->id == 'toplevel_page_woostify-welcome' ) {
				remove_all_actions( 'user_admin_notices' );
				remove_all_actions( 'admin_notices' );
			}				
			
		}

		public function woostify_admin_panel_sidebar(){
			$woostify_url = 'https://woostify.com';
			$facebook_url = 'https://facebook.com';
			?>
			<div class="woostify-enhance__column list-section-wrapper">
				<h3>
					<?php esc_html_e( 'Document', 'woostify' ); ?>
					<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.9399 22.5202H15.0133H6.71994C6.17006 22.5202 5.6427 22.3024 5.25387 21.9146C4.86505 21.5269 4.64661 21.001 4.64661 20.4527V5.97968C4.64661 5.43132 4.86505 4.90543 5.25387 4.51769C5.6427 4.12994 6.17006 3.91211 6.71994 3.91211H19.1599C19.7098 3.91211 20.2372 4.12994 20.626 4.51769C21.0148 4.90543 21.2333 5.43132 21.2333 5.97968V14.2499" stroke="#1F2229" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M18.1233 18.3851C18.1233 18.6593 18.2325 18.9222 18.4269 19.1161C18.6213 19.31 18.885 19.4189 19.16 19.4189H22.27C22.5449 19.4189 22.8086 19.31 23.003 19.1161C23.1974 18.9222 23.3066 18.6593 23.3066 18.3851C23.3066 18.1109 23.1974 17.848 23.003 17.6541C22.8086 17.4602 22.5449 17.3513 22.27 17.3513H19.16C18.885 17.3513 18.6213 17.4602 18.4269 17.6541C18.2325 17.848 18.1233 18.1109 18.1233 18.3851ZM23.3066 22.5202C23.3066 22.2461 23.1974 21.9831 23.003 21.7892C22.8086 21.5954 22.5449 21.4865 22.27 21.4865H19.16C18.885 21.4865 18.6213 21.5954 18.4269 21.7892C18.2325 21.9831 18.1233 22.2461 18.1233 22.5202C18.1233 22.7944 18.2325 23.0574 18.4269 23.2512C18.6213 23.4451 18.885 23.554 19.16 23.554H22.27C22.5449 23.554 22.8086 23.4451 23.003 23.2512C23.1974 23.0574 23.3066 22.7944 23.3066 22.5202Z" fill="#1F2229"/>
						<path d="M9.82996 15.8007L12.658 9.69102C12.683 9.63746 12.7228 9.59212 12.7727 9.56036C12.8227 9.52859 12.8807 9.51172 12.94 9.51172C12.9992 9.51172 13.0572 9.52859 13.1072 9.56036C13.1571 9.59212 13.1969 9.63746 13.2219 9.69102L16.05 15.8007" stroke="#1F2229" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M10.452 13.2162H15.428V15.077H10.452V13.2162Z" fill="#1F2229"/>
					</svg>
				</h3>

				<div class="wf-quick-setting-section">
					<p>
						<?php esc_html_e( 'Want a guide? We have video tutorials to walk you through getting started.', 'woostify' ); ?>
					</p>

					<p>
						<a href="<?php echo esc_url( $woostify_url ); ?>/docs" class="woostify-button"><?php esc_html_e( 'Go to Documentation', 'woostify' ); ?></a>
					</p>
				</div>
			</div>

			<div class="woostify-enhance__column list-section-wrapper">
				<h3>
					<?php esc_html_e( 'Community', 'woostify' ); ?>
					<svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_44_2454)">
							<path d="M25.5366 12C25.5366 5.3725 19.9671 0 13.0966 0C6.22611 0 0.656616 5.3725 0.656616 12C0.656616 17.9895 5.20551 22.954 11.1529 23.854V15.469H7.99414V12H11.1529V9.356C11.1529 6.349 13.0101 4.6875 15.8516 4.6875C17.2122 4.6875 18.636 4.922 18.636 4.922V7.875H17.0676C15.5224 7.875 15.0404 8.8 15.0404 9.75V12H18.4904L17.9389 15.469H15.0404V23.854C20.9877 22.954 25.5366 17.989 25.5366 12Z" fill="black"/>
						</g>
						<defs>
							<clipPath id="clip0_44_2454">
							<rect width="24.88" height="24" fill="white" transform="translate(0.656616)"/>
							</clipPath>
						</defs>
					</svg>
				</h3>

				<div class="wf-quick-setting-section">
					<p>
						<?php esc_html_e( 'Join our community! Share your site, ask a question and help others.', 'woostify' ); ?>
					</p>

					<p>
						<a href="<?php echo esc_url( $facebook_url ); ?>/groups/2245150649099616/" class="woostify-button"><?php esc_html_e( 'Go to Facebook Group', 'woostify' ); ?></a>
					</p>
				</div>
			</div>

			<div class="woostify-enhance__column list-section-wrapper">
				<h3>
					<?php esc_html_e( 'Support', 'woostify' ); ?>
					<svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M21.9301 1.5C22.205 1.5 22.4687 1.60536 22.6631 1.79289C22.8575 1.98043 22.9667 2.23478 22.9667 2.5V18.5C22.9667 18.7652 22.8575 19.0196 22.6631 19.2071C22.4687 19.3946 22.205 19.5 21.9301 19.5H16.6311L13.2931 22.398C13.1027 22.5631 12.8558 22.6545 12.5998 22.6545C12.3438 22.6545 12.0969 22.5631 11.9065 22.398L8.56847 19.5H3.27007C2.99512 19.5 2.73144 19.3946 2.53703 19.2071C2.34262 19.0196 2.2334 18.7652 2.2334 18.5V2.5C2.2334 2.23478 2.34262 1.98043 2.53703 1.79289C2.73144 1.60536 2.99512 1.5 3.27007 1.5H21.9301ZM20.8934 3.5H4.30673V17.5H9.36411L12.6001 20.309L15.8355 17.5H20.8934V3.5ZM17.7834 10C17.7834 9.86739 17.7288 9.74021 17.6316 9.64645C17.5344 9.55268 17.4025 9.5 17.2651 9.5H7.93506C7.79759 9.5 7.66575 9.55268 7.56855 9.64645C7.47134 9.74021 7.41673 9.86739 7.41673 10V11C7.41673 11.1326 7.47134 11.2598 7.56855 11.3536C7.66575 11.4473 7.79759 11.5 7.93506 11.5H17.2651C17.4025 11.5 17.5344 11.4473 17.6316 11.3536C17.7288 11.2598 17.7834 11.1326 17.7834 11V10Z" fill="black"/>
					</svg>
				</h3>

				<div class="wf-quick-setting-section">
					<p>
						<?php esc_html_e( 'Have a question, we are happy to help! Get in touch with our support team.', 'woostify' ); ?>
					</p>

					<p>
						<a href="<?php echo esc_url( $woostify_url ); ?>/contact/" class="woostify-button"><?php esc_html_e( 'Submit a Ticket', 'woostify' ); ?></a>
					</p>
				</div>
			</div>

			<div class="woostify-enhance__column list-section-wrapper">
				<h3>
					<?php esc_html_e( 'Give us feedback', 'woostify' ); ?>
					<svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M21.9301 1.5C22.205 1.5 22.4687 1.60536 22.6631 1.79289C22.8575 1.98043 22.9667 2.23478 22.9667 2.5V18.5C22.9667 18.7652 22.8575 19.0196 22.6631 19.2071C22.4687 19.3946 22.205 19.5 21.9301 19.5H16.6311L13.2931 22.398C13.1027 22.5631 12.8558 22.6545 12.5998 22.6545C12.3438 22.6545 12.0969 22.5631 11.9065 22.398L8.56847 19.5H3.27007C2.99512 19.5 2.73144 19.3946 2.53703 19.2071C2.34262 19.0196 2.2334 18.7652 2.2334 18.5V2.5C2.2334 2.23478 2.34262 1.98043 2.53703 1.79289C2.73144 1.60536 2.99512 1.5 3.27007 1.5H21.9301ZM20.8934 3.5H4.30673V17.5H9.36411L12.6001 20.309L15.8355 17.5H20.8934V3.5ZM17.7834 10C17.7834 9.86739 17.7288 9.74021 17.6316 9.64645C17.5344 9.55268 17.4025 9.5 17.2651 9.5H7.93506C7.79759 9.5 7.66575 9.55268 7.56855 9.64645C7.47134 9.74021 7.41673 9.86739 7.41673 10V11C7.41673 11.1326 7.47134 11.2598 7.56855 11.3536C7.66575 11.4473 7.79759 11.5 7.93506 11.5H17.2651C17.4025 11.5 17.5344 11.4473 17.6316 11.3536C17.7288 11.2598 17.7834 11.1326 17.7834 11V10Z" fill="black"/>
					</svg>
				</h3>

				<div class="wf-quick-setting-section">
					<p>
						<?php esc_html_e( 'Join our community! Share your site, ask a question and help others.', 'woostify' ); ?>
					</p>
					<p>
						<a href="<?php echo esc_url( '//wordpress.org/support/theme/woostify/reviews/#new-post' ); ?>/contact/" class="woostify-button">
							<?php esc_html_e( 'Write a Review', 'woostify' ); ?>
							<svg width="96" height="16" viewBox="0 0 96 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.0085 15.9959C12.8756 15.9964 12.7445 15.9647 12.6262 15.9033L8.38756 13.6559L4.14891 15.9033C3.86811 16.0528 3.52774 16.0274 3.27162 15.8378C3.0155 15.6482 2.88831 15.3274 2.9438 15.0111L3.77491 10.2723L0.350749 6.90545C0.133045 6.68542 0.0531162 6.36163 0.142972 6.06374C0.241245 5.75856 0.502362 5.53655 0.816169 5.49138L5.55348 4.79276L7.63956 0.474815C7.77843 0.184434 8.06897 0 8.38756 0C8.70614 0 8.99669 0.184434 9.13555 0.474815L11.2466 4.78435L15.9839 5.48296C16.2977 5.52813 16.5588 5.75014 16.6571 6.05532C16.7469 6.35321 16.667 6.67701 16.4493 6.89703L13.0251 10.2639L13.8562 15.0027C13.9168 15.3249 13.7871 15.6534 13.5238 15.8444C13.3733 15.9512 13.1921 16.0044 13.0085 15.9959Z" fill="#212B36"/>
								<path d="M33.7418 15.9959C33.6089 15.9964 33.4778 15.9647 33.3595 15.9033L29.1208 13.6559L24.8822 15.9033C24.6014 16.0528 24.261 16.0274 24.0049 15.8378C23.7488 15.6482 23.6216 15.3274 23.6771 15.0111L24.5082 10.2723L21.084 6.90545C20.8663 6.68542 20.7864 6.36163 20.8762 6.06374C20.9745 5.75856 21.2356 5.53655 21.5494 5.49138L26.2868 4.79276L28.3728 0.474815C28.5117 0.184434 28.8022 0 29.1208 0C29.4394 0 29.73 0.184434 29.8688 0.474815L31.9798 4.78435L36.7172 5.48296C37.031 5.52813 37.2921 5.75014 37.3904 6.05532C37.4802 6.35321 37.4003 6.67701 37.1826 6.89703L33.7584 10.2639L34.5895 15.0027C34.6501 15.3249 34.5204 15.6534 34.2571 15.8444C34.1066 15.9512 33.9254 16.0044 33.7418 15.9959Z" fill="#212B36"/>
								<path d="M53.4384 15.9959C53.3055 15.9964 53.1744 15.9647 53.0561 15.9033L48.8175 13.6559L44.5788 15.9033C44.298 16.0528 43.9577 16.0274 43.7015 15.8378C43.4454 15.6482 43.3182 15.3274 43.3737 15.0111L44.2048 10.2723L40.7807 6.90545C40.563 6.68542 40.483 6.36163 40.5729 6.06374C40.6712 5.75856 40.9323 5.53655 41.2461 5.49138L45.9834 4.79276L48.0695 0.474815C48.2084 0.184434 48.4989 0 48.8175 0C49.1361 0 49.4266 0.184434 49.5655 0.474815L51.6765 4.78435L56.4138 5.48296C56.7276 5.52813 56.9887 5.75014 57.087 6.05532C57.1769 6.35321 57.0969 6.67701 56.8792 6.89703L53.4551 10.2639L54.2862 15.0027C54.3468 15.3249 54.217 15.6534 53.9537 15.8444C53.8032 15.9512 53.622 16.0044 53.4384 15.9959Z" fill="#212B36"/>
								<path d="M73.1352 15.9959C73.0023 15.9964 72.8712 15.9647 72.7529 15.9033L68.5143 13.6559L64.2756 15.9033C63.9948 16.0528 63.6544 16.0274 63.3983 15.8378C63.1422 15.6482 63.015 15.3274 63.0705 15.0111L63.9016 10.2723L60.4775 6.90545C60.2598 6.68542 60.1798 6.36163 60.2697 6.06374C60.368 5.75856 60.6291 5.53655 60.9429 5.49138L65.6802 4.79276L67.7663 0.474815C67.9051 0.184434 68.1957 0 68.5143 0C68.8328 0 69.1234 0.184434 69.2623 0.474815L71.3733 4.78435L76.1106 5.48296C76.4244 5.52813 76.6855 5.75014 76.7838 6.05532C76.8736 6.35321 76.7937 6.67701 76.576 6.89703L73.1518 10.2639L73.983 15.0027C74.0435 15.3249 73.9138 15.6534 73.6505 15.8444C73.5 15.9512 73.3188 16.0044 73.1352 15.9959Z" fill="#212B36"/>
								<path d="M91.7951 15.9959C91.6622 15.9964 91.5311 15.9647 91.4128 15.9033L87.1742 13.6559L82.9355 15.9033C82.6547 16.0528 82.3144 16.0274 82.0582 15.8378C81.8021 15.6482 81.6749 15.3274 81.7304 15.0111L82.5615 10.2723L79.1374 6.90545C78.9197 6.68542 78.8397 6.36163 78.9296 6.06374C79.0279 5.75856 79.289 5.53655 79.6028 5.49138L84.3401 4.79276L86.4262 0.474815C86.565 0.184434 86.8556 0 87.1742 0C87.4928 0 87.7833 0.184434 87.9222 0.474815L90.0332 4.78435L94.7705 5.48296C95.0843 5.52813 95.3454 5.75014 95.4437 6.05532C95.5336 6.35321 95.4536 6.67701 95.2359 6.89703L91.8118 10.2639L92.6429 15.0027C92.7034 15.3249 92.5737 15.6534 92.3104 15.8444C92.1599 15.9512 91.9787 16.0044 91.7951 15.9959Z" fill="#212B36"/>
							</svg>
						</a>
					</p>
				</div>

			</div>
			<?php
		}
	}

	Woostify_Admin::get_instance();

endif;
