<?php
/**
 * This file handles the customizer fields for the content.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

WebPress_Customize_Field::add_title(
	'webpress_content_colors_title',
	array(
		'section' => 'webpress_colors_section',
		'title' => __( 'Content', 'webpress' ),
		'choices' => array(
			'toggleId' => 'content-colors',
		),
	)
);

$content_colors = '.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .one-container .container, .separate-containers .paging-navigation, .inside-page-header';

WebPress_Customize_Field::add_field(
	'webpress_settings[content_background_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_background_color'],
		'sanitize_callback' => 'webpress_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => $content_colors,
				'property' => 'background-color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[content_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => $content_colors,
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_content_link_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'content-colors',
			'items' => array(
				'content_link_color',
				'content_link_hover_color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[content_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_link_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'content_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.inside-article a:not(.button):not(.wp-block-button__link), .inside-article a:not(.button):not(.wp-block-button__link):visited, .paging-navigation a, .paging-navigation a:visited, .comments-area a, .comments-area a:visited, .page-header a, .page-header a:visited',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[content_link_hover_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_link_hover_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'content_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'toggleId' => 'content-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.inside-article a:not(.button):not(.wp-block-button__link):hover, .paging-navigation a:hover, .comments-area a:hover, .page-header a:hover',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[content_title_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_title_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Content Title', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-header h1,.page-header h1',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_archive_content_title_link_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'content-colors',
			'items' => array(
				'blog_post_title_color',
				'blog_post_title_hover_color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[blog_post_title_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['blog_post_title_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Archive Content Title', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'blog_post_title_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-title a,.entry-title a:visited',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[blog_post_title_hover_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['blog_post_title_hover_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Archive Content Title Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'blog_post_title_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'toggleId' => 'content-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.entry-title a:hover',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[entry_meta_text_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['entry_meta_text_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Entry Meta Text', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-meta',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_wrapper(
	'webpress_entry_meta_link_wrapper',
	array(
		'section' => 'webpress_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'content-colors',
			'items' => array(
				'entry_meta_link_color',
				'entry_meta_link_color_hover',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[entry_meta_link_color]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['entry_meta_link_color'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Entry Meta Links', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'entry_meta_link_color',
			'tooltip' => __( 'Choose Initial Color', 'webpress' ),
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-meta a',
				'property' => 'color',
			),
		),
	)
);

WebPress_Customize_Field::add_field(
	'webpress_settings[entry_meta_link_color_hover]',
	'WebPress_Customize_Color_Control',
	array(
		'default' => $color_defaults['entry_meta_link_color_hover'],
		'sanitize_callback' => 'webpress_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Entry Meta Links Hover', 'webpress' ),
		'section' => 'webpress_colors_section',
		'choices' => array(
			'wrapper' => 'entry_meta_link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'webpress' ),
			'toggleId' => 'content-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.entry-meta a:hover',
				'property' => 'color',
			),
		),
	)
);

$headings = array(
	array(
		'slug' => 'h1_color',
		'label' => __( 'Heading 1 (H1) Color', 'webpress' ),
		'selector' => 'h1',
	),
	array(
		'slug' => 'h2_color',
		'label' => __( 'Heading 2 (H2) Color', 'webpress' ),
		'selector' => 'h2',
	),
	array(
		'slug' => 'h3_color',
		'label' => __( 'Heading 3 (H3) Color', 'webpress' ),
		'selector' => 'h3',
	),
	array(
		'slug' => 'h4_color',
		'label' => __( 'Heading 4 (H4) Color', 'webpress' ),
		'selector' => 'h4',
	),
	array(
		'slug' => 'h5_color',
		'label' => __( 'Heading 5 (H5) Color', 'webpress' ),
		'selector' => 'h5',
	),
	array(
		'slug' => 'h6_color',
		'label' => __( 'Heading 6 (H6) Color', 'webpress' ),
		'selector' => 'h6',
	),
);

foreach ( $headings as $heading ) {
	WebPress_Customize_Field::add_field(
		'webpress_settings[' . $heading['slug'] . ']',
		'WebPress_Customize_Color_Control',
		array(
			'default' => $color_defaults[ $heading['slug'] ],
			'sanitize_callback' => 'webpress_sanitize_hex_color',
			'transport' => 'postMessage',
		),
		array(
			'label' => $heading['label'],
			'section' => 'webpress_colors_section',
			'choices' => array(
				'toggleId' => 'content-colors',
			),
			'output' => array(
				array(
					'element'  => $heading['selector'],
					'property' => 'color',
				),
			),
		)
	);
}
