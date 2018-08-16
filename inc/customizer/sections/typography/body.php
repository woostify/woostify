<?php
/**
 * Body typography
 *
 * @package woostify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get default value
 */
$defaults = Woostify_Fonts_Helpers::woostify_get_default_fonts();

/**
 * Register typography control
 */
if ( method_exists( $wp_customize, 'register_control_type' ) ) {
	$wp_customize->register_control_type( 'Woostify_Typography_Customize_Control' );
}

// body font family.
$wp_customize->add_setting(
	'woostify_settings[body_font_family]',
	array(
		'default'           => $defaults['body_font_family'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// body font category.
$wp_customize->add_setting(
	'body_font_category',
	array(
		'default'           => $defaults['body_font_category'],
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// font font variants.
$wp_customize->add_setting(
	'body_font_family_variants',
	array(
		'default'           => $defaults['body_font_family_variants'],
		'sanitize_callback' => 'woostify_sanitize_variants',
	)
);

// body font weight.
$wp_customize->add_setting(
	'woostify_settings[body_font_weight]',
	array(
		'default'           => $defaults['body_font_weight'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

// body text transform.
$wp_customize->add_setting(
	'woostify_settings[body_font_transform]',
	array(
		'default'           => $defaults['body_font_transform'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

// add control for body typography.
$wp_customize->add_control(
	new Woostify_Typography_Customize_Control(
		$wp_customize,
		'body_typography',
		array(
			'section'  => 'body_font_section',
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

// body font size.
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
		'section'     => 'body_font_section',
	)
);

// body line height.
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
		'section'     => 'body_font_section',
	)
);
