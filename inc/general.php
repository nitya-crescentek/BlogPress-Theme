<?php
/**
 * General functions.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'blogpress_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'blogpress_scripts' );
	/**
	 * Enqueue scripts and styles
	 */
	function blogpress_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$dir_uri = get_template_directory_uri();

		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentionally loose.
		if ( is_singular() && ( comments_open() || '0' != get_comments_number() ) ) {
			wp_enqueue_style( 'blogpress-comments', $dir_uri . "/assets/css/components/comments{$suffix}.css", array(), BLOGPRESS_VERSION, 'all' );
		}

		if (
			is_active_sidebar( 'top-bar' ) ||
			is_active_sidebar( 'footer-bar' ) ||
			is_active_sidebar( 'footer-1' ) ||
			is_active_sidebar( 'footer-2' ) ||
			is_active_sidebar( 'footer-3' ) ||
			is_active_sidebar( 'footer-4' ) ||
			is_active_sidebar( 'footer-5' )
		) {
			wp_enqueue_style( 'blogpress-widget-areas', $dir_uri . "/assets/css/components/widget-areas{$suffix}.css", array(), BLOGPRESS_VERSION, 'all' );
		}

		wp_enqueue_style( 'blogpress-style', $dir_uri . "/assets/css/main{$suffix}.css", array(), BLOGPRESS_VERSION, 'all' );

		if ( 'font' === blogpress_get_option( 'icons' ) ) {
			wp_enqueue_style( 'blogpress-font-icons', $dir_uri . "/assets/css/components/font-icons{$suffix}.css", array(), BLOGPRESS_VERSION, 'all' );
		}

		if ( ! blogpress_get_option( 'font_awesome_essentials' ) ) {
			wp_enqueue_style( 'font-awesome', $dir_uri . "/assets/css/components/font-awesome{$suffix}.css", false, '4.7', 'all' );
		}

		if ( is_rtl() ) {
			wp_enqueue_style( 'blogpress-rtl', $dir_uri . "/assets/css/main-rtl{$suffix}.css", array(), BLOGPRESS_VERSION, 'all' );
		}

		if ( is_child_theme() && true ) {
			wp_enqueue_style( 'blogpress-child', get_stylesheet_uri(), array( 'blogpress-style' ), filemtime( get_stylesheet_directory() . '/style.css' ), 'all' );
		}

		if ( blogpress_has_active_menu() ) {
			wp_enqueue_script( 'blogpress-menu', $dir_uri . "/assets/js/menu{$suffix}.js", array(), BLOGPRESS_VERSION, true );

			$menu_script_args = array(
				'toggleOpenedSubMenus' => true,
				'openSubMenuLabel'     => esc_attr__( 'Open Sub-Menu', 'blogpress' ),
				'closeSubMenuLabel'    => esc_attr__( 'Close Sub-Menu', 'blogpress' ),
			);

			blogpress_add_inline_script(
				'blogpress-menu',
				$menu_script_args,
				'blogpressMenu'
			);
		}

		if ( 'click' === blogpress_get_option( 'nav_dropdown_type' ) || 'click-arrow' === blogpress_get_option( 'nav_dropdown_type' ) ) {
			wp_enqueue_script( 'blogpress-dropdown-click', $dir_uri . "/assets/js/dropdown-click{$suffix}.js", array(), BLOGPRESS_VERSION, true );

			$dropdown_click_args = array(
				'openSubMenuLabel'  => esc_attr__( 'Open Sub-Menu', 'blogpress' ),
				'closeSubMenuLabel' => esc_attr__( 'Close Sub-Menu', 'blogpress' ),
			);

			blogpress_add_inline_script(
				'blogpress-dropdown-click',
				$dropdown_click_args,
				'blogpressDropdownClick'
			);
		}

		if ( blogpress_get_option( 'nav_search_modal' ) ) {
			wp_enqueue_script( 'blogpress-modal', $dir_uri . '/assets/dist/modal.js', array(), BLOGPRESS_VERSION, true );
		}

		if ( 'enable' === blogpress_get_option( 'nav_search' ) ) {
			wp_enqueue_script( 'blogpress-navigation-search', $dir_uri . "/assets/js/navigation-search{$suffix}.js", array(), BLOGPRESS_VERSION, true );

			$nav_search_args = array(
				'open'  => esc_attr__( 'Open Search Bar', 'blogpress' ),
				'close' => esc_attr__( 'Close Search Bar', 'blogpress' ),
			);

			blogpress_add_inline_script(
				'blogpress-navigation-search',
				$nav_search_args,
				'blogpressNavSearch'
			);
		}

		if ( 'enable' === blogpress_get_option( 'back_to_top' ) ) {
			wp_enqueue_script( 'blogpress-back-to-top', $dir_uri . "/assets/js/back-to-top{$suffix}.js", array(), BLOGPRESS_VERSION, true );

			$back_to_top_args = array(
				'smooth' => true,
			);

			blogpress_add_inline_script(
				'blogpress-back-to-top',
				$back_to_top_args,
				'blogpressBackToTop'
			);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( ! function_exists( 'blogpress_widgets_init' ) ) {
	add_action( 'widgets_init', 'blogpress_widgets_init' );
	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function blogpress_widgets_init() {
		$widgets = array(
			'sidebar-1' => __( 'Right Sidebar', 'blogpress' ),
			'sidebar-2' => __( 'Left Sidebar', 'blogpress' ),
			'header' => __( 'Header', 'blogpress' ),
			'footer-1' => __( 'Footer Widget 1', 'blogpress' ),
			'footer-2' => __( 'Footer Widget 2', 'blogpress' ),
			'footer-3' => __( 'Footer Widget 3', 'blogpress' ),
			'footer-4' => __( 'Footer Widget 4', 'blogpress' ),
			'footer-5' => __( 'Footer Widget 5', 'blogpress' ),
			'footer-bar' => __( 'Footer Bar', 'blogpress' ),
			'top-bar' => __( 'Top Bar', 'blogpress' ),
		);

		foreach ( $widgets as $id => $name ) {
			register_sidebar(
				array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			);
		}
	}
}

if ( ! function_exists( 'blogpress_smart_content_width' ) ) {
	add_action( 'wp', 'blogpress_smart_content_width' );
	/**
	 * Set the $content_width depending on layout of current page
	 * Hook into "wp" so we have the correct layout setting from blogpress_get_layout()
	 * Hooking into "after_setup_theme" doesn't get the correct layout setting
	 */
	function blogpress_smart_content_width() {
		global $content_width;

		$container_width = blogpress_get_option( 'container_width' );
		$right_sidebar_width = '25';
		$left_sidebar_width = '25';
		$layout = blogpress_get_layout();

		if ( 'left-sidebar' === $layout ) {
			$content_width = $container_width * ( ( 100 - $left_sidebar_width ) / 100 );
		} elseif ( 'right-sidebar' === $layout ) {
			$content_width = $container_width * ( ( 100 - $right_sidebar_width ) / 100 );
		} elseif ( 'no-sidebar' === $layout ) {
			$content_width = $container_width;
		} else {
			$content_width = $container_width * ( ( 100 - ( $left_sidebar_width + $right_sidebar_width ) ) / 100 );
		}
	}
}

if ( ! function_exists( 'blogpress_page_menu_args' ) ) {
	add_filter( 'wp_page_menu_args', 'blogpress_page_menu_args' );
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * @since 0.1
	 *
	 * @param array $args The existing menu args.
	 * @return array Menu args.
	 */
	function blogpress_page_menu_args( $args ) {
		$args['show_home'] = true;

		return $args;
	}
}

if ( ! function_exists( 'blogpress_resource_hints' ) ) {
	add_filter( 'wp_resource_hints', 'blogpress_resource_hints', 10, 2 );
	/**
	 * Add resource hints to our Google fonts call.
	 *
	 * @since 1.3.42
	 *
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	function blogpress_resource_hints( $urls, $relation_type ) {
		$handle = 'blogpress-google-fonts';
		$hint_type = 'preconnect';
		$has_crossorigin_support = version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' );

		if ( wp_style_is( $handle, 'queue' ) ) {
			if ( $relation_type === $hint_type ) {
				if ( $has_crossorigin_support && 'preconnect' === $hint_type ) {
					$urls[] = array(
						'href' => 'https://fonts.gstatic.com',
						'crossorigin',
					);

					$urls[] = array(
						'href' => 'https://fonts.googleapis.com',
						'crossorigin',
					);
				} else {
					$urls[] = 'https://fonts.gstatic.com';
					$urls[] = 'https://fonts.googleapis.com';
				}
			}

			if ( 'dns-prefetch' !== $hint_type ) {
				$googleapis_index = array_search( 'fonts.googleapis.com', $urls );

				if ( false !== $googleapis_index ) {
					unset( $urls[ $googleapis_index ] );
				}
			}
		}

		return $urls;
	}
}

if ( ! function_exists( 'blogpress_remove_caption_padding' ) ) {
	add_filter( 'img_caption_shortcode_width', 'blogpress_remove_caption_padding' );
	/**
	 * Remove WordPress's default padding on images with captions
	 *
	 * @param int $width Default WP .wp-caption width (image width + 10px).
	 * @return int Updated width to remove 10px padding.
	 */
	function blogpress_remove_caption_padding( $width ) {
		return $width - 10;
	}
}

if ( ! function_exists( 'blogpress_enhanced_image_navigation' ) ) {
	add_filter( 'attachment_link', 'blogpress_enhanced_image_navigation', 10, 2 );
	/**
	 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages.
	 *
	 * @param string $url The input URL.
	 * @param int    $id The ID of the post.
	 */
	function blogpress_enhanced_image_navigation( $url, $id ) {
		if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
			return $url;
		}

		$image = get_post( $id );
		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentially loose.
		if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
			$url .= '#main';
		}

		return $url;
	}
}

if ( ! function_exists( 'blogpress_categorized_blog' ) ) {
	/**
	 * Determine whether blog/site has more than one category.
	 *
	 * @since 1.2.5
	 *
	 * @return bool True of there is more than one category, false otherwise.
	 */
	function blogpress_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'blogpress_categories' ) ) ) { // phpcs:ignore
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,

					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'blogpress_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so twentyfifteen_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so twentyfifteen_categorized_blog should return false.
			return false;
		}
	}
}

if ( ! function_exists( 'blogpress_category_transient_flusher' ) ) {
	add_action( 'edit_category', 'blogpress_category_transient_flusher' );
	add_action( 'save_post', 'blogpress_category_transient_flusher' );
	/**
	 * Flush out the transients used in {@see blogpress_categorized_blog()}.
	 *
	 * @since 1.2.5
	 */
	function blogpress_category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'blogpress_categories' );
	}
}

if ( ! function_exists( 'blogpress_get_default_color_palettes' ) ) {
	/**
	 * Set up our colors for the color picker palettes and filter them so you can change them.
	 *
	 * @since 1.3.42
	 */
	function blogpress_get_default_color_palettes() {
		$palettes = array(
			'#000000',
			'#FFFFFF',
			'#F1C40F',
			'#E74C3C',
			'#1ABC9C',
			'#1e72bd',
			'#8E44AD',
			'#00CC77',
		);

		return $palettes;
	}
}

add_filter( 'wp_headers', 'blogpress_set_wp_headers' );
/**
 * Set any necessary headers.
 *
 * @param array $headers The existing headers.
 *
 * @since 2.3
 */
function blogpress_set_wp_headers( $headers ) {
	$headers['X-UA-Compatible'] = 'IE=edge';

	return $headers;
}

/**
 * Adds microdata to elements.
 *
 * @since 3.0.0
 * @param string $output The existing output after the class attribute.
 * @param string $context What element we're targeting.
 */
function blogpress_set_microdata_markup( $output, $context ) {
	if ( 'left_sidebar' === $context || 'right_sidebar' === $context ) {
		$context = 'sidebar';
	}

	if ( 'footer' === $context ) {
		return $output;
	}

	if ( 'site-info' === $context ) {
		$context = 'footer';
	}

	$microdata = blogpress_get_microdata( $context );

	if ( $microdata ) {
		return $microdata;
	}

	return $output;
}

add_action( 'wp_footer', 'blogpress_do_a11y_scripts' );
/**
 * Enqueue scripts in the footer.
 *
 * @since 3.1.0
 */
function blogpress_do_a11y_scripts() {
	if ( true && function_exists( 'wp_print_inline_script_tag' ) ) {
		wp_print_inline_script_tag(
			'!function(){"use strict";if("querySelector"in document&&"addEventListener"in window){var e=document.body;e.addEventListener("pointerdown",(function(){e.classList.add("using-mouse")}),{passive:!0}),e.addEventListener("keydown",(function(){e.classList.remove("using-mouse")}),{passive:!0})}}();',
			array(
				'id' => 'blogpress-a11y',
			)
		);
	}
}
