<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Woostify
 * @author      Woostify
 * @copyright   Copyright (c) 2018, Woostify
 * @since       Astra 1.0.0
 */
/**
 * Font section
 */
$wp_customize->add_section(
	'font_section',
	array(
		'title'      => __( 'Typography', 'woostify' ),
		'capability' => 'edit_theme_options',
		'priority'   => 37,
	)
);
/**
 * Footer section
 */
$wp_customize->add_section(
	'woostify_footer',
	array(
		'title'       => __( 'Footer', 'woostify' ),
		'priority'    => 30,
		'description' => __( 'Customize the look & feel of your website footer.', 'woostify' ),
	)
);

/**
 * Blog section
 */
$wp_customize->add_section(
	'woostify_blog',
	array(
		'title'       => __( 'Blog', 'woostify' ),
		'priority'    => 30,
		'description' => __( 'Customize the look & feel of your blog page', 'woostify' ),
	)
);

/**
 * Shop section
 */
$wp_customize->add_section(
	'woostify_shop',
	array(
		'title'       => __( 'Shop', 'woostify' ),
		'priority'    => 30,
		'description' => __( 'Customize the look & feel of your shop page', 'woostify' ),
	)
);

/**
 * Color section
 */
$wp_customize->add_section(
	'woostify_color',
	array(
		'title'    => __( 'Color', 'woostify' ),
		'priority' => 30,
	)
);

/**
 * Buttons section
 */
$wp_customize->add_section(
	'woostify_buttons',
	array(
		'title'       => __( 'Buttons', 'woostify' ),
		'priority'    => 30,
		'description' => __( 'Customize the look & feel of your website buttons.', 'woostify' ),
	)
);

/**
 * Typography panel
 */
$wp_customize->add_panel(
	'font_section',
	array(
		'title'      => __( 'Typography', 'woostify' ),
		'capability' => 'edit_theme_options',
		'priority'   => 35,
	)
);

$wp_customize->add_section(
	'body_font_section',
	array(
		'title'      => __( 'Body', 'woostify' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'font_section',
	)
);

$wp_customize->add_section(
	'menu_font_section',
	array(
		'title'      => __( 'Primary menu', 'woostify' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'font_section',
	)
);

$wp_customize->add_section(
	'heading_font_section',
	array(
		'title'      => __( 'Heading', 'woostify' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'font_section',
	)
);
