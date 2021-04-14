<?php
/**
 * Sticky Footer Bar
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Tabs
$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_context_tabs]'
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_context_tabs]',
		array(
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_context_tabs]',
			'choices'  => array(
				'general' => __( 'General', 'woostify' ),
				'design'  => __( 'Design', 'woostify' ),
			),
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_enable]',
	array(
		'default'           => $defaults['sticky_footer_bar_enable'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_enable]',
		array(
			'label'    => __( 'Enable', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_enable]',
			'tab'      => 'general',
		)
	)
);

// Enable on devices.
$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_enable_on]',
	array(
		'default'           => $defaults['sticky_footer_bar_enable_on'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_enable_on]',
		array(
			'label'    => __( 'Enable On', 'woostify' ),
			'settings' => 'woostify_setting[sticky_footer_bar_enable_on]',
			'section'  => 'woostify_sticky_footer_bar',
			'type'     => 'select',
			'choices'  => array(
				'desktop'     => __( 'Desktop', 'woostify' ),
				'mobile'      => __( 'Mobile', 'woostify' ),
				'all-devices' => __( 'Desktop + Mobile', 'woostify' ),
			),
			'tab'      => 'general',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_items]',
	array(
		'default' => $defaults['sticky_footer_bar_items'],
		'type'    => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Adv_List_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_items]',
		array(
			'label'    => __( 'Items', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_items]',
			'tab'      => 'general',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_icon_color]',
	array(
		'default'           => $defaults['sticky_footer_bar_icon_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_icon_color]',
		array(
			'label'    => __( 'Icon Color', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_icon_color]',
			'tab'      => 'design',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_icon_hover_color]',
	array(
		'default'           => $defaults['sticky_footer_bar_icon_hover_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_icon_hover_color]',
		array(
			'label'    => __( 'Icon Hover Color', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_icon_hover_color]',
			'tab'      => 'design',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_text_color]',
	array(
		'default'           => $defaults['sticky_footer_bar_text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_text_color]',
		array(
			'label'    => __( 'Text Color', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_text_color]',
			'tab'      => 'design',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_text_hover_color]',
	array(
		'default'           => $defaults['sticky_footer_bar_text_hover_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_text_hover_color]',
		array(
			'label'    => __( 'Text Hover Color', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => 'woostify_setting[sticky_footer_bar_text_hover_color]',
			'tab'      => 'design',
		)
	)
);

// Icon font size.
$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_icon_font_size]',
	array(
		'default'           => $defaults['sticky_footer_bar_icon_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_icon_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Icon Font Size', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => array(
				'desktop' => 'woostify_setting[sticky_footer_bar_icon_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_sticky_footer_bar_icon_font_size_min_step', 10 ),
					'max'  => apply_filters( 'woostify_sticky_footer_bar_icon_font_size_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);

// Icon font size.
$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_text_font_size]',
	array(
		'default'           => $defaults['sticky_footer_bar_text_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_text_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Text Font Size', 'woostify' ),
			'section'  => 'woostify_sticky_footer_bar',
			'settings' => array(
				'desktop' => 'woostify_setting[sticky_footer_bar_text_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_sticky_footer_bar_text_font_size_min_step', 10 ),
					'max'  => apply_filters( 'woostify_sticky_footer_bar_text_font_size_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);


// Icon font size.
$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_text_font_weight]',
	array(
		'default'           => $defaults['sticky_footer_bar_text_font_weight'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[sticky_footer_bar_text_font_weight]',
		array(
			'label'    => __( 'Text Font Weight', 'woostify' ),
			'settings' => 'woostify_setting[sticky_footer_bar_text_font_weight]',
			'section'  => 'woostify_sticky_footer_bar',
			'type'     => 'select',
			'choices'  => array(
				'300' => __( '300', 'woostify' ),
				'400' => __( '400', 'woostify' ),
				'500' => __( '500', 'woostify' ),
				'600' => __( '600', 'woostify' ),
				'700' => __( '700', 'woostify' ),
				'800' => __( '800', 'woostify' ),
				'900' => __( '900', 'woostify' ),
			),
			'tab'      => 'design',
		)
	)
);
