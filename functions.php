<?php
/**
 * Woostify
 *
 * @package woostify
 */

// Define constants.
define( 'WOOSTIFY_VERSION', '1.1.8' );
define( 'WOOSTIFY_PRO_MIN_VERSION', '1.0.5' );
define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

// Woostify functions, hooks.
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-hooks.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-functions.php';

// Woostify generate css.
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-fonts-helpers.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-get-css.php';


// Woostify customizer.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-customizer.php';

// Woostify woocommerce.
if ( woostify_is_woocommerce_activated() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-woocommerce.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-template-functions.php';
}

// Woostify admin.
if ( is_admin() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-admin.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-plugin-install.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-meta-boxes.php';
}

// Woostify widgets.
require_once WOOSTIFY_THEME_DIR . 'inc/widget/class-woostify-recent-post-thumbnail.php';

// Woostify elementor.
require_once WOOSTIFY_THEME_DIR . 'inc/elementor.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 */
