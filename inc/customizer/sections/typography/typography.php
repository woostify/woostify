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
            'section'               => 'woostify_typography',
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
            'section'               => 'woostify_typography',
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
            'section'               => 'woostify_typography',
            'settings'              => 'woostify_accent_color',
            'priority'              => 40,
        )
    )
);

/**
 * Hero Heading Color
 */
$wp_customize->add_setting(
    'woostify_hero_heading_color', array(
        'default'               => apply_filters( 'woostify_default_hero_heading_color', '#000000' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_hero_heading_color', array(
            'label'                 => __( 'Hero heading color', 'Woostify'),
            'section'               => 'woostify_typography',
            'settings'              => 'woostify_hero_heading_color',
            'priority'              => 50,
            'active_callback'       => array( $this, 'is_homepage_template' ),
        )
    )
);

/**
 * Hero Text Color
 */
$wp_customize->add_setting(
    'woostify_hero_text_color', array(
        'default'               => apply_filters( 'woostify_default_hero_text_color', '#000000' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_hero_text_color', array(
            'label'                 => __( 'Hero text color', 'Woostify'),
            'section'               => 'woostify_typography',
            'settings'              => 'woostify_hero_text_color',
            'priority'              => 60,
            'active_callback'       => array( $this, 'is_homepage_template' ),
        )
    )
);

$wp_customize->add_control(
    new Arbitrary_Storefront_Control(
        $wp_customize, 'woostify_header_image_heading', array(
            'section'               => 'header_image',
            'type'                  => 'heading',
            'label'                 => __( 'Header background image', 'Woostify'),
            'priority'              => 6,
        )
    )
);