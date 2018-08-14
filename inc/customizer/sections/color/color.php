<?php
/**
 * Heading color
 */
$wp_customize->add_setting(
    'woostify_heading_color', array(
        'default'               => apply_filters( 'woostify_default_heading_color', '#484c51' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_heading_color', array(
            'label'                 => __( 'Heading color', 'Woostify'),
            'section'               => 'woostify_color',
            'settings'              => 'woostify_heading_color',
            'priority'              => 20,
        )
    )
);

/**
 * Text Color
 */
$wp_customize->add_setting(
    'woostify_text_color', array(
        'default'               => apply_filters( 'woostify_default_text_color', '#43454b' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_text_color', array(
            'label'                 => __( 'Text color', 'Woostify'),
            'section'               => 'woostify_color',
            'settings'              => 'woostify_text_color',
            'priority'              => 30,
        )
    )
);

/**
 * Accent Color
 */
$wp_customize->add_setting(
    'woostify_accent_color', array(
        'default'               => apply_filters( 'woostify_default_accent_color', '#96588a' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_accent_color', array(
            'label'                 => __( 'Link / accent color', 'Woostify'),
            'section'               => 'woostify_color',
            'settings'              => 'woostify_accent_color',
            'priority'              => 40,
        )
    )
);