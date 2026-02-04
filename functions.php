<?php
/**
 * Woostify
 *
 * @package woostify
 */

// Define constants.
define( 'WOOSTIFY_VERSION', '2.4.' );
define( 'WOOSTIFY_PRO_MIN_VERSION', '1.7.2' );
define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

// Woostify svgs icon.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify-icon.php';

// Woostify functions, hooks.
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-hooks.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-builder.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-functions.php';

// Woostify generate css.
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-webfont-loader.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-fonts-helpers.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-get-css.php';

// Woostify customizer.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-customizer.php';

// Woostify woocommerce.
if ( woostify_is_woocommerce_activated() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-woocommerce.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-adjacent-products.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-template-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-archive-product-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-single-product-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-query-update.php';
}

// Woostify admin.
if ( is_admin() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-admin.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-meta-boxes.php';
}

// Compatibility.
require_once WOOSTIFY_THEME_DIR . 'inc/compatibility/class-woostify-divi-builder.php';

add_action( 'wp_footer', function () {
    if ( ! is_checkout() ) return;
    ?>
    <script>
    (function () {

        function movePlaceOrder() {
            const placeOrder = document.getElementById('place_order');
            const reviewTable = document.querySelector('.woocommerce-checkout-review-order-table');

            if (!placeOrder || !reviewTable) return false;

            // Nếu đã di chuyển rồi thì không làm lại
            if (placeOrder.closest('.woostify-place-order-bottom')) return true;

            const wrapper = document.createElement('div');
            wrapper.className = 'woostify-place-order-bottom';

            // Đặt nút SAU CÙNG bảng order review
            reviewTable.parentNode.appendChild(wrapper);
            wrapper.appendChild(placeOrder);

            return true;
        }

        // Chạy ngay
        if (movePlaceOrder()) return;

        // Theo dõi Woostify render lại DOM
        const observer = new MutationObserver(function () {
            if (movePlaceOrder()) {
                observer.disconnect();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

    })();
    </script>
    <?php
});
