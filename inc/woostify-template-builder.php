<?php
/**
 * Theme Builder
 *
 * @package woostify
 */

if ( ! function_exists( 'woostify_template_header' ) ) {
	/**
	 * Header template
	 */
	function woostify_template_header() {
		if ( function_exists( 'hfe_render_header' ) && hfe_header_enabled() ) {
			// Support Header & Footer Elementor plugin.
			hfe_render_header();
			do_action( 'woostify_hfe_render_header' );
		} else {
			get_template_part( 'template-parts/header' );
		}
	}
}

if ( ! function_exists( 'woostify_template_footer' ) ) {
	/**
	 * Footer template
	 */
	function woostify_template_footer() {
		// Support Header & Footer Elementor plugin.
		if ( function_exists( 'hfe_render_footer' ) && hfe_footer_enabled() ) {
			do_action( 'woostify_hfe_render_footer' );
			hfe_render_footer();
		} else {
			get_template_part( 'template-parts/footer' );
		}
	}
}

if ( ! function_exists( 'woostify_template_single' ) ) {
	/**
	 * Single template
	 */
	function woostify_template_single() {
		get_template_part( 'template-parts/single' );
	}
}

if ( ! function_exists( 'woostify_template_archive' ) ) {
	/**
	 * Archive template
	 */
	function woostify_template_archive() {
		get_template_part( 'template-parts/archive' );
	}
}

if ( ! function_exists( 'woostify_template_404' ) ) {
	/**
	 * 404 template
	 */
	function woostify_template_404() {
		get_template_part( 'template-parts/404' );
	}
}
