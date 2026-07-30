<?php
/**
 * Integrate BlogPress with the WordPress block editor.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check what sidebar layout we're using.
 * We need this function as the post meta in blogpress_get_layout() only runs
 * on is_singular()
 *
 * @since 2.2
 *
 * @param bool $meta Check for post meta.
 * @return string The saved sidebar layout.
 */
function blogpress_get_block_editor_sidebar_layout( $meta = true ) {
	$layout = blogpress_get_option( 'layout_setting' );

	if ( function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();

		if ( is_object( $screen ) && 'post' === $screen->post_type ) {
			$layout = blogpress_get_option( 'single_layout_setting' );
		}
	}

	// Add in our default filter in case people have adjusted it.
	$layout = $layout;

	if ( $meta ) {
		$layout_meta = get_post_meta( get_the_ID(), '_blogpress-sidebar-layout-meta', true );

		if ( $layout_meta ) {
			$layout = $layout_meta;
		}
	}

	return $layout;
}


/**
 * Get the content width for this post.
 *
 * @since 2.2
 */
function blogpress_get_block_editor_content_width() {
	$container_width = blogpress_get_option( 'container_width' );

	$content_width = $container_width;

	$right_sidebar_width = '25';

	$left_sidebar_width = '25';

	$layout = blogpress_get_block_editor_sidebar_layout();

	if ( 'left-sidebar' === $layout ) {
		$content_width = $container_width * ( ( 100 - $left_sidebar_width ) / 100 );
	} elseif ( 'right-sidebar' === $layout ) {
		$content_width = $container_width * ( ( 100 - $right_sidebar_width ) / 100 );
	} elseif ( 'no-sidebar' === $layout ) {
		$content_width = $container_width;
	} else {
		$content_width = $container_width * ( ( 100 - ( $left_sidebar_width + $right_sidebar_width ) ) / 100 );
	}

	return $content_width;
}

add_filter( 'block_editor_settings_all', 'blogpress_add_inline_block_editor_styles' );
/**
 * Add dynamic inline styles to the block editor content.
 *
 * @param array $editor_settings The existing editor settings.
 */
function blogpress_add_inline_block_editor_styles( $editor_settings ) {
	$show_editor_styles = true;

	if ( $show_editor_styles ) {
		$google_fonts_uri = BlogPress_Typography::get_google_fonts_uri();

		if ( $google_fonts_uri ) {
			// Need to use @import for now until this is ready: https://github.com/WordPress/gutenberg/pull/35950.
			$google_fonts_import = sprintf(
				'@import "%s";',
				$google_fonts_uri
			);

			$editor_settings['styles'][] = array( 'css' => $google_fonts_import );
		}

		$editor_settings['styles'][] = array( 'css' => wp_strip_all_tags( blogpress_do_inline_block_editor_css() ) );

		$editor_settings['styles'][] = array( 'css' => wp_strip_all_tags( BlogPress_Typography::get_css( 'core' ) ) );
	}

	return $editor_settings;
}

add_action( 'enqueue_block_editor_assets', 'blogpress_enqueue_backend_block_editor_assets' );
/**
 * Add CSS to the admin side of the block editor.
 *
 * @since 2.2
 */
function blogpress_enqueue_backend_block_editor_assets() {
	// Our global colors belong on every block editor screen.
	wp_register_style( 'blogpress-block-editor', false, array(), true, true );
	wp_add_inline_style( 'blogpress-block-editor', blogpress_do_inline_block_editor_css( 'block-editor' ) );
	wp_enqueue_style( 'blogpress-block-editor' );

	/*
	 * The content width script is post editor only. The widgets and site editor
	 * screens have no core/editor or core/edit-post store, so loading it there
	 * throws and the editor renders an error notice in its place.
	 */
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || 'post' !== $screen->base ) {
		return;
	}

	wp_enqueue_script(
		'blogpress-block-editor',
		trailingslashit( get_template_directory_uri() ) . 'assets/dist/block-editor.js',
		array( 'wp-data', 'wp-dom-ready', 'wp-element', 'wp-plugins', 'wp-polyfill' ),
		BLOGPRESS_VERSION,
		true
	);

	$color_settings = wp_parse_args(
		get_option( 'blogpress_settings', array() ),
		blogpress_get_color_defaults()
	);

	$spacing_settings = wp_parse_args(
		get_option( 'blogpress_spacing_settings', array() ),
		blogpress_spacing_get_defaults()
	);

	$text_color = blogpress_get_option( 'text_color' );

	if ( $color_settings['content_text_color'] ) {
		$text_color = $color_settings['content_text_color'];
	}

	$sidebar_layout = get_post_meta( get_the_ID(), '_blogpress_sidebar_layout', true );
	$content_area_type = get_post_meta( get_the_ID(), '_blogpress-full-width-content', true );

	wp_localize_script(
		'blogpress-block-editor',
		'blogpressBlockEditor',
		array(
			'sidebarLayout' => $sidebar_layout ? $sidebar_layout : blogpress_get_block_editor_sidebar_layout( false ),
			'containerWidth' => blogpress_get_option( 'container_width' ),
			'contentPaddingRight' => absint( $spacing_settings['content_right'] ) . 'px',
			'contentPaddingLeft' => absint( $spacing_settings['content_left'] ) . 'px',
			'rightSidebarWidth' => '25',
			'leftSidebarWidth' => '25',
			'text_color' => $text_color,
			'show_editor_styles' => true,
			'contentAreaType' => $content_area_type ? $content_area_type : '',
			'customContentWidth' => '',
		)
	);
}

/**
 * Write our CSS for the block editor.
 *
 * @since 2.2
 * @param string $for Define whether this CSS for the block content or the block editor.
 */
function blogpress_do_inline_block_editor_css( $for = 'block-content' ) {
	$css = new BlogPress_CSS();

	$css->set_selector( ':root' );

	$global_colors = blogpress_get_global_colors();

	if ( ! empty( $global_colors ) ) {
		foreach ( (array) $global_colors as $key => $data ) {
			if ( ! empty( $data['slug'] ) && ! empty( $data['color'] ) ) {
				$css->add_property( '--' . $data['slug'], $data['color'] );
			}
		}

		foreach ( (array) $global_colors as $key => $data ) {
			if ( ! empty( $data['slug'] ) && ! empty( $data['color'] ) ) {
				$css->set_selector( '.has-' . $data['slug'] . '-color' );
				$css->add_property( 'color', 'var(--' . $data['slug'] . ')' );

				$css->set_selector( '.has-' . $data['slug'] . '-background-color' );
				$css->add_property( 'background-color', 'var(--' . $data['slug'] . ')' );
			}
		}
	}

	// If this CSS is for the editor only (not the block content), we can return here.
	if ( 'block-editor' === $for ) {
		return $css->css_output();
	}

	$color_settings = wp_parse_args(
		get_option( 'blogpress_settings', array() ),
		blogpress_get_color_defaults()
	);

	$content_width = blogpress_get_block_editor_content_width();

	$spacing_settings = wp_parse_args(
		get_option( 'blogpress_spacing_settings', array() ),
		blogpress_spacing_get_defaults()
	);

	$content_width_calc = sprintf(
		'calc(%1$s - %2$s - %3$s)',
		absint( $content_width ) . 'px',
		absint( $spacing_settings['content_left'] ) . 'px',
		absint( $spacing_settings['content_right'] ) . 'px'
	);

	$css->set_selector( 'body' );
	$css->add_property(
		'--content-width',
		'true' === get_post_meta( get_the_ID(), '_blogpress-full-width-content', true )
			? '100%'
			: $content_width_calc
	);

	$css->set_selector( 'body .wp-block' );
	$css->add_property( 'max-width', 'var(--content-width)' );

	$css->set_selector( '.wp-block[data-align="full"]' );
	$css->add_property( 'max-width', 'none' );

	$css->set_selector( '.wp-block[data-align="wide"]' );
	$css->add_property( 'max-width', absint( $content_width ), false, 'px' );

	$underline_links = blogpress_get_option( 'underline_links' );

	if ( 'never' !== $underline_links ) {
		if ( 'always' === $underline_links ) {
			$css->set_selector( ':where(.wp-block a)' );
			$css->add_property( 'text-decoration', 'underline' );
		}

		if ( 'hover' === $underline_links ) {
			$css->set_selector( ':where(.wp-block a)' );
			$css->add_property( 'text-decoration', 'none' );

			$css->set_selector( ':where(.wp-block a:hover), :where(.wp-block a:focus)' );
			$css->add_property( 'text-decoration', 'underline' );
		}

		if ( 'not-hover' === $underline_links ) {
			$css->set_selector( ':where(.wp-block a)' );
			$css->add_property( 'text-decoration', 'underline' );

			$css->set_selector( ':where(.wp-block a:hover), :where(.wp-block a:focus)' );
			$css->add_property( 'text-decoration', 'none' );
		}

		$css->set_selector( 'a.button, .wp-block-button__link' );
		$css->add_property( 'text-decoration', 'none' );
	} else {
		$css->set_selector( '.wp-block a' );
		$css->add_property( 'text-decoration', 'none' );
	}

	$css->set_selector( '.wp-block-group__inner-container' );
	$css->add_property( 'max-width', absint( $content_width ), false, 'px' );
	$css->add_property( 'margin-left', 'auto' );
	$css->add_property( 'margin-right', 'auto' );
	$css->add_property( 'padding', blogpress_padding_css( $spacing_settings['content_top'], $spacing_settings['content_right'], $spacing_settings['content_bottom'], $spacing_settings['content_left'] ) );

	$css->set_selector( 'a.button, a.button:visited, .wp-block-button__link:not(.has-background)' );
	$css->add_property( 'color', $color_settings['form_button_text_color'] );
	$css->add_property( 'background-color', $color_settings['form_button_background_color'] );
	$css->add_property( 'padding', '10px 20px' );
	$css->add_property( 'border', '0' );
	$css->add_property( 'border-radius', '0' );

	$css->set_selector( 'a.button:hover, a.button:active, a.button:focus, .wp-block-button__link:not(.has-background):active, .wp-block-button__link:not(.has-background):focus, .wp-block-button__link:not(.has-background):hover' );
	$css->add_property( 'color', $color_settings['form_button_text_color_hover'] );
	$css->add_property( 'background-color', $color_settings['form_button_background_color_hover'] );

	$css->set_selector( 'body' );

	if ( $color_settings['content_text_color'] ) {
		$css->add_property( 'color', $color_settings['content_text_color'] );
	} else {
		$css->add_property( 'color', blogpress_get_option( 'text_color' ) );
	}

	$css->set_selector( '.content-title-visibility' );

	if ( $color_settings['content_text_color'] ) {
		$css->add_property( 'color', $color_settings['content_text_color'] );
	} else {
		$css->add_property( 'color', blogpress_get_option( 'text_color' ) );
	}

	$css->set_selector( 'h1' );

	$css->add_property( 'color', $color_settings['h1_color'] );

	if ( $color_settings['content_title_color'] ) {
		$css->set_selector( '.edit-post-visual-editor__post-title-wrapper h1' );
		$css->add_property( 'color', $color_settings['content_title_color'] );
	}

	$css->set_selector( 'h2' );

	$css->add_property( 'color', $color_settings['h2_color'] );

	$css->set_selector( 'h3' );

	$css->add_property( 'color', $color_settings['h3_color'] );

	$css->set_selector( 'h4' );

	$css->add_property( 'color', $color_settings['h4_color'] );

	$css->set_selector( 'h5' );

	$css->add_property( 'color', $color_settings['h5_color'] );

	$css->set_selector( 'h6' );

	$css->add_property( 'color', $color_settings['h6_color'] );

	$css->set_selector( 'a.button, .block-editor-block-list__layout .wp-block-button .wp-block-button__link' );

	if ( version_compare( $GLOBALS['wp_version'], '5.7-alpha.1', '>' ) ) {
		$css->set_selector( '.block-editor__container .edit-post-visual-editor' );
		$css->add_property( 'background-color', blogpress_get_option( 'background_color' ) );

		$css->set_selector( 'body' );

		if ( $color_settings['content_background_color'] ) {
			$css->add_property( 'background-color', $color_settings['content_background_color'] );
		} else {
			$css->add_property( 'background-color', blogpress_get_option( 'background_color' ) );
		}
	} else {
		$css->set_selector( 'body' );
		$css->add_property( 'background-color', blogpress_get_option( 'background_color' ) );

		if ( $color_settings['content_background_color'] ) {
			$body_background = blogpress_get_option( 'background_color' );
			$content_background = $color_settings['content_background_color'];

			$css->add_property( 'background', 'linear-gradient(' . $content_background . ',' . $content_background . '), linear-gradient(' . $body_background . ',' . $body_background . ')' );
		}
	}

	$css->set_selector( 'a' );

	if ( $color_settings['content_link_color'] ) {
		$css->add_property( 'color', $color_settings['content_link_color'] );
	} else {
		$css->add_property( 'color', blogpress_get_option( 'link_color' ) );
	}

	$css->set_selector( 'a:hover, a:focus, a:active' );

	if ( $color_settings['content_link_hover_color'] ) {
		$css->add_property( 'color', $color_settings['content_link_hover_color'] );
	} else {
		$css->add_property( 'color', blogpress_get_option( 'link_color_hover' ) );
	}

	return $css->css_output();
}
