<?php
/**
 * This file handles the customizer fields for the footer bar.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_footer_bar_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Footer Bar', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_background_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_background_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_text_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_text_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_footer_bar_colors_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'footer-bar-colors',
			'items' => array(
				'footer_link_color',
				'footer_link_hover_color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_link_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_link_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_link_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info a',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_link_hover_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_link_hover_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.site-info a:hover',
				'property' => 'color',
			),
		),
	)
);
