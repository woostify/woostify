<?php
/**
 * Woostify functions.
 *
 * @package woostify
 */

if ( ! class_exists( 'woostify_version' ) ) {
	/**
	 * Woostify Version
	 *
	 * @return string Woostify Version.
	 */
	function woostify_version() {
		return WOOSTIFY_VERSION;
	}
}

if ( ! function_exists( 'woostify_get_pro_url' ) ) {
	/**
	 * Generate a URL to our pro add-ons.
	 * Allows the use of a referral ID and campaign.
	 *
	 * @param string $url URL to pro page.
	 * @return string The URL to woostify.com.
	 */
	function woostify_get_pro_url( $url = 'https://woostify.com' ) {
		$url = trailingslashit( $url );

		$args = apply_filters( 'woostify_premium_url_args', array(
			'ref'      => null,
			'campaign' => null,
		) );

		// Set up our URL if we have an ID.
		if ( isset( $args['ref'] ) ) {
			$url = add_query_arg( 'ref', absint( $args['ref'] ), $url );
		}

		// Set up our URL if we have a campaign.
		if ( isset( $args['campaign'] ) ) {
			$url = add_query_arg( 'campaign', sanitize_text_field( $args['campaign'] ), $url );
		}

		return esc_url( $url );
	}
}

if ( ! function_exists( 'woostify_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function woostify_is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

if ( ! function_exists( 'woostify_is_elementor_activated' ) ) {
	/**
	 * Check Elementor active
	 *
	 * @return     bool
	 */
	function woostify_is_elementor_activated() {
		return defined( 'ELEMENTOR_VERSION' );
	}
}

if ( ! function_exists( 'woostify_is_elementor_page' ) ) {
	/**
	 * Detect Elementor Page editor with current page
	 *
	 * @return     bool
	 */
	function woostify_is_elementor_page() {
		if ( ! woostify_is_elementor_activated() ) {
			return false;
		}

		$id = woostify_get_page_id();
		return get_post_meta( $id, '_elementor_edit_mode', true );
	}
}

if ( ! function_exists( 'woostify_theme_name' ) ) {
	/**
	 * Get theme name.
	 *
	 * @return string Theme Name.
	 */
	function woostify_theme_name() {

		$theme_name = __( 'Woostify', 'woostify' );

		return apply_filters( 'woostify_theme_name', $theme_name );
	}
}

if ( ! function_exists( 'woostify_do_shortcode' ) ) {
	/**
	 * Call a shortcode function by tag name.
	 *
	 * @param string $tag     The shortcode whose function to call.
	 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
	 * @param array  $content The shortcode's content. Default is null (none).
	 *
	 * @return string|bool False on failure, the result of the shortcode on success.
	 */
	function woostify_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
}

if ( ! function_exists( 'woostify_raw_html' ) ) {
	/**
	 * Raw html
	 *
	 * @param string $text The setting value.
	 */
	function woostify_raw_html( $text ) {
		return $text;
	}
}

if ( ! function_exists( 'woostify_sanitize_choices' ) ) {
	/**
	 * Sanitizes choices (selects / radios)
	 * Checks that the input matches one of the available choices
	 *
	 * @param array $input the available choices.
	 * @param array $setting the setting object.
	 */
	function woostify_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug.
		$input   = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'woostify_sanitize_checkbox' ) ) {
	/**
	 * Checkbox sanitization callback.
	 *
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function woostify_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'woostify_is_blog' ) ) {
	/**
	 * Woostify detect blog page
	 *
	 * @return boolean $is_blog
	 */
	function woostify_is_blog() {
		global $post;

		$post_type = get_post_type( $post );

		$is_blog = ( 'post' == $post_type && ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) ) ? true : false;

		return apply_filters( 'woostify_is_blog', $is_blog );
	}
}

if ( ! function_exists( 'woostify_options' ) ) {
	/**
	 * Theme option
	 * If ( $defaults = true ) return Default value
	 * Else return all theme option
	 *
	 * @param      bool $defaults  Condition check output.
	 * @return     array $options         All theme options
	 */
	function woostify_options( $defaults = true ) {
		$default_settings = Woostify_Customizer::get_woostify_default_setting_values();
		$default_fonts    = Woostify_Fonts_Helpers::woostify_get_default_fonts();
		$default_options  = array_merge( $default_settings, $default_fonts );

		if ( true == $defaults ) {
			return $default_options;
		}

		$options = wp_parse_args(
			get_option( 'woostify_setting', array() ),
			$default_options
		);

		return $options;
	}
}

if ( ! function_exists( 'woostify_image_alt' ) ) {

	/**
	 * Get image alt
	 *
	 * @param      bolean $id     The image id.
	 * @param      string $alt    The alternate.
	 *
	 * @return     string  The image alt
	 */
	function woostify_image_alt( $id = null, $alt = '' ) {
		if ( ! $id ) {
			return esc_attr__( 'Error image', 'woostify' );
		}

		$data = get_post_meta( $id, '_wp_attachment_image_alt', true );
		$img_alt = ! empty( $data ) ? $data : $alt;

		return $img_alt;
	}
}

if ( ! function_exists( 'woostify_hex_to_rgba' ) ) {
	/**
	 * Convert HEX to RGBA color
	 *
	 * @param      string  $hex    The hexadecimal color.
	 * @param      integer $alpha  The alpha.
	 * @return     string  The rgba color.
	 */
	function woostify_hex_to_rgba( $hex, $alpha = 1 ) {
		$hex = str_replace( '#', '', $hex );

		if ( 3 == strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		$rgba = array( $r, $g, $b, $alpha );

		return 'rgba(' . implode( ',', $rgba ) . ')';
	}
}

if ( ! function_exists( 'woostify_browser_detection' ) ) {
	/**
	 * Woostify broswer detection
	 */
	function woostify_browser_detection() {
		global $is_IE, $is_edge, $is_safari, $is_iphone;

		$class = '';

		if ( $is_iphone ) {
			$class = 'iphone';
		} elseif ( $is_IE ) {
			$class = 'ie';
		} elseif ( $is_edge ) {
			$class = 'edge';
		} elseif ( $is_safari ) {
			$class = 'safari';
		}

		return $class;
	}
}
