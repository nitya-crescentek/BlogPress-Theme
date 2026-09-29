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
	'webpress_forms_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Forms', 'webpress' ),
		'choices' => array(
			'toggleId' => 'form-colors',
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_forms_background_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'form-colors',
			'items' => array(
				'form_background_color',
				'form_background_color_focus',
			),
		),
	)
);

$forms_selector = 'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], textarea, select';
$forms_focus_selector = 'input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, textarea:focus, select:focus';

WebPress_Customize_Field::add_field(
	'webpress_settings[form_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_background_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_background_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => $forms_selector,
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[form_background_color_focus]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_background_color_focus'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background Focus', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_background_color_focus',
			'tooltip' => __( 'Choose Focus Color', 'webpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $forms_focus_selector,
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_forms_text_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'form-colors',
			'items' => array(
				'form_text_color',
				'form_text_color_focus',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[form_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'form-colors',
			'wrapper' => 'form_text_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => $forms_selector,
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[form_text_color_focus]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_text_color_focus'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text Focus', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'form-colors',
			'wrapper' => 'form_text_color_focus',
			'tooltip' => __( 'Choose Focus Color', 'webpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $forms_focus_selector,
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_forms_border_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'form-colors',
			'items' => array(
				'form_border_color',
				'form_border_color_focus',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[form_border_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_border_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Border', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_border_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => $forms_selector,
				'property' => 'border-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[form_border_color_focus]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_border_color_focus'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Border Focus', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_border_color_focus',
			'tooltip' => __( 'Choose Focus Color', 'webpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $forms_focus_selector,
				'property' => 'border-color',
			),
		),
	)
);
