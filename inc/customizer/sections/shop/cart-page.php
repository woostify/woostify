<?php
/**
 * Cart page customizer
 *
 * @package woostify
 */

if ( ! woostify_is_woocommerce_activated() ) {
	return;
}

// Default values.
$defaults = woostify_options();

// Sticky proceed to checkout button.
$wp_customize->add_setting(
	'woostify_setting[cart_page_sticky_proceed_button]',
	[
		'default'           => $defaults['cart_page_sticky_proceed_button'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	]
);

$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[cart_page_sticky_proceed_button]',
		[
			'label'       => __( 'Sticky Proceed To Checkout Button', 'woostify' ),
			'description' => __( 'This option only available on mobile devices', 'woostify' ),
			'settings'    => 'woostify_setting[cart_page_sticky_proceed_button]',
			'section'     => 'woostify_cart_page',
		]
	)
);
