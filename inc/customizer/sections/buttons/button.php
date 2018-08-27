<?php
/**
 * Button customizer
 *
 * @package woostify
 */

/**
 * Default value
 */
$default_color = woostify_default_settings();

/**
 * Text color
 */
$wp_customize->add_setting(
	'woostify_button_text_color',
	array(
		'default'               => $default_color['woostify_button_text_color'],
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_button_text_color',
		array(
			'label'                 => __( 'Text color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_button_text_color',
		)
	)
);

/**
 * Background color
 */
$wp_customize->add_setting(
	'woostify_button_background_color',
	array(
		'default'               => $default_color['woostify_button_background_color'],
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_button_background_color',
		array(
			'label'                 => __( 'Background color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_button_background_color',
		)
	)
);

/**
 * Hover text color
 */
$wp_customize->add_setting(
	'woostify_button_hover_text_color',
	array(
		'default'               => $default_color['woostify_button_hover_text_color'],
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_button_hover_text_color',
		array(
			'label'                 => __( 'Hover text color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_button_hover_text_color',
		)
	)
);

/**
 * Hover background color
 */
$wp_customize->add_setting(
	'woostify_button_hover_background_color',
	array(
		'default'               => $default_color['woostify_button_hover_background_color'],
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_button_hover_background_color',
		array(
			'label'                 => __( 'Hover background color', 'woostify' ),
			'section'               => 'woostify_buttons',
			'settings'              => 'woostify_button_hover_background_color',
		)
	)
);
