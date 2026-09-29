<?php
/**
 * This file handles the customizer fields for the sidebar widgets.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_sidebar_widgets_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Sidebar Widgets', 'webpress' ),
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[sidebar_widget_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_background_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_background_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget',
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[sidebar_widget_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_text_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_sidebar_widget_colors_wrapper',
	array(
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[sidebar_widget_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_link_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget a',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[sidebar_widget_link_hover_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_link_hover_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
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

WebPress_Customize_Field::add_field(
	'webpress_settings[sidebar_widget_title_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_title_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Widget Title', 'webpress' ),
		'section' => 'webpress_colors_section',
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
