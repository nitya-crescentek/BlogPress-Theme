<?php
/**
 * This file handles the customizer fields for the Search Modal.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

BlogPress_Customize_Field::add_title(
	'blogpress_search_modal_colors_title',
	array(
		'section' => 'blogpress_colors_section',
		'title' => __( 'Search Modal', 'blogpress' ),
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'active_callback' => function() {
			if ( blogpress_get_option( 'nav_search_modal' ) ) {
				return true;
			}

			return false;
		},
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[search_modal_bg_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_bg_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Field Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'output' => array(
			array(
				'element'  => ':root',
				'property' => '--bp-search-modal-bg-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[search_modal_text_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_text_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Field Text', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'output' => array(
			array(
				'element'  => ':root',
				'property' => '--bp-search-modal-text-color',
			),
		),
	)
);

BlogPress_Customize_Field::add_field(
	'blogpress_settings[search_modal_overlay_bg_color]',
	'BlogPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_overlay_bg_color'],
		'sanitize_callback' => 'blogpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Overlay Background', 'blogpress' ),
		'section' => 'blogpress_colors_section',
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'output' => array(
			array(
				'element'  => ':root',
				'property' => '--bp-search-modal-overlay-bg-color',
			),
		),
	)
);
