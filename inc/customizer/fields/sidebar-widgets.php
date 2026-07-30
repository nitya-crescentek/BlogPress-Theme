<?php
/**
 * This file handles the customizer fields for the sidebar widgets.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_sidebar_widgets_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Sidebar Widgets', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[sidebar_widget_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_background_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_background_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[sidebar_widget_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_text_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_text_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_sidebar_widget_colors_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'sidebar-widget-colors',
			'items' => array(
				'sidebar_widget_link_color',
				'sidebar_widget_link_hover_color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[sidebar_widget_link_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_link_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_link_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget a',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[sidebar_widget_link_hover_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_link_hover_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget a:hover',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[sidebar_widget_title_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_title_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Widget Title', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget .widget-title',
				'property' => 'color',
			),
		),
	)
);
