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

// Border divider.
$wp_customize->add_setting(
	'header_transparent_border_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'header_transparent_border_divider',
		array(
			'section'  => 'woostify_header_transparent',
			'settings' => 'header_transparent_border_divider',
			'type'     => 'divider',
		)
	)
);

// Border width.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_border_width]',
	array(
		'default'           => $defaults['header_transparent_border_width'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[header_transparent_border_width]',
		array(
			'label'    => __( 'Bottom Border Width', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => array(
				'desktop' => 'woostify_setting[header_transparent_border_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_header_transparent_border_width_min_step', 0 ),
					'max'  => apply_filters( 'woostify_header_transparent_border_width_max_step', 20 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Border color.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_border_color]',
	array(
		'default'           => $defaults['header_transparent_border_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Control(
		$wp_customize,
		'woostify_setting[header_transparent_border_color]',
		array(
			'label'    => __( 'Border Color', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => 'woostify_setting[header_transparent_border_color]',
		)
	)
);

// Box shadow divider.
$wp_customize->add_setting(
	'header_transparent_box_shadow_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'header_transparent_box_shadow_divider',
		array(
			'section'  => 'woostify_header_transparent',
			'settings' => 'header_transparent_box_shadow_divider',
			'type'     => 'divider',
		)
	)
);

// Enable box shadow.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_box_shadow]',
	array(
		'default'           => $defaults['header_transparent_box_shadow'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[header_transparent_box_shadow]',
		array(
			'label'        => __( 'Enable Box Shadow', 'woostify' ),
			'settings'     => 'woostify_setting[header_transparent_box_shadow]',
			'section'      => 'woostify_header_transparent',
			'left_switch'  => __( 'No', 'woostify' ),
			'right_switch' => __( 'Yes', 'woostify' ),
		)
	)
);

// Box shadow type.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_shadow_type]',
	array(
		'default'           => $defaults['header_transparent_shadow_type'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_transparent_shadow_type]',
		array(
			'label'       => __( 'Box Shadow Type', 'woostify' ),
			'settings'    => 'woostify_setting[header_transparent_shadow_type]',
			'section'     => 'woostify_header_transparent',
			'type'        => 'select',
			'choices'     => array(
				'outset' => __( 'Outset', 'woostify' ),
				'inset'  => __( 'Inset', 'woostify' ),
			),
		)
	)
);

// Box shadow X offset.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_shadow_x]',
	array(
		'default'           => $defaults['header_transparent_shadow_x'],
		'sanitize_callback' => 'woostify_sanitize_int',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[header_transparent_shadow_x]',
		array(
			'label'    => __( 'X Offset', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => array(
				'desktop' => 'woostify_setting[header_transparent_shadow_x]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_header_transparent_shadow_x_offset_min_step', -100 ),
					'max'  => apply_filters( 'woostify_header_transparent_shadow_x_offset_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Box shadow Y offset.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_shadow_y]',
	array(
		'default'           => $defaults['header_transparent_shadow_y'],
		'sanitize_callback' => 'woostify_sanitize_int',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[header_transparent_shadow_y]',
		array(
			'label'    => __( 'Y Offset', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => array(
				'desktop' => 'woostify_setting[header_transparent_shadow_y]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_header_transparent_shadow_y_offset_min_step', -100 ),
					'max'  => apply_filters( 'woostify_header_transparent_shadow_y_offset_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Box shadow blur.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_shadow_blur]',
	array(
		'default'           => $defaults['header_transparent_shadow_blur'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[header_transparent_shadow_blur]',
		array(
			'label'    => __( 'Blur', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => array(
				'desktop' => 'woostify_setting[header_transparent_shadow_blur]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_header_transparent_shadow_blur_min_step', 0 ),
					'max'  => apply_filters( 'woostify_header_transparent_shadow_blur_max_step', 20 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Box shadow spread.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_shadow_spread]',
	array(
		'default'           => $defaults['header_transparent_shadow_spread'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[header_transparent_shadow_spread]',
		array(
			'label'    => __( 'Spread', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => array(
				'desktop' => 'woostify_setting[header_transparent_shadow_spread]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_header_transparent_shadow_spread_min_step', 0 ),
					'max'  => apply_filters( 'woostify_header_transparent_shadow_spread_max_step', 20 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Box shadow color.
$wp_customize->add_setting(
	'woostify_setting[header_transparent_shadow_color]',
	array(
		'default'           => $defaults['header_transparent_shadow_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Control(
		$wp_customize,
		'woostify_setting[header_transparent_shadow_color]',
		array(
			'label'    => __( 'Shadow Color', 'woostify' ),
			'section'  => 'woostify_header_transparent',
			'settings' => 'woostify_setting[header_transparent_shadow_color]',
		)
	)
);
