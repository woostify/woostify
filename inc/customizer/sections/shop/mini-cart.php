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
			'label'    => __( 'Show Free Shipping Threshold', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => 'woostify_setting[mini_cart_show_shipping_threshold]',
		)
	)
);

// Free Shipping Threshold position.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_fst_position]',
	array(
		'default'           => $defaults['mini_cart_fst_position'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_fst_position]',
		array(
			'label'    => __( 'Position', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_fst_position]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_mini_cart_fst_position_choices',
				array(
					'woocommerce_before_mini_cart' => __( 'After Header', 'woostify' ),
					'woocommerce_widget_shopping_cart_before_buttons' => __( 'Before Buttons', 'woostify' ),
					'woocommerce_widget_shopping_cart_after_buttons' => __( 'After Buttons', 'woostify' ),
				)
			),
		)
	)
);
