<?php
/**
 * Sidebar customizer
 *
 * @package woostify
 */

// Default values.
$defaults = woostify_options();

// Default sidebar.
$wp_customize->add_setting(
	'woostify_setting[sidebar_default]',
	array(
		'default'           => $defaults['sidebar_default'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[sidebar_default]',
		array(
			'label'    => __( 'Default', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_setting[sidebar_default]',
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
	new Arbitrary_Woostify_Control(
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
	'woostify_setting[sidebar_blog]',
	array(
		'default'           => $defaults['sidebar_blog'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[sidebar_blog]',
		array(
			'label'    => __( 'Blog list', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_setting[sidebar_blog]',
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
	'woostify_setting[sidebar_blog_single]',
	array(
		'default'           => $defaults['sidebar_blog_single'],
		'sanitize_callback' => 'woostify_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'woostify_setting[sidebar_blog_single]',
		array(
			'label'    => __( 'Blog single', 'woostify' ),
			'section'  => 'woostify_sidebar',
			'settings' => 'woostify_setting[sidebar_blog_single]',
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

if ( class_exists( 'woocommerce' ) ) {
	// woocommerce divider.
	$wp_customize->add_setting( 'woocommerce_sidebar_divider' );
	$wp_customize->add_control(
		new Arbitrary_Woostify_Control(
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
		'woostify_setting[sidebar_shop]',
		array(
			'default'           => $defaults['sidebar_shop'],
			'sanitize_callback' => 'woostify_sanitize_choices',
			'type'              => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'woostify_setting[sidebar_shop]',
			array(
				'label'    => __( 'Shop page', 'woostify' ),
				'section'  => 'woostify_sidebar',
				'settings' => 'woostify_setting[sidebar_shop]',
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
		'woostify_setting[sidebar_shop_single]',
		array(
			'default'           => $defaults['sidebar_shop_single'],
			'sanitize_callback' => 'woostify_sanitize_choices',
			'type'              => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'woostify_setting[sidebar_shop_single]',
			array(
				'label'    => __( 'Shop single', 'woostify' ),
				'section'  => 'woostify_sidebar',
				'settings' => 'woostify_setting[sidebar_shop_single]',
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
}
