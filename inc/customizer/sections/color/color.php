<?php
/**
 * Color customizer
 *
 * @package woostify
 */

/**
 * Default value
 */
$default_color = Woostify_Customizer::get_woostify_default_setting_values();

/**
 * Theme color
 */
$wp_customize->add_setting(
	'woostify_theme_color',
	array(
		'default'           => $default_color['woostify_theme_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_theme_color',
		array(
			'label'    => __( 'Theme color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_theme_color',
		)
	)
);

/**
 * Primary menu color
 */
$wp_customize->add_setting(
	'woostify_primary_menu_color',
	array(
		'default'           => $default_color['woostify_primary_menu_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_primary_menu_color',
		array(
			'label'    => __( 'Menu color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_primary_menu_color',
		)
	)
);

/**
 * Heading color
 */
$wp_customize->add_setting(
	'woostify_heading_color',
	array(
		'default'           => $default_color['woostify_heading_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_heading_color',
		array(
			'label'    => __( 'Heading color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_heading_color',
		)
	)
);

/**
 * Text Color
 */
$wp_customize->add_setting(
	'woostify_text_color',
	array(
		'default'           => $default_color['woostify_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_text_color',
		array(
			'label'    => __( 'Text color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_text_color',
		)
	)
);

/**
 * Accent Color
 */
$wp_customize->add_setting(
	'woostify_accent_color',
	array(
		'default'           => $default_color['woostify_accent_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_accent_color',
		array(
			'label'    => __( 'Link / accent color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_accent_color',
		)
	)
);
