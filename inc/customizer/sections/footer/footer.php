<?php

/**
 * Footer widgets column
 */
$wp_customize->add_setting(
    'woostify_footer_column',
    array(
        'default'   => 4,
        'transport' => 'postMessage'
    ) 
);

$wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'woostify_footer_column',
    array(
        'label'       => __( 'Widget columns', 'woostify' ),
        'settings'    => 'woostify_footer_column',
        'section'     => 'woostify_footer',
        'type'        => 'select',
        'choices'     => array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
        )
    )
));


/**
 * Footer Background
 */
$wp_customize->add_setting(
    'woostify_footer_background_color', array(
        'default'               => apply_filters( 'woostify_default_footer_background_color', '#f0f0f0' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_footer_background_color', array(
            'label'                 => __( 'Background color', 'Woostify'),
            'section'               => 'woostify_footer',
            'settings'              => 'woostify_footer_background_color',
        )
    )
);

/**
 * Footer heading color
 */
$wp_customize->add_setting(
    'woostify_footer_heading_color', array(
        'default'               => apply_filters( 'woostify_default_footer_heading_color', '#494c50' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_footer_heading_color', array(
            'label'                 => __( 'Heading color', 'Woostify'),
            'section'               => 'woostify_footer',
            'settings'              => 'woostify_footer_heading_color',
        )
    )
);

/**
 * Footer text color
 */
$wp_customize->add_setting(
    'woostify_footer_text_color', array(
        'default'               => apply_filters( 'woostify_default_footer_text_color', '#61656b' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_footer_text_color', array(
            'label'                 => __( 'Text color', 'Woostify'),
            'section'               => 'woostify_footer',
            'settings'              => 'woostify_footer_text_color',
        )
    )
);

/**
 * Footer link color
 */
$wp_customize->add_setting(
    'woostify_footer_link_color', array(
        'default'               => apply_filters( 'woostify_default_footer_link_color', '#2c2d33' ),
        'sanitize_callback'     => 'sanitize_hex_color',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize, 'woostify_footer_link_color', array(
            'label'                 => __( 'Link color', 'Woostify'),
            'section'               => 'woostify_footer',
            'settings'              => 'woostify_footer_link_color',
        )
    )
);