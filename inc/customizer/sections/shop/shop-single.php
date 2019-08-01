<?php
/**
 * Woocommerce shop single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// SHOP SINGLE STRUCTURE SECTION.
$wp_customize->add_setting(
	'shop_single_general_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_single_general_section',
		array(
			'label'      => __( 'General', 'woostify' ),
			'section'    => 'woostify_shop_single',
			'dependency' => [
				'woostify_setting[shop_single_breadcrumb]',
				'woostify_setting[shop_single_content_background]',
			]
		)
	)
);

// Breadcrumbs.
$wp_customize->add_setting(
	'woostify_setting[shop_single_breadcrumb]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_single_breadcrumb'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_single_breadcrumb]',
		array(
			'label'    => __( 'Breadcrumb', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_breadcrumb]',
		)
	)
);

// Product content background.
$wp_customize->add_setting(
	'woostify_setting[shop_single_content_background]',
	array(
		'default'           => $defaults['shop_single_content_background'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'woostify_setting[shop_single_content_background]',
		array(
			'label'    => __( 'Content Background', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_content_background]',
		)
	)
);

// SHOP SINGLE PRODUCT IMAGE SECTION.
$wp_customize->add_setting(
	'shop_single_product_images_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_single_product_images_section',
		array(
			'label'      => __( 'Product Images', 'woostify' ),
			'section'    => 'woostify_shop_single',
			'dependency' => [
				'woostify_setting[shop_single_gallery_layout]',
				'woostify_setting[shop_single_image_zoom]',
				'woostify_setting[shop_single_image_lightbox]',
			]
		)
	)
);

// Gallery layout.
$wp_customize->add_setting(
	'woostify_setting[shop_single_gallery_layout]',
	array(
		'default'           => $defaults['shop_single_gallery_layout'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Woostify_Radio_Image_Control(
		$wp_customize,
		'woostify_setting[shop_single_gallery_layout]',
		array(
			'label'    => __( 'Gallery Layout', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_gallery_layout]',
			'choices'  => apply_filters(
				'woostify_setting_sidebar_default_choices',
				array(
					'vertical'   => WOOSTIFY_THEME_URI . 'assets/images/customizer/product-images/vertical.jpg',
					'horizontal' => WOOSTIFY_THEME_URI . 'assets/images/customizer/product-images/horizontal.jpg',
				)
			),
		)
	)
);

// Image zoom.
$wp_customize->add_setting(
	'woostify_setting[shop_single_image_zoom]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_single_image_zoom'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_single_image_zoom]',
		array(
			'label'        => __( 'Gallery Zoom Effect', 'woostify' ),
			'section'      => 'woostify_shop_single',
			'settings'     => 'woostify_setting[shop_single_image_zoom]',
		)
	)
);

// Image lightbox.
$wp_customize->add_setting(
	'woostify_setting[shop_single_image_lightbox]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_single_image_lightbox'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_single_image_lightbox]',
		array(
			'label'        => __( 'Gallery Lightbox Effect', 'woostify' ),
			'section'      => 'woostify_shop_single',
			'settings'     => 'woostify_setting[shop_single_image_lightbox]',
		)
	)
);

// SHOP SINGLE PRODUCT META SECTION.
$wp_customize->add_setting(
	'shop_single_product_meta_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_single_product_meta_section',
		array(
			'label'      => __( 'Product Meta', 'woostify' ),
			'section'    => 'woostify_shop_single',
			'dependency' => [
				'woostify_setting[shop_single_skus]',
				'woostify_setting[shop_single_categories]',
				'woostify_setting[shop_single_tags]',
			]
		)
	)
);

// Sku.
$wp_customize->add_setting(
	'woostify_setting[shop_single_skus]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'default'           => $defaults['shop_single_skus'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_single_skus]',
		array(
			'label'    => __( 'SKU', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_skus]',
		)
	)
);

// Categories.
$wp_customize->add_setting(
	'woostify_setting[shop_single_categories]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'default'           => $defaults['shop_single_categories'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_single_categories]',
		array(
			'label'    => __( 'Categories', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_categories]',
		)
	)
);

// Tags.
$wp_customize->add_setting(
	'woostify_setting[shop_single_tags]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'default'           => $defaults['shop_single_tags'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_single_tags]',
		array(
			'label'    => __( 'Tags', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_tags]',
		)
	)
);
