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

$woo_builder = new Woostify_Woo_Builder();
$cart_page   = $woo_builder->get_template_id( 'woostify_cart_page' );
$cart_empty  = $woo_builder->get_template_id( 'woostify_cart_empty' );
$args        = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => 1,
);

$products      = new WP_Query( $args );
$total_product = $products->found_posts;

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		if ( $cart_page && $total_product ) {
			WC()->cart->add_to_cart( $products->posts[0]->ID );
		} elseif ( $cart_empty ) {
			WC()->cart->empty_cart();
		}

		the_content();
	}
}

get_footer();
