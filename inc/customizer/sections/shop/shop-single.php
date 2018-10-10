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
			'label'       => __( 'Ajax Single Add To Cart', 'woostify' ),
			'section'     => 'woostify_shop_single',
			'type'        => 'checkbox',
			'settings'    => 'woostify_setting[single_add_to_cart_ajax]',
		)
	)
);

// Product content background.
$wp_customize->add_setting(
	'woostify_setting[single_content_background]',
	array(
		'default'           => $defaults['single_content_background'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[single_content_background]',
		array(
			'label'    => __( 'Content Background', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[single_content_background]',
		)
	)
);
