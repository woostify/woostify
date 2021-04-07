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

$wp_customize->add_setting(
	'woostify_setting[sticky_footer_bar_items]',
	array(
		'default' => $defaults['sticky_footer_bar_items'],
		'type'	=> 'option'
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
