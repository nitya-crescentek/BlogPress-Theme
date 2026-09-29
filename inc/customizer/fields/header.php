<?php
/**
 * This file handles the customizer fields for the header.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_header_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Header', 'webpress' ),
		'choices' => array(
			'toggleId' => 'header-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[header_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_background_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.site-header',
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[header_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_text_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.site-header',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_header_link_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'header-colors',
			'items' => array(
				'header_link_color',
				'header_link_hover_color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[header_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_link_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
			'wrapper' => 'header_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-header a:not([rel="home"])',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[header_link_hover_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_link_hover_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
			'wrapper' => 'header_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.site-header a:not([rel="home"]):hover',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[site_title_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['site_title_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Site Title', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.main-title a, .main-title a:hover',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[site_tagline_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['site_tagline_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Tagline', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.site-description',
				'property' => 'color',
			),
		),
	)
);
