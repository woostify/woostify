<?php
/**
 * Post Meta Box
 *
 * @package Woostify
 */

/**
 * Meta Boxes setup
 */
if ( ! class_exists( 'Woostify_Meta_Boxes' ) ) {

	/**
	 * Meta Boxes setup
	 */
	class Woostify_Meta_Boxes {

		/**
		 * Instance
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Meta Option
		 *
		 * @var $meta_option
		 */
		private static $meta_option;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'load-post.php', array( $this, 'woostify_init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'woostify_init_metabox' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'woostify_metabox_assets' ) );
		}

		/**
		 *  Init Metabox
		 */
		public function woostify_init_metabox() {

			add_action( 'add_meta_boxes', array( $this, 'woostify_setup_meta_box' ) );
			add_action( 'save_post', array( $this, 'woostify_save_meta_box' ) );

			/**
			 * Set metabox options
			 *
			 * @see http://php.net/manual/en/filter.filters.sanitize.php
			 */
			self::$meta_option = array(
				'site-container' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-header-transparent' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-sidebar' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-header-primary-menu' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-post-title' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-footer' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
			);
		}


		/**
		 * Add script and style for meta boxs setting
		 */
		public function woostify_metabox_assets() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style(
				'woostify-metabox-setting-tab',
				WOOSTIFY_THEME_URI . 'assets/css/admin/metabox.css',
				array(),
				woostify_version()
			);

			wp_enqueue_script(
				'woostify-metabox-setting-tab',
				WOOSTIFY_THEME_URI . 'assets/js/admin/metabox' . $suffix . '.js',
				array( 'jquery' ),
				woostify_version(),
				true
			);
		}

		/**
		 *  Setup Metabox
		 */
		public function woostify_setup_meta_box() {

			// Get all public posts.
			$post_types = apply_filters(
				'woostify_metabox_post_types',
				array( 'post', 'page' )
			);

			// Enable for all posts.
			foreach ( $post_types as $type ) {
				$metabox_name = ucwords( $type ) . __( ' Settings', 'woostify' );

				add_meta_box(
					'woostify_settings_meta_box',           // Id.
					$metabox_name,                          // Title.
					array( $this, 'woostify_markup_meta_box' ),      // Callback.
					$type,                                  // Post_type.
					'side'                             // Context.
				);
			}
		}

		/**
		 * Get metabox options
		 */
		public static function woostify_get_meta_option() {
			return self::$meta_option;
		}

		/**
		 * Metabox Markup
		 *
		 * @param  object $post Post object.
		 * @return void
		 */
		public function woostify_markup_meta_box( $post ) {

			wp_nonce_field( basename( __FILE__ ), 'woostify_settings_meta_box' );
			$stored = get_post_meta( $post->ID );

			// Set stored and override defaults.
			foreach ( $stored as $key => $value ) {
				self::$meta_option[ $key ]['default'] = isset( $stored[ $key ][0] ) ? $stored[ $key ][0] : '';
			}

			// Get defaults.
			$meta = self::woostify_get_meta_option();

			/**
			 * Get options
			 */
			$site_container          = isset( $meta['site-container']['default'] ) ? $meta['site-container']['default'] : 'default';
			$site_sidebar            = isset( $meta['site-sidebar']['default'] ) ? $meta['site-sidebar']['default'] : 'default';
			$site_header_transparent = isset( $meta['site-header-transparent']['default'] ) ? $meta['site-header-transparent']['default'] : 'default';

			$site_header_menu        = isset( $meta['site-header-primary-menu']['default'] ) ? $meta['site-header-primary-menu']['default'] : 'default';
			$site_post_title         = isset( $meta['site-post-title']['default'] ) ? $meta['site-post-title']['default'] : 'default';
			$site_footer             = isset( $meta['site-footer']['default'] ) ? $meta['site-footer']['default'] : 'default';
			?>

			<div class="woostify-metabox-setting">
				<div class="woostify-metabox-content-box">
					<div class="woostify-metabox-content">
						<?php // Option: Container. ?>
						<div class="woostify-metabox-option">
							<div class="woostify-metabox-option-title">
								<span><?php esc_html_e( 'Container', 'woostify' ); ?>:</span>
							</div>

							<div class="woostify-metabox-option-content">
								<select name="site-container" id="site-container">
									<option value="default" <?php selected( $site_container, 'default' ); ?> >
										<?php esc_html_e( 'Customizer Setting', 'woostify' ); ?>
									</option>

									<option value="normal" <?php selected( $site_container, 'normal' ); ?> >
										<?php esc_html_e( 'Normal', 'woostify' ); ?>
									</option>

									<option value="boxed" <?php selected( $site_container, 'boxed' ); ?> >
										<?php esc_html_e( 'Boxed', 'woostify' ); ?>
									</option>

									<option value="full-width" <?php selected( $site_container, 'full-width' ); ?> >
										<?php esc_html_e( 'Full Width', 'woostify' ); ?>
									</option>
								</select>
							</div>
						</div>

						<?php // Option: Sidebar. ?>
						<div class="woostify-metabox-option">
							<div class="woostify-metabox-option-title">
								<span><?php esc_html_e( 'Sidebar', 'woostify' ); ?>:</span>
							</div>

							<div class="woostify-metabox-option-content">
								<select name="site-sidebar" id="site-sidebar">
									<option value="default" <?php selected( $site_sidebar, 'default' ); ?> >
										<?php esc_html_e( 'Customizer Setting', 'woostify' ); ?>
									</option>

									<option value="left" <?php selected( $site_sidebar, 'left' ); ?> >
										<?php esc_html_e( 'Left Sidebar', 'woostify' ); ?>
									</option>

									<option value="right" <?php selected( $site_sidebar, 'right' ); ?> >
										<?php esc_html_e( 'Right Sidebar', 'woostify' ); ?>
									</option>

									<option value="full" <?php selected( $site_sidebar, 'full' ); ?> >
										<?php esc_html_e( 'No Sidebar', 'woostify' ); ?>
									</option>
								</select>
							</div>
						</div>

						<?php // Option: Transparent Header. ?>
						<!-- <div class="woostify-metabox-option">
							<div class="woostify-metabox-option-title">
								<span><?php esc_html_e( 'Transparent Header', 'woostify' ); ?>:</span>
							</div>

							<div class="woostify-metabox-option-content">
								<select name="site-header-transparent" id="site-header-transparent">
									<option value="default" <?php selected( $site_header_transparent, 'default' ); ?> >
										<?php esc_html_e( 'Customizer Setting', 'woostify' ); ?>
									</option>

									<option value="enabled" <?php selected( $site_header_transparent, 'enabled' ); ?> >
										<?php esc_html_e( 'Enabled', 'woostify' ); ?>
									</option>

									<option value="disabled" <?php selected( $site_header_transparent, 'disabled' ); ?> >
										<?php esc_html_e( 'Disabled', 'woostify' ); ?>
									</option>
								</select>
							</div>
						</div> -->

						<?php // Option: Disable Sections - Primary Header, Title, Footer Widgets, Footer Bar. ?>
						<div class="woostify-metabox-option">
							<div class="woostify-metabox-option-title">
								<span><?php esc_html_e( 'Disable Sections', 'woostify' ); ?>:</span>
							</div>

							<div class="woostify-metabox-option-content">
								<div class="disable-section-meta">
									<div class="site-header-primary-menu-option-wrap">
										<label for="site-header-primary-menu">
											<input type="checkbox" id="site-header-primary-menu" name="site-header-primary-menu" value="disabled" <?php checked( $site_header_menu, 'disabled' ); ?> />
											<?php esc_html_e( 'Disable Header Menu', 'woostify' ); ?>
										</label>
									</div>

									<div class="site-post-title-option-wrap">
										<label for="site-post-title">
											<input type="checkbox" id="site-post-title" name="site-post-title" value="disabled" <?php checked( $site_post_title, 'disabled' ); ?> />
											<?php esc_html_e( 'Disable Title', 'woostify' ); ?>
										</label>
									</div>

									<div class="site-footer-option-wrap">
										<label for="site-footer">
											<input type="checkbox" id="site-footer" name="site-footer" value="disabled" <?php checked( $site_footer, 'disabled' ); ?> />
											<?php esc_html_e( 'Disable Footer', 'woostify' ); ?>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Metabox Save
		 *
		 * @param  number $post_id Post ID.
		 * @return void
		 */
		public function woostify_save_meta_box( $post_id ) {

			// Checks save status.
			$is_autosave    = wp_is_post_autosave( $post_id );
			$is_revision    = wp_is_post_revision( $post_id );
			$is_valid_nonce = ( isset( $_POST['woostify_settings_meta_box'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woostify_settings_meta_box'] ) ), basename( __FILE__ ) ) ) ? true : false;

			// Exits script depending on save status.
			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return;
			}

			/**
			 * Get meta options
			 */
			$post_meta = self::woostify_get_meta_option();

			foreach ( $post_meta as $key => $data ) {

				// Sanitize values.
				$sanitize_filter = isset( $data['sanitize'] ) ? $data['sanitize'] : 'FILTER_DEFAULT';

				switch ( $sanitize_filter ) {

					case 'FILTER_SANITIZE_STRING':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
						break;

					case 'FILTER_SANITIZE_URL':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
						break;

					case 'FILTER_SANITIZE_NUMBER_INT':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
						break;

					default:
							$meta_value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
						break;
				}

				// Store values.
				if ( $meta_value ) {
					update_post_meta( $post_id, $key, $meta_value );
				} else {
					delete_post_meta( $post_id, $key );
				}
			}

		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
Woostify_Meta_Boxes::get_instance();
