<?php
/**
 * Topbar
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Tabs.
$wp_customize->add_setting(
	'woostify_setting[topbar_context_tabs]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[topbar_context_tabs]',
		array(
			'section'  => 'woostify_topbar',
			'settings' => 'woostify_setting[topbar_context_tabs]',
			'choices'  => array(
				'general' => __( 'General', 'woostify' ),
				'design'  => __( 'Design', 'woostify' ),
			),
		)
	)
);

// Display topbar.
$wp_customize->add_setting(
	'woostify_setting[topbar_display]',
	array(
		'type'              => 'option',
		'default'           => $defaults['topbar_display'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[topbar_display]',
		array(
			'label'    => __( 'Topbar Display', 'woostify' ),
			'section'  => 'woostify_topbar',
			'settings' => 'woostify_setting[topbar_display]',
			'tab'      => 'general',
		)
	)
);

// Topbar color.
$wp_customize->add_setting(
	'woostify_setting[topbar_text_color]',
	array(
		'default'           => $defaults['topbar_text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[topbar_text_color]',
		array(
			'label'        => __( 'Text Color', 'woostify' ),
			'section'      => 'woostify_topbar',
			'settings'     => array(
				'woostify_setting[topbar_text_color]',
			),
			'color_format' => 'hex',
			'tab'          => 'design',
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'woostify_setting[topbar_background_color]',
	array(
		'default'           => $defaults['topbar_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[topbar_background_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_topbar',
			'settings' => array(
				'woostify_setting[topbar_background_color]',
			),
			'tab'      => 'design',
		)
	)
);

// Space.
$wp_customize->add_setting(
	'woostify_setting[topbar_space]',
	array(
		'default'           => $defaults['topbar_space'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[topbar_space]',
		array(
			'label'    => __( 'Space', 'woostify' ),
			'section'  => 'woostify_topbar',
			'settings' => array(
				'desktop' => 'woostify_setting[topbar_space]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_topbar_min_step', 0 ),
					'max'  => apply_filters( 'woostify_topbar_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);

// Content divider.
$wp_customize->add_setting(
	'topbar_content_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'topbar_content_divider',
		array(
			'section'  => 'woostify_topbar',
			'settings' => 'topbar_content_divider',
			'type'     => 'divider',
			'tab'      => 'general',
		)
	)
);

// Topbar left.
$wp_customize->add_setting(
	'woostify_setting[topbar_left]',
	array(
		'default'           => $defaults['topbar_left'],
		'sanitize_callback' => 'woostify_sanitize_raw_html',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[topbar_left]',
		array(
			'label'    => __( 'Content Left', 'woostify' ),
			'section'  => 'woostify_topbar',
			'settings' => 'woostify_setting[topbar_left]',
			'type'     => 'textarea',
			'tab'      => 'general',
		)
	)
);

// Topbar center.
$wp_customize->add_setting(
	'woostify_setting[topbar_center]',
	array(
		'default'           => $defaults['topbar_center'],
		'sanitize_callback' => 'woostify_sanitize_raw_html',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[topbar_center]',
		array(
			'label'    => __( 'Content Center', 'woostify' ),
			'section'  => 'woostify_topbar',
			'settings' => 'woostify_setting[topbar_center]',
			'type'     => 'textarea',
			'tab'      => 'general',
		)
	)
);

// Topbar right.
$wp_customize->add_setting(
	'woostify_setting[topbar_right]',
	array(
		'default'           => $defaults['topbar_right'],
		'sanitize_callback' => 'woostify_sanitize_raw_html',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[topbar_right]',
		array(
			'label'    => __( 'Content Right', 'woostify' ),
			'section'  => 'woostify_topbar',
			'settings' => 'woostify_setting[topbar_right]',
			'type'     => 'textarea',
			'tab'      => 'general',
		)
	)
);

// Topbar Slider Tabs.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_context_tabs]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_context_tabs]',
		array(
			'section'  => 'woostify_topbar_slider',
			'settings' => 'woostify_setting[topbar_slider_context_tabs]',
			'choices'  => array(
				'general' => __( 'General', 'woostify' ),
				'design'  => __( 'Design', 'woostify' ),
			),
		)
	)
);

// Display topbar slider.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_display]',
	array(
		'type'              => 'option',
		'default'           => $defaults['topbar_slider_display'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_display]',
		array(
			'label'    => __( 'Topbar Slider Display', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => 'woostify_setting[topbar_slider_display]',
			'tab'      => 'general',
		)
	)
);

// Type.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_type]',
	array(
		'default'           => $defaults['topbar_slider_type'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_type]',
		array(
			'label'    => __( 'Type', 'woostify' ),
			'settings' => 'woostify_setting[topbar_slider_type]',
			'section'  => 'woostify_topbar_slider',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_slider_type_choices',
				array(
					'text-scroll' => __( 'Text Scroll', 'woostify' ),
					'text-slide'  => __( 'Text Slide', 'woostify' ),
				)
			),
			'tab'      => 'general',
		)
	)
);

// Topbar Slider Auto Scroll.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_slide_to_show]',
	array(
		'type'              => 'option',
		'default'           => $defaults['topbar_slider_slide_to_show'],
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_slide_to_show]',
		array(
			'label'    => __( 'Slide To Show', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => 'woostify_setting[topbar_slider_slide_to_show]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_slider_type_choices',
				array(
					'1' => 1,
					'2'  => 2,
					'3' => 3,
					'4'  => 4,
					'5' => 5,
					'6'  => 6,
				)
			),
			'tab'      => 'general',
		)
	)
);

// Topbar Slider Button.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_button]',
	array(
		'type'              => 'option',
		'default'           => $defaults['topbar_slider_button'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_button]',
		array(
			'label'    => __( 'PrevNext Button', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => 'woostify_setting[topbar_slider_button]',
			'tab'      => 'general',
		)
	)
);

// Topbar Slider Auto Play.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_autoplay]',
	array(
		'type'              => 'option',
		'default'           => $defaults['topbar_slider_autoplay'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_autoplay]',
		array(
			'label'    => __( 'Auto Play', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => 'woostify_setting[topbar_slider_autoplay]',
			'tab'      => 'general',
		)
	)
);

// Topbar slider Items.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_items]',
	array(
		'default'           => $defaults['topbar_slider_items'],
		'sanitize_callback' => 'woostify_sanitize_json_string',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Topbar_Slider_Data_Items_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_items]',
		array(
			'label'    => __( 'Sliders', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => 'woostify_setting[topbar_slider_items]',
			'tab'      => 'general',
		)
	)
);

// Topbar Slider Color.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_text_color]',
	array(
		'default'           => $defaults['topbar_slider_text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_text_color]',
		array(
			'label'        => __( 'Text Color', 'woostify' ),
			'section'      => 'woostify_topbar_slider',
			'settings'     => array(
				'woostify_setting[topbar_slider_text_color]',
			),
			'color_format' => 'hex',
			'tab'          => 'design',
		)
	)
);

// Topbar Slider Background Color.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_background_color]',
	array(
		'default'           => $defaults['topbar_slider_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_background_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => array(
				'woostify_setting[topbar_slider_background_color]',
			),
			'tab'      => 'design',
		)
	)
);

// Topbar Slider Space.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_space]',
	array(
		'default'           => $defaults['topbar_slider_space'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_space]',
		array(
			'label'    => __( 'Space', 'woostify' ),
			'section'  => 'woostify_topbar_slider',
			'settings' => array(
				'desktop' => 'woostify_setting[topbar_slider_space]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_topbar_min_step', 0 ),
					'max'  => apply_filters( 'woostify_topbar_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);

// Topbar Slider Button Color.
$wp_customize->add_setting(
	'woostify_setting[topbar_slider_button_color]',
	array(
		'default'           => $defaults['topbar_slider_button_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[topbar_slider_button_color]',
		array(
			'label'        => __( 'Button Color', 'woostify' ),
			'section'      => 'woostify_topbar_slider',
			'settings'     => array(
				'woostify_setting[topbar_slider_button_color]',
			),
			'color_format' => 'hex',
			'tab'          => 'design',
		)
	)
);