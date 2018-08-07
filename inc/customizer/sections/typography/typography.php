<?php
/**
 * Typography related functions.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$defaults = Woostify_Font_Helpers::woostify_get_default_fonts();

if ( method_exists( $wp_customize,'register_control_type' ) ) {
    $wp_customize->register_control_type( 'Woostify_Typography_Customize_Control' );
    //$wp_customize->register_control_type( 'woostify_Range_Slider_Control' );
}

$wp_customize->add_section(
    'font_section',
    array(
        'title' => __( 'Typography', 'woostify' ),
        'capability' => 'edit_theme_options',
        'description' => '',
        'priority' => 30
    )
);

$wp_customize->add_setting(
    'woostify_settings[font_body]',
    array(
        'default' => $defaults['font_body'],
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    )
);

$wp_customize->add_setting(
    'font_body_category',
    array(
        'default' => $defaults['font_body_category'],
        'sanitize_callback' => 'sanitize_text_field'
    )
);

$wp_customize->add_setting(
    'font_body_variants',
    array(
        'default' => $defaults['font_body_variants'],
        'sanitize_callback' => 'woostify_sanitize_variants'
    )
);

$wp_customize->add_setting(
    'woostify_settings[body_font_weight]',
    array(
        'default' => $defaults['body_font_weight'],
        'type' => 'option',
        'sanitize_callback' => 'sanitize_key',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_setting(
    'woostify_settings[body_font_transform]',
    array(
        'default' => $defaults['body_font_transform'],
        'type' => 'option',
        'sanitize_callback' => 'sanitize_key',
        'transport' => 'postMessage'

    )
);

$wp_customize->add_control(
    new Woostify_Typography_Customize_Control(
        $wp_customize,
        'body_typography',
        array(
            'section' => 'font_section',
            'priority' => 1,
            'settings' => array(
                'family' => 'woostify_settings[font_body]',
                'variant' => 'font_body_variants',
                'category' => 'font_body_category',
                'weight' => 'woostify_settings[body_font_weight]',
                'transform' => 'woostify_settings[body_font_transform]',
            ),
        )
    )
);

		// $wp_customize->add_setting(
		// 	'woostify_settings[body_font_size]',
		// 	array(
		// 		'default' => $defaults['body_font_size'],
		// 		'type' => 'option',
		// 		'sanitize_callback' => 'woostify_sanitize_integer',
		// 		'transport' => 'postMessage'
		// 	)
		// );

		// $wp_customize->add_control(
		// 	new woostify_Range_Slider_Control(
		// 		$wp_customize,
		// 		'woostify_settings[body_font_size]',
		// 		array(
		// 			'type' => 'woostify-range-slider',
		// 			'description' => __( 'Font size', 'woostify' ),
		// 			'section' => 'font_section',
		// 			'settings' => array(
		// 				'desktop' => 'woostify_settings[body_font_size]',
		// 			),
		// 			'choices' => array(
		// 				'desktop' => array(
		// 					'min' => 6,
		// 					'max' => 25,
		// 					'step' => 1,
		// 					'edit' => true,
		// 					'unit' => 'px',
		// 				),
		// 			),
		// 			'priority' => 40,
		// 		)
		// 	)
		// );

		// $wp_customize->add_setting(
		// 	'woostify_settings[body_line_height]',
		// 	array(
		// 		'default' => $defaults['body_line_height'],
		// 		'type' => 'option',
		// 		'sanitize_callback' => 'woostify_sanitize_decimal_integer',
		// 		'transport' => 'postMessage'
		// 	)
		// );

		// $wp_customize->add_control(
		// 	new woostify_Range_Slider_Control(
		// 		$wp_customize,
		// 		'woostify_settings[body_line_height]',
		// 		array(
		// 			'type' => 'woostify-range-slider',
		// 			'description' => __( 'Line height', 'woostify' ),
		// 			'section' => 'font_section',
		// 			'settings' => array(
		// 				'desktop' => 'woostify_settings[body_line_height]',
		// 			),
		// 			'choices' => array(
		// 				'desktop' => array(
		// 					'min' => 1,
		// 					'max' => 3,
		// 					'step' => .1,
		// 					'edit' => true,
		// 					'unit' => '',
		// 				),
		// 			),
		// 			'priority' => 45,
		// 		)
		// 	)
		// );

		// $wp_customize->add_setting(
		// 	'woostify_settings[paragraph_margin]',
		// 	array(
		// 		'default' => $defaults['paragraph_margin'],
		// 		'type' => 'option',
		// 		'sanitize_callback' => 'woostify_sanitize_decimal_integer',
		// 		'transport' => 'postMessage'
		// 	)
		// );

		// $wp_customize->add_control(
		// 	new woostify_Range_Slider_Control(
		// 		$wp_customize,
		// 		'woostify_settings[paragraph_margin]',
		// 		array(
		// 			'type' => 'woostify-range-slider',
		// 			'description' => __( 'Paragraph margin', 'woostify' ),
		// 			'section' => 'font_section',
		// 			'settings' => array(
		// 				'desktop' => 'woostify_settings[paragraph_margin]',
		// 			),
		// 			'choices' => array(
		// 				'desktop' => array(
		// 					'min' => 0,
		// 					'max' => 5,
		// 					'step' => .1,
		// 					'edit' => true,
		// 					'unit' => 'em',
		// 				),
		// 			),
		// 			'priority' => 47,
		// 		)
		// 	)
		// );

		// if ( ! function_exists( 'woostify_fonts_customize_register' ) && ! defined( 'GP_PREMIUM_VERSION' ) ) {
		// 	$wp_customize->add_control(
		// 		new woostify_Customize_Misc_Control(
		// 			$wp_customize,
		// 			'typography_get_addon_desc',
		// 			array(
		// 				'section' => 'font_section',
		// 				'type' => 'addon',
		// 				'label' => __( 'Learn more','woostify' ),
		// 				'description' => __( 'More options are available for this section in our premium version.', 'woostify' ),
		// 				'url' => woostify_get_premium_url( 'https://generatepress.com/downloads/generate-typography/' ),
		// 				'priority' => 50,
		// 				'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname'
		// 			)
		// 		)
		// 	);
		// }



