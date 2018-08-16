<?php
/**
 * Shop customizer
 *
 * @package woostify
 */

$wp_customize->add_setting(
	'woostify_shop_layout', array(
		'default'           => apply_filters( 'woostify_default_shop_layout', $layout = is_rtl() ? 'left' : 'right' ),
		'sanitize_callback' => 'woostify_sanitize_choices',
	)
);

$wp_customize->add_control(
	new Woostify_Custom_Radio_Image_Control(
		$wp_customize,
		'woostify_shop_layout',
		array(
			'settings' => 'woostify_shop_layout',
			'section'  => 'woostify_shop',
			'label'    => __( 'Shop Layout', 'woostify' ),
			'choices'  => array(
				'left'  => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/left.png',
				'full'  => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/full.png',
				'right' => WOOSTIFY_THEME_URI . 'assets/images/customizer/controls/right.png',
			),
		)
	)
);
