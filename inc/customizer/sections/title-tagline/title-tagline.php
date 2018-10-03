<?php
/**
 * Site Title & Tagline
 *
 * @package woostify
 */

// Retina logo.
$wp_customize->add_setting(
	'woostify_retina_logo',
	array(
		'type' => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'woostify_retina_logo',
		array(
			'label'    => __( 'Retina logo', 'woostify' ),
			'section'  => 'title_tagline',
			'settings' => 'woostify_retina_logo',
			'priority' => 8,
		)
	)
);

// Logo mobile.
$wp_customize->add_setting(
	'woostify_logo_mobile',
	array(
		'type' => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'woostify_logo_mobile',
		array(
			'label'    => __( 'Mobile logo (optional)', 'woostify' ),
			'section'  => 'title_tagline',
			'settings' => 'woostify_logo_mobile',
			'priority' => 8,
		)
	)
);

// Logo width.
$wp_customize->add_setting(
	'woostify_logo_width',
	array(
		'default'   => '',
		'type'      => 'option',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new Woostify_Range_Customize_Control(
		$wp_customize,
		'woostify_logo_width',
		array(
			'type'     => 'woostify-range-slider',
			'label'    => __( 'Logo width', 'woostify' ),
			'section'  => 'title_tagline',
			'settings' => array(
				'desktop' => 'woostify_logo_width',
				'tablet' => 'woostify_logo_width',
				'mobile' => 'woostify_logo_width',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'woostify_logo_desktop_width_min_step', 50 ),
					'max'  => apply_filters( 'woostify_logo_desktop_width_max_step', 500 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'tablet' => array(
					'min'  => apply_filters( 'woostify_logo_tablet_width_min_step', 50 ),
					'max'  => apply_filters( 'woostify_logo_tablet_width_max_step', 500 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
				'mobile' => array(
					'min'  => apply_filters( 'woostify_logo_mobile_width_min_step', 50 ),
					'max'  => apply_filters( 'woostify_logo_mobile_width_max_step', 500 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
			'priority' => 8,
		)
	)
);
