<?php
/**
 * Heading typography
 *
 * @package woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get default value
 */
$defaults = woostify_default_fonts();

/**
 * Register typography control
 */
if ( method_exists( $wp_customize, 'register_control_type' ) ) {
	$wp_customize->register_control_type( 'Woostify_Typography_Customize_Control' );
}


$wp_customize->add_setting(
	'woostify_settings[heading_font_family]',
	array(
		'default'           => $defaults['heading_font_family'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_setting(
	'heading_font_category',
	array(
		'default'           => $defaults['heading_font_category'],
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_setting(
	'heading_font_family_variants',
	array(
		'default'           => $defaults['heading_font_family_variants'],
		'sanitize_callback' => 'woostify_sanitize_variants',
	)
);

$wp_customize->add_setting(
	'woostify_settings[heading_font_weight]',
	array(
		'default'           => $defaults['heading_font_weight'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_settings[heading_font_transform]',
	array(
		'default'           => $defaults['heading_font_transform'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Typography_Customize_Control(
		$wp_customize,
		'heading_typography',
		array(
			'section'  => 'heading_font_section',
			'label'    => __( 'Heading Font', 'woostify' ),
			'settings' => array(
				'family'    => 'woostify_settings[heading_font_family]',
				'variant'   => 'heading_font_family_variants',
				'category'  => 'heading_font_category',
				'weight'    => 'woostify_settings[heading_font_weight]',
				'transform' => 'woostify_settings[heading_font_transform]',
			),
		)
	)
);

// heading line height.
$wp_customize->add_setting(
	'woostify_settings[heading_line_height]',
	array(
		'default'           => $defaults['heading_line_height'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[heading_line_height]',
	array(
		'type'        => 'number',
		'description' => __( 'Line height', 'woostify' ),
		'section'     => 'heading_font_section',
	)
);

// Heading font size divider.
$wp_customize->add_setting( 'heading_font_divider' );
$wp_customize->add_control(
	new Arbitrary_Storefront_Control(
		$wp_customize,
		'heading_font_divider',
		array(
			'section'  => 'heading_font_section',
			'settings' => 'heading_font_divider',
			'type'     => 'divider',
		)
	)
);

// Heading font size title.
$wp_customize->add_setting( 'heading_font_size_title' );
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'heading_font_size_title',
		array(
			'label'    => __( 'Font size (px)', 'woostify' ),
			'section'  => 'heading_font_section',
			'settings' => 'heading_font_size_title',
			'type'     => 'hidden',
		)
	)
);

// h1.
$wp_customize->add_setting(
	'woostify_settings[heading_h1_font_size]',
	array(
		'default'           => $defaults['heading_h1_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_settings[heading_h1_font_size]',
		array(
			'section'     => 'heading_font_section',
			'description' => __( 'h1', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// h2.
$wp_customize->add_setting(
	'woostify_settings[heading_h2_font_size]',
	array(
		'default'           => $defaults['heading_h2_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_settings[heading_h2_font_size]',
		array(
			'section'     => 'heading_font_section',
			'description' => __( 'h2', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// h3.
$wp_customize->add_setting(
	'woostify_settings[heading_h3_font_size]',
	array(
		'default'           => $defaults['heading_h3_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_settings[heading_h3_font_size]',
		array(
			'section'     => 'heading_font_section',
			'description' => __( 'h3', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// h4.
$wp_customize->add_setting(
	'woostify_settings[heading_h4_font_size]',
	array(
		'default'           => $defaults['heading_h4_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_settings[heading_h4_font_size]',
		array(
			'section'     => 'heading_font_section',
			'description' => __( 'h4', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// h5.
$wp_customize->add_setting(
	'woostify_settings[heading_h5_font_size]',
	array(
		'default'           => $defaults['heading_h5_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_settings[heading_h5_font_size]',
		array(
			'section'     => 'heading_font_section',
			'description' => __( 'h5', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// h6.
$wp_customize->add_setting(
	'woostify_settings[heading_h6_font_size]',
	array(
		'default'           => $defaults['heading_h6_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_settings[heading_h6_font_size]',
		array(
			'section'     => 'heading_font_section',
			'description' => __( 'h6', 'woostify' ),
			'type'        => 'number',
		)
	)
);
