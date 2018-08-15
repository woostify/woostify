<?php
/**
 * Blog customizer
 *
 * @package woostify
 */

$wp_customize->add_setting(
	'woostify_blog_layout', array(
		'default'           => apply_filters( 'woostify_default_blog_layout', $layout = is_rtl() ? 'left' : 'right' ),
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new Woostify_Custom_Radio_Image_Control(
		$wp_customize,
		'woostify_blog_layout',
		array(
			'label'                 => __( 'Blog layout', 'woostify' ),
			'section'               => 'woostify_blog',
			'settings'              => 'woostify_blog_layout',
			'choices'  => array(
				'left'  => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/left.png',
				'full'  => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/full.png',
				'right' => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/right.png',
			),
		)
	)
);
