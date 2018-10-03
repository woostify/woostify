<?php
/**
 * Woocommerce shop single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Ajax single add to cart.
$wp_customize->add_setting(
	'woostify_setting[single_add_to_cart_ajax]',
	array(
		'default'           => $defaults['single_add_to_cart_ajax'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[single_add_to_cart_ajax]',
		array(
			'label'       => __( 'Ajax single add to cart', 'woostify' ),
			'section'     => 'wc_shop_single',
			'type'        => 'checkbox',
			'settings'    => 'woostify_setting[single_add_to_cart_ajax]',
		)
	)
);
