<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Woostify
 * @author      Woostify
 * @copyright   Copyright (c) 2018, Woostify
 * @since       Astra 1.0.0
 */
/**
 * Footer section
 */
$wp_customize->add_section(
    'woostify_footer', array(
        'title'                 => __( 'Footer', 'Woostify'),
        'priority'              => 28,
        'description'           => __( 'Customize the look & feel of your website footer.', 'Woostify'),
    )
);
        
/**
 * Add the typography section
 */
$wp_customize->add_section(
    'woostify_typography', array(
        'title'                 => __( 'Typography', 'woostify'),
        'priority'              => 45,
    )
);

/**
 * Buttons section
 */
$wp_customize->add_section(
    'woostify_buttons', array(
        'title'                 => __( 'Buttons', 'woostify'),
        'priority'              => 45,
        'description'           => __( 'Customize the look & feel of your website buttons.', 'woostify'),
    )
);


/**
 * Layout
 */
$wp_customize->add_section(
    'woostify_layout', array(
        'title'                 => __( 'Layout', 'woostify'),
        'priority'              => 50,
    )
);