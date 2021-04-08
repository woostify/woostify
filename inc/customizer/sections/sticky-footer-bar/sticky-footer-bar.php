<?php
/**
 * Sticky Footer Bar
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Space.
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
	new WP_Customize_Control(
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
		)
	)
);
