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

// Background color.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_background_color]',
	array(
		'default'           => $defaults['mini_cart_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[mini_cart_background_color]',
		array(
			'label'    => __( 'Background', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => array(
				'woostify_setting[mini_cart_background_color]',
			),
		)
	)
);

// FREE SHIPPING THRESHOLD SECTION.
$wp_customize->add_setting(
	'mini_cart_fst_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_fst_section',
		array(
			'label'      => __( 'Free shipping threshold', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_show_shipping_threshold]',
				'woostify_setting[mini_cart_fst_position]',
			),
		)
	)
);

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
			'label'    => __( 'Enable', 'woostify' ),
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

// EMPTY CART.
$wp_customize->add_setting(
	'mini_cart_empty',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_empty',
		array(
			'label'      => __( 'Empty cart', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_empty_message]',
				'woostify_setting[mini_cart_empty_enable_button]',
			),
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[mini_cart_empty_message]',
	array(
		'default'           => $defaults['mini_cart_empty_message'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_empty_message]',
		array(
			'label'    => __( 'Message', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_empty_message]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'textarea',
		)
	)
);

// Enable button.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_empty_enable_button]',
	array(
		'type'              => 'option',
		'default'           => $defaults['mini_cart_empty_enable_button'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[mini_cart_empty_enable_button]',
		array(
			'label'    => __( 'Enable Button', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => 'woostify_setting[mini_cart_empty_enable_button]',
		)
	)
);
