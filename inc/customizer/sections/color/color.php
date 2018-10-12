<?php
/**
 * Color customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

/*
$wp_customize->add_setting(
	'woostify_setting[theme_switch]',
	array(
		'default'           => true,
		'sanitize_callback' => 'woostify_sanitize_checkbox',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[theme_switch]',
		array(
			'label'    => __( 'On or Off', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[theme_switch]',
			'type'     => 'switch',
			'choices' => array(
				0 => __( 'No', 'woostify' ),
				1 => __( 'Yes', 'woostify' ),
			),
		)
	)
);
*/

// Theme color.
$wp_customize->add_setting(
	'woostify_setting[theme_color]',
	array(
		'default'           => $defaults['theme_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[theme_color]',
		array(
			'label'    => __( 'Theme Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[theme_color]',
		)
	)
);

// Primary parent menu color.
$wp_customize->add_setting(
	'woostify_setting[primary_menu_color]',
	array(
		'default'           => $defaults['primary_menu_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[primary_menu_color]',
		array(
			'label'    => __( 'Parent Menu Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[primary_menu_color]',
		)
	)
);

// Primary sub menu color.
$wp_customize->add_setting(
	'woostify_setting[primary_sub_menu_color]',
	array(
		'default'           => $defaults['primary_sub_menu_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[primary_sub_menu_color]',
		array(
			'label'    => __( 'Sub-menu Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[primary_sub_menu_color]',
		)
	)
);

// Heading color.
$wp_customize->add_setting(
	'woostify_setting[heading_color]',
	array(
		'default'           => $defaults['heading_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[heading_color]',
		array(
			'label'    => __( 'Heading Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[heading_color]',
		)
	)
);

// Text Color.
$wp_customize->add_setting(
	'woostify_setting[text_color]',
	array(
		'default'           => $defaults['text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[text_color]',
		array(
			'label'    => __( 'Text Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[text_color]',
		)
	)
);

// Accent Color.
$wp_customize->add_setting(
	'woostify_setting[accent_color]',
	array(
		'default'           => $defaults['accent_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[accent_color]',
		array(
			'label'    => __( 'Link / Accent Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => 'woostify_setting[accent_color]',
		)
	)
);
