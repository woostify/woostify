<?php
/**
 * Checkout page customizer
 *
 * @package woostify
 */

if ( ! woostify_is_woocommerce_activated() ) {
	return;
}

// Default values.
$defaults = woostify_options();

// Sticky place order button.
$wp_customize->add_setting(
	'woostify_setting[checkout_sticky_place_order_button]',
	array(
		'default'           => $defaults['checkout_sticky_place_order_button'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[checkout_sticky_place_order_button]',
		array(
			'label'       => __( 'Sticky Place Order Button', 'woostify-pro' ),
			'description' => __( 'This option only available on mobile devices', 'woostify-pro' ),
			'settings'    => 'woostify_setting[checkout_sticky_place_order_button]',
			'section'     => 'woocommerce_checkout',
		)
	)
);
