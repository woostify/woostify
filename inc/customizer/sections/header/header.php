<?php
/**
 * Header Background
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Background color.
$wp_customize->add_setting(
	'woostify_setting[header_background_color]',
	array(
		'default'           => $defaults['header_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[header_background_color]',
		array(
			'label'    => __( 'Background color', 'woostify' ),
			'section'  => 'header_image',
			'settings' => 'woostify_setting[header_background_color]',
			'priority' => 15,
		)
	)
);
