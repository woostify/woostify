<?php
/**
 * Woocommerce mini cart customizer
 *
 * @package woostify
 */

if ( ! woostify_is_woocommerce_activated() ) {
	return;
}

// Default values.
$defaults = woostify_options();

// General heading.
$wp_customize->add_setting(
	'mini_cart_general_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_general_heading',
		array(
			'label'   => __( 'GENERAL', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_background_color]',
	array(
		'default'           => $defaults['mini_cart_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[mini_cart_background_color]',
		array(
			'label'    => __( 'Background', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => array(
				'woostify_setting[mini_cart_background_color]',
			),
		)
	)
);

// TOP CONTENT.
$wp_customize->add_setting(
	'mini_cart_top_content_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_top_content_heading',
		array(
			'label'   => __( 'Top content', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Select content.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_top_content_select]',
	array(
		'default'           => $defaults['mini_cart_top_content_select'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_top_content_select]',
		array(
			'label'    => __( 'Select Content', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_top_content_select]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_mini_cart_content_choices',
				array(
					''            => __( 'None', 'woostify' ),
					'custom_html' => __( 'Custom HTML', 'woostify' ),
				)
			),
		)
	)
);

// Top Content Custom HTML.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_top_content_custom_html]',
	array(
		'default'           => $defaults['mini_cart_top_content_custom_html'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_top_content_custom_html]',
		array(
			'label'    => __( 'Custom HTML', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_top_content_custom_html]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'textarea',
		)
	)
);

// BEFORE CHECKOUT BUTTON CONTENT.
$wp_customize->add_setting(
	'mini_cart_before_checkout_button_content_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_before_checkout_button_content_heading',
		array(
			'label'   => __( 'Before Checkout button content', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Select content.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_before_checkout_button_content_select]',
	array(
		'default'           => $defaults['mini_cart_before_checkout_button_content_select'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_before_checkout_button_content_select]',
		array(
			'label'    => __( 'Select Content', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_before_checkout_button_content_select]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_mini_cart_content_choices',
				array(
					''            => __( 'None', 'woostify' ),
					'custom_html' => __( 'Custom HTML', 'woostify' ),
				)
			),
		)
	)
);

// Before checkout button Content Custom HTML.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_before_checkout_button_content_custom_html]',
	array(
		'default'           => $defaults['mini_cart_before_checkout_button_content_custom_html'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_before_checkout_button_content_custom_html]',
		array(
			'label'    => __( 'Custom HTML', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_before_checkout_button_content_custom_html]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'textarea',
		)
	)
);

// AFTER CHECKOUT BUTTON CONTENT.
$wp_customize->add_setting(
	'mini_cart_after_checkout_button_content_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_after_checkout_button_content_heading',
		array(
			'label'   => __( 'After Checkout button content', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Select content.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_after_checkout_button_content_select]',
	array(
		'default'           => $defaults['mini_cart_after_checkout_button_content_select'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_after_checkout_button_content_select]',
		array(
			'label'    => __( 'Select Content', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_after_checkout_button_content_select]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_mini_cart_content_choices',
				array(
					''            => __( 'None', 'woostify' ),
					'custom_html' => __( 'Custom HTML', 'woostify' ),
				)
			),
		)
	)
);

// After checkout button Content Custom HTML.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_after_checkout_button_content_custom_html]',
	array(
		'default'           => $defaults['mini_cart_after_checkout_button_content_custom_html'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_after_checkout_button_content_custom_html]',
		array(
			'label'    => __( 'Custom HTML', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_after_checkout_button_content_custom_html]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'textarea',
		)
	)
);

// EMPTY CART.
$wp_customize->add_setting(
	'mini_cart_empty_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'mini_cart_empty_heading',
		array(
			'label'   => __( 'EMPTY CART', 'woostify' ),
			'section' => 'woostify_mini_cart',
		)
	)
);

// Empty cart message.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_empty_message]',
	array(
		'default'           => $defaults['mini_cart_empty_message'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_empty_message]',
		array(
			'label'    => __( 'Message', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_empty_message]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'textarea',
		)
	)
);

// Enable button.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_empty_enable_button]',
	array(
		'type'              => 'option',
		'default'           => $defaults['mini_cart_empty_enable_button'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[mini_cart_empty_enable_button]',
		array(
			'label'    => __( 'Enable Button', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => 'woostify_setting[mini_cart_empty_enable_button]',
		)
	)
);
