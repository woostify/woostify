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
	'shop_page_structure_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_structure_section',
		array(
			'label'      => __( 'Shop Structure', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_title]',
				'woostify_setting[shop_page_breadcrumb]',
				'woostify_setting[shop_page_result_count]',
				'woostify_setting[shop_page_product_filter]',
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

// Result count.
$wp_customize->add_setting(
	'woostify_setting[shop_page_result_count]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_result_count'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_result_count]',
		array(
			'label'    => __( 'Result Count', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_result_count]',
		)
	)
);

// Product filter.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_filter]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_filter'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_filter]',
		array(
			'label'    => __( 'Product Filtering', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_filter]',
		)
	)
);

// PRODUCT CARD SECTION.
$wp_customize->add_setting(
	'shop_page_product_card_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_product_card_section',
		array(
			'label'      => __( 'Product Card', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_product_card_border_style]',
				'woostify_setting[shop_page_product_card_border_width]',
				'woostify_setting[shop_page_product_card_border_color]',
			],
		)
	)
);

// Border style
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_card_border_style]',
	array(
		'default'           => $defaults['shop_page_product_card_border_style'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_card_border_style]',
		array(
			'label'    => __( 'Border Style', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_card_border_style]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_product_card_border_style_choices',
				array(
					'none'   => __( 'None', 'woostify' ),
					'solid'  => __( 'Solid', 'woostify' ),
					'dashed' => __( 'Dashed', 'woostify' ),
					'dotted' => __( 'Dotted', 'woostify' ),
					'double' => __( 'Double', 'woostify' ),
				)
			),
		)
	)
);

// Border width
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_card_border_width]',
	array(
		'default'           => $defaults['shop_page_product_card_border_width'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_card_border_width]',
		array(
			'label'    => __( 'Border Width', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_card_border_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_product_card_border_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_product_card_border_width_max_step', 10 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Border color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_card_border_color]',
	array(
		'default'           => $defaults['shop_page_product_card_border_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_card_border_color]',
		array(
			'label'    => __( 'Border Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_card_border_color]',
		)
	)
);

// PRODUCT CONTENT SECTION.
$wp_customize->add_setting(
	'shop_page_product_meta_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_product_meta_section',
		array(
			'label'      => __( 'Product Content', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_product_alignment]',
				'shop_page_product_alignment_divider',
				'woostify_setting[shop_page_product_title]',
				'woostify_setting[shop_page_product_category]',
				'woostify_setting[shop_page_product_rating]',
				'woostify_setting[shop_page_product_price]',
			]
		)
	)
);

// Alignment.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_alignment]',
	array(
		'default'           => $defaults['shop_page_product_alignment'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_alignment]',
		array(
			'label'    => __( 'Alignment', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_alignment]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_product_alignment_choices',
				array(
					'left'   => __( 'Left', 'woostify' ),
					'center' => __( 'Center', 'woostify' ),
					'right'  => __( 'Right', 'woostify' ),
				)
			),
		)
	)
);

// Divider.
$wp_customize->add_setting(
	'shop_page_product_alignment_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'shop_page_product_alignment_divider',
		array(
			'section'  => 'woostify_shop_page',
			'settings' => 'shop_page_product_alignment_divider',
			'type'     => 'divider',
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

// PRODUCT IMAGE SECTION.
$wp_customize->add_setting(
	'shop_page_product_image_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_product_image_section',
		array(
			'label'      => __( 'Product Image', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_product_image_border_style]',
				'woostify_setting[shop_page_product_image_border_width]',
				'woostify_setting[shop_page_product_image_border_color]',
				'woostify_setting[shop_page_product_image_hover]',
				'woostify_setting[shop_page_product_image_equal_height]',
				'woostify_setting[shop_page_product_image_height]',
			],
		)
	)
);

// Image hover.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_hover]',
	array(
		'default'           => $defaults['shop_page_product_image_hover'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_hover]',
		array(
			'label'    => __( 'Hover Effect', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_image_hover]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_image_hover_choices',
				array(
					'none' => __( 'None', 'woostify' ),
					'zoom' => __( 'Zoom', 'woostify' ),
					'swap' => __( 'Swap', 'woostify' ),
				)
			),
		)
	)
);

// Border style
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_border_style]',
	array(
		'default'           => $defaults['shop_page_product_image_border_style'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_border_style]',
		array(
			'label'    => __( 'Border Style', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_image_border_style]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_product_image_border_style_choices',
				array(
					'none'   => __( 'None', 'woostify' ),
					'solid'  => __( 'Solid', 'woostify' ),
					'dashed' => __( 'Dashed', 'woostify' ),
					'dotted' => __( 'Dotted', 'woostify' ),
					'double' => __( 'Double', 'woostify' ),
				)
			),
		)
	)
);

// Border width
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_border_width]',
	array(
		'default'           => $defaults['shop_page_product_image_border_width'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_border_width]',
		array(
			'label'    => __( 'Border Width', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_image_border_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_product_image_border_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_product_image_border_width_max_step', 10 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Border color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_border_color]',
	array(
		'default'           => $defaults['shop_page_product_image_border_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_border_color]',
		array(
			'label'    => __( 'Border Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_image_border_color]',
		)
	)
);

// Equal image height.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_equal_height]',
	array(
		'default'           => $defaults['shop_page_product_image_equal_height'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_equal_height]',
		array(
			'label'    => __( 'Equal Image Height', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_product_image_equal_height]',
			'section'  => 'woostify_shop_page',
		)
	)
);

// Image height.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_image_height]',
	array(
		'default'           => $defaults['shop_page_product_image_height'],
		'type'              => 'option',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_height]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Image Height', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_image_height]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_product_image_height_min_step', 50 ),
					'max'  => apply_filters( 'woostify_shop_page_product_image_height_max_step', 600 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// ADD TO CART SECTION.
$wp_customize->add_setting(
	'shop_page_add_to_cart_Section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_add_to_cart_Section',
		array(
			'label'      => __( 'Add To Cart Button', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_add_to_cart]',
				'woostify_setting[shop_product_add_to_cart_icon]',
				'woostify_setting[shop_page_add_to_cart_button_position]',
			],
		)
	)
);

// Add to cart.
$wp_customize->add_setting(
	'woostify_setting[shop_page_add_to_cart]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_add_to_cart'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_add_to_cart]',
		array(
			'label'    => __( 'Add To Cart', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_add_to_cart]',
		)
	)
);

// Button icon.
$wp_customize->add_setting(
	'woostify_setting[shop_product_add_to_cart_icon]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_product_add_to_cart_icon'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_product_add_to_cart_icon]',
		array(
			'label'    => __( 'Button Icon', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_product_add_to_cart_icon]',
		)
	)
);

// Position.
$wp_customize->add_setting(
	'woostify_setting[shop_page_add_to_cart_button_position]',
	array(
		'default'           => $defaults['shop_page_add_to_cart_button_position'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_add_to_cart_button_position]',
		array(
			'label'    => __( 'Position', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_add_to_cart_button_position]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_sale_tag_position_choices',
				array(
					'bottom'         => __( 'Bottom', 'woostify' ),
					'bottom-visible' => __( 'Bottom & Visible', 'woostify' ),
					'image'          => __( 'Display On Image', 'woostify' ),
				)
			),
		)
	)
);

// SALE TAG SECTION.
$wp_customize->add_setting(
	'shop_page_sale_tag_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_sale_tag_section',
		array(
			'label'      => __( 'Sale Tag', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => [
				'woostify_setting[shop_page_sale_tag_position]',
				'woostify_setting[shop_page_sale_percent]',
				'woostify_setting[shop_page_sale_text]',
				'woostify_setting[shop_page_sale_border_radius]',
				'woostify_setting[shop_page_sale_square]',
				'woostify_setting[shop_page_sale_size]',
				'woostify_setting[shop_page_sale_color]',
			],
		)
	)
);

// Position.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_tag_position]',
	array(
		'default'           => $defaults['shop_page_sale_tag_position'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_tag_position]',
		array(
			'label'    => __( 'Position', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_sale_tag_position]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_sale_tag_position_choices',
				array(
					'left'    => __( 'Left', 'woostify' ),
					'right'   => __( 'Right', 'woostify' ),
				)
			),
		)
	)
);

// Sale text.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_text]',
	array(
		'default'           => $defaults['shop_page_sale_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_text]',
		array(
			'label'    => __( 'Text', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_sale_text]',
			'type'     => 'text',
		)
	)
);

// Text color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_color]',
	array(
		'default'           => $defaults['shop_page_sale_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_color]',
		array(
			'label'    => __( 'Text Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_sale_color]',
		)
	)
);

// Border radius.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_border_radius]',
	array(
		'default'           => $defaults['shop_page_sale_border_radius'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_border_radius]',
		array(
			'label'    => __( 'Border Radius', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_sale_border_radius]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_sale_border_radius_min_step', 0 ),
					'max'  => apply_filters( 'woostify_sale_border_radius_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Sale percentage.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_percent]',
	array(
		'default'           => $defaults['shop_page_sale_percent'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_percent]',
		array(
			'label'    => __( 'Sale Percentage', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_sale_percent]',
			'section'  => 'woostify_shop_page',
		)
	)
);

// Sale square.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_square]',
	array(
		'default'           => $defaults['shop_page_sale_square'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_square]',
		array(
			'label'    => __( 'Sale Square', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_sale_square]',
			'section'  => 'woostify_shop_page',
		)
	)
);

// Sale size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_size]',
	array(
		'default'           => $defaults['shop_page_sale_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_size]',
		array(
			'label'    => __( 'Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_sale_size]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_sale_size_min_step', 20 ),
					'max'  => apply_filters( 'woostify_sale_size_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);
