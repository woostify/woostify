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
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
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

// Legacy WooCommerce columns filter.
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
	add_filter( 'loop_shop_columns', 'woostify_loop_columns' );
	add_action( 'woocommerce_before_shop_loop', 'woostify_product_columns_wrapper', 40 );
	add_action( 'woocommerce_after_shop_loop', 'woostify_product_columns_wrapper_close', 40 );
}

/**
 * Products
 *
 * @see woostify_upsell_display()
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woostify_upsell_display', 15 );

add_action( 'woocommerce_after_single_product_summary', 'woostify_single_product_pagination', 30 );
add_action( 'woostify_after_footer', 'woostify_sticky_single_add_to_cart', 999 );

add_action( 'woostify_loop_product_image_wrapper_action', 'woostify_loop_product_image_wrapper' );

/**
 * Header
 *
 * @see woostify_product_search()
 * @see woostify_header_cart()
 */
add_action( 'woostify_header', 'woostify_product_search', 40 );
add_action( 'woostify_header', 'woostify_header_cart', 50 );

/**
 * Cart fragment
 *
 * @see woostify_cart_link_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'woostify_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'woostify_cart_link_fragment' );
}

/**
 * Integrations
 *
 * @see woostify_woocommerce_brands_archive()
 * @see woostify_woocommerce_brands_single()
 * @see woostify_woocommerce_brands_homepage_section()
 */
if ( class_exists( 'WC_Brands' ) ) {
	add_action( 'woocommerce_archive_description', 'woostify_woocommerce_brands_archive', 5 );
	add_action( 'woocommerce_single_product_summary', 'woostify_woocommerce_brands_single', 4 );
	add_action( 'homepage', 'woostify_woocommerce_brands_homepage_section', 80 );
}
