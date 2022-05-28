<?php
/**
 * Woocommerce shop single customizer
 *
 * @package woostify
 */

if ( ! woostify_is_woocommerce_activated() ) {
	return;
}

// Default values.
$defaults = woostify_options();


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
			'label'      => __( 'General', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => array(
				'woostify_setting[shop_context_tabs]',
				'woostify_setting[shop_page_header_display]',
				'woostify_setting[shop_page_title]',
				'woostify_setting[shop_page_header_breadcrumb]',
				'woostify_setting[shop_page_result_count]',
				'woostify_setting[shop_page_product_filter]',
				'woostify_setting[shop_page_product_title_color]',
				'woostify_setting[shop_page_product_price_color]',
				'woostify_setting[shop_page_product_price_font_size]',
				'woostify_setting[shop_page_product_title_font_size]',
				'woostify_setting[shop_page_header_title_color]',
				'woostify_setting[shop_page_header_background_color]',
				'woostify_setting[shop_page_header_title_font_size]',
				'woostify_setting[shop_page_header_breadcrumb_font_size]',
				'woostify_setting[shop_page_header_background_image]',
				'woostify_setting[shop_page_header_background_image_size]',
				'woostify_setting[shop_page_header_background_image_repeat]',
				'woostify_setting[shop_page_header_background_image_position]',
				'woostify_setting[shop_page_header_background_image_attachment]',
				'woostify_setting[shop_page_header_padding_top]',
				'woostify_setting[shop_page_header_padding_bottom]',
				'woostify_setting[shop_page_header_margin_bottom]',
				'woostify_setting[shop_page_header_text_align]',
			),
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_context_tabs]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[shop_context_tabs]',
		array(
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_context_tabs]',
			'choices'  => array(
				'general' => __( 'Settings', 'woostify' ),
				'design'  => __( 'Design', 'woostify' ),
			),
		)
	)
);

// Page header display.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_display]',
	array(
		'default'           => $defaults['shop_page_header_display'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_display]',
		array(
			'label'    => __( 'Page Header Display', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_header_display]',
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
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
			'tab'      => 'general',
		)
	)
);

// Breadcrumbs.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_breadcrumb]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_header_breadcrumb'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_breadcrumb]',
		array(
			'label'    => __( 'Breadcrumb', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_header_breadcrumb]',
			'tab'      => 'general',
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
			'tab'      => 'general',
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
			'tab'      => 'general',
		)
	)
);

// Text align.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_text_align]',
	array(
		'default'           => $defaults['shop_page_header_text_align'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_text_align]',
		array(
			'label'    => __( 'Text Align', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_header_text_align]',
			'section'  => 'woostify_shop_page',
			'type'     => 'select',
			'choices'  => array(
				'left'    => __( 'Left', 'woostify' ),
				'center'  => __( 'Center', 'woostify' ),
				'right'   => __( 'Right', 'woostify' ),
				'justify' => __( 'Page Title / Breadcrumb', 'woostify' ),
			),
			'tab'      => 'general',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_page_product_style_heading]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_style_heading]',
		array(
			'label'    => __( 'Product Style', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_style_heading]',
			'tab'      => 'design',
		)
	)
);


$wp_customize->add_setting(
	'woostify_setting[shop_page_product_title_color]',
	array(
		'default'           => $defaults['shop_page_product_title_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_title_color]',
		array(
			'label'           => __( 'Product Title Color', 'woostify' ),
			'section'         => 'woostify_shop_page',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[shop_page_product_title_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_title_font_size]',
	array(
		'default'           => $defaults['shop_page_product_title_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_page_product_title_tablet_font_size]',
	array(
		'default'           => $defaults['shop_page_product_title_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_title_mobile_font_size]',
	array(
		'default'           => $defaults['shop_page_product_title_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_title_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Title Font Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_title_font_size]',
				'tablet'  => 'woostify_setting[shop_page_product_title_tablet_font_size]',
				'mobile'  => 'woostify_setting[shop_page_product_title_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_product_title_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_shop_page_product_title_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_shop_page_product_title_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_shop_page_product_title_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_shop_page_product_title_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_shop_page_product_title_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_page_product_price_color]',
	array(
		'default'           => $defaults['shop_page_product_price_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_price_color]',
		array(
			'label'           => __( 'Price Color', 'woostify' ),
			'section'         => 'woostify_shop_page',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[shop_page_product_price_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_price_font_size]',
	array(
		'default'           => $defaults['shop_page_product_price_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_page_product_price_tablet_font_size]',
	array(
		'default'           => $defaults['shop_page_product_price_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_price_mobile_font_size]',
	array(
		'default'           => $defaults['shop_page_product_price_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_price_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Price Font Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_price_font_size]',
				'tablet'  => 'woostify_setting[shop_page_product_price_tablet_font_size]',
				'mobile'  => 'woostify_setting[shop_page_product_price_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_product_price_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_shop_page_product_price_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_shop_page_product_price_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_shop_page_product_price_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_shop_page_product_price_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_shop_page_product_price_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_heading]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_heading]',
		array(
			'label'    => __( 'Page Header', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_header_heading]',
			'tab'      => 'design',
		)
	)
);


// Title color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_title_color]',
	array(
		'default'           => $defaults['shop_page_header_title_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_title_color]',
		array(
			'label'    => __( 'Title Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'woostify_setting[shop_page_header_title_color]',
			),
			'tab'      => 'design',
		)
	)
);


// font size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_title_font_size]',
	array(
		'default'           => $defaults['shop_page_header_title_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_page_header_title_tablet_font_size]',
	array(
		'default'           => $defaults['shop_page_header_title_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_title_mobile_font_size]',
	array(
		'default'           => $defaults['shop_page_header_title_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_title_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Title Font Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[page_header_title_font_size]',
				'tablet'  => 'woostify_setting[page_header_title_tablet_font_size]',
				'mobile'  => 'woostify_setting[page_header_title_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_page_header_title_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_page_header_title_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_page_header_title_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_title_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_page_header_title_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_title_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);


// Breadcrumb text color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_breadcrumb_text_color]',
	array(
		'default'           => $defaults['page_header_breadcrumb_text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_breadcrumb_text_color]',
		array(
			'label'    => __( 'Breadcrumb Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'woostify_setting[shop_page_header_breadcrumb_text_color]',
			),
			'tab'      => 'design',
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_breadcrumb_font_size]',
	array(
		'default'           => $defaults['shop_page_header_breadcrumb_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[shop_page_header_breadcrumb_tablet_font_size]',
	array(
		'default'           => $defaults['shop_page_header_breadcrumb_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_breadcrumb_mobile_font_size]',
	array(
		'default'           => $defaults['shop_page_header_breadcrumb_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_breadcrumb_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Breadcrumb Font Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[page_header_breadcrumb_font_size]',
				'tablet'  => 'woostify_setting[page_header_breadcrumb_tablet_font_size]',
				'mobile'  => 'woostify_setting[page_header_breadcrumb_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_page_header_breadcrumb_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_page_header_breadcrumb_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_page_header_breadcrumb_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_breadcrumb_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_page_header_breadcrumb_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_breadcrumb_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);



// Background color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_background_color]',
	array(
		'default'           => $defaults['shop_page_header_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_background_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'woostify_setting[shop_page_header_background_color]',
			),
			'tab'      => 'design',
		)
	)
);

// Background image.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_background_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_header_background_image'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Image_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_background_image]',
		array(
			'label'    => __( 'Background Image', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_header_background_image]',
			'tab'      => 'design',
		)
	)
);

// Background image size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_background_image_size]',
	array(
		'default'           => $defaults['shop_page_header_background_image_size'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_background_image_size]',
		array(
			'label'    => __( 'Background Size', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_header_background_image_size]',
			'section'  => 'woostify_shop_page',
			'type'     => 'select',
			'choices'  => array(
				'auto'    => __( 'Default', 'woostify' ),
				'cover'   => __( 'Cover', 'woostify' ),
				'contain' => __( 'Contain', 'woostify' ),
			),
			'tab'      => 'design',
		)
	)
);

// Background image repeat.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_background_image_repeat]',
	array(
		'default'           => $defaults['shop_page_header_background_image_repeat'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_background_image_repeat]',
		array(
			'label'    => __( 'Background Repeat', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_header_background_image_repeat]',
			'section'  => 'woostify_shop_page',
			'type'     => 'select',
			'choices'  => array(
				'repeat'    => __( 'Default', 'woostify' ),
				'no-repeat' => __( 'No Repeat', 'woostify' ),
				'repeat-x'  => __( 'Repeat X', 'woostify' ),
				'repeat-y'  => __( 'Repeat Y', 'woostify' ),
				'space'     => __( 'Space', 'woostify' ),
				'round'     => __( 'Round', 'woostify' ),
			),
			'tab'      => 'design',
		)
	)
);

// Background image position.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_background_image_position]',
	array(
		'default'           => $defaults['shop_page_header_background_image_position'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_background_image_position]',
		array(
			'label'    => __( 'Background Position', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_header_background_image_position]',
			'section'  => 'woostify_shop_page',
			'type'     => 'select',
			'choices'  => array(
				'left-top'      => __( 'Left Top', 'woostify' ),
				'left-center'   => __( 'Left Center', 'woostify' ),
				'left-bottom'   => __( 'Left Bottom', 'woostify' ),
				'center-top'    => __( 'Center Top', 'woostify' ),
				'center-center' => __( 'Center Center', 'woostify' ),
				'center-bottom' => __( 'Center Bottom', 'woostify' ),
				'right-top'     => __( 'Right Top', 'woostify' ),
				'right-center'  => __( 'Right Center', 'woostify' ),
				'right-bottom'  => __( 'Right Bottom', 'woostify' ),
			),
			'tab'      => 'design',
		)
	)
);

// Background image attachment.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_background_image_attachment]',
	array(
		'default'           => $defaults['shop_page_header_background_image_attachment'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_background_image_attachment]',
		array(
			'label'    => __( 'Background Attachment', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_header_background_image_attachment]',
			'section'  => 'woostify_shop_page',
			'type'     => 'select',
			'choices'  => array(
				'scroll' => __( 'Default', 'woostify' ),
				'fixed'  => __( 'Fixed', 'woostify' ),
				'local'  => __( 'Local', 'woostify' ),
			),
			'tab'      => 'design',
		)
	)
);

// Padding divider.
$wp_customize->add_setting(
	'shop_page_header_spacing_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'shop_page_header_spacing_divider',
		array(
			'section'  => 'woostify_shop_page',
			'settings' => 'shop_page_header_spacing_divider',
			'type'     => 'divider',
			'tab'      => 'design',
		)
	)
);

// Padding top.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_padding_top]',
	array(
		'default'           => $defaults['shop_page_header_padding_top'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_padding_top]',
		array(
			'label'    => __( 'Padding Top', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_header_padding_top]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_header_padding_top_min_step', 0 ),
					'max'  => apply_filters( 'woostify_shop_page_header_padding_top_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);

// Padding bottom.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_padding_bottom]',
	array(
		'default'           => $defaults['shop_page_header_padding_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_padding_bottom]',
		array(
			'label'    => __( 'Padding Bottom', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_header_padding_bottom]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_header_padding_bottom_min_step', 0 ),
					'max'  => apply_filters( 'woostify_shop_page_header_padding_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);

// Margin bottom.
$wp_customize->add_setting(
	'woostify_setting[shop_page_header_margin_bottom]',
	array(
		'default'           => $defaults['shop_page_header_margin_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_header_margin_bottom]',
		array(
			'label'    => __( 'Margin Bottom', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_header_margin_bottom]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_header_margin_bottom_min_step', 0 ),
					'max'  => apply_filters( 'woostify_shop_page_header_margin_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);




// SHOP INFINITE SCROLL.
$wp_customize->add_setting(
	'shop_page_infinite_scroll_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_infinite_scroll_section',
		array(
			'label'      => __( 'Infinite Scroll', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => array(
				'woostify_setting[shop_page_infinite_scroll_enable]',
				'woostify_setting[shop_page_infinite_scroll_type]',
			),
		)
	)
);

// Infinite scroll enable.
$wp_customize->add_setting(
	'woostify_setting[shop_page_infinite_scroll_enable]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_infinite_scroll_enable'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_infinite_scroll_enable]',
		array(
			'label'       => __( 'Enable', 'woostify' ),
			'description' => __( 'Enable infinite scroll for WooCommerce category/product archive.', 'woostify' ),
			'section'     => 'woostify_shop_page',
			'settings'    => 'woostify_setting[shop_page_infinite_scroll_enable]',
			'tab'         => 'general',
		)
	)
);

// Infinite scroll loading type.
$wp_customize->add_setting(
	'woostify_setting[shop_page_infinite_scroll_type]',
	array(
		'default'           => $defaults['shop_page_infinite_scroll_type'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_infinite_scroll_type]',
		array(
			'label'    => __( 'Loading Type', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_infinite_scroll_type]',
			'type'     => 'select',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_infinite_scroll_type_choices',
				array(
					'button' => __( 'Button (On click)', 'woostify' ),
					'auto'   => __( 'Auto (On scroll)', 'woostify' ),
				)
			),
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
			'dependency' => array(
				'woostify_setting[shop_page_product_card_border_style]',
				'woostify_setting[shop_page_product_card_border_width]',
				'woostify_setting[shop_page_product_card_border_color]',
			),
		)
	)
);

// Border style.
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
			'tab'      => 'general',
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

// Border width.
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
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_card_border_width]',
			),
			'choices'  => array(
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
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_card_border_color]',
		array(
			'label'    => __( 'Border Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array( 'woostify_setting[shop_page_product_card_border_color]' ),
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
			'dependency' => array(
				'woostify_setting[shop_page_product_alignment]',
				'shop_page_product_alignment_divider',
				'woostify_setting[shop_page_product_title]',
				'woostify_setting[shop_page_product_category]',
				'woostify_setting[shop_page_product_rating]',
				'woostify_setting[shop_page_product_price]',
				'woostify_setting[shop_page_product_quantity]',
				'woostify_setting[shop_page_product_content_equal]',
				'woostify_setting[shop_page_product_content_min_height]',
			),
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
			'tab'      => 'general',
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
			'tab'      => 'general',
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
			'tab'      => 'general',
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
			'tab'      => 'general',
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
			'tab'      => 'general',
		)
	)
);

// Product quantity.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_quantity]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_quantity'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_quantity]',
		array(
			'label'    => __( 'Product Quantity', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_quantity]',
			'tab'      => 'general',
		)
	)
);

// Equal product content.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_content_equal]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_content_equal'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_content_equal]',
		array(
			'label'    => __( 'Equal Product Content', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_product_content_equal]',
			'tab'      => 'general',
		)
	)
);

// Product content min height.
$wp_customize->add_setting(
	'woostify_setting[shop_page_product_content_min_height]',
	array(
		'default'           => $defaults['shop_page_product_content_min_height'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_content_min_height]',
		array(
			'label'    => __( 'Product Content Min Height', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_content_min_height]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_product_content_min_height_min_step', 10 ),
					'max'  => apply_filters( 'woostify_product_content_min_height_max_step', 500 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
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
			'dependency' => array(
				'woostify_setting[shop_page_product_image_border_style]',
				'woostify_setting[shop_page_product_image_border_width]',
				'woostify_setting[shop_page_product_image_border_color]',
				'woostify_setting[shop_page_product_image_hover]',
				'woostify_setting[shop_page_product_image_equal_height]',
				'woostify_setting[shop_page_product_image_height]',
			),
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
			'tab'      => 'general',
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

// Border style.
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
			'tab'      => 'general',
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

// Border width.
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
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_image_border_width]',
			),
			'choices'  => array(
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
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_product_image_border_color]',
		array(
			'label'    => __( 'Border Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array( 'woostify_setting[shop_page_product_image_border_color]' ),
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
			'tab'      => 'general',
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
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_product_image_height]',
			),
			'choices'  => array(
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
			'dependency' => array(
				'woostify_setting[shop_page_sale_tag_position]',
				'woostify_setting[shop_page_sale_percent]',
				'woostify_setting[shop_page_sale_text]',
				'woostify_setting[shop_page_sale_border_radius]',
				'woostify_setting[shop_page_sale_square]',
				'woostify_setting[shop_page_sale_size]',
				'woostify_setting[shop_page_sale_color]',
				'woostify_setting[shop_page_sale_bg_color]',
			),
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
		'transport'         => 'postMessage',
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
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_sale_tag_position_choices',
				array(
					'left'  => __( 'Left', 'woostify' ),
					'right' => __( 'Right', 'woostify' ),
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
		'transport'         => 'postMessage',
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
			'tab'      => 'general',
		)
	)
);

// Text color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_color]',
	array(
		'default'           => $defaults['shop_page_sale_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_color]',
		array(
			'label'    => __( 'Text Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'woostify_setting[shop_page_sale_color]',
			),
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_sale_bg_color]',
	array(
		'default'           => $defaults['shop_page_sale_bg_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_bg_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'woostify_setting[shop_page_sale_bg_color]',
			),
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
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_border_radius]',
		array(
			'label'    => __( 'Border Radius', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_sale_border_radius]',
			),
			'choices'  => array(
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
			'tab'      => 'general',
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
		'transport'         => 'postMessage',
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
			'tab'      => 'general',
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
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_sale_size]',
		array(
			'label'    => __( 'Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_sale_size]',
			),
			'choices'  => array(
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

// OUT OF STOCK TAG SECTION.
$wp_customize->add_setting(
	'shop_page_out_of_stock_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_out_of_stock_section',
		array(
			'label'      => __( 'Out Of Stock Label', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => array(
				'woostify_setting[shop_page_out_of_stock_position]',
				'woostify_setting[shop_page_out_of_stock_text]',
				'woostify_setting[shop_page_out_of_stock_color]',
				'woostify_setting[shop_page_out_of_stock_bg_color]',
				'woostify_setting[shop_page_out_of_stock_border_radius]',
				'woostify_setting[shop_page_out_of_stock_square]',
				'woostify_setting[shop_page_out_of_stock_size]',
			),
		)
	)
);

// Display.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_position]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_position'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_position]',
		array(
			'label'    => __( 'Display', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_out_of_stock_position]',
			'type'     => 'select',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_out_of_stock_position_choices',
				array(
					'left'  => __( 'Left', 'woostify' ),
					'right' => __( 'Right', 'woostify' ),
					'none'  => __( 'None', 'woostify' ),
				)
			),
		)
	)
);

// Text.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_text]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_text]',
		array(
			'label'    => __( 'Text', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_out_of_stock_text]',
			'type'     => 'text',
			'tab'      => 'general',
		)
	)
);

// Text color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_color]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_color]',
		array(
			'label'    => __( 'Text Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'woostify_setting[shop_page_out_of_stock_color]',
			),
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_bg_color]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_bg_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_bg_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'woostify_setting[shop_page_out_of_stock_bg_color]',
			),
		)
	)
);

// Border radius.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_border_radius]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_border_radius'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_border_radius]',
		array(
			'label'    => __( 'Border Radius', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_out_of_stock_border_radius]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_out_of_stock_border_radius_min_step', 0 ),
					'max'  => apply_filters( 'woostify_out_of_stock_border_radius_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Square.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_square]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_square'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_square]',
		array(
			'label'    => __( 'Square', 'woostify' ),
			'settings' => 'woostify_setting[shop_page_out_of_stock_square]',
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
		)
	)
);

// Size.
$wp_customize->add_setting(
	'woostify_setting[shop_page_out_of_stock_size]',
	array(
		'default'           => $defaults['shop_page_out_of_stock_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_out_of_stock_size]',
		array(
			'label'    => __( 'Size', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_out_of_stock_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_out_of_stock_size_min_step', 20 ),
					'max'  => apply_filters( 'woostify_out_of_stock_size_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// WISHLIST SECTION.
$wp_customize->add_setting(
	'shop_page_wishlist_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_wishlist_section',
		array(
			'label'      => __( 'Wishlist Button', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'tab'      => 'general',
			'dependency' => array(
				'woostify_setting[shop_page_wishlist_support_plugin]',
				'woostify_setting[shop_page_wishlist_position]',
			),
		)
	)
);

// Support plugin.
$wp_customize->add_setting(
	'woostify_setting[shop_page_wishlist_support_plugin]',
	array(
		'default'           => $defaults['shop_page_wishlist_support_plugin'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[shop_page_wishlist_support_plugin]',
		array(
			'label'    => __( 'Support For Plugin', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_wishlist_support_plugin]',
			'type'     => 'select',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_wishlist_support_plugin_choices',
				array(
					'yith' => __( 'YITH WooCommerce Wishlist', 'woostify' ),
					'ti'   => __( 'TI WooCommerce Wishlist', 'woostify' ),
				)
			),
		)
	)
);

// Position.
$wp_customize->add_setting(
	'woostify_setting[shop_page_wishlist_position]',
	array(
		'default'           => $defaults['shop_page_wishlist_position'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Radio_Image_Control(
		$wp_customize,
		'woostify_setting[shop_page_wishlist_position]',
		array(
			'label'    => __( 'Position', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_wishlist_position]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_wishlist_position_choices',
				array(
					'none'         => WOOSTIFY_THEME_URI . 'assets/images/customizer/wishlist/wishlist-1.jpg',
					'top-right'    => WOOSTIFY_THEME_URI . 'assets/images/customizer/wishlist/wishlist-2.jpg',
					'bottom-right' => WOOSTIFY_THEME_URI . 'assets/images/customizer/wishlist/wishlist-3.jpg',
				)
			),
		)
	)
);

// ADD TO CART SECTION.
$wp_customize->add_setting(
	'shop_page_add_to_cart_section',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Section_Control(
		$wp_customize,
		'shop_page_add_to_cart_section',
		array(
			'label'      => __( 'Add To Cart Button', 'woostify' ),
			'section'    => 'woostify_shop_page',
			'dependency' => array(
				'woostify_setting[shop_product_add_to_cart_icon]',
				'woostify_setting[shop_page_add_to_cart_button_position]',
				'woostify_setting[shop_page_button_cart_background]',
				'woostify_setting[shop_page_button_cart_color]',
				'woostify_setting[shop_page_button_background_hover]',
				'woostify_setting[shop_page_button_color_hover]',
				'woostify_setting[shop_page_button_border_radius]',
			),
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
	new Woostify_Radio_Image_Control(
		$wp_customize,
		'woostify_setting[shop_page_add_to_cart_button_position]',
		array(
			'label'    => __( 'Position', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_page_add_to_cart_button_position]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_shop_page_add_to_cart_button_position_choices',
				array(
					'none'           => WOOSTIFY_THEME_URI . 'assets/images/customizer/add-to-cart/add-cart-1.jpg',
					'bottom'         => WOOSTIFY_THEME_URI . 'assets/images/customizer/add-to-cart/add-cart-2.jpg',
					'bottom-visible' => WOOSTIFY_THEME_URI . 'assets/images/customizer/add-to-cart/add-cart-3.jpg',
					'image'          => WOOSTIFY_THEME_URI . 'assets/images/customizer/add-to-cart/add-cart-4.jpg',
					'icon'           => WOOSTIFY_THEME_URI . 'assets/images/customizer/add-to-cart/add-cart-5.jpg',
				)
			),
		)
	)
);

// Cart icon.
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
			'label'    => __( 'Cart Icon', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => 'woostify_setting[shop_product_add_to_cart_icon]',
			'tab'      => 'general',
		)
	)
);

// Button Background.
$wp_customize->add_setting(
	'woostify_setting[shop_page_button_cart_background]',
	array(
		'default'           => $defaults['shop_page_button_cart_background'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'transport'         => 'postMessage',
	)
);
// Button Hover Background.
$wp_customize->add_setting(
	'woostify_setting[shop_page_button_background_hover]',
	array(
		'default'           => $defaults['shop_page_button_background_hover'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_button_cart_background]',
		array(
			'label'    => __( 'Background', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'settings' => array(
				'woostify_setting[shop_page_button_cart_background]',
				'woostify_setting[shop_page_button_background_hover]',
			),
			'tab'      => 'general',
			'tooltips' => array(
				'Normal',
				'Hover',
			),
		)
	)
);

// Button Color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_button_cart_color]',
	array(
		'default'           => $defaults['shop_page_button_cart_color'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'transport'         => 'postMessage',
	)
);
// Button Hover Color.
$wp_customize->add_setting(
	'woostify_setting[shop_page_button_color_hover]',
	array(
		'default'           => $defaults['shop_page_button_color_hover'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[shop_page_button_cart_color]',
		array(
			'label'    => __( 'Color', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'woostify_setting[shop_page_button_cart_color]',
				'woostify_setting[shop_page_button_color_hover]',
			),
			'tooltips' => array(
				'Normal',
				'Hover',
			),
		)
	)
);

// Border radius.
$wp_customize->add_setting(
	'woostify_setting[shop_page_button_border_radius]',
	array(
		'default'           => $defaults['shop_page_button_border_radius'],
		'type'              => 'option',
		'sanitize_callback' => 'esc_html',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[shop_page_button_border_radius]',
		array(
			'label'    => __( 'Border Radius', 'woostify' ),
			'section'  => 'woostify_shop_page',
			'tab'      => 'general',
			'settings' => array(
				'desktop' => 'woostify_setting[shop_page_button_border_radius]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_shop_page_button_border_radius_min_step', 0 ),
					'max'  => apply_filters( 'woostify_shop_page_button_border_radius_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);




