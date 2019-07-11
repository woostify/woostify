<?php
/**
 * Woocommerce shop single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

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

// PRODUCT CARD SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_card_section]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_card_section]',
		array(
			'label'   => __( 'Product Card', 'woostify' ),
			'section' => 'woostify_shop_page',
		)
	)
);

// PRODUCT IMAGE SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_section]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_section]',
		array(
			'label'   => __( 'Product Image', 'woostify' ),
			'section' => 'woostify_shop_page',
		)
	)
);

// PRODUCT CONTENT SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_content_section]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_content_section]',
		array(
			'label'   => __( 'Product Content', 'woostify' ),
			'section' => 'woostify_shop_page',
		)
	)
);

// SALE TAG SECTION.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_tag_section]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_tag_section]',
		array(
			'label'   => __( 'Sale Tag', 'woostify' ),
			'section' => 'woostify_shop_page',
		)
	)
);
