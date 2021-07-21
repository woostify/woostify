<?php
/**
 * Performance customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

$wp_customize->add_setting(
	'woostify_setting[load_google_fonts_locally]',
	array(
		'default'           => $defaults['load_google_fonts_locally'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[load_google_fonts_locally]',
		array(
			'label'    => __( 'Load Google Fonts Locally', 'woostify' ),
			'section'  => 'woostify_performance',
			'settings' => 'woostify_setting[load_google_fonts_locally]',
		)
	)
);
