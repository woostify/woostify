<?php
/**
 * Woostify Customizer Class
 *
 * @package  woostify
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Storefront_Customizer' ) ) :

	/**
	 * The Woostify Customizer class
	 */
	class Storefront_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class', array( $this, 'layout_class' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
		}

		/**
		 * Returns an array of the desired default Woostify Options
		 *
		 * @return array
		 */
		public static function get_woostify_default_setting_values() {
			return apply_filters(
				'woostify_setting_default_values', $args = array(
					'woostify_heading_color'               => '#333333',
					'woostify_text_color'                  => '#6d6d6d',
					'woostify_accent_color'                => '#96588a',
					'woostify_hero_heading_color'          => '#000000',
					'woostify_hero_text_color'             => '#000000',
					'woostify_header_background_color'     => '#ffffff',
					'woostify_header_text_color'           => '#404040',
					'woostify_header_link_color'           => '#333333',
					'woostify_footer_background_color'     => '#f0f0f0',
					'woostify_footer_heading_color'        => '#333333',
					'woostify_footer_text_color'           => '#6d6d6d',
					'woostify_footer_link_color'           => '#333333',
					'woostify_button_background_color'     => '#eeeeee',
					'woostify_button_text_color'           => '#333333',
					'woostify_button_alt_background_color' => '#333333',
					'woostify_button_alt_text_color'       => '#ffffff',
					'woostify_layout'                      => 'right',
					'background_color'                       => 'ffffff',
				)
			);
		}

		/**
		 * Adds a value to each Woostify setting if one isn't already present.
		 *
		 * @uses get_woostify_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( self::get_woostify_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value Theme modification value.
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_woostify_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter woostify_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_woostify_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( self::get_woostify_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section   = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority  = 20;

			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title     = __( 'Background', 'Woostify');
			$wp_customize->get_section( 'background_image' )->priority  = 30;

			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title         = __( 'Header', 'Woostify');
			$wp_customize->get_section( 'header_image' )->priority      = 25;

			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

				$wp_customize->selective_refresh->add_partial(
					'custom_logo', array(
						'selector'        => '.site-branding',
						'render_callback' => array( $this, 'get_site_logo' ),
					)
				);

				$wp_customize->selective_refresh->add_partial(
					'blogname', array(
						'selector'        => '.site-title.beta a',
						'render_callback' => array( $this, 'get_site_name' ),
					)
				);

				$wp_customize->selective_refresh->add_partial(
					'blogdescription', array(
						'selector'        => '.site-description',
						'render_callback' => array( $this, 'get_site_description' ),
					)
				);
			}

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/class-storefront-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/class-storefront-customizer-control-arbitrary.php';

			if ( apply_filters( 'woostify_customizer_more', true ) ) {
				require_once dirname( __FILE__ ) . '/class-storefront-customizer-control-more.php';
			}

			/**
			 * Add the typography section
			 */
			$wp_customize->add_section(
				'woostify_typography', array(
					'title'                 => __( 'Typography', 'Woostify'),
					'priority'              => 45,
				)
			);

			/**
			 * Heading color
			 */
			$wp_customize->add_setting(
				'woostify_heading_color', array(
					'default'               => apply_filters( 'woostify_default_heading_color', '#484c51' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_heading_color', array(
						'label'                 => __( 'Heading color', 'Woostify'),
						'section'               => 'woostify_typography',
						'settings'              => 'woostify_heading_color',
						'priority'              => 20,
					)
				)
			);

			/**
			 * Text Color
			 */
			$wp_customize->add_setting(
				'woostify_text_color', array(
					'default'               => apply_filters( 'woostify_default_text_color', '#43454b' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_text_color', array(
						'label'                 => __( 'Text color', 'Woostify'),
						'section'               => 'woostify_typography',
						'settings'              => 'woostify_text_color',
						'priority'              => 30,
					)
				)
			);

			/**
			 * Accent Color
			 */
			$wp_customize->add_setting(
				'woostify_accent_color', array(
					'default'               => apply_filters( 'woostify_default_accent_color', '#96588a' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_accent_color', array(
						'label'                 => __( 'Link / accent color', 'Woostify'),
						'section'               => 'woostify_typography',
						'settings'              => 'woostify_accent_color',
						'priority'              => 40,
					)
				)
			);

			/**
			 * Hero Heading Color
			 */
			$wp_customize->add_setting(
				'woostify_hero_heading_color', array(
					'default'               => apply_filters( 'woostify_default_hero_heading_color', '#000000' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_hero_heading_color', array(
						'label'                 => __( 'Hero heading color', 'Woostify'),
						'section'               => 'woostify_typography',
						'settings'              => 'woostify_hero_heading_color',
						'priority'              => 50,
						'active_callback'       => array( $this, 'is_homepage_template' ),
					)
				)
			);

			/**
			 * Hero Text Color
			 */
			$wp_customize->add_setting(
				'woostify_hero_text_color', array(
					'default'               => apply_filters( 'woostify_default_hero_text_color', '#000000' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_hero_text_color', array(
						'label'                 => __( 'Hero text color', 'Woostify'),
						'section'               => 'woostify_typography',
						'settings'              => 'woostify_hero_text_color',
						'priority'              => 60,
						'active_callback'       => array( $this, 'is_homepage_template' ),
					)
				)
			);

			$wp_customize->add_control(
				new Arbitrary_Storefront_Control(
					$wp_customize, 'woostify_header_image_heading', array(
						'section'               => 'header_image',
						'type'                  => 'heading',
						'label'                 => __( 'Header background image', 'Woostify'),
						'priority'              => 6,
					)
				)
			);

			/**
			 * Header Background
			 */
			$wp_customize->add_setting(
				'woostify_header_background_color', array(
					'default'               => apply_filters( 'woostify_default_header_background_color', '#2c2d33' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_header_background_color', array(
						'label'                 => __( 'Background color', 'Woostify'),
						'section'               => 'header_image',
						'settings'              => 'woostify_header_background_color',
						'priority'              => 15,
					)
				)
			);

			/**
			 * Header text color
			 */
			$wp_customize->add_setting(
				'woostify_header_text_color', array(
					'default'               => apply_filters( 'woostify_default_header_text_color', '#9aa0a7' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_header_text_color', array(
						'label'                 => __( 'Text color', 'Woostify'),
						'section'               => 'header_image',
						'settings'              => 'woostify_header_text_color',
						'priority'              => 20,
					)
				)
			);

			/**
			 * Header link color
			 */
			$wp_customize->add_setting(
				'woostify_header_link_color', array(
					'default'               => apply_filters( 'woostify_default_header_link_color', '#d5d9db' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_header_link_color', array(
						'label'                 => __( 'Link color', 'Woostify'),
						'section'               => 'header_image',
						'settings'              => 'woostify_header_link_color',
						'priority'              => 30,
					)
				)
			);

			/**
			 * Footer section
			 */
			$wp_customize->add_section(
				'woostify_footer', array(
					'title'                 => __( 'Footer', 'Woostify'),
					'priority'              => 28,
					'description'           => __( 'Customize the look & feel of your website footer.', 'Woostify'),
				)
			);

			/**
			 * Footer Background
			 */
			$wp_customize->add_setting(
				'woostify_footer_background_color', array(
					'default'               => apply_filters( 'woostify_default_footer_background_color', '#f0f0f0' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_footer_background_color', array(
						'label'                 => __( 'Background color', 'Woostify'),
						'section'               => 'woostify_footer',
						'settings'              => 'woostify_footer_background_color',
						'priority'              => 10,
					)
				)
			);

			/**
			 * Footer heading color
			 */
			$wp_customize->add_setting(
				'woostify_footer_heading_color', array(
					'default'               => apply_filters( 'woostify_default_footer_heading_color', '#494c50' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_footer_heading_color', array(
						'label'                 => __( 'Heading color', 'Woostify'),
						'section'               => 'woostify_footer',
						'settings'              => 'woostify_footer_heading_color',
						'priority'              => 20,
					)
				)
			);

			/**
			 * Footer text color
			 */
			$wp_customize->add_setting(
				'woostify_footer_text_color', array(
					'default'               => apply_filters( 'woostify_default_footer_text_color', '#61656b' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_footer_text_color', array(
						'label'                 => __( 'Text color', 'Woostify'),
						'section'               => 'woostify_footer',
						'settings'              => 'woostify_footer_text_color',
						'priority'              => 30,
					)
				)
			);

			/**
			 * Footer link color
			 */
			$wp_customize->add_setting(
				'woostify_footer_link_color', array(
					'default'               => apply_filters( 'woostify_default_footer_link_color', '#2c2d33' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_footer_link_color', array(
						'label'                 => __( 'Link color', 'Woostify'),
						'section'               => 'woostify_footer',
						'settings'              => 'woostify_footer_link_color',
						'priority'              => 40,
					)
				)
			);

			/**
			 * Buttons section
			 */
			$wp_customize->add_section(
				'woostify_buttons', array(
					'title'                 => __( 'Buttons', 'Woostify'),
					'priority'              => 45,
					'description'           => __( 'Customize the look & feel of your website buttons.', 'Woostify'),
				)
			);

			/**
			 * Button background color
			 */
			$wp_customize->add_setting(
				'woostify_button_background_color', array(
					'default'               => apply_filters( 'woostify_default_button_background_color', '#96588a' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_button_background_color', array(
						'label'                 => __( 'Background color', 'Woostify'),
						'section'               => 'woostify_buttons',
						'settings'              => 'woostify_button_background_color',
						'priority'              => 10,
					)
				)
			);

			/**
			 * Button text color
			 */
			$wp_customize->add_setting(
				'woostify_button_text_color', array(
					'default'               => apply_filters( 'woostify_default_button_text_color', '#ffffff' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_button_text_color', array(
						'label'                 => __( 'Text color', 'Woostify'),
						'section'               => 'woostify_buttons',
						'settings'              => 'woostify_button_text_color',
						'priority'              => 20,
					)
				)
			);

			/**
			 * Button alt background color
			 */
			$wp_customize->add_setting(
				'woostify_button_alt_background_color', array(
					'default'               => apply_filters( 'woostify_default_button_alt_background_color', '#2c2d33' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_button_alt_background_color', array(
						'label'                 => __( 'Alternate button background color', 'Woostify'),
						'section'               => 'woostify_buttons',
						'settings'              => 'woostify_button_alt_background_color',
						'priority'              => 30,
					)
				)
			);

			/**
			 * Button alt text color
			 */
			$wp_customize->add_setting(
				'woostify_button_alt_text_color', array(
					'default'               => apply_filters( 'woostify_default_button_alt_text_color', '#ffffff' ),
					'sanitize_callback'     => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'woostify_button_alt_text_color', array(
						'label'                 => __( 'Alternate button text color', 'Woostify'),
						'section'               => 'woostify_buttons',
						'settings'              => 'woostify_button_alt_text_color',
						'priority'              => 40,
					)
				)
			);

			/**
			 * Layout
			 */
			$wp_customize->add_section(
				'woostify_layout', array(
					'title'                 => __( 'Layout', 'Woostify'),
					'priority'              => 50,
				)
			);

			$wp_customize->add_setting(
				'woostify_layout', array(
					'default'               => apply_filters( 'woostify_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
					'sanitize_callback'     => 'woostify_sanitize_choices',
				)
			);

			$wp_customize->add_control(
				new Storefront_Custom_Radio_Image_Control(
					$wp_customize, 'woostify_layout', array(
						'settings'              => 'woostify_layout',
						'section'               => 'woostify_layout',
						'label'                 => __( 'General Layout', 'Woostify'),
						'priority'              => 1,
						'choices'               => array(
							'right' => get_template_directory_uri() . '/assets/images/customizer/controls/2cr.png',
							'left'  => get_template_directory_uri() . '/assets/images/customizer/controls/2cl.png',
						),
					)
				)
			);

			/**
			 * More
			 */
			if ( apply_filters( 'woostify_customizer_more', true ) ) {
				$wp_customize->add_section(
					'woostify_more', array(
						'title'             => __( 'More', 'Woostify'),
						'priority'          => 999,
					)
				);

				$wp_customize->add_setting(
					'woostify_more', array(
						'default'           => null,
						'sanitize_callback' => 'sanitize_text_field',
					)
				);

				$wp_customize->add_control(
					new More_Storefront_Control(
						$wp_customize, 'woostify_more', array(
							'label'             => __( 'Looking for more options?', 'Woostify'),
							'section'           => 'woostify_more',
							'settings'          => 'woostify_more',
							'priority'          => 1,
						)
					)
				);
			}
		}

		/**
		 * Get all of the Woostify theme mods.
		 *
		 * @return array $woostify_theme_mods The Woostify Theme Mods.
		 */
		public function get_woostify_theme_mods() {
			$woostify_theme_mods = array(
				'background_color'            => woostify_get_content_background_color(),
				'accent_color'                => get_theme_mod( 'woostify_accent_color' ),
				'hero_heading_color'          => get_theme_mod( 'woostify_hero_heading_color' ),
				'hero_text_color'             => get_theme_mod( 'woostify_hero_text_color' ),
				'header_background_color'     => get_theme_mod( 'woostify_header_background_color' ),
				'header_link_color'           => get_theme_mod( 'woostify_header_link_color' ),
				'header_text_color'           => get_theme_mod( 'woostify_header_text_color' ),
				'footer_background_color'     => get_theme_mod( 'woostify_footer_background_color' ),
				'footer_link_color'           => get_theme_mod( 'woostify_footer_link_color' ),
				'footer_heading_color'        => get_theme_mod( 'woostify_footer_heading_color' ),
				'footer_text_color'           => get_theme_mod( 'woostify_footer_text_color' ),
				'text_color'                  => get_theme_mod( 'woostify_text_color' ),
				'heading_color'               => get_theme_mod( 'woostify_heading_color' ),
				'button_background_color'     => get_theme_mod( 'woostify_button_background_color' ),
				'button_text_color'           => get_theme_mod( 'woostify_button_text_color' ),
				'button_alt_background_color' => get_theme_mod( 'woostify_button_alt_background_color' ),
				'button_alt_text_color'       => get_theme_mod( 'woostify_button_alt_text_color' ),
			);

			return apply_filters( 'woostify_theme_mods', $woostify_theme_mods );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_woostify_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
			$woostify_theme_mods = $this->get_woostify_theme_mods();
			$brighten_factor       = apply_filters( 'woostify_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'woostify_darken_factor', -25 );

			$styles                = '
			.main-navigation ul li a,
			.site-title a,
			ul.menu li a,
			.site-branding h1 a,
			.site-footer .woostify-handheld-footer-bar a:not(.button),
			button.menu-toggle,
			button.menu-toggle:hover {
				color: ' . $woostify_theme_mods['header_link_color'] . ';
			}

			button.menu-toggle,
			button.menu-toggle:hover {
				border-color: ' . $woostify_theme_mods['header_link_color'] . ';
			}

			.main-navigation ul li a:hover,
			.main-navigation ul li:hover > a,
			.site-title a:hover,
			.site-header ul.menu li.current-menu-item > a {
				color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_link_color'], 65 ) . ';
			}

			table th {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -7 ) . ';
			}

			table tbody td {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -2 ) . ';
			}

			table tbody tr:nth-child(2n) td,
			fieldset,
			fieldset legend {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -4 ) . ';
			}

			.site-header,
			.secondary-navigation ul ul,
			.main-navigation ul.menu > li.menu-item-has-children:after,
			.secondary-navigation ul.menu ul,
			.woostify-handheld-footer-bar,
			.woostify-handheld-footer-bar ul li > a,
			.woostify-handheld-footer-bar ul li.search .site-search,
			button.menu-toggle,
			button.menu-toggle:hover {
				background-color: ' . $woostify_theme_mods['header_background_color'] . ';
			}

			p.site-description,
			.site-header,
			.woostify-handheld-footer-bar {
				color: ' . $woostify_theme_mods['header_text_color'] . ';
			}

			button.menu-toggle:after,
			button.menu-toggle:before,
			button.menu-toggle span:before {
				background-color: ' . $woostify_theme_mods['header_link_color'] . ';
			}

			h1, h2, h3, h4, h5, h6 {
				color: ' . $woostify_theme_mods['heading_color'] . ';
			}

			.widget h1 {
				border-bottom-color: ' . $woostify_theme_mods['heading_color'] . ';
			}

			body,
			.secondary-navigation a {
				color: ' . $woostify_theme_mods['text_color'] . ';
			}

			.widget-area .widget a,
			.hentry .entry-header .posted-on a,
			.hentry .entry-header .byline a {
				color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['text_color'], 5 ) . ';
			}

			a  {
				color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			a:focus,
			.button:focus,
			.button.alt:focus,
			button:focus,
			input[type="button"]:focus,
			input[type="reset"]:focus,
			input[type="submit"]:focus {
				outline-color: ' . $woostify_theme_mods['accent_color'] . ';
			}

			button, input[type="button"], input[type="reset"], input[type="submit"], .button, .widget a.button {
				background-color: ' . $woostify_theme_mods['button_background_color'] . ';
				border-color: ' . $woostify_theme_mods['button_background_color'] . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .widget a.button:hover {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $woostify_theme_mods['button_text_color'] . ';
			}

			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .widget-area .widget a.button.alt {
				background-color: ' . $woostify_theme_mods['button_alt_background_color'] . ';
				border-color: ' . $woostify_theme_mods['button_alt_background_color'] . ';
				color: ' . $woostify_theme_mods['button_alt_text_color'] . ';
			}

			button.alt:hover, input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover, .button.alt:hover, .widget-area .widget a.button.alt:hover {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				border-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				color: ' . $woostify_theme_mods['button_alt_text_color'] . ';
			}

			.pagination .page-numbers li .page-numbers.current {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], $darken_factor ) . ';
				color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['text_color'], -10 ) . ';
			}

			#comments .comment-list .comment-content .comment-text {
				background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['background_color'], -7 ) . ';
			}

			.site-footer {
				background-color: ' . $woostify_theme_mods['footer_background_color'] . ';
				color: ' . $woostify_theme_mods['footer_text_color'] . ';
			}

			.site-footer a:not(.button) {
				color: ' . $woostify_theme_mods['footer_link_color'] . ';
			}

			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 {
				color: ' . $woostify_theme_mods['footer_heading_color'] . ';
			}

			.page-template-template-homepage.has-post-thumbnail .type-page.has-post-thumbnail .entry-title {
				color: ' . $woostify_theme_mods['hero_heading_color'] . ';
			}

			.page-template-template-homepage.has-post-thumbnail .type-page.has-post-thumbnail .entry-content {
				color: ' . $woostify_theme_mods['hero_text_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.secondary-navigation ul.menu a:hover {
					color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_text_color'], $brighten_factor ) . ';
				}

				.secondary-navigation ul.menu a {
					color: ' . $woostify_theme_mods['header_text_color'] . ';
				}

				.main-navigation ul.menu ul.sub-menu,
				.main-navigation ul.nav-menu ul.children {
					background-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_background_color'], -15 ) . ';
				}

				.site-header {
					border-bottom-color: ' . woostify_adjust_color_brightness( $woostify_theme_mods['header_background_color'], -15 ) . ';
				}
			}';

			return apply_filters( 'woostify_customizer_css', $styles );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			wp_add_inline_style( 'woostify-style', $this->get_css() );
		}

		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'woostify_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.5.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
			.customize-control-radio-image input[type=radio] {
				display: none;
			}

			.customize-control-radio-image label {
				display: block;
				width: 48%;
				float: left;
				margin-right: 4%;
			}

			.customize-control-radio-image label:nth-of-type(2n) {
				margin-right: 0;
			}

			.customize-control-radio-image img {
				opacity: .5;
			}

			.customize-control-radio-image input[type=radio]:checked + label img,
			.customize-control-radio-image img:hover {
				opacity: 1;
			}

			</style>
			<?php
		}

		/**
		 * Get site logo.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_logo() {
			return woostify_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}

		/**
		 * Check if current page is using the Homepage template.
		 *
		 * @since 2.3.0
		 * @return bool
		 */
		public function is_homepage_template() {
			$template = get_post_meta( get_the_ID(), '_wp_page_template', true );

			if ( ! $template || 'template-homepage.php' !== $template || ! has_post_thumbnail( get_the_ID() ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Setup the WordPress core custom header feature.
		 *
		 * @deprecated 2.4.0
		 * @return void
		 */
		public function custom_header_setup() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.4.0' );
			} else {
				_deprecated_function( __FUNCTION__, '2.4.0' );
			}
		}

		/**
		 * Get Customizer css associated with WooCommerce.
		 *
		 * @deprecated 2.4.0
		 * @return void
		 */
		public function get_woocommerce_css() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}

		/**
		 * Assign Woostify styles to individual theme mods.
		 *
		 * @deprecated 2.3.1
		 * @return void
		 */
		public function set_woostify_style_theme_mods() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}
	}

endif;

return new Storefront_Customizer();
