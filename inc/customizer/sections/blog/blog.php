<?php
/**
 * Button background color
 *
 * @package woostify
 */

$wp_customize->add_setting(
	'woostify_blog_layout',
	array(
		'default'               => apply_filters( 'woostify_default_button_background_color', '#96588a' ),
		'sanitize_callback'     => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_blog_layout',
		array(
			'label'                 => __( 'Background color', 'woostify' ),
			'section'               => 'woostify_blog',
			'settings'              => 'woostify_blog_layout',
		)
	)
);
