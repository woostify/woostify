<?php
/**
 * Woostify engine room
 *
 * @package woostify
 */

/**
 * Assign the Woostify version to a var
 */
$theme            = wp_get_theme();
$woostify_version = $theme->get( 'Version' );

define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170; /* pixels */
}

require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-fonts-helpers.php';

$woostify = (object) array(
	'version' => $woostify_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify.php',
	'customizer' => require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-customizer.php',
);


require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-get-css.php';

/**
 * Sanitize our Google Font variants
 *
 * @param      string $input sanitize variants.
 * @return     sanitize_text_field( $input )
 * @since 1.0
 */
function woostify_sanitize_variants( $input ) {
	if ( is_array( $input ) ) {
		$input = implode( ',', $input );
	}
	return sanitize_text_field( $input );
}

require_once WOOSTIFY_THEME_DIR . 'inc/woostify-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-hooks.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-functions.php';


if ( class_exists( 'Jetpack' ) ) {
	$woostify->jetpack = require_once WOOSTIFY_THEME_DIR . 'inc/jetpack/class-woostify-jetpack.php';
}

if ( woostify_is_woocommerce_activated() ) {
	$woostify->woocommerce = require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-woocommerce.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-template-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-template-hooks.php';
}

if ( is_admin() ) {
	$woostify->admin = require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-admin.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-plugin-install.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-meta-boxes.php';
}

/**
 * NUX
 */
if (
	version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) &&
	( is_admin() || is_customize_preview() )
) {
	require_once WOOSTIFY_THEME_DIR . 'inc/nux/class-woostify-nux-admin.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/nux/class-woostify-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require_once WOOSTIFY_THEME_DIR . 'inc/nux/class-woostify-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 */
