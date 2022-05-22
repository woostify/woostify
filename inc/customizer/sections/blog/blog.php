<?php
/**
 * Blog customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();


// Tabs.
$wp_customize->add_setting(
	'woostify_setting[blog_context_tabs]',

	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[blog_context_tabs]',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_context_tabs]',
			'choices'  => array(
				'general' => __( 'Settings', 'woostify' ),
				'design'   => __( 'Design', 'woostify' ),
			),
		)
	)
);

// Blog layout.
$wp_customize->add_setting(
	'woostify_setting[blog_list_layout]',
	array(
		'sanitize_callback' => 'woostify_sanitize_choices',
		'default'           => $defaults['blog_list_layout'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Radio_Image_Control(
		$wp_customize,
		'woostify_setting[blog_list_layout]',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_layout]',
			'label'    => __( 'Blog Layout', 'woostify' ),
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_list_layout_choices',
				array(
					'standard' => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/standard.jpg',
					'list'     => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/list.jpg',
					'grid'     => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/grid.jpg',
					'zigzag'   => WOOSTIFY_THEME_URI . 'assets/images/customizer/blog/zigzag.jpg',
				)
			),
		)
	)
);

// Page header display.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_display]',
	array(
		'default'           => $defaults['blog_page_header_display'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_display]',
		array(
			'label'    => __( 'Enable  Archive Title', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_display]',
			'section'  => 'woostify_blog',
			'tab'      => 'general',
		)
	)
);

// Page title.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_title]',
	array(
		'default'           => $defaults['blog_page_header_title'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_title]',
		array(
			'label'    => __( 'Title', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_title]',
			'section'  => 'woostify_blog',
			'tab'      => 'general',
		)
	)
);

// Breadcrumb.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_breadcrumb]',
	array(
		'default'           => $defaults['blog_page_header_breadcrumb'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_breadcrumb]',
		array(
			'label'    => __( 'Breadcrumb', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_breadcrumb]',
			'section'  => 'woostify_blog',
			'tab'      => 'general',
		)
	)
);

// Text align.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_text_align]',
	array(
		'default'           => $defaults['blog_page_header_text_align'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_text_align]',
		array(
			'label'    => __( 'Text Align', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_text_align]',
			'section'  => 'woostify_blog',
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


// Limit exerpt.
$wp_customize->add_setting(
	'woostify_setting[blog_list_limit_exerpt]',
	array(
		'sanitize_callback' => 'absint',
		'default'           => $defaults['blog_list_limit_exerpt'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_limit_exerpt]',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_limit_exerpt]',
			'type'     => 'number',
			'label'    => __( 'Limit Excerpt', 'woostify' ),
			'tab'      => 'general',
		)
	)
);

// End section one divider.
$wp_customize->add_setting(
	'blog_list_section_one_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_list_section_one_divider',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'blog_list_section_one_divider',
			'type'     => 'divider',
			'tab'      => 'general',
		)
	)
);

// Blog list structure.
$wp_customize->add_setting(
	'woostify_setting[blog_list_structure]',
	array(
		'default'           => $defaults['blog_list_structure'],
		'sanitize_callback' => 'woostify_sanitize_array',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Sortable_Control(
		$wp_customize,
		'woostify_setting[blog_list_structure]',
		array(
			'label'    => __( 'Blog List Structure', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_structure]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_list_structure_choices',
				array(
					'image'      => __( 'Featured Image', 'woostify' ),
					'title-meta' => __( 'Title', 'woostify' ),
					'post-meta'  => __( 'Post Meta', 'woostify' ),
				)
			),
		)
	)
);

// Blog list post meta.
$wp_customize->add_setting(
	'woostify_setting[blog_list_post_meta]',
	array(
		'default'           => $defaults['blog_list_post_meta'],
		'sanitize_callback' => 'woostify_sanitize_array',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Sortable_Control(
		$wp_customize,
		'woostify_setting[blog_list_post_meta]',
		array(
			'label'    => __( 'Blog Post Meta', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_post_meta]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_list_post_meta_choices',
				array(
					'date'     => __( 'Publish Date', 'woostify' ),
					'author'   => __( 'Author', 'woostify' ),
					'category' => __( 'Category', 'woostify' ),
					'comments' => __( 'Comments', 'woostify' ),
				)
			),
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_style]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'woostify_setting[blog_style]',
		array(
			'label'    => __( 'Style', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_style]',
			'tab'      => 'design',
		)
	)
);



// Title color.
$wp_customize->add_setting(
	'woostify_setting[blog_title_color]',
	array(
		'default'           => $defaults['blog_title_color'],

		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);



$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,

		'woostify_setting[blog_title_color]',
		array(
			'label'           => __( 'Title Color', 'woostify' ),
			'section'         => 'woostify_blog',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[blog_title_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_title_font_size]',
	array(
		'default'           => $defaults['blog_title_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(

	'woostify_setting[blog_title_tablet_font_size]',
	array(
		'default'           => $defaults['blog_title_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_title_mobile_font_size]',
	array(
		'default'           => $defaults['blog_title_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);


$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_title_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Title Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(

				'desktop' => 'woostify_setting[blog_title_font_size]',
				'tablet'  => 'woostify_setting[blog_title_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_title_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_title_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_title_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_title_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_title_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_title_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_title_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);


// Metadata  color.
$wp_customize->add_setting(
	'woostify_setting[blog_metadata_color]',
	array(
		'default'           => $defaults['blog_metadata_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_metadata_color]',
		array(
			'label'           => __( 'Meta Data Color', 'woostify' ),
			'section'         => 'woostify_blog',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[blog_metadata_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,
		)
	)
);

// font size.
$wp_customize->add_setting(

	'woostify_setting[blog_metadata_font_size]',
	array(
		'default'           => $defaults['blog_metadata_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);


$wp_customize->add_setting(
	'woostify_setting[blog_metadata_tablet_font_size]',
	array(
		'default'           => $defaults['blog_metadata_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_metadata_mobile_font_size]',
	array(
		'default'           => $defaults['blog_metadata_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_metadata_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Meta Data Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_metadata_font_size]',
				'tablet'  => 'woostify_setting[blog_metadata_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_metadata_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_metadata_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_metadata_font_size_max_step', 60 ),

					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(

					'min'  => apply_filters( 'woostify_blog_metadata_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_metadata_tablet_width_max_step', 50 ),

					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_page_header_breadcrumb_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_breadcrumb_mobile_width_max_step', 50 ),
					'min'  => apply_filters( 'woostify_blog_metadata_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_metadata_mobile_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);


// Description  color.
$wp_customize->add_setting(
	'woostify_setting[blog_description_color]',
	array(
		'default'           => $defaults['blog_description_color'],

		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,

		'woostify_setting[blog_description_color]',
		array(
			'label'           => __( 'Description Color', 'woostify' ),
			'section'         => 'woostify_blog',
			'tab'             => 'design',
			'settings'        => array(
				'woostify_setting[blog_description_color]',
			),
			'enable_swatches' => false,
			'is_global_color' => true,

		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_description_font_size]',
	array(
		'default'           => $defaults['blog_description_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_description_tablet_font_size]',
	array(
		'default'           => $defaults['blog_description_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_description_mobile_font_size]',
	array(
		'default'           => $defaults['blog_description_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_description_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Description Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_description_font_size]',
				'tablet'  => 'woostify_setting[blog_description_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_description_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_description_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_description_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_description_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_description_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_description_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_description_mobile_width_max_step', 50 ),

					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),

			'tab'      => 'design',
		)
	)
);

$wp_customize->add_setting(
	'blog_style_page_header_breadcrumb_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_style_page_header_breadcrumb_divider',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'blog_style_page_header_breadcrumb_divider',
			'type'     => 'divider',
			'tab'      => 'general',
		)
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_page_header_heading]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Heading_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_heading]',
		array(
			'label'    => __( 'Page Header', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_page_header_heading]',
			'tab'      => 'design',
		)
	)
);


$wp_customize->add_setting(
	'woostify_setting[blog_page_header_title_color]',
	array(
		'default'           => $defaults['blog_page_header_title_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);


$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,

		'woostify_setting[blog_page_header_title_color]',
		array(
			'label'    => __( 'Title Color', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => array(
				'woostify_setting[blog_page_header_title_color]',
			),
			'tab'      => 'design',
		)
	)
);


// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_title_font_size]',
	array(
		'default'           => $defaults['blog_page_header_title_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_page_header_title_tablet_font_size]',
	array(
		'default'           => $defaults['blog_page_header_title_tablet_font_size'],

		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_setting(

	'woostify_setting[blog_page_header_title_mobile_font_size]',
	array(
		'default'           => $defaults['blog_page_header_title_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,

		'woostify_setting[blog_page_header_title_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Title Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(

				'desktop' => 'woostify_setting[blog_page_header_title_font_size]',
				'tablet'  => 'woostify_setting[blog_page_header_title_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_page_header_title_mobile_font_size]',
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
	'woostify_setting[blog_page_header_breadcrumb_text_color]',
	array(
		'default'           => $defaults['blog_page_header_breadcrumb_text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_breadcrumb_text_color]',
		array(
			'label'    => __( 'Breadcrumb Color', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => array(
				'woostify_setting[blog_page_header_breadcrumb_text_color]',
			),
			'tab'      => 'design',

		)
	)
);

// font size.
$wp_customize->add_setting(

	'woostify_setting[blog_page_header_breadcrumb_font_size]',
	array(
		'default'           => $defaults['blog_page_header_breadcrumb_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_page_header_breadcrumb_tablet_font_size]',
	array(
		'default'           => $defaults['blog_page_header_breadcrumb_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_page_header_breadcrumb_mobile_font_size]',
	array(
		'default'           => $defaults['blog_page_header_breadcrumb_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_breadcrumb_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Breadcrumb Font Size', 'woostify' ),
			'section'  => 'woostify_blog',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_page_header_breadcrumb_font_size]',
				'tablet'  => 'woostify_setting[blog_page_header_breadcrumb_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_page_header_breadcrumb_mobile_font_size]',
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
	'woostify_setting[blog_page_header_background_color]',
	array(
		'default'           => $defaults['blog_page_header_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);



$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,

		'woostify_setting[blog_page_header_background_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => array(
				'woostify_setting[page_header_background_color]',
			),
			'tab'      => 'design',
		)
	)
);


// Background image.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_background_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_page_header_background_image'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Image_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_background_image]',
		array(
			'label'    => __( 'Background Image', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_page_header_background_image]',
			'tab'      => 'design',
		)
	)
);

// Background image size.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_background_image_size]',
	array(
		'default'           => $defaults['page_header_background_image_size'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_background_image_size]',
		array(
			'label'    => __( 'Background Size', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_background_image_size]',
			'section'  => 'woostify_blog',
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
	'woostify_setting[blog_page_header_background_image_repeat]',
	array(
		'default'           => $defaults['blog_page_header_background_image_repeat'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_background_image_repeat]',
		array(
			'label'    => __( 'Background Repeat', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_background_image_repeat]',
			'section'  => 'woostify_blog',
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
	'woostify_setting[blog_page_header_background_image_position]',
	array(
		'default'           => $defaults['blog_page_header_background_image_position'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_background_image_position]',
		array(
			'label'    => __( 'Background Position', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_background_image_position]',
			'section'  => 'woostify_blog',
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
	'woostify_setting[blog_page_header_background_image_attachment]',
	array(
		'default'           => $defaults['blog_page_header_background_image_attachment'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_background_image_attachment]',
		array(
			'label'    => __( 'Background Attachment', 'woostify' ),
			'settings' => 'woostify_setting[blog_page_header_background_image_attachment]',
			'section'  => 'woostify_blog',
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
	'blog_page_header_spacing_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_page_header_spacing_divider',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'blog_page_header_spacing_divider',
			'type'     => 'divider',
			'tab'      => 'design',
		)
	)
);


// Padding top.
$wp_customize->add_setting(
	'woostify_setting[blog_page_header_padding_top]',
	array(
		'default'           => $defaults['blog_page_header_padding_top'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_padding_top]',
		array(
			'label'    => __( 'Padding Top', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_page_header_padding_top]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_page_header_padding_top_min_step', 0 ),
					'max'  => apply_filters( 'woostify_page_header_padding_top_max_step', 200 ),
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
	'woostify_setting[blog_page_header_padding_bottom]',
	array(
		'default'           => $defaults['blog_page_header_padding_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_padding_bottom]',
		array(
			'label'    => __( 'Padding Bottom', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_page_header_padding_bottom]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_page_header_padding_bottom_min_step', 0 ),
					'max'  => apply_filters( 'woostify_page_header_padding_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_page_header_padding_bottom_tablet_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_padding_bottom_tablet_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_page_header_padding_bottom_mobile_min_step', 1 ),
					'max'  => apply_filters( 'woostify_page_header_padding_bottom_mobile_max_step', 50 ),

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
	'woostify_setting[blog_page_header_margin_bottom]',
	array(
		'default'           => $defaults['blog_page_header_margin_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_page_header_margin_bottom]',
		array(
			'label'    => __( 'Margin Bottom', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_page_header_margin_bottom]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_page_header_margin_bottom_min_step', 0 ),
					'max'  => apply_filters( 'woostify_page_header_margin_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);
