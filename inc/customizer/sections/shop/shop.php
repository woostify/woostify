<?php
/**
 * Shop customizer
 *
 * @package woostify
 */

/**
 * Default value
 */
$default_color = woostify_default_settings();

// Product content background color.
$wp_customize->add_setting(
	'woostify_shop_content_background',
	array(
		'default'           => '#f00',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_shop_content_background',
		array(
			'label'    => __( 'Content background', 'woostify' ),
			'section'  => 'woostify_shop',
			'settings' => 'woostify_shop_content_background',
		)
	)
);
