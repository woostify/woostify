<?php // phpcs:ignore
/**
 * Elementor Library Single
 *
 * @package woostify
 */

get_header();

// Do not display content on single Woo Builder post type.
if ( ! woostify_is_elementor_editor() && is_singular( 'woo_builder' ) ) {
	return get_footer();
}

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		the_content();
	}
}

get_footer();
