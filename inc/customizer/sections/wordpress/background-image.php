<?php
/**
 * Site Title & Tagline
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Default contailer.
$wp_customize->add_setting(
	'woostify_setting[default_container]',
	array(
		'type'              => 'option',
		'default'           => $defaults['default_container'],
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[default_container]',
		array(
			'label'    => __( 'Default Container', 'woostify' ),
			'section'  => 'background_image',
			'type'     => 'select',
			'settings' => 'woostify_setting[default_container]',
			'priority' => 8,
			'choices' => apply_filters(
				'woostify_setting_default_container',
				array(
					'normal'     => __( 'Normal', 'woostify' ),
					'full-width' => __( 'Full Width', 'woostify' ),
					'boxed'      => __( 'Boxed', 'woostify' ),
				)
			),
		)
	)
);
