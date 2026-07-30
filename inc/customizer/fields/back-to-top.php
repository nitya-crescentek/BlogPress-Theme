<?php
/**
 * This file handles the customizer fields for the back to top button.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_back_to_top_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Back to Top', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'back-to-top-colors',
		),
		'active_callback' => function() {
			if ( blogpress_get_option( 'back_to_top' ) ) {
				return true;
			}

			return false;
		},
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_back_to_top_background_wrapper',
	array(
		'section' => 'blogpress_colors_section',
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

BlogPress_Customize_Field::add_field(
	'blogpress_settings[back_to_top_background_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_background_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_background_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => 'a.blogpress-back-to-top',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[back_to_top_background_color_hover]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_background_color_hover'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_background_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a.blogpress-back-to-top:hover, a.blogpress-back-to-top:focus',
				'property' => 'background-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_wrapper(
	'blogpress_back_to_top_text_wrapper',
	array(
		'section' => 'blogpress_colors_section',
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

BlogPress_Customize_Field::add_field(
	'blogpress_settings[back_to_top_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_text_color'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'button-colors',
			'wrapper' => 'back_to_top_text_color',
			'tooltip' => __( 'Choose Initial Color', 'blogpress' ),
		),
		'output' => array(
			array(
				'element'  => 'a.blogpress-back-to-top',
				'property' => 'color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[back_to_top_text_color_hover]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_text_color_hover'],
		'sanitize_callback' => 'blogpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text Hover', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_text_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'blogpress' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a.blogpress-back-to-top:hover, a.blogpress-back-to-top:focus',
				'property' => 'color',
			),
		),
	)
);
