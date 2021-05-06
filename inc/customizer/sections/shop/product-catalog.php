<?php
/**
 * Woocommerce product catalog customizer
 *
 * @package woostify
 */

if ( ! woostify_is_woocommerce_activated() ) {
	return;
}

// Default values.
$defaults = woostify_options();

// Products per page.
$wp_customize->add_setting(
	'woostify_setting[products_per_row]',
	array(
		'default'           => $defaults['products_per_row'],
		'type'              => 'option',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[tablet_products_per_row]',
	array(
		'default'           => $defaults['tablet_products_per_row'],
		'type'              => 'option',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[mobile_products_per_row]',
	array(
		'default'           => $defaults['mobile_products_per_row'],
		'type'              => 'option',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[products_per_row]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Products Per Row', 'woostify' ),
			'section'  => 'woocommerce_product_catalog',
			'settings' => array(
				'desktop' => 'woostify_setting[products_per_row]',
				'tablet'  => 'woostify_setting[tablet_products_per_row]',
				'mobile'  => 'woostify_setting[mobile_products_per_row]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_products_per_row_desktop_min_step', 1 ),
					'max'  => apply_filters( 'woostify_products_per_row_desktop_max_step', 6 ),
					'step' => 1,
					'edit' => false,
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_products_per_row_tablet_min_step', 1 ),
					'max'  => apply_filters( 'woostify_products_per_row_tablet_max_step', 4 ),
					'step' => 1,
					'edit' => false,
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_products_per_row_mobile_min_step', 1 ),
					'max'  => apply_filters( 'woostify_products_per_row_mobile_max_step', 3 ),
					'step' => 1,
					'edit' => false,
				),
			),
		)
	)
);

// Products per page.
$wp_customize->add_setting(
	'woostify_setting[products_per_page]',
	array(
		'sanitize_callback' => 'woostify_sanitize_int',
		'default'           => $defaults['products_per_page'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[products_per_page]',
		array(
			'section'  => 'woocommerce_product_catalog',
			'settings' => 'woostify_setting[products_per_page]',
			'type'     => 'number',
			'label'    => __( 'Products Per Page', 'woostify' ),
		)
	)
);
