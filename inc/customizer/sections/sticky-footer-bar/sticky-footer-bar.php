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
			'choices' => array(
				'general' => __( 'General', 'woostify' ),
				'design'	=> __( 'Design', 'woostify' )
			)
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
			'tab'	=> 'general'
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
			'tab'	=> 'general'
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
			'tab'	=> 'general'
		)
	)
);
