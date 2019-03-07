<?php
/**
 * Woostify functions.
 *
 * @package woostify
 */

if ( ! function_exists( 'woostify_version' ) ) {
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

		$id        = woostify_get_page_id();
		$edit_mode = woostify_get_metabox( '_elementor_edit_mode' );

		$elementor = 'builder' === $edit_mode ? true : false;

		return $elementor;
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

if ( ! function_exists( 'woostify_sanitize_variants' ) ) {
	/**
	 * Sanitize our Google Font variants
	 *
	 * @param      string $input sanitize variants.
	 * @return     sanitize_text_field( $input )
	 */
	function woostify_sanitize_variants( $input ) {
		if ( is_array( $input ) ) {
			$input = implode( ',', $input );
		}
		return sanitize_text_field( $input );
	}
}

if ( ! function_exists( 'woostify_sanitize_rgba_color' ) ) {
	/**
	 * Sanitize color || rgba color
	 *
	 * @param      string $color  The color.
	 */
	function woostify_sanitize_rgba_color( $color ) {
		if ( empty( $color ) || is_array( $color ) ) {
			return 'rgba(255,255,255,0)';
		}

		// If string does not start with 'rgba', then treat as hex sanitize the hex color and finally convert hex to rgba.
		if ( false === strpos( $color, 'rgba' ) ) {
			return sanitize_hex_color( $color );
		}

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

		return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
	}
}

if ( ! function_exists( 'woostify_sanitize_int' ) ) {
	/**
	 * Sanitize integer value
	 *
	 * @param      integer $value  The integer number.
	 */
	function woostify_sanitize_int( $value ) {
		return intval( $value );
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
		$default_settings = Woostify_Customizer::woostify_get_woostify_default_setting_values();
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
	 * @param      bolean $id          The image id.
	 * @param      string $alt         The alternate.
	 * @param      bolean $placeholder The bolean.
	 *
	 * @return     string  The image alt
	 */
	function woostify_image_alt( $id = null, $alt = '', $placeholder = false ) {
		if ( ! $id ) {
			if ( $placeholder ) {
				return esc_attr__( 'Placeholder image', 'woostify' );
			}
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

if ( ! function_exists( 'woostify_dequeue_scripts_and_styles' ) ) {
	/**
	 * Dequeue scripts and style no need
	 */
	function woostify_dequeue_scripts_and_styles() {
		// What is 'sb-font-awesome'?
		wp_deregister_style( 'sb-font-awesome' );
		wp_dequeue_style( 'sb-font-awesome' );

		// Remove default YITH Wishlist css.
		wp_dequeue_style( 'yith-wcwl-main' );
		wp_dequeue_style( 'yith-wcwl-font-awesome' );
		wp_dequeue_style( 'jquery-selectBox' );
	}
}

if ( ! function_exists( 'woostify_narrow_data' ) ) {
	/**
	 * Get dropdown data
	 *
	 * @param      string $type   The type 'post' || 'term'.
	 * @param      string $terms  The terms post, category, product, product_cat, custom_post_type...
	 *
	 * @return     array
	 */
	function woostify_narrow_data( $type = 'post', $terms = 'category' ) {
		$output = array();
		switch ( $type ) {
			case 'post':
				$args = array(
					'post_type'           => $terms,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => -1,
				);

				$qr     = new WP_Query( $args );
				$output = wp_list_pluck( $qr->posts, 'post_title', 'ID' );
				break;

			case 'term':
				$terms  = get_terms( $terms );
				$output = wp_list_pluck( $terms, 'name', 'term_id' );
				break;
		}

		return $output;
	}
}

if ( ! function_exists( 'woostify_get_metabox' ) ) {
	/**
	 * Get metabox option
	 *
	 * @param string $metabox_name Metabox option name.
	 */
	function woostify_get_metabox( $metabox_name ) {
		$page_id = woostify_get_page_id();
		$metabox = get_post_meta( $page_id, $metabox_name, true );

		if ( '' === $metabox || false === $metabox ) {
			$metabox = 'default';
		}

		return $metabox;
	}
}

if ( ! function_exists( 'woostify_header_transparent' ) ) {
	/**
	 * Detect header transparent on current page
	 */
	function woostify_header_transparent() {
		$options             = woostify_options( false );
		$transparent         = false;
		$general_transparent = $options['header_transparent'];
		$archive_transparent = $options['header_transparent_disable_archive'];
		$index_transparent   = $options['header_transparent_disable_index'];
		$page_transparent    = $options['header_transparent_disable_page'];
		$post_transparent    = $options['header_transparent_disable_post'];
		$metabox_transparent = woostify_get_metabox( 'site-header-transparent' );

		// General header transparent for all site.
		if ( true == $general_transparent ) {
			$transparent = true;
		}

		// Disable header transparent on Archive, 404 and Search page.
		if ( ( is_archive() || is_404() || is_search() ) && true == $archive_transparent ) {
			$transparent = false;
		} elseif ( is_home() && true == $index_transparent ) {
			// Disable header transparent on Blog page.
			$transparent = false;
		} elseif ( is_page() && true == $page_transparent ) {
			// Disable header transparent on Pages.
			$transparent = false;
		} elseif ( is_singular( 'post' ) && true == $post_transparent ) {
			// Disable header transparent on Posts.
			$transparent = false;
		}

		// For metabox, special page or post. Priority highest.
		if ( 'default' != $metabox_transparent ) {
			if ( 'enabled' == $metabox_transparent ) {
				$transparent = true;
			} else {
				$transparent = false;
			}
		}

		return $transparent;
	}
}

if ( ! function_exists( 'woostify_pingback' ) ) {
	/**
	 * Pingback
	 */
	function woostify_pingback() {
		if ( ! is_singular() || ! pings_open( get_queried_object() ) ) {
			return;
		}
		?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
}
