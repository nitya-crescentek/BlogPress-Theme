<?php
/**
 * This file handles the customizer fields for the footer widgets.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_footer_widgets_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Footer Widgets', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_widget_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_background_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_background_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_widget_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_text_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_text_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_footer_widget_colors_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'footer-widget-colors',
			'items' => array(
				'footer_widget_link_color',
				'footer_widget_link_hover_color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_widget_link_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_link_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_link_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets a',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_widget_link_hover_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_link_hover_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets a:hover',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[footer_widget_title_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_title_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Widget Title', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets .widget-title',
				'property' => 'color',
			),
		),
	)
);
