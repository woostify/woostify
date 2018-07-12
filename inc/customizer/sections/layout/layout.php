<?php
$wp_customize->add_setting(
    'woostify_layout', array(
        'default'               => apply_filters( 'woostify_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
        'sanitize_callback'     => 'woostify_sanitize_choices',
    )
);

$wp_customize->add_control(
    new Storefront_Custom_Radio_Image_Control(
        $wp_customize, 'woostify_layout', array(
            'settings'              => 'woostify_layout',
            'section'               => 'woostify_layout',
            'label'                 => __( 'General Layout', 'Woostify'),
            'priority'              => 1,
            'choices'               => array(
                'right' => get_template_directory_uri() . '/assets/images/customizer/controls/2cr.png',
                'left'  => get_template_directory_uri() . '/assets/images/customizer/controls/2cl.png',
            ),
        )
    )
);