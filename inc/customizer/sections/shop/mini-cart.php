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

// GENERAL SECTION.
$wp_customize->add_setting(
	'mini_cart_general_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_general_section',
		array(
			'label'      => __( 'General', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_background_color]',
				'woostify_setting[mini_cart_empty_message]',
				'woostify_setting[mini_cart_empty_enable_button]',
			),
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
			'label'    => __( 'Empty Cart Message', 'woostify' ),
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
			'label'    => __( 'Enable Empty Cart Button', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => 'woostify_setting[mini_cart_empty_enable_button]',
		)
	)
);

// TOP CONTENT SECTION.
$wp_customize->add_setting(
	'mini_cart_top_content_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_top_content_section',
		array(
			'label'      => __( 'Top content', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_top_content_select]',
				'woostify_setting[mini_cart_top_content_custom_html]',
			),
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
					'fst'         => __( 'Free Shipping Threshold', 'woostify' ),
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

// BEFORE CHECKOUT BUTTON CONTENT SECTION.
$wp_customize->add_setting(
	'mini_cart_before_checkout_button_content_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_before_checkout_button_content_section',
		array(
			'label'      => __( 'Before checkout button', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_before_checkout_button_content_select]',
				'woostify_setting[mini_cart_before_checkout_button_content_custom_html]',
			),
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
					'fst'         => __( 'Free Shipping Threshold', 'woostify' ),
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

// AFTER CHECKOUT BUTTON CONTENT SECTION.
$wp_customize->add_setting(
	'mini_cart_after_checkout_button_content_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_after_checkout_button_content_section',
		array(
			'label'      => __( 'After checkout button', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_after_checkout_button_content_select]',
				'woostify_setting[mini_cart_after_checkout_button_content_custom_html]',
			),
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
					'fst'         => __( 'Free Shipping Threshold', 'woostify' ),
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

// CROSS-SELL / UPSELL SECTION.
$wp_customize->add_setting(
	'mini_cart_cross_sell_upsell_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'mini_cart_cross_sell_upsell_section',
		array(
			'label'      => __( 'Cross-sell / Upsell', 'woostify' ),
			'section'    => 'woostify_mini_cart',
			'dependency' => array(
				'woostify_setting[mini_cart_cross_sell_upsell_enable]',
				'woostify_setting[mini_cart_cross_sell_upsell_title]',
				'woostify_setting[mini_cart_cross_sell_upsell_mobile_enable]',
				'woostify_setting[mini_cart_cross_sell_upsell_type]',
				'woostify_setting[mini_cart_cross_sell_upsell_location]',
				'woostify_setting[mini_cart_cross_sell_upsell_mobile_location]',
				'woostify_setting[mini_cart_cross_sell_upsell_number_of_products]',
			),
		)
	)
);

// Enable cross-sell / upsell.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_enable]',
	array(
		'type'              => 'option',
		'default'           => $defaults['mini_cart_cross_sell_upsell_enable'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_enable]',
		array(
			'label'    => __( 'Enable Cross-sell / Upsell', 'woostify' ),
			'section'  => 'woostify_mini_cart',
			'settings' => 'woostify_setting[mini_cart_cross_sell_upsell_enable]',
		)
	)
);

// Title.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_title]',
	array(
		'default'           => $defaults['mini_cart_cross_sell_upsell_title'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_title]',
		array(
			'label'    => __( 'Title', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_cross_sell_upsell_title]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'text',
		)
	)
);

// Enable on mobile devices.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_mobile_enable]',
	array(
		'type'              => 'option',
		'default'           => $defaults['mini_cart_cross_sell_upsell_mobile_enable'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_mobile_enable]',
		array(
			'label'       => __( 'Enable on mobile devices', 'woostify' ),
			'description' => __( 'Show suggested products on mobile.', 'woostify' ),
			'section'     => 'woostify_mini_cart',
			'settings'    => 'woostify_setting[mini_cart_cross_sell_upsell_mobile_enable]',
		)
	)
);

// Type.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_type]',
	array(
		'default'           => $defaults['mini_cart_cross_sell_upsell_type'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_type]',
		array(
			'label'    => __( 'Type', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_cross_sell_upsell_type]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => array(
				'cross-sell' => __( 'Cross-Sells', 'woostify' ),
				'upsell'     => __( 'Up-Sells', 'woostify' ),
				'related'    => __( 'Related', 'woostify' ),
			),
		)
	)
);

// Location.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_location]',
	array(
		'default'           => $defaults['mini_cart_cross_sell_upsell_location'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_location]',
		array(
			'label'    => __( 'Location', 'woostify' ),
			'settings' => 'woostify_setting[mini_cart_cross_sell_upsell_location]',
			'section'  => 'woostify_mini_cart',
			'type'     => 'select',
			'choices'  => array(
				'after-cart-items' => __( 'After Cart Items', 'woostify' ),
				'footer'           => __( 'Footer', 'woostify' ),
				'drawer'           => __( 'Drawer', 'woostify' ),
			),
		)
	)
);

// Location (Mobile).
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_mobile_location]',
	array(
		'default'           => $defaults['mini_cart_cross_sell_upsell_mobile_location'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_mobile_location]',
		array(
			'label'       => __( 'Location (Mobile)', 'woostify' ),
			'description' => __( 'The slider is optimized for and visible on mobile devices', 'woostify' ),
			'settings'    => 'woostify_setting[mini_cart_cross_sell_upsell_mobile_location]',
			'section'     => 'woostify_mini_cart',
			'type'        => 'select',
			'choices'     => array(
				'after-cart-items' => __( 'After Cart Items', 'woostify' ),
				'footer'           => __( 'Footer', 'woostify' ),
			),
		)
	)
);

// Number of Products.
$wp_customize->add_setting(
	'woostify_setting[mini_cart_cross_sell_upsell_number_of_products]',
	array(
		'type'              => 'option',
		'default'           => $defaults['mini_cart_cross_sell_upsell_number_of_products'],
		'sanitize_callback' => 'woostify_sanitize_int',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[mini_cart_cross_sell_upsell_number_of_products]',
		array(
			'label'       => __( 'Number of Products', 'woostify' ),
			'description' => __( 'Display the number of recommended products, -1 for all displays', 'woostify' ),
			'type'        => 'number',
			'section'     => 'woostify_mini_cart',
			'settings'    => 'woostify_setting[mini_cart_cross_sell_upsell_number_of_products]',
		)
	)
);
