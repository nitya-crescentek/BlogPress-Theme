<?php
/**
 * This file handles the customizer fields for the footer bar.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_footer_bar_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Footer Bar', 'webpress' ),
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_background_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_background_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info',
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_text_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_footer_bar_colors_wrapper',
	array(
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_link_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info a',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_link_hover_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_link_hover_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
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
