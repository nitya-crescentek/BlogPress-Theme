<?php
/**
 * Adds HTML markup.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'blogpress_body_classes' ) ) {
	add_filter( 'body_class', 'blogpress_body_classes' );
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_body_classes( $classes ) {
		$sidebar_layout       = blogpress_get_layout();
		$navigation_location  = blogpress_get_navigation_location();
		$navigation_alignment = blogpress_get_option( 'nav_alignment_setting' );
		$navigation_dropdown  = blogpress_get_option( 'nav_dropdown_type' );
		$header_alignment     = blogpress_get_option( 'header_alignment_setting' );
		$content_layout       = blogpress_get_option( 'content_layout_setting' );

		// These values all have defaults, but we like to be extra careful.
		$classes[] = ( $sidebar_layout ) ? $sidebar_layout : 'right-sidebar';
		$classes[] = ( $navigation_location ) ? $navigation_location : 'nav-below-header';
		$classes[] = ( $content_layout ) ? $content_layout : 'separate-containers';

		if ( 'enable' === blogpress_get_option( 'nav_search' ) ) {
			$classes[] = 'nav-search-enabled';
		}

		// Only necessary for nav before or after header.
		if ( 'nav-above-header' === $navigation_location ) {
			if ( 'center' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-center';
			} elseif ( 'right' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-right';
			} elseif ( 'left' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-left';
			}
		}

		if ( 'center' === $header_alignment ) {
			$classes[] = 'header-aligned-center';
		} elseif ( 'right' === $header_alignment ) {
			$classes[] = 'header-aligned-right';
		} elseif ( 'left' === $header_alignment ) {
			$classes[] = 'header-aligned-left';
		}

		if ( 'click' === $navigation_dropdown ) {
			$classes[] = 'dropdown-click';
			$classes[] = 'dropdown-click-menu-item';
		} elseif ( 'click-arrow' === $navigation_dropdown ) {
			$classes[] = 'dropdown-click-arrow';
			$classes[] = 'dropdown-click';
		} else {
			$classes[] = 'dropdown-hover';
		}

		if ( is_singular() ) {
			// Page builder container metabox option.
			// Used to be a single checkbox, hence the name/true value. Now it's a radio choice between full width and contained.
			$content_container = get_post_meta( get_the_ID(), '_blogpress-full-width-content', true );

			if ( $content_container ) {
				if ( 'true' === $content_container ) {
					$classes[] = 'full-width-content';
				}

				if ( 'contained' === $content_container ) {
					$classes[] = 'contained-content';
				}
			}

			if ( has_post_thumbnail() ) {
				$classes[] = 'featured-image-active';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_top_bar_classes' ) ) {
	/**
	 * Adds custom classes to the header.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_top_bar_classes( $classes ) {
		$classes[] = 'top-bar';

		if ( 'contained' === blogpress_get_option( 'top_bar_width' ) ) {
			$classes[] = 'grid-container';
		}

		$classes[] = 'top-bar-align-' . esc_attr( blogpress_get_option( 'top_bar_alignment' ) );

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_right_sidebar_classes' ) ) {
	/**
	 * Adds custom classes to the right sidebar.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_right_sidebar_classes( $classes ) {
		$classes[] = 'widget-area';
		$classes[] = 'sidebar';
		$classes[] = 'is-right-sidebar';

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_left_sidebar_classes' ) ) {
	/**
	 * Adds custom classes to the left sidebar.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_left_sidebar_classes( $classes ) {
		$classes[] = 'widget-area';
		$classes[] = 'sidebar';
		$classes[] = 'is-left-sidebar';

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_content_classes' ) ) {
	/**
	 * Adds custom classes to the content container.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_content_classes( $classes ) {
		$classes[] = 'content-area';

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_header_classes' ) ) {
	/**
	 * Adds custom classes to the header.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_header_classes( $classes ) {
		$classes[] = 'site-header';

		if ( 'contained-header' === blogpress_get_option( 'header_layout_setting' ) ) {
			$classes[] = 'grid-container';
		}

		if ( blogpress_has_inline_mobile_toggle() ) {
			$classes[] = 'has-inline-mobile-toggle';
		}

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_inside_header_classes' ) ) {
	/**
	 * Adds custom classes to inside the header.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_inside_header_classes( $classes ) {
		$classes[] = 'inside-header';

		if ( 'full-width' !== blogpress_get_option( 'header_inner_width' ) ) {
			$classes[] = 'grid-container';
		}

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_navigation_classes' ) ) {
	/**
	 * Adds custom classes to the navigation.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_navigation_classes( $classes ) {
		$classes[] = 'main-navigation';

		if ( 'contained-nav' === blogpress_get_option( 'nav_layout_setting' ) ) {
			$navigation_location = blogpress_get_navigation_location();

			if ( 'nav-float-right' !== $navigation_location && 'nav-float-left' !== $navigation_location ) {
				$classes[] = 'grid-container';
			}
		}

		$nav_alignment = blogpress_get_option( 'nav_alignment_setting' );

		if ( 'center' === $nav_alignment ) {
			$classes[] = 'nav-align-center';
		} elseif ( 'right' === $nav_alignment ) {
			$classes[] = 'nav-align-right';
		} elseif ( is_rtl() && 'left' === $nav_alignment ) {
			$classes[] = 'nav-align-left';
		}

		if ( blogpress_has_menu_bar_items() ) {
			$classes[] = 'has-menu-bar-items';
		}

		$submenu_direction = 'right';

		if ( 'left' === blogpress_get_option( 'nav_dropdown_direction' ) ) {
			$submenu_direction = 'left';
		}

		if ( 'nav-left-sidebar' === blogpress_get_navigation_location() ) {
			$submenu_direction = 'right';

			if ( 'both-right' === blogpress_get_layout() ) {
				$submenu_direction = 'left';
			}
		}

		if ( 'nav-right-sidebar' === blogpress_get_navigation_location() ) {
			$submenu_direction = 'left';

			if ( 'both-left' === blogpress_get_layout() ) {
				$submenu_direction = 'right';
			}
		}

		$classes[] = 'sub-menu-' . $submenu_direction;

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_inside_navigation_classes' ) ) {
	/**
	 * Adds custom classes to the inner navigation.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.3.41
	 */
	function blogpress_inside_navigation_classes( $classes ) {
		$classes[] = 'inside-navigation';

		if ( 'full-width' !== blogpress_get_option( 'nav_inner_width' ) ) {
			$classes[] = 'grid-container';
		}

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_menu_classes' ) ) {
	/**
	 * Adds custom classes to the menu.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_menu_classes( $classes ) {
		$classes[] = 'menu';
		$classes[] = 'sf-menu';

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_footer_classes' ) ) {
	/**
	 * Adds custom classes to the footer.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_footer_classes( $classes ) {
		$classes[] = 'site-footer';

		if ( 'contained-footer' === blogpress_get_option( 'footer_layout_setting' ) ) {
			$classes[] = 'grid-container';
		}

		if ( is_active_sidebar( 'footer-bar' ) ) {
			$classes[] = 'footer-bar-active';
			$classes[] = 'footer-bar-align-' . esc_attr( blogpress_get_option( 'footer_bar_alignment' ) );
		}

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_inside_footer_classes' ) ) {
	/**
	 * Adds custom classes to the footer.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_inside_footer_classes( $classes ) {
		$classes[] = 'footer-widgets-container';

		if ( 'full-width' !== blogpress_get_option( 'footer_inner_width' ) ) {
			$classes[] = 'grid-container';
		}

		return $classes;
	}
}

if ( ! function_exists( 'blogpress_main_classes' ) ) {
	/**
	 * Adds custom classes to the <main> element
	 *
	 * @param array $classes The existing classes.
	 * @since 1.0.0
	 */
	function blogpress_main_classes( $classes ) {
		$classes[] = 'site-main';

		return $classes;
	}
}

/**
 * Adds custom classes to the #page element
 *
 * @param array $classes The existing classes.
 * @since 3.0.0
 */
function blogpress_do_page_container_classes( $classes ) {
	$classes[] = 'site';
	$classes[] = 'grid-container';
	$classes[] = 'container';

	if ( blogpress_is_using_hatom() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}

/**
 * Adds custom classes to the comment author element
 *
 * @param array $classes The existing classes.
 * @since 3.0.0
 */
function blogpress_do_comment_author_classes( $classes ) {
	$classes[] = 'comment-author';

	if ( blogpress_is_using_hatom() ) {
		$classes[] = 'vcard';
	}

	return $classes;
}

if ( ! function_exists( 'blogpress_post_classes' ) ) {
	add_filter( 'post_class', 'blogpress_post_classes' );
	/**
	 * Adds custom classes to the <article> element.
	 * Remove .hentry class from pages to comply with structural data guidelines.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.3.39
	 */
	function blogpress_post_classes( $classes ) {
		if ( 'page' === get_post_type() || ! blogpress_is_using_hatom() ) {
			$classes = array_diff( $classes, array( 'hentry' ) );
		}

		return $classes;
	}
}
