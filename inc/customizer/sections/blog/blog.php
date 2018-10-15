<?php
/**
 * Blog customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Blog list structure title.
$wp_customize->add_setting(
	'blog_list_structure_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_list_structure_title',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'blog_list_structure_title',
			'type'     => 'heading',
			'label'    => __( 'Blog List Structure', 'woostify' ),
		)
	)
);

// Post feature image.
$wp_customize->add_setting(
	'woostify_setting[blog_list_feature_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_feature_image'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_feature_image]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Featured Image', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_feature_image]',
		)
	)
);

// Post title.
$wp_customize->add_setting(
	'woostify_setting[blog_list_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_title'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_title]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Post Title', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_title]',
		)
	)
);

// Blog list meta title.
$wp_customize->add_setting(
	'blog_list_post_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_list_post_meta_title',
		array(
			'section'  => 'woostify_blog',
			'settings' => 'blog_list_post_meta_title',
			'type'     => 'heading',
			'label'    => __( 'Blog Post Meta', 'woostify' ),
		)
	)
);

// Publish date.
$wp_customize->add_setting(
	'woostify_setting[blog_list_publish_date]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_publish_date'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_publish_date]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Publish Date', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_publish_date]',
		)
	)
);

// Author.
$wp_customize->add_setting(
	'woostify_setting[blog_list_author]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_author'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_author]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Author', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_author]',
		)
	)
);

// Category.
$wp_customize->add_setting(
	'woostify_setting[blog_list_category]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_category'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_category]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Category', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_category]',
		)
	)
);

// Comment.
$wp_customize->add_setting(
	'woostify_setting[blog_list_comment]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_comment'],
		'sanitize_callback' => 'woostify_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_list_comment]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Comments', 'woostify' ),
			'section'  => 'woostify_blog',
			'settings' => 'woostify_setting[blog_list_comment]',
		)
	)
);
