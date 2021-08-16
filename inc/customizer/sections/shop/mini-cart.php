<?php
/**
 * Woocommerce mini cart customizer
 *
 * @package woostify
 */

if ( ! woostify_is_woocommerce_activated() ) {
	return;
}

// Default values.
$defaults = woostify_options();

// Show free shipping threshold.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_show_shipping_threshold]',
	array(
		'type'              => 'option',
		'default'           => $defaults['mini_cart_show_shipping_threshold'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[mini_cart_show_shipping_threshold]',
		array(
			'label'       => __( 'Show Free Shipping Threshold', 'woostify' ),
			'section'     => 'woostify_mini_cart',
			'settings'    => 'woostify_setting[mini_cart_show_shipping_threshold]',
		)
	)
);
