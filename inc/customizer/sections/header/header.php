<?php
/**
 * Header
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Header layout.
$wp_customize->add_setting(
	'woostify_setting[header_layout]',
	array(
		'default'           => $defaults['header_layout'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Custom_Radio_Image_Control(
		$wp_customize,
		'woostify_setting[header_layout]',
		array(
			'label'    => __( 'Header layout', 'woostify' ),
			'section'  => 'header_image',
			'settings' => 'woostify_setting[header_layout]',
			'priority' => 5,
			'choices'  => apply_filters(
				'woostify_setting_header_layout_choices',
				array(
					'layout-1' => WOOSTIFY_THEME_URI . 'assets/images/customizer/header/header-1.png',
				)
			),
		)
	)
);

// Background color divider.
$wp_customize->add_setting( 'header_background_color_divider' );
$wp_customize->add_control(
	new Arbitrary_Woostify_Control(
		$wp_customize,
		'header_background_color_divider',
		array(
			'section'  => 'header_image',
			'settings' => 'header_background_color_divider',
			'type'     => 'divider',
			'priority' => 7,
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'woostify_setting[header_background_color]',
	array(
		'default'           => $defaults['header_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[header_background_color]',
		array(
			'label'    => __( 'Background color', 'woostify' ),
			'section'  => 'header_image',
			'settings' => 'woostify_setting[header_background_color]',
			'priority' => 9,
		)
	)
);

// Show/hide feature divider.
$wp_customize->add_setting( 'header_show_hide_element_divider' );
$wp_customize->add_control(
	new Arbitrary_Woostify_Control(
		$wp_customize,
		'header_show_hide_element_divider',
		array(
			'section'  => 'header_image',
			'settings' => 'header_show_hide_element_divider',
			'type'     => 'divider',
		)
	)
);

// Header element.
// Search form.
$wp_customize->add_setting(
	'woostify_setting[header_search_form]',
	array(
		'type'      => 'option',
		'default'   => $defaults['header_search_form'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[header_search_form]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Search form', 'woostify' ),
			'section'  => 'header_image',
			'settings' => 'woostify_setting[header_search_form]',
		)
	)
);

// Woocommerce.
if ( class_exists( 'woocommerce' ) ) {
	// Search product only.
	$wp_customize->add_setting(
		'woostify_setting[header_search_only_product]',
		array(
			'type'    => 'option',
			'default' => $defaults['header_search_only_product'],
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'woostify_setting[header_search_only_product]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Search only product', 'woostify' ),
				'section'  => 'header_image',
				'settings' => 'woostify_setting[header_search_only_product]',
			)
		)
	);

	// Account icon.
	$wp_customize->add_setting(
		'woostify_setting[header_account_icon]',
		array(
			'type'    => 'option',
			'default' => $defaults['header_account_icon'],
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'woostify_setting[header_account_icon]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Account icon', 'woostify' ),
				'section'  => 'header_image',
				'settings' => 'woostify_setting[header_account_icon]',
			)
		)
	);

	// Shopping cart icon.
	$wp_customize->add_setting(
		'woostify_setting[header_shop_cart_icon]',
		array(
			'type'    => 'option',
			'default' => $defaults['header_shop_cart_icon'],
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'woostify_setting[header_shop_cart_icon]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Shopping cart icon', 'woostify' ),
				'section'  => 'header_image',
				'settings' => 'woostify_setting[header_shop_cart_icon]',
			)
		)
	);
}
