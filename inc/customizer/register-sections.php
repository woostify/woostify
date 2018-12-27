<?php
/**
 * Register customizer panels & sections.
 *
 * @package     Woostify
 */

// Layout.
$wp_customize->add_panel(
	'woostify_layout',
	array(
		'title'      => __( 'Layout', 'woostify' ),
		'capability' => 'edit_theme_options',
		'priority'   => 30,
	)
);

// Topbar section.
$wp_customize->add_section(
	'woostify_topbar',
	array(
		'title'       => __( 'Topbar', 'woostify' ),
		'panel'       => 'woostify_layout',
	)
);

// Header section.
$wp_customize->add_section(
	'woostify_header',
	array(
		'title'       => __( 'Header', 'woostify' ),
		'panel'       => 'woostify_layout',
	)
);

// Blog section.
$wp_customize->add_section(
	'woostify_blog',
	array(
		'title'       => __( 'Blog', 'woostify' ),
		'panel'       => 'woostify_layout',
	)
);

// Blog single section.
$wp_customize->add_section(
	'woostify_blog_single',
	array(
		'title'       => __( 'Blog Single', 'woostify' ),
		'panel'       => 'woostify_layout',
	)
);

// Sidebar section.
$wp_customize->add_section(
	'woostify_sidebar',
	array(
		'title'       => __( 'Sidebar', 'woostify' ),
		'panel'       => 'woostify_layout',
	)
);

// Footer section.
$wp_customize->add_section(
	'woostify_footer',
	array(
		'title'       => __( 'Footer', 'woostify' ),
		'panel'       => 'woostify_layout',
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
	'woostify_typography',
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
		'panel'      => 'woostify_typography',
	)
);

$wp_customize->add_section(
	'menu_font_section',
	array(
		'title'      => __( 'Primary menu', 'woostify' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'woostify_typography',
	)
);

$wp_customize->add_section(
	'heading_font_section',
	array(
		'title'      => __( 'Heading', 'woostify' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'woostify_typography',
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
		'woostify_product_style',
		array(
			'title'      => __( 'Product Style', 'woostify' ),
			'capability' => 'edit_theme_options',
			'panel'      => 'woostify_shop',
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
			'title'      => __( 'Product Single', 'woostify' ),
			'capability' => 'edit_theme_options',
			'panel'      => 'woostify_shop',
		)
	);
}
