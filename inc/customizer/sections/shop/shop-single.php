<?php
/**
 * Woocommerce shop single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

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
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_single_gallery_layout]',
		array(
			'label'    => __( 'Gallery Layout', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_gallery_layout]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'woostify_setting_sidebar_default_choices',
				array(
					'vertical'   => __( 'Vertical', 'woostify' ),
					'horizontal' => __( 'Horizontal', 'woostify' ),
				)
			),
		)
	)
);

// End section one divider.
$wp_customize->add_setting(
	'shop_single_section_one_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'shop_single_section_one_divider',
		array(
			'section'  => 'woostify_shop_single',
			'settings' => 'shop_single_section_one_divider',
			'type'     => 'divider',
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

// Structure title.
$wp_customize->add_setting(
	'shop_single_structute_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'shop_single_structute_meta_title',
		array(
			'section'  => 'woostify_shop_single',
			'settings' => 'shop_single_structute_meta_title',
			'type'     => 'heading',
			'label'    => __( 'Product Single Structure', 'woostify' ),
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
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_single_breadcrumb]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Breadcrumb', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_breadcrumb]',
		)
	)
);

// Single product meta title.
$wp_customize->add_setting(
	'shop_single_product_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'shop_single_product_meta_title',
		array(
			'section'  => 'woostify_shop_single',
			'settings' => 'shop_single_product_meta_title',
			'type'     => 'heading',
			'label'    => __( 'Product Meta', 'woostify' ),
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
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_single_skus]',
		array(
			'type'     => 'checkbox',
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
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_single_categories]',
		array(
			'type'     => 'checkbox',
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
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_single_tags]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Tags', 'woostify' ),
			'section'  => 'woostify_shop_single',
			'settings' => 'woostify_setting[shop_single_tags]',
		)
	)
);

// End section two divider.
$wp_customize->add_setting(
	'shop_single_section_two_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'shop_single_section_two_divider',
		array(
			'section'  => 'woostify_shop_single',
			'settings' => 'shop_single_section_two_divider',
			'type'     => 'divider',
		)
	)
);
