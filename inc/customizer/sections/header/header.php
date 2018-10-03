<?php
/**
 * Header Background
 *
 * @package woostify
 */

// Default value.
$default_value = woostify_default_settings();

// Background color.
$wp_customize->add_setting(
	'woostify_header_background_color',
	array(
		'default'           => $default_value['woostify_header_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_header_background_color',
		array(
			'label'    => __( 'Background color', 'woostify' ),
			'section'  => 'header_image',
			'settings' => 'woostify_header_background_color',
			'priority' => 15,
		)
	)
);
