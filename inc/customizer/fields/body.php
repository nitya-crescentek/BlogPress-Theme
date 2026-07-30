<?php
/**
 * This file handles the customizer fields for the Body.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_body_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Body', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'base-colors',
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $defaults['background_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'base-colors',
		),
		'output' => array(
			array(
				'element'  => 'body',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $defaults['text_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'base-colors',
		),
		'output' => array(
			array(
				'element'  => 'body',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_body_link_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'base-colors',
			'items' => array(
				'link_color',
				'link_color_hover',
				'link_color_visited',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[link_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $defaults['link_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'wrapper' => 'link_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
			'toggleId' => 'base-colors',
		),
		'output' => array(
			array(
				'element'  => 'a, a:visited',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[link_color_hover]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $defaults['link_color_hover'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'wrapper' => 'link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'toggleId' => 'base-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a:hover',
				'property' => 'color',
			),
		),
	)
);

if ( '' !== blogpress_get_option( 'link_color_visited' ) ) {
	BlogPress_Customize_Field::add_field(
		'blogpress_settings[link_color_visited]',
		'BlogPress_Customize_Color_Control',
		array(
			'default' => $defaults['link_color_visited'],
			'sanitize_callback' => 'blogpress_sanitize_hex_color',
			'transport' => 'refresh',
		),
		array(
			'label' => __( 'Link Color Visited', 'blogpress' ),
			'section' => 'blogpress_colors_section',
			'choices' => array(
				'wrapper' => 'link_color_visited',
				'tooltip' => __( 'Choose Visited Color', 'blogpress' ),
				'toggleId' => 'base-colors',
				'hideLabel' => true,
			),
		)
	);
}
