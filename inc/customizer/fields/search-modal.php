<?php
/**
 * This file handles the customizer fields for the Search Modal.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_search_modal_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Search Modal', 'webpress' ),
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'active_callback' => function() {
			if ( webpress_get_option( 'nav_search_modal' ) ) {
				return true;
			}

			return false;
		},
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[search_modal_bg_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_bg_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Field Background', 'webpress' ),
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[search_modal_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_text_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Field Text', 'webpress' ),
		'section' => 'webpress_colors_section',
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

WebPress_Customize_Field::add_field(
	'webpress_settings[search_modal_overlay_bg_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_overlay_bg_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Overlay Background', 'webpress' ),
		'section' => 'webpress_colors_section',
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
