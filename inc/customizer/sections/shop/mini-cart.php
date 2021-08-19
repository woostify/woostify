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

// General heading.
$wp_customize->add_setting(
	'mini_cart_general_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_general_heading',
		array(
			'label'   => __( 'GENERAL', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

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

// TOP CONTENT.
$wp_customize->add_setting(
	'mini_cart_top_content_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_top_content_heading',
		array(
			'label'   => __( 'Top content', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Select content.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_top_content_select]',
	array(
		'default'           => $defaults['mini_cart_top_content_select'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_top_content_select]',
		array(
			'label'    => __( 'Select Content', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_top_content_select]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_mini_cart_top_content_choices',
				array(
					''            => __( 'None', 'woostify' ),
					'custom_html' => __( 'Custom HTML', 'woostify' ),
				)
			),
		)
	)
);

// EMPTY CART.
$wp_customize->add_setting(
	'mini_cart_empty_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_empty_heading',
		array(
			'label'   => __( 'EMPTY CART', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Empty cart message.
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
