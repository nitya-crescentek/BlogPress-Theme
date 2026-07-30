<?php
/**
 * This file handles the customizer fields for the Body.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_buttons_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Buttons', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'button-colors',
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_buttons_background_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'button-colors',
			'items' => array(
				'form_button_background_color',
				'form_button_background_color_hover',
			),
		),
	)
);

$buttons_selector = 'button, html input[type="button"], input[type="reset"], input[type="submit"], a.button, a.button:visited, a.wp-block-button__link:not(.has-background)';
$buttons_hover_selector = 'button:hover, html input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, a.button:hover, button:focus, html input[type="button"]:focus, input[type="reset"]:focus, input[type="submit"]:focus, a.button:focus, a.wp-block-button__link:not(.has-background):active, a.wp-block-button__link:not(.has-background):focus, a.wp-block-button__link:not(.has-background):hover';

BlogPress_Customize_Field::add_field(
	'blogpress_settings[form_button_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_button_background_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'button-colors',
			'wrapper' => 'form_button_background_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => $buttons_selector,
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[form_button_background_color_hover]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_button_background_color_hover'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'button-colors',
			'wrapper' => 'form_button_background_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $buttons_hover_selector,
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_buttons_text_wrapper',
	array(
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'button-colors',
			'items' => array(
				'form_button_text_color',
				'form_button_text_color_hover',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[form_button_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_button_text_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'button-colors',
			'wrapper' => 'form_button_text_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => $buttons_selector,
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[form_button_text_color_hover]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_button_text_color_hover'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'button-colors',
			'wrapper' => 'form_button_text_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $buttons_hover_selector,
				'property' => 'color',
			),
		),
	)
);
