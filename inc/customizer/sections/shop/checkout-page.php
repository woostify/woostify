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

// Distraction Free Checkout.
$wp_customize->add_setting(
	'woostify_setting[checkout_distraction_free]',
	array(
		'default'           => $defaults['checkout_distraction_free'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[checkout_distraction_free]',
		array(
			'label'    => __( 'Distraction Free Checkout', 'woostify' ),
			'settings' => 'woostify_setting[checkout_distraction_free]',
			'section'  => 'woocommerce_checkout',
			'priority' => 0,
		)
	)
);

// Multi step checkout.
$wp_customize->add_setting(
	'woostify_setting[checkout_multi_step]',
	array(
		'default'           => $defaults['checkout_multi_step'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[checkout_multi_step]',
		array(
			'label'    => __( 'Multi Step Checkout', 'woostify' ),
			'settings' => 'woostify_setting[checkout_multi_step]',
			'section'  => 'woocommerce_checkout',
			'priority' => 0,
		)
	)
);

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
			'label'       => __( 'Sticky Place Order Button', 'woostify' ),
			'description' => __( 'This option only available on mobile devices', 'woostify' ),
			'settings'    => 'woostify_setting[checkout_sticky_place_order_button]',
			'section'     => 'woocommerce_checkout',
			'priority'    => 0,
		)
	)
);

// Theme checkout divider.
$wp_customize->add_setting(
	'woostify_checkout_start',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'woostify_checkout_start',
		array(
			'section'  => 'woocommerce_checkout',
			'settings' => 'woostify_checkout_start',
			'type'     => 'divider',
			'priority' => 0,
		)
	)
);
