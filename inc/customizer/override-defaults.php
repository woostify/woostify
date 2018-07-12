<?php
/**
 * Override default customizer panels, sections, settings or controls.
 *
 * @package     Woostify
 */

// Move background color setting alongside background image.
$wp_customize->get_control( 'background_color' )->section   = 'background_image';
$wp_customize->get_control( 'background_color' )->priority  = 20;

// Change background image section title & priority.
$wp_customize->get_section( 'background_image' )->title     = __( 'Background', 'Woostify');
$wp_customize->get_section( 'background_image' )->priority  = 30;

// Change header image section title & priority.
$wp_customize->get_section( 'header_image' )->title         = __( 'Header', 'Woostify');
$wp_customize->get_section( 'header_image' )->priority      = 25;

// Selective refresh.
if ( function_exists( 'add_partial' ) ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    $wp_customize->selective_refresh->add_partial(
        'custom_logo', array(
            'selector'        => '.site-branding',
            'render_callback' => array( $this, 'get_site_logo' ),
        )
    );

    $wp_customize->selective_refresh->add_partial(
        'blogname', array(
            'selector'        => '.site-title.beta a',
            'render_callback' => array( $this, 'get_site_name' ),
        )
    );

    $wp_customize->selective_refresh->add_partial(
        'blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => array( $this, 'get_site_description' ),
        )
    );
}