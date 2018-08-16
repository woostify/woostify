<?php
/**
 * Primary menu typography
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

// menu font family.
$wp_customize->add_setting(
	'woostify_settings[menu_font_family]',
	array(
		'default'           => $defaults['menu_font_family'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// menu font category.
$wp_customize->add_setting(
	'menu_font_category',
	array(
		'default'           => $defaults['menu_font_category'],
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// font font variants.
$wp_customize->add_setting(
	'menu_font_family_variants',
	array(
		'default'           => $defaults['menu_font_family_variants'],
		'sanitize_callback' => 'woostify_sanitize_variants',
	)
);

// menu font weight.
$wp_customize->add_setting(
	'woostify_settings[menu_font_weight]',
	array(
		'default'           => $defaults['menu_font_weight'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

// menu text transform.
$wp_customize->add_setting(
	'woostify_settings[menu_font_transform]',
	array(
		'default'           => $defaults['menu_font_transform'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'postMessage',
	)
);

// add control for menu typography.
$wp_customize->add_control(
	new Woostify_Typography_Customize_Control(
		$wp_customize,
		'menu_typography',
		array(
			'section'  => 'menu_font_section',
			'label'    => __( 'Menu Font', 'woostify' ),
			'settings' => array(
				'family'    => 'woostify_settings[menu_font_family]',
				'variant'   => 'menu_font_family_variants',
				'category'  => 'menu_font_category',
				'weight'    => 'woostify_settings[menu_font_weight]',
				'transform' => 'woostify_settings[menu_font_transform]',
			),
		)
	)
);

// CUSTOM HEADING.
$wp_customize->add_setting( 'parent_menu_title' );
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'parent_menu_title',
		array(
			'label'    => __( 'Parent menu', 'woostify' ),
			'section'  => 'menu_font_section',
			'settings' => 'parent_menu_title',
			'type'     => 'hidden',
		)
	)
);

// parent menu font size.
$wp_customize->add_setting(
	'woostify_settings[parent_menu_font_size]',
	array(
		'default'           => $defaults['parent_menu_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[parent_menu_font_size]',
	array(
		'type'        => 'number',
		'description' => __( 'Font size (px)', 'woostify' ),
		'section'     => 'menu_font_section',
	)
);

// parent menu line height.
$wp_customize->add_setting(
	'woostify_settings[parent_menu_line_height]',
	array(
		'default'           => $defaults['parent_menu_line_height'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[parent_menu_line_height]',
	array(
		'type'        => 'number',
		'description' => __( 'Line height (px)', 'woostify' ),
		'section'     => 'menu_font_section',
	)
);

// CUSTOM HEADING.
$wp_customize->add_setting( 'sub_menu_title' );
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'sub_menu_title',
		array(
			'label'    => __( 'Sub menu', 'woostify' ),
			'section'  => 'menu_font_section',
			'settings' => 'sub_menu_title',
			'type'     => 'hidden',
		)
	)
);

// sub menu font size.
$wp_customize->add_setting(
	'woostify_settings[sub_menu_font_size]',
	array(
		'default'           => $defaults['sub_menu_font_size'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[sub_menu_font_size]',
	array(
		'type'        => 'number',
		'description' => __( 'Font size (px)', 'woostify' ),
		'section'     => 'menu_font_section',
	)
);

// sub menu line height.
$wp_customize->add_setting(
	'woostify_settings[sub_menu_line_height]',
	array(
		'default'           => $defaults['sub_menu_line_height'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'woostify_settings[sub_menu_line_height]',
	array(
		'type'        => 'number',
		'description' => __( 'Line height (px)', 'woostify' ),
		'section'     => 'menu_font_section',
	)
);
