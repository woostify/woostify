<?php
/**
 * Woostify hooks
 *
 * @package woostify
 */

/**
 * General
 *
 * @see  woostify_get_sidebar()
 */
add_action( 'woostify_sidebar', 'woostify_get_sidebar', 10 );

add_action( 'woostify_content_top', 'woostify_content_open', 10 );
add_action( 'woostify_content_bottom', 'woostify_content_close', 10 );

add_action( 'woostify_before_view', 'woostify_sidebar_menu_open', 10 );
add_action( 'woostify_before_view', 'woostify_search', 20 );
add_action( 'woostify_before_view', 'woostify_primary_navigation', 30 ); // Header menu for mobile.
add_action( 'woostify_before_view', 'woostify_sidebar_menu_action', 40 );
add_action( 'woostify_before_view', 'woostify_sidebar_menu_close', 100 );

add_action( 'woostify_after_view', 'woostify_overlay', 30 );

/**
 * Header
 *
 * @see  woostify_skip_links()
 * @see  woostify_site_branding()
 * @see  woostify_primary_navigation()
 * @see woostify_search()
 * @see woostify_header_action()
 */
add_action( 'woostify_header', 'woostify_header_container', 0 );
add_action( 'woostify_header', 'woostify_skip_links', 5 );
add_action( 'woostify_header', 'woostify_mobile_menu_toggle_btn', 10 );
add_action( 'woostify_header', 'woostify_site_branding', 20 );
add_action( 'woostify_header', 'woostify_primary_navigation', 30 );
add_action( 'woostify_header', 'woostify_search', 40 );
add_action( 'woostify_header', 'woostify_header_action', 50 );
add_action( 'woostify_header', 'woostify_header_container_close', 200 );

/**
 * Footer
 *
 * @see  woostify_footer_widgets()
 * @see  woostify_credit()
 */
add_action( 'woostify_site_footer', 'woostify_site_footer', 10 );
add_action( 'woostify_footer_content', 'woostify_footer_widgets', 10 );
add_action( 'woostify_footer_content', 'woostify_credit', 20 );

/**
 * Posts
 *
 * @see  woostify_post_header()
 * @see  woostify_post_meta()
 * @see  woostify_post_content()
 * @see  woostify_paging_nav()
 * @see  woostify_single_post_header()
 * @see  woostify_post_nav()
 * @see  woostify_display_comments()
 */
add_action( 'woostify_loop_post', 'woostify_post_header_wrapper', 5 );
add_action( 'woostify_loop_post', 'woostify_post_thumbnail', 7 );
add_action( 'woostify_loop_post', 'woostify_post_meta', 10 );
add_action( 'woostify_loop_post', 'woostify_post_title', 15 );
add_action( 'woostify_loop_post', 'woostify_post_header_wrapper_close', 20 );
add_action( 'woostify_loop_post', 'woostify_post_content', 30 );

add_action( 'woostify_loop_after', 'woostify_paging_nav', 10 );
add_action( 'woostify_post_content_after', 'woostify_post_read_more_button', 10 );

add_action( 'woostify_single_post', 'woostify_post_meta', 10 );
add_action( 'woostify_single_post', 'woostify_post_title', 20 );
add_action( 'woostify_single_post', 'woostify_post_thumbnail', 25 );
add_action( 'woostify_single_post', 'woostify_post_content', 30 );
add_action( 'woostify_single_post', 'woostify_post_tags', 40 );

add_action( 'woostify_single_post_after', 'woostify_post_nav', 10 );
add_action( 'woostify_single_post_after', 'woostify_post_related', 15 );
add_action( 'woostify_single_post_after', 'woostify_display_comments', 20 );

/**
 * Pages
 *
 * @see  woostify_page_header()
 * @see  woostify_page_content()
 * @see  woostify_display_comments()
 */
add_action( 'woostify_page', 'woostify_page_header', 10 );
add_action( 'woostify_page', 'woostify_page_content', 20 );

add_action( 'woostify_page_after', 'woostify_display_comments', 10 );
