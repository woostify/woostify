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

if ( ! class_exists( 'Woostify_Customizer' ) ) :

	/**
	 * The Woostify Customizer class
	 */
	class Woostify_Customizer {

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

			/**
			 * Custom default section, panel
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/override-defaults.php';

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/custom-controls/radio-image/class-woostify-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/custom-controls/divider/class-woostify-customizer-control-arbitrary.php';
			// Typography
//            require_once dirname( __FILE__ ) . '/custom-controls/typography/class-woostify-fonts-helpers.php';
            //require_once dirname( __FILE__ ) . '/custom-controls/typography/class-typography-control.php';

			/**
			 * Register section & panel
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/register-sections.php';

			/**
			 * Section, settings & control
			 */
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/buttons/button.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/footer/footer.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/header/header.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/layout/layout.php';
			require_once WOOSTIFY_THEME_DIR . 'inc/customizer/sections/color/color.php';
			

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
         * Wrapper function to create font-family value for CSS.
         *
         * @since 1.3.0
         *
         * @param string $font The name of our font.
         * @param string $settings The ID of the settings we're looking up.
         * @param array $default The defaults for our $settings.
         * @return string The CSS value for our font family.
         */
        public function woostify_get_font_family_css( $font, $settings, $default ) {
            $woostify_settings = wp_parse_args(
                get_option( $settings, array() ),
                $default
            );

            // We don't want to wrap quotes around these values
            $no_quotes = array(
                'inherit',
                'Arial, Helvetica, sans-serif',
                'Georgia, Times New Roman, Times, serif',
                'Helvetica',
                'Impact',
                'Segoe UI, Helvetica Neue, Helvetica, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif',
                apply_filters( 'woostify_typography_system_stack', '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"' )
            );

            // Get our font
            $font_family = $woostify_settings[ $font ];

            if ( 'System Stack' == $font_family ) {
                $font_family = apply_filters( 'woostify_typography_system_stack', '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"' );
            }

            // If our value is still using the old format, fix it
            if ( strpos( $font_family, ':' ) !== false ) {
                $font_family = current( explode( ':', $font_family ) );
            }

            // Set up our wrapper
            if ( in_array( $font_family, $no_quotes ) ) {
                $wrapper_start = null;
                $wrapper_end = null;
            } else {
                $wrapper_start = '"';
                $wrapper_end = '"' . woostify_get_google_font_category( $font_family, $font );
            }

            // Output the CSS
            $output = ( 'inherit' == $font_family ) ? '' : $wrapper_start . $font_family . $wrapper_end;
            return $output;
        }

        /**
         * Set default options.
         *
         * @since 0.1
         *
         * @param bool $filter Whether to return the filtered values or original values.
         * @return array Option defaults.
         */
        public function woostify_get_default_fonts( $filter = true ) {
            $woostify_font_defaults = array(
                'font_body' => 'System Stack',
                'font_body_category' => '',
                'font_body_variants' => '',
                'body_font_weight' => 'normal',
                'body_font_transform' => 'none',
                'body_font_size' => '17',
                'body_line_height' => '1.5', // no unit
                'paragraph_margin' => '1.5', // em
                'font_top_bar' => 'inherit',
                'font_top_bar_category' => '',
                'font_top_bar_variants' => '',
                'top_bar_font_weight' => 'normal',
                'top_bar_font_transform' => 'none',
                'top_bar_font_size' => '13',
                'font_site_title' => 'inherit',
                'font_site_title_category' => '',
                'font_site_title_variants' => '',
                'site_title_font_weight' => 'bold',
                'site_title_font_transform' => 'none',
                'site_title_font_size' => '45',
                'mobile_site_title_font_size' => '30',
                'font_site_tagline' => 'inherit',
                'font_site_tagline_category' => '',
                'font_site_tagline_variants' => '',
                'site_tagline_font_weight' => 'normal',
                'site_tagline_font_transform' => 'none',
                'site_tagline_font_size' => '15',
                'font_navigation' => 'inherit',
                'font_navigation_category' => '',
                'font_navigation_variants' => '',
                'navigation_font_weight' => 'normal',
                'navigation_font_transform' => 'none',
                'navigation_font_size' => '15',
                'font_widget_title' => 'inherit',
                'font_widget_title_category' => '',
                'font_widget_title_variants' => '',
                'widget_title_font_weight' => 'normal',
                'widget_title_font_transform' => 'none',
                'widget_title_font_size' => '20',
                'widget_title_separator' => '30',
                'widget_content_font_size' => '17',
                'font_buttons' => 'inherit',
                'font_buttons_category' => '',
                'font_buttons_variants' => '',
                'buttons_font_weight' => 'normal',
                'buttons_font_transform' => 'none',
                'buttons_font_size' => '',
                'font_heading_1' => 'inherit',
                'font_heading_1_category' => '',
                'font_heading_1_variants' => '',
                'heading_1_weight' => '300',
                'heading_1_transform' => 'none',
                'heading_1_font_size' => '40',
                'heading_1_line_height' => '1.2', // em
                'mobile_heading_1_font_size' => '30',
                'font_heading_2' => 'inherit',
                'font_heading_2_category' => '',
                'font_heading_2_variants' => '',
                'heading_2_weight' => '300',
                'heading_2_transform' => 'none',
                'heading_2_font_size' => '30',
                'heading_2_line_height' => '1.2', // em
                'mobile_heading_2_font_size' => '25',
                'font_heading_3' => 'inherit',
                'font_heading_3_category' => '',
                'font_heading_3_variants' => '',
                'heading_3_weight' => 'normal',
                'heading_3_transform' => 'none',
                'heading_3_font_size' => '20',
                'heading_3_line_height' => '1.2', // em
                'font_heading_4' => 'inherit',
                'font_heading_4_category' => '',
                'font_heading_4_variants' => '',
                'heading_4_weight' => 'normal',
                'heading_4_transform' => 'none',
                'heading_4_font_size' => '',
                'heading_4_line_height' => '', // em
                'font_heading_5' => 'inherit',
                'font_heading_5_category' => '',
                'font_heading_5_variants' => '',
                'heading_5_weight' => 'normal',
                'heading_5_transform' => 'none',
                'heading_5_font_size' => '',
                'heading_5_line_height' => '', // em
                'font_heading_6' => 'inherit',
                'font_heading_6_category' => '',
                'font_heading_6_variants' => '',
                'heading_6_weight' => 'normal',
                'heading_6_transform' => 'none',
                'heading_6_font_size' => '',
                'heading_6_line_height' => '', // em
                'font_footer' => 'inherit',
                'font_footer_category' => '',
                'font_footer_variants' => '',
                'footer_weight' => 'normal',
                'footer_transform' => 'none',
                'footer_font_size' => '15',
            );

            if ( $filter ) {
                return apply_filters( 'woostify_font_option_defaults', $woostify_font_defaults );
            }

            return $woostify_font_defaults;
        }

		/**
		 * Get Customizer css.
		 *
		 * @see get_woostify_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
            $woostify_settings = wp_parse_args(
                get_option( 'woostify_settings', array() ),
                $this->woostify_get_default_fonts()
            );

			$woostify_theme_mods = $this->get_woostify_theme_mods();
			$brighten_factor       = apply_filters( 'woostify_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'woostify_darken_factor', -25 );
            $body_font = $body_family = $this->woostify_get_font_family_css( 'font_body', 'woostify_settings', $this->woostify_get_default_fonts());
            //var_dump($body_font);

			$styles                = '
			h2{
			    font-family: ' . $body_font . ';
			}
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

			button,
            input[type="button"],
            input[type="reset"],
            input[type="file"],
            input[type="submit"],
            .button,
            .widget a.button {
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

return new Woostify_Customizer();
