<?php
/**
 * Button customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Text color.
$wp_customize->add_setting(
	'woostify_setting[button_text_color]',
	array(
		'default'           => $defaults['button_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[button_text_color]',
		array(
			'label'                 => __( 'Text color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_setting[button_text_color]',
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'woostify_setting[button_background_color]',
	array(
		'default'           => $defaults['button_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[button_background_color]',
		array(
			'label'                 => __( 'Background color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_setting[button_background_color]',
		)
	)
);

// Hover text color.
$wp_customize->add_setting(
	'woostify_setting[button_hover_text_color]',
	array(
		'default'           => $defaults['button_hover_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[button_hover_text_color]',
		array(
			'label'                 => __( 'Hover text color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_setting[button_hover_text_color]',
		)
	)
);

// Hover background color.
$wp_customize->add_setting(
	'woostify_setting[button_hover_background_color]',
	array(
		'default'           => $defaults['button_hover_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[button_hover_background_color]',
		array(
			'label'                 => __( 'Hover background color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_setting[button_hover_background_color]',
		)
	)
);
