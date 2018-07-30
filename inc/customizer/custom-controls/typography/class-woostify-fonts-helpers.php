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
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct()
        {
            add_action( 'customize_controls_enqueue_scripts', array( $this,'woostify_do_control_inline_scripts' ), 100  );
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
            wp_localize_script( 'woostify-typography-customizer', 'typography_defaults', woostify_typography_default_fonts() );
        }
    }
endif;

return new Woostify_Font_Helpers();