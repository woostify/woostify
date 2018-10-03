<?php
/**
 * Shop single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Product content background.
$wp_customize->add_setting(
	'woostify_setting[single_content_background]',
	array(
		'default'           => $defaults['single_content_background'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[single_content_background]',
		array(
			'label'    => __( 'Content background', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[single_content_background]',
		)
	)
);
