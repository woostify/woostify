<?php
/**
 * Shop sidebar
 */
$wp_customize->add_setting(
    'woostify_layout', array(
        'default'               => apply_filters( 'woostify_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
        'sanitize_callback'     => 'woostify_sanitize_choices',
    )
);

$wp_customize->add_control(
    new Woostify_Custom_Radio_Image_Control(
        $wp_customize, 'woostify_layout', array(
            'settings'              => 'woostify_layout',
            'section'               => 'woostify_shop',
            'label'                 => __( 'General Layout', 'woostify' ),
            'priority'              => 1,
            'choices'               => array(
                'right' => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/2cr.png',
                'left'  => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/2cl.png',
            ),
        )
    )
);