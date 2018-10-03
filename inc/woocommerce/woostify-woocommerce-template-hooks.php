<?php
/**
 * Woostify WooCommerce hooks
 *
 * @package woostify
 */

/**
 * Homepage
 *
 * @see  woostify_product_categories()
 * @see  woostify_recent_products()
 * @see  woostify_featured_products()
 * @see  woostify_popular_products()
 * @see  woostify_on_sale_products()
 * @see  woostify_best_selling_products()
 */
add_action( 'homepage', 'woostify_product_categories', 20 );
add_action( 'homepage', 'woostify_recent_products', 30 );
add_action( 'homepage', 'woostify_featured_products', 40 );
add_action( 'homepage', 'woostify_popular_products', 50 );
add_action( 'homepage', 'woostify_on_sale_products', 60 );
add_action( 'homepage', 'woostify_best_selling_products', 70 );

/**
 * Layout
 *
 * @see  woostify_before_content()
 * @see  woostify_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  woostify_shop_messages()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

add_action( 'woocommerce_before_main_content', 'woostify_before_content', 10 );
add_action( 'woocommerce_after_main_content', 'woostify_after_content', 10 );
add_action( 'woostify_content_top', 'woostify_shop_messages', 15 );

add_action( 'woocommerce_before_shop_loop', 'woostify_sorting_wrapper', 9 );
add_action( 'woocommerce_before_shop_loop', 'woostify_sorting_wrapper_close', 31 );

// Woocommerce sidebar.
add_action( 'woostify_after_view', 'woostify_woocommerce_cart_sidebar', 20 );

// Legacy WooCommerce columns filter.
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
	add_filter( 'loop_shop_columns', 'woostify_loop_columns' );
	add_action( 'woocommerce_before_shop_loop', 'woostify_product_columns_wrapper', 40 );
	add_action( 'woocommerce_after_shop_loop', 'woostify_product_columns_wrapper_close', 40 );
}

// PRODUCT PAGE.
// Remove default gallery.
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

// Sale flash.
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 25 );

// Swap position price and rating star.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
