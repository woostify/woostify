<?php
/**
 * Woostify hooks
 *
 * @package woostify
 */

/**
 * General
 *
 * @see  woostify_header_widget_region()
 * @see  woostify_get_sidebar()
 */
add_action( 'woostify_before_content', 'woostify_header_widget_region', 10 );
add_action( 'woostify_sidebar', 'woostify_get_sidebar', 10 );

/**
 * Header
 *
 * @see  woostify_skip_links()
 * @see  woostify_site_branding()
 * @see  woostify_primary_navigation()
 */
add_action( 'woostify_header', 'woostify_header_container', 0 );
add_action( 'woostify_header', 'woostify_skip_links', 5 );
add_action( 'woostify_header', 'woostify_site_branding', 20 );
add_action( 'woostify_header', 'woostify_primary_navigation', 30 );
add_action( 'woostify_header', 'woostify_header_container_close', 60 );


/**
 * Footer
 *
 * @see  woostify_footer_widgets()
 * @see  woostify_credit()
 */
add_action( 'woostify_footer', 'woostify_footer_widgets', 10 );
add_action( 'woostify_footer', 'woostify_credit', 20 );

/**
 * Homepage
 *
 * @see  woostify_homepage_content()
 */
add_action( 'homepage', 'woostify_homepage_content', 10 );

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

add_action( 'woostify_single_post_bottom', 'woostify_post_nav', 10 );
add_action( 'woostify_single_post_bottom', 'woostify_display_comments', 20 );

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

/**
 * Homepage Page Template
 *
 * @see  woostify_homepage_header()
 * @see  woostify_page_content()
 */
add_action( 'woostify_homepage', 'woostify_homepage_header', 10 );
add_action( 'woostify_homepage', 'woostify_page_content', 20 );
