<?php
/**
 * Woocommerce shop single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// GENERAL SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_general_section]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_general_section]',
		array(
			'label'      => __( 'General', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_columns]',
				'woostify_setting[shop_product_per_page]',
			]
		)
	)
);

// Shop columns.
$wp_customize->add_setting(
	'woostify_setting[shop_columns]',
	array(
		'default'           => $defaults['shop_columns'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_columns]',
		array(
			'label'    => __( 'Product Columns', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'type'     => 'select',
			'settings' => 'woostify_setting[shop_columns]',
			'choices'     => apply_filters(
				'woostify_setting_shop_columns',
				array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				)
			),
		)
	)
);

// Product per page.
$wp_customize->add_setting(
	'woostify_setting[shop_product_per_page]',
	array(
		'default'           => $defaults['shop_product_per_page'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_product_per_page]',
		array(
			'type'        => 'woostify-range-slider',
			'label'       => __( 'Products Per Row', 'woostify' ),
			'description' => __( 'How many products should be shown per row?', 'woostify' ),
			'section'     => 'woostify_shop_page',
			'settings'    => array(
				'desktop' => 'woostify_setting[shop_product_per_page]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_product_per_row_min_step', 3 ),
					'max'  => apply_filters( 'woostify_shop_product_per_row_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => '',
				),
			),
		)
	)
);

// SHOP STRUCTURE SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_demo_section_hihi]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_demo_section_hihi]',
		array(
			'label'      => __( 'Shop Structure', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_title]',
				'woostify_setting[shop_page_breadcrumb]',
				'woostify_setting[shop_page_image_hover]',
			]
		)
	)
);

// Shop title.
$wp_customize->add_setting(
	'woostify_setting[shop_page_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_title'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_title]',
		array(
			'label'    => __( 'Shop Title', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_title]',
		)
	)
);

// Breadcrumbs.
$wp_customize->add_setting(
	'woostify_setting[shop_page_breadcrumb]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_breadcrumb'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_breadcrumb]',
		array(
			'label'    => __( 'Breadcrumb', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_breadcrumb]',
		)
	)
);

// Hover effect.
$wp_customize->add_setting(
	'woostify_setting[shop_page_image_hover]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_image_hover'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_image_hover]',
		array(
			'label'        => __( 'Product Hover Effect', 'woostify' ),
			'section'      => 'woostify_shop_page',
			'settings'     => 'woostify_setting[shop_page_image_hover]',
		)
	)
);

// PRODUCT META SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_demo_section]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_demo_section]',
		array(
			'label'      => __( 'Product Meta', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_product_title]',
				'woostify_setting[shop_page_product_category]',
				'woostify_setting[shop_page_product_rating]',
				'woostify_setting[shop_page_product_add_to_cart_button]',
				'woostify_setting[shop_page_product_price]',
			]
		)
	)
);

// Product title.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_title'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_title]',
		array(
			'label'    => __( 'Product Title', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_title]',
		)
	)
);

// Product category.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_category]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_category'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_category]',
		array(
			'label'    => __( 'Product Category', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_category]',
		)
	)
);

// Product rating.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_rating]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_rating'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_rating]',
		array(
			'label'    => __( 'Product Rating', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_rating]',
		)
	)
);

// Product add to cart button.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_add_to_cart_button]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_add_to_cart_button'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_add_to_cart_button]',
		array(
			'label'    => __( 'Product Add To Cart Button', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_add_to_cart_button]',
		)
	)
);

// Product price.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_price]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_price'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_price]',
		array(
			'label'    => __( 'Product Price', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_price]',
		)
	)
);
