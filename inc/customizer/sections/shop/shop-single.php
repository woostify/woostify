<?php
/**
 * Shop single customizer
 *
 * @package woostify
 */

// Default value.
$default_value = woostify_default_settings();

// Product content background.
$wp_customize->add_setting(
	'woostify_single_content_background',
	array(
		'default'           => $default_value['woostify_single_content_background'],
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_single_content_background',
		array(
			'label'    => __( 'Content background', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_single_content_background',
		)
	)
);
