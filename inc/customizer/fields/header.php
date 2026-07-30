<?php
/**
 * This file handles the customizer fields for the header.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_header_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Header', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'header-colors',
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[header_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_background_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
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

BlogPress_Customize_Field::add_field(
	'blogpress_settings[header_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_text_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
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

BlogPress_Customize_Field::add_wrapper(
	'blogpress_header_link_wrapper',
	array(
		'section' => 'blogpress_colors_section',
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

BlogPress_Customize_Field::add_field(
	'blogpress_settings[header_link_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_link_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
			'wrapper' => 'header_link_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.site-header a:not([rel="home"])',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[header_link_hover_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_link_hover_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
			'wrapper' => 'header_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
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

BlogPress_Customize_Field::add_field(
	'blogpress_settings[site_title_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['site_title_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Site Title', 'blogpress' ),
		'section' => 'blogpress_colors_section',
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

BlogPress_Customize_Field::add_field(
	'blogpress_settings[site_tagline_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['site_tagline_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Tagline', 'blogpress' ),
		'section' => 'blogpress_colors_section',
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
