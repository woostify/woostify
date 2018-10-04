<?php
/**
 * Footer widgets column
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Footer widget columns.
if ( is_active_sidebar( 'footer' ) ) {

	$wp_customize->add_setting(
		'woostify_setting[footer_column]',
		array(
			'default'           => $defaults['footer_column'],
			'type'              => 'option',
			'sanitize_callback' => 'woostify_sanitize_choices',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[footer_column]',
		array(
			'label'       => __( 'Widget columns', 'woostify' ),
			'settings'    => 'woostify_setting[footer_column]',
			'section'     => 'woostify_footer',
			'type'        => 'select',
			'choices'     => apply_filters(
				'woostify_setting_footer_column_choices',
				array(
					0 => 0,
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				)
			),
		)
	));
}

// Footer Background.
$wp_customize->add_setting(
	'woostify_setting[footer_background_color]',
	array(
		'default'           => $defaults['footer_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[footer_background_color]',
		array(
			'label'    => __( 'Background color', 'woostify' ),
			'section'  => 'woostify_footer',
			'settings' => 'woostify_setting[footer_background_color]',
		)
	)
);

// Footer heading color.
$wp_customize->add_setting(
	'woostify_setting[footer_heading_color]',
	array(
		'default'           => $defaults['footer_heading_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[footer_heading_color]',
		array(
			'label'    => __( 'Heading color', 'woostify' ),
			'section'  => 'woostify_footer',
			'settings' => 'woostify_setting[footer_heading_color]',
		)
	)
);

// Footer link color.
$wp_customize->add_setting(
	'woostify_setting[footer_link_color]',
	array(
		'default'           => $defaults['footer_link_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[footer_link_color]',
		array(
			'label'    => __( 'Link color', 'woostify' ),
			'section'  => 'woostify_footer',
			'settings' => 'woostify_setting[footer_link_color]',
		)
	)
);

// Footer text color.
$wp_customize->add_setting(
	'woostify_setting[footer_text_color]',
	array(
		'default'           => $defaults['footer_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[footer_text_color]',
		array(
			'label'    => __( 'Text color', 'woostify' ),
			'section'  => 'woostify_footer',
			'settings' => 'woostify_setting[footer_text_color]',
		)
	)
);
