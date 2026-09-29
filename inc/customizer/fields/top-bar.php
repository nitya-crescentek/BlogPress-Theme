<?php
/**
 * This file handles the customizer fields for the top bar.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_top_bar_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Top Bar', 'webpress' ),
		'choices' => array(
			'toggleId' => 'top-bar-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[top_bar_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_background_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'settings' => 'webpress_settings[top_bar_background_color]',
		'active_callback' => 'webpress_is_top_bar_active',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[top_bar_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_text_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'active_callback' => 'webpress_is_top_bar_active',
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

WebPress_Customize_Field::add_wrapper(
	'webpress_top_bar_link_wrapper',
	array(
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[top_bar_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_link_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'active_callback' => 'webpress_is_top_bar_active',
		'choices' => array(
			'wrapper' => 'top_bar_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
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

WebPress_Customize_Field::add_field(
	'webpress_settings[top_bar_link_color_hover]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_link_color_hover'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'active_callback' => 'webpress_is_top_bar_active',
		'choices' => array(
			'wrapper' => 'top_bar_link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
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
