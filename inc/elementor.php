<?php
/**
 * Elementor
 *
 * @package woostify
 */

namespace Elementor;

add_action( 'elementor/elements/categories_registered', 'Elementor\woostify_widget_categories' );
/**
 * Add Elementor Category
 *
 * @param      Elements_Manager $elements_manager The elements manager.
 */
function woostify_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		'woostify-theme',
		array(
			'title' => esc_html__( 'Woostify Theme', 'woostify' ),
		)
	);
}
