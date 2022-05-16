<?php
/**
 * Blog single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Tabs.
$wp_customize->add_setting(
	'woostify_setting[blog_single_context_tabs]',

	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Woostify_Tabs_Control(
		$wp_customize,
		'woostify_setting[blog_single_context_tabs]',
		array(
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_context_tabs]',
			'choices'  => array(
				'general' => __( 'Settings', 'woostify' ),
				'design'   => __( 'Design', 'woostify' ),
			),
		)
	)
);


// Page header display.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_display]',
	array(
		'default'           => $defaults['blog_single_page_header_display'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_display]',
		array(
			'label'    => __( 'Page Header Display', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_display]',
			'section'  => 'woostify_blog_single',
			'tab'      => 'general',
		)
	)
);

// Breadcrumb divider.
$wp_customize->add_setting(
	'blog_single_page_header_breadcrumb_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_single_page_header_breadcrumb_divider',
		array(
			'section'  => 'woostify_blog_single',
			'settings' => 'blog_single_page_header_breadcrumb_divider',
			'type'     => 'divider',
			'tab'      => 'general',
		)
	)
);

// Page title.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_title]',
	array(
		'default'           => $defaults['blog_single_page_header_title'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_title]',
		array(
			'label'    => __( 'Title', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_title]',
			'section'  => 'woostify_blog_single',
			'tab'      => 'general',
		)
	)
);

// Breadcrumb.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_breadcrumb]',
	array(
		'default'           => $defaults['blog_single_page_header_breadcrumb'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_breadcrumb]',
		array(
			'label'    => __( 'Breadcrumb', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_breadcrumb]',
			'section'  => 'woostify_blog_single',
			'tab'      => 'general',
		)
	)
);

// Text align.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_text_align]',
	array(
		'default'           => $defaults['blog_single_page_header_text_align'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_text_align]',
		array(
			'label'    => __( 'Text Align', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_text_align]',
			'section'  => 'woostify_blog_single',
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


// Blog single structure.
$wp_customize->add_setting(
	'woostify_setting[blog_single_structure]',
	array(
		'default'           => $defaults['blog_single_structure'],
		'sanitize_callback' => 'woostify_sanitize_array',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Sortable_Control(
		$wp_customize,
		'woostify_setting[blog_single_structure]',
		array(
			'label'    => __( 'Blog Single Structure', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_structure]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_single_structure_choices',
				array(
					'image'      => __( 'Featured Image', 'woostify' ),
					'title-meta' => __( 'Title', 'woostify' ),
					'post-meta'  => __( 'Post Meta', 'woostify' ),
				)
			),
		)
	)
);

// Blog single post meta.
$wp_customize->add_setting(
	'woostify_setting[blog_single_post_meta]',
	array(
		'default'           => $defaults['blog_single_post_meta'],
		'sanitize_callback' => 'woostify_sanitize_array',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Woostify_Sortable_Control(
		$wp_customize,
		'woostify_setting[blog_single_post_meta]',
		array(
			'label'    => __( 'Blog Single Post Meta', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_post_meta]',
			'tab'      => 'general',
			'choices'  => apply_filters(
				'woostify_setting_blog_single_post_meta_choices',
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

// Breadcrumb divider.
$wp_customize->add_setting(
	'blog_single_author_box_start',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_single_author_box_start',
		array(
			'section'  => 'woostify_blog_single',
			'settings' => 'blog_single_author_box_start',
			'type'     => 'divider',
			'tab'      => 'general',
		)
	)
);

// Author box.
$wp_customize->add_setting(
	'woostify_setting[blog_single_author_box]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_author_box'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_single_author_box]',
		array(
			'label'    => __( 'Author Box', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_author_box]',
			'tab'      => 'general',
		)
	)
);

// Related post.
$wp_customize->add_setting(
	'woostify_setting[blog_single_related_post]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_related_post'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Woostify_Switch_Control(
		$wp_customize,
		'woostify_setting[blog_single_related_post]',
		array(
			'label'    => __( 'Related Post', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_related_post]',
			'tab'      => 'general',
		)
	)
);

// Title color.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_title_color]',
	array(
		'default'           => $defaults['blog_single_page_header_title_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_title_color]',
		array(
			'label'    => __( 'Title Color', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => array(
				'woostify_setting[blog_single_page_header_title_color]',
			),
			'tab'      => 'design',
		)
	)
);


// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_title_font_size]',
	array(
		'default'           => $defaults['blog_single_page_header_title_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_title_tablet_font_size]',
	array(
		'default'           => $defaults['blog_single_page_header_title_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_title_mobile_font_size]',
	array(
		'default'           => $defaults['blog_single_page_header_title_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_title_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Title Font Size', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_single_page_header_title_font_size]',
				'tablet'  => 'woostify_setting[blog_single_page_header_title_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_single_page_header_title_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_title_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_title_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_title_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_title_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_title_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_title_mobile_width_max_step', 50 ),
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
	'woostify_setting[blog_single_page_header_breadcrumb_text_color]',
	array(
		'default'           => $defaults['blog_single_page_header_breadcrumb_text_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_breadcrumb_text_color]',
		array(
			'label'    => __( 'Breadcrumb Color', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => array(
				'woostify_setting[blog_single_page_header_breadcrumb_text_color]',
			),
			'tab'      => 'design',
		)
	)
);

// font size.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_breadcrumb_font_size]',
	array(
		'default'           => $defaults['blog_single_page_header_breadcrumb_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_breadcrumb_tablet_font_size]',
	array(
		'default'           => $defaults['blog_single_page_header_breadcrumb_tablet_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_breadcrumb_mobile_font_size]',
	array(
		'default'           => $defaults['blog_single_page_header_breadcrumb_mobile_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_breadcrumb_font_size]',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Breadcrumb Font Size', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'tab'      => 'design',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_single_page_header_breadcrumb_font_size]',
				'tablet'  => 'woostify_setting[blog_single_page_header_breadcrumb_tablet_font_size]',
				'mobile'  => 'woostify_setting[blog_single_page_header_breadcrumb_mobile_font_size]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_breadcrumb_font_size_min_step', 5 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_breadcrumb_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet'  => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_breadcrumb_tablet_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_breadcrumb_tablet_width_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile'  => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_breadcrumb_mobile_width_min_step', 1 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_breadcrumb_mobile_width_max_step', 50 ),
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
	'woostify_setting[blog_single_page_header_background_color]',
	array(
		'default'           => $defaults['blog_single_page_header_background_color'],
		'sanitize_callback' => 'woostify_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Color_Group_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_background_color]',
		array(
			'label'    => __( 'Background Color', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => array(
				'woostify_setting[blog_single_page_header_background_color]',
			),
			'tab'      => 'design',
		)
	)
);

// Background image.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_background_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_page_header_background_image'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Image_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_background_image]',
		array(
			'label'    => __( 'Background Image', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_page_header_background_image]',
			'tab'      => 'design',
		)
	)
);

// Background image size.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_background_image_size]',
	array(
		'default'           => $defaults['blog_single_page_header_background_image_size'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_background_image_size]',
		array(
			'label'    => __( 'Background Size', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_background_image_size]',
			'section'  => 'woostify_blog_single',
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
	'woostify_setting[blog_single_page_header_background_image_repeat]',
	array(
		'default'           => $defaults['blog_single_page_header_background_image_repeat'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_background_image_repeat]',
		array(
			'label'    => __( 'Background Repeat', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_background_image_repeat]',
			'section'  => 'woostify_blog_single',
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
	'woostify_setting[blog_single_page_header_background_image_position]',
	array(
		'default'           => $defaults['blog_single_page_header_background_image_position'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_background_image_position]',
		array(
			'label'    => __( 'Background Position', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_background_image_position]',
			'section'  => 'woostify_blog_single',
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
	'woostify_setting[blog_single_page_header_background_image_attachment]',
	array(
		'default'           => $defaults['blog_single_page_header_background_image_attachment'],
		'type'              => 'option',
		'sanitize_callback' => 'woostify_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_background_image_attachment]',
		array(
			'label'    => __( 'Background Attachment', 'woostify' ),
			'settings' => 'woostify_setting[blog_single_page_header_background_image_attachment]',
			'section'  => 'woostify_blog_single',
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
	'blog_single_page_header_spacing_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_single_page_header_spacing_divider',
		array(
			'section'  => 'woostify_blog_single',
			'settings' => 'page_header_spacing_divider',
			'type'     => 'divider',
			'tab'      => 'design',
		)
	)
);

// Padding top.
$wp_customize->add_setting(
	'woostify_setting[blog_single_page_header_padding_top]',
	array(
		'default'           => $defaults['blog_single_page_header_padding_top'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_padding_top]',
		array(
			'label'    => __( 'Padding Top', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_single_page_header_padding_top]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_padding_top_min_step', 0 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_padding_top_max_step', 200 ),
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
	'woostify_setting[blog_single_page_header_padding_bottom]',
	array(
		'default'           => $defaults['blog_single_page_header_padding_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_padding_bottom]',
		array(
			'label'    => __( 'Padding Bottom', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_single_page_header_padding_bottom]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_padding_bottom_min_step', 0 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_padding_bottom_max_step', 200 ),
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
	'woostify_setting[blog_single_page_header_margin_bottom]',
	array(
		'default'           => $defaults['blog_single_page_header_margin_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Woostify_Range_Slider_Control(
		$wp_customize,
		'woostify_setting[blog_single_page_header_margin_bottom]',
		array(
			'label'    => __( 'Margin Bottom', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => array(
				'desktop' => 'woostify_setting[blog_single_page_header_margin_bottom]',
			),
			'choices'  => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_blog_single_page_header_margin_bottom_min_step', 0 ),
					'max'  => apply_filters( 'woostify_blog_single_page_header_margin_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'tab'      => 'design',
		)
	)
);
