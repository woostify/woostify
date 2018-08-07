<?php
/**
 * Woostify Fotn  Class
 *
 * @package  woostify
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Woostify_Font_Helpers' ) ) :

    /**
     * The Woostify Customizer class
     */
    class Woostify_Font_Helpers
    {

        /**
         * Instance
         *
         * @access private
         * @var object
         */
        private static $instance;

        /**
         * Initiator
         */
        public static function get_instance() {
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct()
        {
            add_action( 'customize_controls_enqueue_scripts', array( $this,'woostify_do_control_inline_scripts' ), 100  );
            add_action( 'wp_enqueue_scripts', array( $this, 'woostify_enqueue_google_fonts' ), 0 );
        }
        /**
         * Add misc inline scripts to our controls.
         *
         * We don't want to add these to the controls themselves, as they will be repeated
         * each time the control is initialized.
         *
         * @since 2.0
         */
        function woostify_do_control_inline_scripts() {
            wp_localize_script( 'woostify-typography-customizer', 'gp_customize', array( 'nonce' => wp_create_nonce( 'gp_customize_nonce' ) ) );
            wp_localize_script( 'woostify-typography-customizer', 'typography_defaults', $this->woostify_typography_default_fonts() );
        }

        /**
         * Set the default system fonts.
         *
         * @since 1.0
         */
        function woostify_typography_default_fonts() {
            $fonts = array(
                'inherit',
                'System Stack',
                'Arial, Helvetica, sans-serif',
                'Century Gothic',
                'Comic Sans MS',
                'Courier New',
                'Georgia, Times New Roman, Times, serif',
                'Helvetica',
                'Impact',
                'Lucida Console',
                'Lucida Sans Unicode',
                'Palatino Linotype',
                'Segoe UI, Helvetica Neue, Helvetica, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            );

            return apply_filters( 'woostify_typography_default_fonts', $fonts );
        }

        /**
         * Set default options.
         *
         * @since 1.0
         *
         * @param bool $filter Whether to return the filtered values or original values.
         * @return array Option defaults.
         */
        static public function woostify_get_default_fonts( $filter = true ) {
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
         * Add Google Fonts to wp_head if needed.
         *
         * @since 0.1
         */
        function woostify_enqueue_google_fonts() {

            if ( is_admin() ) {
                return;
            }

            // Grab our options
            $woostify_settings = wp_parse_args(
                get_option( 'woostify_settings', array() ),
                Woostify_Font_Helpers::woostify_get_default_fonts()
            );

            // List our non-Google fonts
            $not_google = str_replace( ' ', '+', Woostify_Font_Helpers::woostify_typography_default_fonts() );

            // Grab our font family settings
            $font_settings = array(
                'font_body',
                'font_top_bar',
                'font_site_title',
                'font_site_tagline',
                'font_navigation',
                'font_widget_title',
                'font_buttons',
                'font_heading_1',
                'font_heading_2',
                'font_heading_3',
                'font_heading_4',
                'font_heading_5',
                'font_heading_6',
                'font_footer',
            );

            // Create our Google Fonts array
            $google_fonts = array();
            if ( ! empty( $font_settings ) ) {

                foreach ( $font_settings as $key ) {

                    // If the key isn't set, move on
                    if ( ! isset( $woostify_settings[$key] ) ) {
                        continue;
                    }

                    // If our value is still using the old format, fix it
                    if ( strpos( $woostify_settings[$key], ':' ) !== false ) {
                        $woostify_settings[$key] = current( explode( ':', $woostify_settings[$key] ) );
                    }

                    // Replace the spaces in the names with a plus
                    $value = str_replace( ' ', '+', $woostify_settings[$key] );

                    // Grab the variants using the plain name
                    $variants = woostify_get_google_font_variants( $woostify_settings[$key], $key );

                    // If we have variants, add them to our value
                    $value = ! empty( $variants ) ? $value . ':' . $variants : $value;

                    // Make sure we don't add the same font twice
                    if ( ! in_array( $value, $google_fonts ) ) {
                        $google_fonts[] = $value;
                    }

                }

            }

            // Ignore any non-Google fonts
            $google_fonts = array_diff( $google_fonts, $not_google );

            // Separate each different font with a bar
            $google_fonts = implode( '|', $google_fonts );

            // Apply a filter to the output
            $google_fonts = apply_filters( 'woostify_typography_google_fonts', $google_fonts );

            // Get the subset
            $subset = apply_filters( 'woostify_fonts_subset','' );

            // Set up our arguments
            $font_args = array();
            $font_args[ 'family' ] = $google_fonts;
            if ( '' !== $subset ) {
                $font_args[ 'subset' ] = urlencode( $subset );
            }

            // Create our URL using the arguments
            $fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );

            // Enqueue our fonts
            if ( $google_fonts ) {
                wp_enqueue_style('generate-fonts', $fonts_url, array(), null, 'all' );
            }
        }
    }
endif;

Woostify_Font_Helpers::get_instance();