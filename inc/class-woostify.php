<?php
/**
 * Woostify Class
 *
 * @since    1.0
 * @package  woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'woostify' ) ) :

	/**
	 * The main Woostify class
	 */
	class Woostify {

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );

			// After WooCommerce.
			add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 );

			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_filter( 'wp_page_menu_args', array( $this, 'page_menu_args' ) );
			add_filter( 'navigation_markup_template', array( $this, 'navigation_markup_template' ) );
			add_action( 'customize_preview_init', array( $this, 'customize_live_preview' ) );
			add_filter( 'wp_tag_cloud', array( $this, 'remove_tag_inline_style' ) );
			add_filter( 'excerpt_more', array( $this, 'modify_excerpt_more' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function setup() {
			/*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

			// Loads wp-content/languages/themes/woostify-it_IT.mo.
			load_theme_textdomain( 'woostify', WP_LANG_DIR . '/themes/' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'woostify', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/woostify/languages/it_IT.mo.
			load_theme_textdomain( 'woostify', WOOSTIFY_THEME_DIR . 'languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			// Post formats.
			add_theme_support(
				'post-formats',
				array(
					'gallery',
					'image',
					'link',
					'quote',
					'video',
					'audio',
					'status',
					'aside',
				)
			);

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo',
				apply_filters(
					'woostify_custom_logo_args',
					array(
						'height'      => 110,
						'width'       => 470,
						'flex-width'  => true,
						'flex-height' => true,
					)
				)
			);

			/**
			 * Register menu locations.
			 */
			register_nav_menus(
				apply_filters(
					'woostify_register_nav_menus',
					array(
						'primary'     => __( 'Primary Menu', 'woostify' ),
						'footer_menu' => __( 'Footer Menu', 'woostify' ),
					)
				)
			);

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5',
				apply_filters(
					'woostify_html5_args',
					array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
					)
				)
			);

			/**
			 * Setup the WordPress core custom background feature.
			 */
			add_theme_support(
				'custom-background',
				apply_filters(
					'woostify_custom_background_args',
					array(
						'default-color' => apply_filters( 'woostify_default_background_color', 'ffffff' ),
						'default-image' => '',
					)
				)
			);

			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {
			$sidebar_args['sidebar'] = array(
				'name'          => __( 'Main Sidebar', 'woostify' ),
				'id'            => 'sidebar',
				'description'   => __( 'Appears in the sidebar of the site.', 'woostify' ),
			);

			if ( class_exists( 'woocommerce' ) ) {
				$sidebar_args['shop_sidebar'] = array(
					'name'          => __( 'Woocommerce Sidebar', 'woostify' ),
					'id'            => 'sidebar-shop',
					'description'   => __( ' Appears in the sidebar of shop/product page.', 'woostify' ),
				);
			}

			$sidebar_args['footer'] = array(
				'name'        => __( 'Footer Widget', 'woostify' ),
				'id'          => 'footer',
				'description' => __( 'Appears in the footer section of the site.', 'woostify' ),
			);

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 */
				$filter_hook = sprintf( 'woostify_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}

			// Custom widgets.
			register_widget( 'Woostify_Recent_Post_Thumbnail' );
		}

		/**
		 * Enqueue scripts and styles.
		 */
		public function scripts() {
			global $woostify_version;
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			/**
			 * Styles
			 */
			wp_enqueue_style(
				'woostify-style',
				WOOSTIFY_THEME_URI . 'style.css',
				array(),
				$woostify_version
			);

			/**
			 * Scripts
			 */

			// General script.
			wp_enqueue_script(
				'woostify-general',
				WOOSTIFY_THEME_URI . 'assets/js/general' . $suffix . '.js',
				array(),
				$woostify_version,
				true
			);

			// Mobile menu.
			wp_enqueue_script(
				'woostify-navigation',
				WOOSTIFY_THEME_URI . 'assets/js/navigation' . $suffix . '.js',
				array( 'jquery' ),
				$woostify_version,
				true
			);

			// Quantity button.
			wp_register_script(
				'woostify-quantity-button',
				WOOSTIFY_THEME_URI . 'assets/js/woocommerce/quantity-button' . $suffix . '.js',
				array( 'jquery' ),
				$woostify_version,
				true
			);

			// Single add to cart.
			wp_register_script(
				'woostify-single-add-to-cart',
				WOOSTIFY_THEME_URI . 'assets/js/woocommerce/single-add-to-cart' . $suffix . '.js',
				array(),
				$woostify_version,
				true
			);

			// Woocommerce.
			wp_register_script(
				'woostify-woocommerce',
				WOOSTIFY_THEME_URI . 'assets/js/woocommerce/woocommerce' . $suffix . '.js',
				array( 'jquery' ),
				$woostify_version,
				true
			);

			// Product gallery zoom.
			wp_register_script(
				'easyzoom',
				WOOSTIFY_THEME_URI . 'assets/js/easyzoom' . $suffix . '.js',
				array( 'jquery' ),
				$woostify_version,
				true
			);

			// Product gallery zoom handle.
			wp_register_script(
				'easyzoom-handle',
				WOOSTIFY_THEME_URI . 'assets/js/woocommerce/easyzoom-handle' . $suffix . '.js',
				array( 'easyzoom' ),
				$woostify_version,
				true
			);

			// Product varitions.
			wp_register_script(
				'woostify-product-variation',
				WOOSTIFY_THEME_URI . 'assets/js/woocommerce/product-variation' . $suffix . '.js',
				array( 'jquery', 'easyzoom-handle' ),
				$woostify_version,
				true
			);

			// Tiny slider js.
			wp_register_script(
				'tiny-slider',
				WOOSTIFY_THEME_URI . 'assets/js/tiny-slider.min' . $suffix . '.js',
				array(),
				$woostify_version,
				true
			);

			// Photoswipe init js.
			wp_register_script(
				'photoswipe-init',
				WOOSTIFY_THEME_URI . 'assets/js/photoswipe-init' . $suffix . '.js',
				array( 'photoswipe', 'photoswipe-ui-default' ),
				$woostify_version,
				true
			);

			// Comment reply.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style(
					'woostify-child-style',
					get_stylesheet_uri(),
					array(),
					$child_theme->get( 'Version' )
				);
			}
		}

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 * @return array
		 */
		public function page_menu_args( $args ) {
			$args['show_home'] = true;
			return $args;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function body_classes( $classes ) {
			$options   = woostify_options( false );

			// Theme version.
			global $woostify_version;
			$classes[] = 'woostify-' . $woostify_version;

			// Broser detection.
			if ( '' != woostify_browser_detection() ) {
				$classes[] = woostify_browser_detection() . '-detected';
			}

			// Site container layout.
			$page_id                = woostify_get_page_id();
			$metabox_container      = get_post_meta( $page_id, 'site-container', true );

			if ( ! empty( $metabox_container ) && 'default' != $metabox_container ) {
				$classes[] = 'site-' . $metabox_container . '-container';
			} else {
				$classes[] = 'site-' . $options['default_container'] . '-container';
			}

			// Header layout.
			$classes[] = 'header-' . $options['header_layout'];

			// Sidebar class detected.
			$classes[] = woostify_sidebar_class();

			return $classes;
		}

		/**
		 * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
		 */
		public function navigation_markup_template() {
			$template  = '<nav id="post-navigation" class="navigation %1$s" role="navigation" aria-label="' . esc_html__( 'Post Navigation', 'woostify' ) . '">';
			$template .= '<h2 class="screen-reader-text">%2$s</h2>';
			$template .= '<div class="nav-links">%3$s</div>';
			$template .= '</nav>';

			return apply_filters( 'woostify_navigation_markup_template', $template );
		}

		/**
		 * Customizer live preview
		 */
		public function customize_live_preview() {
			global $woostify_version;
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_script(
				'woostify-customize-preview-js',
				WOOSTIFY_THEME_URI . '/assets/js/customize-preview' . $suffix . '.js',
				array(),
				$woostify_version,
				true
			);
		}

		/**
		 * Remove inline css on tag cloud
		 *
		 * @param string $string tagCloud.
		 */
		public function remove_tag_inline_style( $string ) {
			return preg_replace( '/ style=("|\')(.*?)("|\')/', '', $string );
		}


		/**
		 * Modify excerpt more to `...`
		 *
		 * @param string $more More exerpt.
		 */
		public function modify_excerpt_more( $more ) {
			return '...';
		}
	}
endif;

return new Woostify();
