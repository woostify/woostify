<?php
/**
 * Woostify functions.
 *
 * @package woostify
 */

if ( ! function_exists( 'woostify_get_pro_url' ) ) {
	/**
	 * Generate a URL to our pro add-ons.
	 * Allows the use of a referral ID and campaign.
	 *
	 * @param string $url URL to pro page.
	 * @return string The URL to woostify.com.
	 */
	function woostify_get_pro_url( $url = 'https://woostify.com/pro' ) {
		$url = trailingslashit( $url );

		$args = apply_filters( 'generate_premium_url_args', array(
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

if ( ! function_exists( 'woostify_do_shortcode' ) ) {
	/**
	 * Call a shortcode function by tag name.
	 *
	 * @since  1.0
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

if ( ! function_exists( 'woostify_header_styles' ) ) {
	/**
	 * Apply inline style to the Woostify header.
	 *
	 * @uses  get_header_image()
	 */
	function woostify_header_styles() {
		$is_header_image = get_header_image();
		$header_bg_image = '';

		if ( $is_header_image ) {
			$header_bg_image = 'url(' . esc_url( $is_header_image ) . ')';
		}

		$styles = array();

		if ( '' !== $header_bg_image ) {
			$styles['background-image'] = $header_bg_image;
		}

		$styles = apply_filters( 'woostify_header_styles', $styles );

		foreach ( $styles as $style => $value ) {
			echo esc_attr( $style . ': ' . $value . '; ' );
		}
	}
}

if ( ! function_exists( 'woostify_sanitize_choices' ) ) {
	/**
	 * Sanitizes choices (selects / radios)
	 * Checks that the input matches one of the available choices
	 *
	 * @param array $input the available choices.
	 * @param array $setting the setting object.
	 * @since  1.0
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
	 * @since  1.0
	 */
	function woostify_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'woostify_is_blog' ) ) {
	/**
	 * Woostify detect blog page
	 *
	 * @return boolean
	 */
	function woostify_is_blog() {
		global $post;
		$post_type = get_post_type( $post );
		return ( 'post' == $post_type && ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) ) ? true : false;
	}
}

if ( ! function_exists( 'woostify_default_settings' ) ) {
	/**
	 * Default setting values
	 *
	 * @return     array $default_setting Default setting value
	 */
	function woostify_default_settings() {
		$default_setting = Woostify_Customizer::get_woostify_default_setting_values();
		return $default_setting;
	}
}

if ( ! function_exists( 'woostify_default_fonts' ) ) {
	/**
	 * Default font values
	 *
	 * @return     array $default_fonts Default font value
	 */
	function woostify_default_fonts() {
		$default_font = Woostify_Fonts_Helpers::woostify_get_default_fonts();
		return $default_font;
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

