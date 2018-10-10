<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Woostify
 * @author      Woostify
 * @copyright   Copyright (c) 2018, Woostify
 * @since       Astra 1.0.0
 */

// Layout.
$wp_customize->add_panel(
	'layout_section',
	array(
		'title'      => __( 'Layout', 'woostify' ),
		'capability' => 'edit_theme_options',
		'priority'   => 30,
	)
);

// Header section.
$wp_customize->add_section(
	'woostify_header',
	array(
		'title'       => __( 'Header', 'woostify' ),
		'panel'       => 'layout_section',
	)
);

// Blog section.
$wp_customize->add_section(
	'woostify_blog',
	array(
		'title'       => __( 'Blog', 'woostify' ),
		'panel'       => 'layout_section',
	)
);

// Blog single section.
$wp_customize->add_section(
	'woostify_blog_single',
	array(
		'title'       => __( 'Blog Single', 'woostify' ),
		'panel'       => 'layout_section',
	)
);

// Sidebar section.
$wp_customize->add_section(
	'woostify_sidebar',
	array(
		'title'       => __( 'Sidebar', 'woostify' ),
		'panel'       => 'layout_section',
	)
);

// Footer section.
$wp_customize->add_section(
	'woostify_footer',
	array(
		'title'       => __( 'Footer', 'woostify' ),
		'panel'       => 'layout_section',
	)
);

// Color section.
$wp_customize->add_section(
	'woostify_color',
	array(
		'title'    => __( 'Color', 'woostify' ),
		'priority' => 30,
	)
);

// Buttons section.
$wp_customize->add_section(
	'woostify_buttons',
	array(
		'title'       => __( 'Buttons', 'woostify' ),
		'priority'    => 30,
	)
);

// Typography panel.
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

// Woocommerce shop.
if ( class_exists( 'woocommerce' ) ) {
	$wp_customize->add_panel(
		'woostify_shop',
		array(
			'title'      => __( 'Shop', 'woostify' ),
			'capability' => 'edit_theme_options',
			'priority'   => 30,
		)
	);

	$wp_customize->add_section(
		'woostify_shop_page',
		array(
			'title'      => __( 'Shop Archive', 'woostify' ),
			'capability' => 'edit_theme_options',
			'panel'      => 'woostify_shop',
		)
	);

	$wp_customize->add_section(
		'woostify_shop_single',
		array(
			'title'      => __( 'Shop Single', 'woostify' ),
			'capability' => 'edit_theme_options',
			'panel'      => 'woostify_shop',
		)
	);
}
