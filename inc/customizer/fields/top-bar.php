<?php
/**
 * This file handles the customizer fields for the top bar.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_top_bar_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Top Bar', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'top-bar-colors',
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[top_bar_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_background_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'settings' => 'blogpress_settings[top_bar_background_color]',
		'active_callback' => 'blogpress_is_top_bar_active',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'top-bar-colors',
		),
		'output' => array(
			array(
				'element'  => '.top-bar',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[top_bar_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_text_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'active_callback' => 'blogpress_is_top_bar_active',
		'choices' => array(
			'toggleId' => 'top-bar-colors',
		),
		'output' => array(
			array(
				'element'  => '.top-bar',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_top_bar_link_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'top-bar-colors',
			'items' => array(
				'top_bar_link_color',
				'top_bar_link_color_hover',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[top_bar_link_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_link_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'active_callback' => 'blogpress_is_top_bar_active',
		'choices' => array(
			'wrapper' => 'top_bar_link_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
			'toggleId' => 'top-bar-colors',
		),
		'output' => array(
			array(
				'element'  => '.top-bar a',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[top_bar_link_color_hover]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_link_color_hover'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'active_callback' => 'blogpress_is_top_bar_active',
		'choices' => array(
			'wrapper' => 'top_bar_link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'toggleId' => 'top-bar-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.top-bar a:hover',
				'property' => 'color',
			),
		),
	)
);
