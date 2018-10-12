<?php
/**
 * Blog single customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Blog single structure title.
$wp_customize->add_setting( 'blog_single_structure_title' );
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_single_structure_title',
		array(
			'section'  => 'woostify_blog_single',
			'settings' => 'blog_single_structure_title',
			'type'     => 'heading',
			'label'    => __( 'Blog Single Structure', 'woostify' ),
		)
	)
);

// Post feature image.
$wp_customize->add_setting(
	'woostify_setting[blog_single_feature_image]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_feature_image'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_feature_image]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Featured Image', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_feature_image]',
		)
	)
);

// Post title.
$wp_customize->add_setting(
	'woostify_setting[blog_single_title]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_title'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_title]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Post Title', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_title]',
		)
	)
);

// Related post.
$wp_customize->add_setting(
	'woostify_setting[blog_single_related_post]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_related_post'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_related_post]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Related Post', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_related_post]',
		)
	)
);

// Blog single post meta title.
$wp_customize->add_setting( 'blog_single_post_meta_title' );
$wp_customize->add_control(
	new Woostify_Divider_Control(
		$wp_customize,
		'blog_single_post_meta_title',
		array(
			'section'  => 'woostify_blog_single',
			'settings' => 'blog_single_post_meta_title',
			'type'     => 'heading',
			'label'    => __( 'Blog Post Meta', 'woostify' ),
		)
	)
);

// Publish date.
$wp_customize->add_setting(
	'woostify_setting[blog_single_publish_date]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_publish_date'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_publish_date]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Publish Date', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_publish_date]',
		)
	)
);

// Author.
$wp_customize->add_setting(
	'woostify_setting[blog_single_author]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_author'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_author]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Author', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_author]',
		)
	)
);

// Category.
$wp_customize->add_setting(
	'woostify_setting[blog_single_category]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_category'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_category]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Category', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_category]',
		)
	)
);

// Comment.
$wp_customize->add_setting(
	'woostify_setting[blog_single_comment]',
	array(
		'type'      => 'option',
		'default'   => $defaults['blog_single_comment'],
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[blog_single_comment]',
		array(
			'type'     => 'checkbox',
			'label'    => __( 'Comments', 'woostify' ),
			'section'  => 'woostify_blog_single',
			'settings' => 'woostify_setting[blog_single_comment]',
		)
	)
);
