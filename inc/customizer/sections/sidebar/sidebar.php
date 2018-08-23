<?php
/**
 * Sidebar customizer
 *
 * @package woostify
 */

// Default sidebar.
$wp_customize->add_setting(
	'woostify_default_sidebar',
	array(
		'default'           => apply_filters( 'woostify_default_blog_layout', $layout = is_rtl() ? 'left' : 'right' ),
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_default_sidebar',
		array(
			'label'    => __( 'Default', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_default_sidebar',
			'type'     => 'select',
			'choices'  => array(
				'full'  => __( 'No sidebar', 'woostify' ),
				'left'  => __( 'Left sidebar', 'woostify' ),
				'right' => __( 'Right sidebar', 'woostify' ),
			),
		)
	)
);

// Blog sidebar divider.
$wp_customize->add_setting( 'blog_sidebar_divider' );
$wp_customize->add_control(
	new Arbitrary_Storefront_Control(
		$wp_customize,
		'blog_sidebar_divider',
		array(
			'section'  => 'woostify_sidebar',
			'settings' => 'blog_sidebar_divider',
			'type'     => 'divider',
		)
	)
);

// Blog archive sidebar.
$wp_customize->add_setting(
	'woostify_blog_archive_sidebar',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_blog_archive_sidebar',
		array(
			'label'    => __( 'Blog list', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_blog_archive_sidebar',
			'type'     => 'select',
			'choices'  => array(
				'default' => __( 'Default', 'woostify' ),
				'full'    => __( 'No sidebar', 'woostify' ),
				'left'    => __( 'Left sidebar', 'woostify' ),
				'right'   => __( 'Right sidebar', 'woostify' ),
			),
		)
	)
);

// Blog single sidebar.
$wp_customize->add_setting(
	'woostify_blog_single_sidebar',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_blog_single_sidebar',
		array(
			'label'    => __( 'Blog single', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_blog_single_sidebar',
			'type'     => 'select',
			'choices'  => array(
				'default' => __( 'Default', 'woostify' ),
				'full'    => __( 'No sidebar', 'woostify' ),
				'left'    => __( 'Left sidebar', 'woostify' ),
				'right'   => __( 'Right sidebar', 'woostify' ),
			),
		)
	)
);

// woocommerce divider.
$wp_customize->add_setting( 'woocommerce_sidebar_divider' );
$wp_customize->add_control(
	new Arbitrary_Storefront_Control(
		$wp_customize,
		'woocommerce_sidebar_divider',
		array(
			'section'  => 'woostify_sidebar',
			'settings' => 'woocommerce_sidebar_divider',
			'type'     => 'divider',
		)
	)
);

// Shop page sidebar.
$wp_customize->add_setting(
	'woostify_shop_page_sidebar',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_shop_page_sidebar',
		array(
			'label'    => __( 'Shop page', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_shop_page_sidebar',
			'type'     => 'select',
			'choices'  => array(
				'default' => __( 'Default', 'woostify' ),
				'full'    => __( 'No sidebar', 'woostify' ),
				'left'    => __( 'Left sidebar', 'woostify' ),
				'right'   => __( 'Right sidebar', 'woostify' ),
			),
		)
	)
);

// Product page sidebar.
$wp_customize->add_setting(
	'woostify_product_page_sidebar',
	array(
		'default'           => 'full',
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_product_page_sidebar',
		array(
			'label'    => __( 'Shop single', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_product_page_sidebar',
			'type'     => 'select',
			'choices'  => array(
				'default' => __( 'Default', 'woostify' ),
				'full'    => __( 'No sidebar', 'woostify' ),
				'left'    => __( 'Left sidebar', 'woostify' ),
				'right'   => __( 'Right sidebar', 'woostify' ),
			),
		)
	)
);
