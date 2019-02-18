<?php
/**
 * Elementor
 *
 * @package woostify
 */

/**
 * Support Elementor Location
 *
 * @param      array|object $elementor_theme_manager  The elementor theme manager.
 */
function woostify_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location(
		'header',
		[
			'hook'            => 'woostify_theme_header',
			'remove_hooks'    => [ 'woostify_theme_print_elementor_header' ],
			'label'           => __( 'Woostify Header', 'woostify' ),
			'multiple'        => false,
			'edit_in_content' => true,
		]
	);
	$elementor_theme_manager->register_location(
		'footer',
		[
			'hook'            => 'woostify_theme_footer',
			'remove_hooks'    => [ 'woostify_theme_print_elementor_footer' ],
			'label'           => __( 'Woostify Footer', 'woostify' ),
			'multiple'        => false,
			'edit_in_content' => true,
		]
	);
	$elementor_theme_manager->register_location(
		'single',
		[
			'hook'            => 'woostify_theme_single',
			'remove_hooks'    => [ 'woostify_theme_print_elementor_single' ],
			'label'           => __( 'Woostify Single', 'woostify' ),
			'multiple'        => false,
			'edit_in_content' => true,
		]
	);
	$elementor_theme_manager->register_location(
		'archive',
		[
			'hook'            => 'woostify_theme_archive',
			'remove_hooks'    => [ 'woostify_theme_print_elementor_archive' ],
			'label'           => __( 'Woostify Archive', 'woostify' ),
			'multiple'        => false,
			'edit_in_content' => true,
		]
	);
	$elementor_theme_manager->register_location(
		'404',
		[
			'hook'            => 'woostify_theme_404',
			'remove_hooks'    => [ 'woostify_theme_print_elementor_404' ],
			'label'           => __( 'Woostify 404', 'woostify' ),
			'multiple'        => false,
			'edit_in_content' => true,
		]
	);
}
add_action( 'elementor/theme/register_locations', 'woostify_register_elementor_locations' );

/**
 * Header template
 */
function woostify_theme_print_elementor_header() {
	// Support Header & Footer Elementor plugin.
	if ( function_exists( 'hfe_render_header' ) && hfe_header_enabled() ) {
		hfe_render_header();
		do_action( 'woostify_after_hle_render_header' );
	} else {
		get_template_part( 'template-parts/header' );
	}
}
add_action( 'woostify_theme_header', 'woostify_theme_print_elementor_header' );

/**
 * Footer template
 */
function woostify_theme_print_elementor_footer() {
	// Support Header & Footer Elementor plugin.
	if ( function_exists( 'hfe_render_footer' ) && hfe_footer_enabled() ) {
		do_action( 'woostify_before_hle_render_footer' );
		hfe_render_footer();

		// Close 3 `div` on header template.
		// If only using HLE Footer template.
		if ( ! hfe_header_enabled() ) {
			?>
					</div>
				</div>
			</div>
			<?php
		}
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
add_action( 'woostify_theme_footer', 'woostify_theme_print_elementor_footer' );

/**
 * Single template
 */
function woostify_theme_print_elementor_single() {
	get_template_part( 'template-parts/single' );
}
add_action( 'woostify_theme_single', 'woostify_theme_print_elementor_single' );

/**
 * Archive template
 */
function woostify_theme_print_elementor_archive() {
	get_template_part( 'template-parts/archive' );
}
add_action( 'woostify_theme_archive', 'woostify_theme_print_elementor_archive' );

/**
 * 404 template
 */
function woostify_theme_print_elementor_404() {
	get_template_part( 'template-parts/404' );
}
add_action( 'woostify_theme_404', 'woostify_theme_print_elementor_404' );
