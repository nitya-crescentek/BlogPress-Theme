<?php
/**
 * This file handles the customizer fields for the primary navigation.
 *
 * @package WebPress
 *
 * @var array $color_defaults
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

$menu_hover_selectors = '.navigation-search input[type="search"], .navigation-search input[type="search"]:active, .navigation-search input[type="search"]:focus, .main-navigation .main-nav ul li:not([class*="current-menu-"]):hover > a, .main-navigation .main-nav ul li:not([class*="current-menu-"]):focus > a, .main-navigation .main-nav ul li.sfHover:not([class*="current-menu-"]) > a, .main-navigation .menu-bar-item:hover > a, .main-navigation .menu-bar-item.sfHover > a';
$menu_current_selectors = '.main-navigation .main-nav ul li[class*="current-menu-"] > a';
$submenu_hover_selectors = '.main-navigation .main-nav ul ul li:not([class*="current-menu-"]):hover > a,.main-navigation .main-nav ul ul li:not([class*="current-menu-"]):focus > a,.main-navigation .main-nav ul ul li.sfHover:not([class*="current-menu-"]) > a';
$submenu_current_selectors = '.main-navigation .main-nav ul ul li[class*="current-menu-"] > a';

WebPress_Customize_Field::add_title(
	'webpress_primary_navigation_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Primary Navigation', 'webpress' ),
		'choices' => array(
			'toggleId' => 'primary-navigation-colors',
		),
	)
);

// Navigation background group.
WebPress_Customize_Field::add_color_field_group(
	'primary_navigation_background',
	'webpress_colors_section',
	'primary-navigation-colors',
	array(
		'webpress_settings[navigation_background_color]' => array(
			'default_value' => $color_defaults['navigation_background_color'],
			'label' => __( 'Navigation Background', 'webpress' ),
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'element' => '.main-navigation',
			'property' => 'background-color',
			'hide_label' => false,
		),
		'webpress_settings[navigation_background_hover_color]' => array(
			'default_value' => $color_defaults['navigation_background_hover_color'],
			'label' => __( 'Navigation Background Hover', 'webpress' ),
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'element' => $menu_hover_selectors,
			'property' => 'background-color',
			'hide_label' => true,
		),
		'webpress_settings[navigation_background_current_color]' => array(
			'default_value' => $color_defaults['navigation_background_current_color'],
			'label' => __( 'Navigation Background Current', 'webpress' ),
			'tooltip' => __( 'Choose Current Color', 'webpress' ),
			'element' => $menu_current_selectors,
			'property' => 'background-color',
			'hide_label' => true,
		),
	)
);

// Navigation text group.
WebPress_Customize_Field::add_color_field_group(
	'primary_navigation_text',
	'webpress_colors_section',
	'primary-navigation-colors',
	array(
		'webpress_settings[navigation_text_color]' => array(
			'default_value' => $color_defaults['navigation_text_color'],
			'label' => __( 'Navigation Text', 'webpress' ),
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'element' => '.main-navigation .main-nav ul li a, .main-navigation .menu-toggle, .main-navigation button.menu-toggle:hover, .main-navigation button.menu-toggle:focus, .main-navigation .mobile-bar-items a, .main-navigation .mobile-bar-items a:hover, .main-navigation .mobile-bar-items a:focus, .main-navigation .menu-bar-items',
			'property' => 'color',
			'hide_label' => false,
		),
		'webpress_settings[navigation_text_hover_color]' => array(
			'default_value' => $color_defaults['navigation_text_hover_color'],
			'label' => __( 'Navigation Text Hover', 'webpress' ),
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'element' => $menu_hover_selectors,
			'property' => 'color',
			'hide_label' => true,
		),
		'webpress_settings[navigation_text_current_color]' => array(
			'default_value' => $color_defaults['navigation_text_current_color'],
			'label' => __( 'Navigation Text Current', 'webpress' ),
			'tooltip' => __( 'Choose Current Color', 'webpress' ),
			'element' => $menu_current_selectors,
			'property' => 'color',
			'hide_label' => true,
		),
	)
);

// Sub-Menu background group.
WebPress_Customize_Field::add_color_field_group(
	'primary_navigation_submenu_background',
	'webpress_colors_section',
	'primary-navigation-colors',
	array(
		'webpress_settings[subnavigation_background_color]' => array(
			'default_value' => $color_defaults['subnavigation_background_color'],
			'label' => __( 'Sub-Menu Background', 'webpress' ),
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'element' => '.main-navigation ul ul',
			'property' => 'background-color',
			'hide_label' => false,
		),
		'webpress_settings[subnavigation_background_hover_color]' => array(
			'default_value' => $color_defaults['subnavigation_background_hover_color'],
			'label' => __( 'Sub-Menu Background Hover', 'webpress' ),
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'element' => $submenu_hover_selectors,
			'property' => 'background-color',
			'hide_label' => true,
		),
		'webpress_settings[subnavigation_background_current_color]' => array(
			'default_value' => $color_defaults['subnavigation_background_current_color'],
			'label' => __( 'Sub-Menu Background Current', 'webpress' ),
			'tooltip' => __( 'Choose Current Color', 'webpress' ),
			'element' => $submenu_current_selectors,
			'property' => 'background-color',
			'hide_label' => true,
		),
	)
);

// Sub-Menu text group.
WebPress_Customize_Field::add_color_field_group(
	'primary_navigation_submenu_text',
	'webpress_colors_section',
	'primary-navigation-colors',
	array(
		'webpress_settings[subnavigation_text_color]' => array(
			'default_value' => $color_defaults['subnavigation_text_color'],
			'label' => __( 'Sub-Menu Text', 'webpress' ),
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'element' => '.main-navigation .main-nav ul ul li a',
			'property' => 'color',
			'hide_label' => false,
		),
		'webpress_settings[subnavigation_text_hover_color]' => array(
			'default_value' => $color_defaults['subnavigation_text_hover_color'],
			'label' => __( 'Sub-Menu Text Hover', 'webpress' ),
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'element' => $submenu_hover_selectors,
			'property' => 'color',
			'hide_label' => true,
		),
		'webpress_settings[subnavigation_text_current_color]' => array(
			'default_value' => $color_defaults['subnavigation_text_current_color'],
			'label' => __( 'Sub-Menu Text Current', 'webpress' ),
			'tooltip' => __( 'Choose Current Color', 'webpress' ),
			'element' => $submenu_current_selectors,
			'property' => 'color',
			'hide_label' => true,
		),
	)
);

WebPress_Customize_Field::add_title(
	'webpress_navigation_search_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Navigation Search', 'webpress' ),
		'choices' => array(
			'toggleId' => 'primary-navigation-search-colors',
		),
		'active_callback' => function() {
			if ( 'enable' === webpress_get_option( 'nav_search' ) ) {
				return true;
			}

			return false;
		},
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[navigation_search_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['navigation_search_background_color'],
		'transport' => 'refresh',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'primary-navigation-search-colors',
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[navigation_search_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['navigation_search_text_color'],
		'transport' => 'refresh',
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'primary-navigation-search-colors',
		),
	)
);
