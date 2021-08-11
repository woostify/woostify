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

// Tabs.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_context_tabs]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_context_tabs]',
		array(
			'section'  => 'woostify_shipping_threshold',
			'settings' => 'woostify_setting[shipping_threshold_context_tabs]',
			'choices'  => array(
				'general' => __( 'General', 'woostify' ),
				'design'  => __( 'Design', 'woostify' ),
			),
		)
	)
);

// Enable progress bar.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_enable_progress_bar]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shipping_threshold_enable_progress_bar'],
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_enable_progress_bar]',
		array(
			'label'       => __( 'Enable Progress Bar', 'woostify' ),
			'description' => __( 'Show a progress bar on mini cart', 'woostify' ),
			'section'     => 'woostify_shipping_threshold',
			'settings'    => 'woostify_setting[shipping_threshold_enable_progress_bar]',
			'tab'         => 'general',
		)
	)
);

// Message.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_msg]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shipping_threshold_msg'],
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_msg]',
		array(
			'label'    => __( 'Message', 'woostify' ),
			'type'     => 'textarea',
			'section'  => 'woostify_shipping_threshold',
			'settings' => 'woostify_setting[shipping_threshold_msg]',
			'tab'      => 'general',
		)
	)
);

// Amount.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_progress_bar_amount]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shipping_threshold_progress_bar_amount'],
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_progress_bar_amount]',
		array(
			'label'       => __( 'Goal Amount', 'woostify' ),
			'description' => __( 'Amount to reach 100%', 'woostify' ),
			'type'        => 'number',
			'section'     => 'woostify_shipping_threshold',
			'settings'    => 'woostify_setting[shipping_threshold_progress_bar_amount]',
			'tab'         => 'general',
		)
	)
);

// Initial Message.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_progress_bar_initial_msg]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shipping_threshold_progress_bar_initial_msg'],
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_progress_bar_initial_msg]',
		array(
			'label'       => __( 'Initial Message', 'woostify' ),
			'description' => __( 'Message to show before reaching the goal. Use shortcode [missing_amount] to display the amount left to reach the minimum', 'woostify' ),
			'type'        => 'textarea',
			'section'     => 'woostify_shipping_threshold',
			'settings'    => 'woostify_setting[shipping_threshold_progress_bar_initial_msg]',
			'tab'         => 'general',
		)
	)
);

// Success Message.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_progress_bar_success_msg]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shipping_threshold_progress_bar_success_msg'],
		'sanitize_callback' => 'woostify_sanitize_raw_html',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_progress_bar_success_msg]',
		array(
			'label'       => __( 'Success Message', 'woostify' ),
			'description' => __( 'Message to show after reaching 100%.', 'woostify' ),
			'type'        => 'textarea',
			'section'     => 'woostify_shipping_threshold',
			'settings'    => 'woostify_setting[shipping_threshold_progress_bar_success_msg]',
			'tab'         => 'general',
		)
	)
);

// Progress bar initial color.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_progress_bar_color]',
	array(
		'default'           => $defaults['shipping_threshold_progress_bar_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_progress_bar_color]',
		array(
			'label'    => __( 'Initial Color', 'woostify' ),
			'section'  => 'woostify_shipping_threshold',
			'settings' => array(
				'woostify_setting[shipping_threshold_progress_bar_color]',
			),
			'tab'      => 'design',
		)
	)
);

// Progress bar success color.
$wp_customize->add_setting(
	'woostify_setting[shipping_threshold_progress_bar_success_color]',
	array(
		'default'           => $defaults['shipping_threshold_progress_bar_success_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shipping_threshold_progress_bar_success_color]',
		array(
			'label'    => __( 'Success Color', 'woostify' ),
			'section'  => 'woostify_shipping_threshold',
			'settings' => array(
				'woostify_setting[shipping_threshold_progress_bar_success_color]',
			),
			'tab'      => 'design',
		)
	)
);
