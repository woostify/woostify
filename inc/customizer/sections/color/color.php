<?php
/**
 * Color customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Theme color.
$wp_customize->add_setting(
	'woostify_setting[theme_color]',
	array(
		'default'           => $defaults['theme_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[theme_color]',
		array(
			'label'    => __( 'Theme Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => array(
				'woostify_setting[theme_color]',
			),
		)
	)
);

// Primary parent menu color.
$wp_customize->add_setting(
	'woostify_setting[primary_menu_color]',
	array(
		'default'           => $defaults['primary_menu_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[primary_menu_color]',
		array(
			'label'    => __( 'Parent Menu Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => array(
				'woostify_setting[primary_menu_color]',
			),
		)
	)
);

// Primary sub menu color.
$wp_customize->add_setting(
	'woostify_setting[primary_sub_menu_color]',
	array(
		'default'           => $defaults['primary_sub_menu_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[primary_sub_menu_color]',
		array(
			'label'    => __( 'Sub-menu Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => array(
				'woostify_setting[primary_sub_menu_color]',
			),
		)
	)
);

// Heading color.
$wp_customize->add_setting(
	'woostify_setting[heading_color]',
	array(
		'default'           => $defaults['heading_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[heading_color]',
		array(
			'label'    => __( 'Heading Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => array(
				'woostify_setting[heading_color]',
			),
		)
	)
);

// Text Color.
$wp_customize->add_setting(
	'woostify_setting[text_color]',
	array(
		'default'           => $defaults['text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[text_color]',
		array(
			'label'    => __( 'Text Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => array(
				'woostify_setting[text_color]',
			),
		)
	)
);

// Accent Color.
$wp_customize->add_setting(
	'woostify_setting[accent_color]',
	array(
		'default'           => $defaults['accent_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[accent_color]',
		array(
			'label'    => __( 'Link / Accent Color', 'woostify' ),
			'section'  => 'woostify_color',
			'settings' => array(
				'woostify_setting[accent_color]',
			),
		)
	)
);

// Extra Color 1.
$wp_customize->add_setting(
	'woostify_setting[extra_color_1]',
	array(
		'default'           => $defaults['extra_color_1'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[extra_color_1]',
		array(
			'label'           => __( 'Extra Color 1', 'woostify' ),
			'section'         => 'woostify_color',
			'settings'        => array(
				'woostify_setting[extra_color_1]',
			),
			'enable_swatches' => false,
		)
	)
);

// Extra Color 2.
$wp_customize->add_setting(
	'woostify_setting[extra_color_2]',
	array(
		'default'           => $defaults['extra_color_2'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[extra_color_2]',
		array(
			'label'           => __( 'Extra Color 2', 'woostify' ),
			'section'         => 'woostify_color',
			'settings'        => array(
				'woostify_setting[extra_color_2]',
			),
			'enable_swatches' => false,
		)
	)
);
