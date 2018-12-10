<?php
/**
 * Woostify
 *
 * @package woostify
 */

// Define constants.
define( 'WOOSTIFY_VERSION', '1.0.3' );
define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	// Pixel.
	$content_width = 1170;
}

require_once WOOSTIFY_THEME_DIR . 'inc/woostify-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-hooks.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-fonts-helpers.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-get-css.php';

$woostify = (object) array(
	'version' => woostify_version(),

	// Initialize all the things.
	'main'       => require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify.php',
	'customizer' => require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-customizer.php',
);

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

// Widgets.
require_once WOOSTIFY_THEME_DIR . 'inc/widget/class-woostify-recent-post-thumbnail.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 */
