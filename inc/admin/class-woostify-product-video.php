<?php
/**
 * Product Video Gallery
 *
 * @package Woostify
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woostify_Product_Video' ) ) {
	/**
	 * Woostify Product Video Class
	 */
	class Woostify_Product_Video {
		/**
		 * Instance
		 *
		 * @var $instance
		 */
		private static $instance = null;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_footer', array( $this, 'modal_markup' ) );
			add_action( 'wp_ajax_woostify_get_attachment_video_data', array( $this, 'get_attachment_video_data' ) );
			add_action( 'wp_ajax_woostify_save_attachment_video_data', array( $this, 'save_attachment_video_data' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		}

		/**
		 * Enqueue Frontend Scripts
		 */
		public function enqueue_frontend_scripts() {
			if ( ! is_product() ) {
				return;
			}

			wp_enqueue_style(
				'woostify-product-video-gallery-frontend',
				WOOSTIFY_THEME_URI . 'assets/css/product-video-gallery-frontend.css',
				array(),
				woostify_version()
			);

			wp_enqueue_script(
				'woostify-product-video-gallery-frontend',
				WOOSTIFY_THEME_URI . 'assets/js/product-video-gallery-frontend.js',
				array( 'jquery' ),
				woostify_version(),
				true
			);
		}

		/**
		 * Enqueue Scripts
		 */
		public function enqueue_scripts() {
			$screen = get_current_screen();
			if ( 'product' !== $screen->post_type ) {
				return;
			}

			wp_enqueue_style(
				'woostify-product-video-gallery',
				WOOSTIFY_THEME_URI . 'assets/css/admin/product-video-gallery.css',
				array(),
				woostify_version()
			);

			wp_enqueue_script(
				'woostify-product-video-gallery',
				WOOSTIFY_THEME_URI . 'assets/js/admin/product-video-gallery.js',
				array( 'jquery' ),
				woostify_version(),
				true
			);

			
			wp_enqueue_media();

			// Get current product images to set initial state
			global $post;
			$video_map = array();
			if ( $post ) {
				$product = wc_get_product( $post->ID );
				if ( $product ) {
					$attachment_ids = $product->get_gallery_image_ids();
					$thumbnail_id   = $product->get_image_id();
					if ( $thumbnail_id ) {
						$attachment_ids[] = $thumbnail_id;
					}

					if ( ! empty( $attachment_ids ) ) {
						foreach ( $attachment_ids as $att_id ) {
							$url = get_post_meta( $att_id, 'woostify_video_url', true );
							if ( ! empty( $url ) ) {
								$video_map[ $att_id ] = true;
							}
						}
					}
				}
			}

			wp_localize_script(
				'woostify-product-video-gallery',
				'woostify_product_video_gallery',
				array(
					'nonce'        => wp_create_nonce( 'woostify_product_video_gallery_nonce' ),
					'video_exists' => $video_map,
				)
			);
		}

		/**
		 * Get Attachment Video Data
		 */
		public function get_attachment_video_data() {
			check_ajax_referer( 'woostify_product_video_gallery_nonce', 'nonce' );

			$attachment_id = isset( $_POST['attachment_id'] ) ? absint( $_POST['attachment_id'] ) : 0;
			if ( ! $attachment_id ) {
				wp_send_json_error( 'Invalid attachment ID' );
			}

			$data = array(
				'source'        => get_post_meta( $attachment_id, 'woostify_video_source', true ),
				'url'           => get_post_meta( $attachment_id, 'woostify_video_url', true ),
				'autoplay'      => get_post_meta( $attachment_id, 'woostify_video_autoplay', true ),
				'mute'          => get_post_meta( $attachment_id, 'woostify_video_mute', true ),
			);

			wp_send_json_success( $data );
		}

		/**
		 * Save Attachment Video Data
		 */
		public function save_attachment_video_data() {
			check_ajax_referer( 'woostify_product_video_gallery_nonce', 'nonce' );

			$attachment_id = isset( $_POST['attachment_id'] ) ? absint( $_POST['attachment_id'] ) : 0;
			if ( ! $attachment_id ) {
				wp_send_json_error( 'Invalid attachment ID' );
			}

			$source        = isset( $_POST['source'] ) ? sanitize_text_field( $_POST['source'] ) : 'youtube';
			$url           = isset( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : '';
			$autoplay      = isset( $_POST['autoplay'] ) ? sanitize_text_field( $_POST['autoplay'] ) : '';
			$mute          = isset( $_POST['mute'] ) ? sanitize_text_field( $_POST['mute'] ) : '';

			update_post_meta( $attachment_id, 'woostify_video_source', $source );
			update_post_meta( $attachment_id, 'woostify_video_url', $url );
			update_post_meta( $attachment_id, 'woostify_video_autoplay', $autoplay );
			update_post_meta( $attachment_id, 'woostify_video_mute', $mute );

			wp_send_json_success( 'Saved successfully' );
		}

		/**
		 * Modal Markup
		 */
		public function modal_markup() {
			$screen = get_current_screen();
			if ( 'product' !== $screen->post_type ) {
				return;
			}
			?>
			<div id="woostify-product-video-modal" class="woostify-modal" style="display:none;">
				<div class="woostify-modal-content">
					<div class="woostify-modal-header">
						<h2><?php esc_html_e( 'Product gallery video', 'woostify' ); ?></h2>
						<span class="woostify-modal-close">&times;</span>
					</div>
					<div class="woostify-modal-body">
						
						<div class="woostify-form-group">
							<label><?php esc_html_e( 'Video source', 'woostify' ); ?></label>
							<div class="woostify-video-source-tabs">
								<button type="button" class="woostify-tab-btn" data-tab="mp4"><?php esc_html_e( 'MP4', 'woostify' ); ?></button>
								<button type="button" class="woostify-tab-btn active" data-tab="youtube"><?php esc_html_e( 'YouTube', 'woostify' ); ?></button>
							</div>
							<input type="hidden" id="woostify-video-source" value="youtube">
						</div>

						<div class="woostify-tab-content" id="woostify-tab-youtube">
							<div class="woostify-form-group">
								<label for="woostify-video-url"><?php esc_html_e( 'YouTube video URL', 'woostify' ); ?></label>
								<input type="text" id="woostify-video-url" class="widefat" placeholder="https://www.youtube.com/...">
								<p class="description"><?php esc_html_e( 'Example: https://youtu.be/LXb3EKWsInQ', 'woostify' ); ?></p>
							</div>
						</div>

						<div class="woostify-tab-content" id="woostify-tab-mp4" style="display: none;">
							<div class="woostify-form-group">
								<label for="woostify-mp4-url"><?php esc_html_e( 'MP4 video file', 'woostify' ); ?></label>
								<div class="woostify-mp4-upload-wrapper">
									<input type="text" id="woostify-mp4-url" class="widefat" readonly placeholder="<?php esc_html_e( 'No file selected', 'woostify' ); ?>">
									<button type="button" class="button" id="woostify-upload-mp4-btn">
										<span class="dashicons dashicons-upload" style="margin-top: 3px;"></span> 
										<?php esc_html_e( 'Upload', 'woostify' ); ?>
									</button>
								</div>
								<p class="description"><?php esc_html_e( 'Upload a new or select (.mp4) video file from the media library.', 'woostify' ); ?></p>
							</div>
						</div>

						<div class="woostify-form-group">
							<div class="woostify-toggle-group">
								<label for="woostify-video-autoplay"><?php esc_html_e( 'Autoplay', 'woostify' ); ?></label>
								<label class="woostify-switch">
									<input type="checkbox" id="woostify-video-autoplay">
									<span class="slider round"></span>
								</label>
							</div>
							<p class="description"><?php esc_html_e( 'Start playback after the gallery is loaded.', 'woostify' ); ?></p>
						</div>

						<div class="woostify-form-group">
							<label><?php esc_html_e( 'Audio status', 'woostify' ); ?></label>
							<div class="woostify-video-audio-options">
								<button type="button" class="woostify-btn-audio active" data-value="0"><?php esc_html_e( 'Unmute', 'woostify' ); ?></button>
								<button type="button" class="woostify-btn-audio" data-value="1"><?php esc_html_e( 'Mute', 'woostify' ); ?></button>
							</div>
							<input type="hidden" id="woostify-video-mute" value="0">
							<p class="description"><?php esc_html_e( 'Audio in autoplay videos is always muted.', 'woostify' ); ?></p>
						</div>
					</div>
					<div class="woostify-modal-footer">
						<button type="button" class="button button-primary woostify-save-video"><?php esc_html_e( 'Save', 'woostify' ); ?></button>
					</div>
				</div>
				<div class="woostify-modal-overlay"></div>
			</div>
			<?php
		}
	}

	Woostify_Product_Video::get_instance();
}
