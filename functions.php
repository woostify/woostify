<?php
/**
 * Woostify engine room
 *
 * @package woostify
 */

/**
 * Assign the Woostify version to a var
 */
$theme              = wp_get_theme('Woostify');
$woostify_version = $theme['Version'];
define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$woostify = (object) array(
	'version' => $woostify_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-woostify.php',
	'customizer' => require 'inc/customizer/class-woostify-customizer.php',
);
/**
 * Sanitize our Google Font variants
 *
 * @since 2.0
 */
function generate_sanitize_variants( $input ) {
	if ( is_array( $input ) ) {
		$input = implode( ',', $input );
	}
	return sanitize_text_field( $input );
}

require 'inc/woostify-functions.php';
require 'inc/woostify-template-hooks.php';
require 'inc/woostify-template-functions.php';
require 'inc/customizer/sections/typography/typography.php';

if ( class_exists( 'Jetpack' ) ) {
	$woostify->jetpack = require 'inc/jetpack/class-woostify-jetpack.php';
}

if ( woostify_is_woocommerce_activated() ) {
	$woostify->woocommerce            = require 'inc/woocommerce/class-woostify-woocommerce.php';
	$woostify->woocommerce_customizer = require 'inc/woocommerce/class-woostify-woocommerce-customizer.php';

	require 'inc/woocommerce/woostify-woocommerce-template-hooks.php';
	require 'inc/woocommerce/woostify-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$woostify->admin = require 'inc/admin/class-woostify-admin.php';

	require 'inc/admin/class-woostify-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
