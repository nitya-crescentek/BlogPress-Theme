<?php
/**
 * This file handles the customizer fields for the footer widgets.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_footer_widgets_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Footer Widgets', 'webpress' ),
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_widget_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_background_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_background_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets',
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_widget_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_text_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_footer_widget_colors_wrapper',
	array(
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_widget_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_link_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets a',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_widget_link_hover_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_link_hover_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
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

WebPress_Customize_Field::add_field(
	'webpress_settings[footer_widget_title_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_title_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Widget Title', 'webpress' ),
		'section' => 'webpress_colors_section',
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
