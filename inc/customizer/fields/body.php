<?php
/**
 * This file handles the customizer fields for the Body.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_body_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Body', 'webpress' ),
		'choices' => array(
			'toggleId' => 'base-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $defaults['background_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $defaults['text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_wrapper(
	'webpress_body_link_wrapper',
	array(
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $defaults['link_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
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

WebPress_Customize_Field::add_field(
	'webpress_settings[link_color_hover]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $defaults['link_color_hover'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
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

if ( '' !== webpress_get_option( 'link_color_visited' ) ) {
	WebPress_Customize_Field::add_field(
		'webpress_settings[link_color_visited]',
		'WebPress_Customize_Color_Control',
		array(
			'default' => $defaults['link_color_visited'],
			'sanitize_callback' => 'webpress_sanitize_hex_color',
			'transport' => 'refresh',
		),
		array(
			'label' => __( 'Link Color Visited', 'webpress' ),
			'section' => 'webpress_colors_section',
			'choices' => array(
				'wrapper' => 'link_color_visited',
				'tooltip' => __( 'Choose Visited Color', 'webpress' ),
				'toggleId' => 'base-colors',
				'hideLabel' => true,
			),
		)
	);
}
