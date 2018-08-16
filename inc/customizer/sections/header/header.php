<?php
/**
 * Header Background
 *
 * @package woostify
 */

$wp_customize->add_setting(
	'woostify_header_background_color', array(
		'default'               => apply_filters( 'woostify_default_header_background_color', '#2c2d33' ),
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 'woostify_header_background_color', array(
			'label'                 => __( 'Background color', 'woostify' ),
			'section'               => 'header_image',
			'settings'              => 'woostify_header_background_color',
			'priority'              => 15,
		)
	)
);

/**
 * Header text color
 */
$wp_customize->add_setting(
	'woostify_header_text_color', array(
		'default'               => apply_filters( 'woostify_default_header_text_color', '#9aa0a7' ),
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 'woostify_header_text_color', array(
			'label'                 => __( 'Text color', 'woostify' ),
			'section'               => 'header_image',
			'settings'              => 'woostify_header_text_color',
			'priority'              => 20,
		)
	)
);

/**
 * Header link color
 */
$wp_customize->add_setting(
	'woostify_header_link_color', array(
		'default'               => apply_filters( 'woostify_default_header_link_color', '#d5d9db' ),
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 'woostify_header_link_color', array(
			'label'                 => __( 'Link color', 'woostify' ),
			'section'               => 'header_image',
			'settings'              => 'woostify_header_link_color',
			'priority'              => 30,
		)
	)
);
