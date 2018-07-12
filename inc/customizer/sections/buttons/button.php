<?php
/**
 * Button background color
 */
$wp_customize->add_setting(
    'woostify_button_background_color', array(
        'default'               => apply_filters( 'woostify_default_button_background_color', '#96588a' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_button_background_color', array(
            'label'                 => __( 'Background color', 'Woostify'),
            'section'               => 'woostify_buttons',
            'settings'              => 'woostify_button_background_color',
            'priority'              => 10,
        )
    )
);

/**
 * Button text color
 */
$wp_customize->add_setting(
    'woostify_button_text_color', array(
        'default'               => apply_filters( 'woostify_default_button_text_color', '#ffffff' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_button_text_color', array(
            'label'                 => __( 'Text color', 'Woostify'),
            'section'               => 'woostify_buttons',
            'settings'              => 'woostify_button_text_color',
            'priority'              => 20,
        )
    )
);

/**
 * Button alt background color
 */
$wp_customize->add_setting(
    'woostify_button_alt_background_color', array(
        'default'               => apply_filters( 'woostify_default_button_alt_background_color', '#2c2d33' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_button_alt_background_color', array(
            'label'                 => __( 'Alternate button background color', 'Woostify'),
            'section'               => 'woostify_buttons',
            'settings'              => 'woostify_button_alt_background_color',
            'priority'              => 30,
        )
    )
);

/**
 * Button alt text color
 */
$wp_customize->add_setting(
    'woostify_button_alt_text_color', array(
        'default'               => apply_filters( 'woostify_default_button_alt_text_color', '#ffffff' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_button_alt_text_color', array(
            'label'                 => __( 'Alternate button text color', 'Woostify'),
            'section'               => 'woostify_buttons',
            'settings'              => 'woostify_button_alt_text_color',
            'priority'              => 40,
        )
    )
);