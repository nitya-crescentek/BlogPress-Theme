<?php
/**
 * This file handles the customizer fields for the back to top button.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_back_to_top_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Back to Top', 'webpress' ),
		'choices' => array(
			'toggleId' => 'back-to-top-colors',
		),
		'active_callback' => function() {
			if ( webpress_get_option( 'back_to_top' ) ) {
				return true;
			}

			return false;
		},
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_back_to_top_background_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'back-to-top-colors',
			'items' => array(
				'back_to_top_background_color',
				'back_to_top_background_color_hover',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[back_to_top_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_background_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_background_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => 'a.webpress-back-to-top',
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[back_to_top_background_color_hover]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_background_color_hover'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_background_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a.webpress-back-to-top:hover, a.webpress-back-to-top:focus',
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_back_to_top_text_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'back-to-top-colors',
			'items' => array(
				'back_to_top_text_color',
				'back_to_top_text_color_hover',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[back_to_top_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'button-colors',
			'wrapper' => 'back_to_top_text_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
		),
		'output' => array(
			array(
				'element'  => 'a.webpress-back-to-top',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[back_to_top_text_color_hover]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_text_color_hover'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_text_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a.webpress-back-to-top:hover, a.webpress-back-to-top:focus',
				'property' => 'color',
			),
		),
	)
);
