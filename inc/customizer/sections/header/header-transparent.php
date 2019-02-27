<?php
/**
 * Header
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Enable/disable Header transparent.
$wp_customize->add_setting(
	'woostify_setting[header_transparent]',
	array(
		'default'           => $defaults['header_transparent'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[header_transparent]',
		array(
			'label'        => __( 'Enable Transparent Header', 'woostify' ),
			'settings'     => 'woostify_setting[header_transparent]',
			'section'      => 'woostify_header_transparent',
			'left_switch'  => __( 'No', 'woostify' ),
			'right_switch' => __( 'Yes', 'woostify' ),
		)
	)
);

// Disable on 404, Search and Archive.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_disable_archive]',
	array(
		'default'           => $defaults['header_transparent_disable_archive'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_transparent_disable_archive]',
		array(
			'label'    => __( 'Disable on 404, Search & Archives', 'woostify' ),
			'settings' => 'woostify_setting[header_transparent_disable_archive]',
			'section'  => 'woostify_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Index.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_disable_index]',
	array(
		'default'           => $defaults['header_transparent_disable_index'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_transparent_disable_index]',
		array(
			'label'    => __( 'Disable on Blog page', 'woostify' ),
			'settings' => 'woostify_setting[header_transparent_disable_index]',
			'section'  => 'woostify_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Pages.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_disable_page]',
	array(
		'default'           => $defaults['header_transparent_disable_page'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_transparent_disable_page]',
		array(
			'label'    => __( 'Disable on Pages', 'woostify' ),
			'settings' => 'woostify_setting[header_transparent_disable_page]',
			'section'  => 'woostify_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Posts.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_disable_post]',
	array(
		'default'           => $defaults['header_transparent_disable_post'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_transparent_disable_post]',
		array(
			'label'    => __( 'Disable on Posts', 'woostify' ),
			'settings' => 'woostify_setting[header_transparent_disable_post]',
			'section'  => 'woostify_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Enable on devices.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_enable_on]',
	array(
		'default'           => $defaults['header_transparent_enable_on'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_transparent_enable_on]',
		array(
			'label'    => __( 'Enable On', 'woostify' ),
			'settings' => 'woostify_setting[header_transparent_enable_on]',
			'section'  => 'woostify_header_transparent',
			'type'     => 'select',
			'choices'  => array(
				'desktop' => __( 'Desktop', 'woostify' ),
				'mobile'  => __( 'Mobile', 'woostify' ),
				'both'    => __( 'Both', 'woostify' ),
			),
		)
	)
);

