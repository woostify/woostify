<?php
/**
 * Typography related functions.
 *
 * @package woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$defaults = Woostify_Fonts_Helpers::woostify_get_default_fonts();

/**
 * Body Font
 */
// Demo Range
$wp_customize->add_setting(
	'woostify_settings[container]',
	array(
		'default' => 14,
		'type' => 'option',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Customize_Control(
		$wp_customize,
		'woostify_settings[container]',
		array(
			'type' => 'woostify-range-slider',
			'description' => __( 'Demo Range', 'apress' ),
			'section' => 'font_section',
			'settings' => array(
				'desktop' => 'woostify_settings[container]',
			),
			'choices' => array(
				'desktop' => array(
					'min' => 5,
					'max' => 35,
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 0,
		)
	)
);
// Body font family.
$wp_customize->add_setting(
	'woostify_settings[body_font_family]',
	array(
		'default'           => $defaults['body_font_family'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// Body font category.
$wp_customize->add_setting(
	'body_font_category',
	array(
		'default'           => $defaults['body_font_category'],
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// Font font variants.
$wp_customize->add_setting(
	'body_font_family_variants',
	array(
		'default'           => $defaults['body_font_family_variants'],
		'sanitize_callback' => 'woostify_sanitize_variants',
	)
);

// Body font weight.
$wp_customize->add_setting(
	'woostify_settings[body_font_weight]',
	array(
		'default'           => $defaults['body_font_weight'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

// Body text transform.
$wp_customize->add_setting(
	'woostify_settings[body_font_transform]',
	array(
		'default'           => $defaults['body_font_transform'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

// Add control for body typography.
$wp_customize->add_control(
	new Woostify_Typography_Customize_Control(
		$wp_customize,
		'body_typography',
		array(
			'section'  => 'font_section',
			'label'    => __( 'Body Font', 'woostify' ),
			'settings' => array(
				'family'    => 'woostify_settings[body_font_family]',
				'variant'   => 'body_font_family_variants',
				'category'  => 'body_font_category',
				'weight'    => 'woostify_settings[body_font_weight]',
				'transform' => 'woostify_settings[body_font_transform]',
			),
		)
	)
);


// Body font size.
$wp_customize->add_setting(
	'woostify_settings[body_font_size]',
	array(
		'default'           => $defaults['body_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[body_font_size]',
	array(
		'type'        => 'number',
		'description' => __( 'Font size (px)', 'woostify' ),
		'section'     => 'font_section',
	)
);

// Body line height.
$wp_customize->add_setting(
	'woostify_settings[body_line_height]',
	array(
		'default'           => $defaults['body_line_height'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[body_line_height]',
	array(
		'type'        => 'text',
		'description' => __( 'Line height', 'woostify' ),
		'section'     => 'font_section',
	)
);

/**
 * Heading
 */

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
	'heading_font_variants',
	array(
		'default'           => $defaults['heading_font_variants'],
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
			'section'  => 'font_section',
			'label'    => __( 'Heading Font', 'woostify' ),
			'settings' => array(
				'family'    => 'woostify_settings[heading_font_family]',
				'variant'   => 'heading_font_variants',
				'category'  => 'heading_font_category',
				'weight'    => 'woostify_settings[heading_font_weight]',
				'transform' => 'woostify_settings[heading_font_transform]',
			),
		)
	)
);

// Heading line height.
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
		'section'     => 'font_section',
	)
);

// CUSTOM HEADING.
$wp_customize->add_setting( 'heading_font_size_title' );
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'heading_font_size_title',
		array(
			'label'    => __( 'Font size (px)', 'woostify' ),
			'section'  => 'font_section',
			'settings' => 'heading_font_size_title',
			'type'     => 'hidden',
		)
	)
);

// H1.
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
			'section'     => 'font_section',
			'description' => __( 'h1', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// H2.
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
			'section'     => 'font_section',
			'description' => __( 'h2', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// H3.
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
			'section'     => 'font_section',
			'description' => __( 'h3', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// H4.
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
			'section'     => 'font_section',
			'description' => __( 'h4', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// H5.
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
			'section'     => 'font_section',
			'description' => __( 'h5', 'woostify' ),
			'type'        => 'number',
		)
	)
);

// H6.
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
			'section'     => 'font_section',
			'description' => __( 'h6', 'woostify' ),
			'type'        => 'number',
		)
	)
);
