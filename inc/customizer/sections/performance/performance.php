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

$wp_customize->add_setting(
	'woostify_setting[load_google_fonts_locally_preload]',
	array(
		'default'           => $defaults['load_google_fonts_locally_preload'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[load_google_fonts_locally_preload]',
		array(
			'label'    => __( 'Preload Local Font', 'woostify' ),
			'section'  => 'woostify_performance',
			'settings' => 'woostify_setting[load_google_fonts_locally_preload]',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[load_google_fonts_locally_clear]',
	array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Button_Control(
		$wp_customize,
		'woostify_setting[load_google_fonts_locally_clear]',
		array(
			'label'        => __( 'Clear Local Fonts Cache', 'woostify' ),
			'description'  => __('Click the button to reset the local fonts cache.', 'woostify' ),
			'section'      => 'woostify_performance',
			'settings'     => 'woostify_setting[load_google_fonts_locally_clear]',
			'button_label' => __( 'Clear', 'woostify' ),
			'button_class' => 'button button-secondary woostify-clear-font-files',
			'button_link'  => 'javascript:;',
		)
	)
);
