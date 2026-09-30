<?php
/**
 * Navigation elements.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'webpress_navigation_position' ) ) {
	/**
	 * Build the navigation.
	 *
	 * @since 1.0.0
	 */
	function webpress_navigation_position() {
		webpress_do_header_mobile_menu_toggle();

		/**
		 * Fires before the primary navigation element is output.
		 *
		 * @since 1.0.0
		 */
		do_action( 'webpress_before_navigation' );
		?>
		<nav <?php webpress_do_attr( 'navigation' ); ?>>
			<div <?php webpress_do_attr( 'inside-navigation' ); ?>>
				<?php
				/**
				 * Fires inside the navigation container, before the menu.
				 *
				 * @since 1.0.0
				 */
				do_action( 'webpress_inside_navigation' );

				webpress_navigation_search();
				webpress_mobile_menu_search_icon();
				?>
				<button <?php webpress_do_attr( 'menu-toggle' ); ?>>
					<?php

					webpress_do_svg_icon( 'menu-bars', true );

					$mobile_menu_label = __( 'Menu', 'webpress' );

					/** This filter is documented in inc/structure/navigation.php */
					$mobile_menu_label = apply_filters( 'webpress_mobile_menu_label', $mobile_menu_label );

					if ( $mobile_menu_label ) {
						printf(
							'<span class="mobile-menu">%s</span>',
							$mobile_menu_label // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML allowed in filter.
						);
					} else {
						printf(
							'<span class="screen-reader-text">%s</span>',
							esc_html__( 'Menu', 'webpress' )
						);
					}
					?>
				</button>
				<?php
				/**
				 * Fires immediately after the mobile menu toggle button.
				 *
				 * @since 1.0.0
				 */
				do_action( 'webpress_after_mobile_menu_button' );

				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container' => 'div',
						'container_class' => 'main-nav',
						'container_id' => 'primary-menu',
						'menu_class' => '',
						'fallback_cb' => 'webpress_menu_fallback',
						'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', webpress_get_element_classes( 'menu' ) ) . '">%3$s</ul>',
					)
				);

				webpress_do_menu_bar_item_container();
				?>
			</div>
		</nav>
		<?php
		/**
		 * Fires after the primary navigation element is output.
		 *
		 * @since 1.0.0
		 */
		do_action( 'webpress_after_navigation' );
	}
}

if ( ! function_exists( 'webpress_do_header_mobile_menu_toggle' ) ) {
	/**
	 * Build the mobile menu toggle in the header.
	 *
	 * @since 1.0.0
	 */
	function webpress_do_header_mobile_menu_toggle() {
		if ( ! webpress_has_inline_mobile_toggle() ) {
			return;
		}
		?>
		<nav <?php webpress_do_attr( 'mobile-menu-control-wrapper' ); ?>>
			<?php
			webpress_do_menu_bar_item_container();
			?>
			<button <?php webpress_do_attr( 'menu-toggle', array( 'data-nav' => 'site-navigation' ) ); ?>>
				<?php

				webpress_do_svg_icon( 'menu-bars', true );

				$mobile_menu_label = __( 'Menu', 'webpress' );

				if ( 'nav-float-right' === webpress_get_navigation_location() || 'nav-float-left' === webpress_get_navigation_location() ) {
					$mobile_menu_label = '';
				}

				/**
				 * Filters the visible label on the mobile menu toggle button.
				 *
				 * Return an empty string to show only the icon, with the label moved
				 * into a screen-reader-only span.
				 *
				 * @since 1.0.0
				 *
				 * @param string $mobile_menu_label The button label. HTML is allowed.
				 * @return string The label to display.
				 */
				$mobile_menu_label = apply_filters( 'webpress_mobile_menu_label', $mobile_menu_label );

				if ( $mobile_menu_label ) {
					printf(
						'<span class="mobile-menu">%s</span>',
						$mobile_menu_label // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML allowed in filter.
					);
				} else {
					printf(
						'<span class="screen-reader-text">%s</span>',
						esc_html__( 'Menu', 'webpress' )
					);
				}
				?>
			</button>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'webpress_menu_fallback' ) ) {
	/**
	 * Menu fallback.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Existing menu args.
	 */
	function webpress_menu_fallback( $args ) {
		$webpress_settings = wp_parse_args(
			get_option( 'webpress_settings', array() ),
			webpress_get_defaults()
		);
		?>
		<div id="primary-menu" class="main-nav">
			<ul <?php webpress_do_element_classes( 'menu' ); ?>>
				<?php
				$args = array(
					'sort_column' => 'menu_order',
					'title_li' => '',
					'walker' => new WebPress_Page_Walker(),
				);

				wp_list_pages( $args );
				?>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'webpress_add_navigation_after_header' ) ) {
	/**
	 * Output the navigation below the header, if that is the chosen location.
	 *
	 * Each navigation location has its own function rather than one shared
	 * callback, so a child theme can un-hook or re-prioritise a single
	 * location without affecting the others.
	 *
	 * @since 1.0.0
	 */
	function webpress_add_navigation_after_header() {
		if ( 'nav-below-header' === webpress_get_navigation_location() ) {
			webpress_navigation_position();
		}
	}
}

if ( ! function_exists( 'webpress_add_navigation_before_header' ) ) {
	/**
	 * Output the navigation above the header, if that is the chosen location.
	 *
	 * Each navigation location has its own function rather than one shared
	 * callback, so a child theme can un-hook or re-prioritise a single
	 * location without affecting the others.
	 *
	 * @since 1.0.0
	 */
	function webpress_add_navigation_before_header() {
		if ( 'nav-above-header' === webpress_get_navigation_location() ) {
			webpress_navigation_position();
		}
	}
}

if ( ! function_exists( 'webpress_add_navigation_float_right' ) ) {
	/**
	 * Output the navigation floated beside the site branding, if that is the
	 * chosen location. Covers both the float-right and float-left settings.
	 *
	 * Each navigation location has its own function rather than one shared
	 * callback, so a child theme can un-hook or re-prioritise a single
	 * location without affecting the others.
	 *
	 * @since 1.0.0
	 */
	function webpress_add_navigation_float_right() {
		if ( 'nav-float-right' === webpress_get_navigation_location() || 'nav-float-left' === webpress_get_navigation_location() ) {
			webpress_navigation_position();
		}
	}
}

if ( ! function_exists( 'webpress_add_navigation_before_right_sidebar' ) ) {
	/**
	 * Output the navigation inside the right sidebar, if that is the chosen
	 * location.
	 *
	 * Each navigation location has its own function rather than one shared
	 * callback, so a child theme can un-hook or re-prioritise a single
	 * location without affecting the others.
	 *
	 * @since 1.0.0
	 */
	function webpress_add_navigation_before_right_sidebar() {
		if ( 'nav-right-sidebar' === webpress_get_navigation_location() ) {
			echo '<div class="webpress-sidebar-nav">';
				webpress_navigation_position();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'webpress_add_navigation_before_left_sidebar' ) ) {
	/**
	 * Output the navigation inside the left sidebar, if that is the chosen
	 * location.
	 *
	 * Each navigation location has its own function rather than one shared
	 * callback, so a child theme can un-hook or re-prioritise a single
	 * location without affecting the others.
	 *
	 * @since 1.0.0
	 */
	function webpress_add_navigation_before_left_sidebar() {
		if ( 'nav-left-sidebar' === webpress_get_navigation_location() ) {
			echo '<div class="webpress-sidebar-nav">';
				webpress_navigation_position();
			echo '</div>';
		}
	}
}

if ( ! class_exists( 'WebPress_Page_Walker' ) && class_exists( 'Walker_Page' ) ) {
	/**
	 * Add current-menu-item to the current item if no theme location is set
	 * This means we don't have to duplicate CSS properties for current_page_item and current-menu-item
	 *
	 * @since 1.0.0
	 */
	class WebPress_Page_Walker extends Walker_Page {
		/**
		 * Start the element output.
		 *
		 * @param string  $output       Used to append additional content. Passed by reference.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Depth of page. Used for padding.
		 * @param array   $args         An array of arguments.
		 * @param int     $current_page ID of the current page.
		 */
		public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase -- Signature inherited from Walker_Page.
			$css_class = array( 'page_item', 'page-item-' . $page->ID );
			$button = '';

			if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
				$css_class[] = 'menu-item-has-children';
				$icon = webpress_get_svg_icon( 'arrow' );
				$button = '<span role="presentation" class="dropdown-menu-toggle">' . $icon . '</span>';
			}

			if ( ! empty( $current_page ) ) {
				$_current_page = get_post( $current_page );
				if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
					$css_class[] = 'current-menu-ancestor';
				}

				if ( $page->ID == $current_page ) { // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual -- $current_page may be a numeric string; loose compare is intentional.
					$css_class[] = 'current-menu-item';
				} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) { // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual -- IDs may be numeric strings; loose compare is intentional.
					$css_class[] = 'current-menu-parent';
				}
			} elseif ( $page->ID == get_option( 'page_for_posts' ) ) { // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual,WordPress.PHP.YodaConditions.NotYoda -- Option returns a numeric string; loose compare is intentional.
				$css_class[] = 'current-menu-parent';
			}

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core filter name.
			$css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

			$args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
			$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

			$output .= sprintf(
				'<li class="%s"><a href="%s">%s%s%s%s</a>',
				$css_classes,
				get_permalink( $page->ID ),
				$args['link_before'],
				apply_filters( 'the_title', $page->post_title, $page->ID ), // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core filter name.
				$args['link_after'],
				$button
			);
		}
	}
}

if ( ! function_exists( 'webpress_dropdown_icon_to_menu_link' ) ) {
	add_filter( 'nav_menu_item_title', 'webpress_dropdown_icon_to_menu_link', 10, 4 );
	/**
	 * Add dropdown icon if menu item has children.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $title The menu item title.
	 * @param WP_Post  $item All of our menu item data.
	 * @param stdClass $args All of our menu item args.
	 * @param int      $depth Depth of menu item.
	 * @return string The menu item.
	 */
	function webpress_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
		$role        = 'presentation';
		$tabindex    = '';
		$aria_label  = '';

		if ( 'click-arrow' === webpress_get_option( 'nav_dropdown_type' ) ) {
			$role = 'button';
			$tabindex = ' tabindex="0"';
			$aria_label = sprintf(
				' aria-label="%s"',
				esc_attr__( 'Open Sub-Menu', 'webpress' )
			);
		}

		if ( isset( $args->container_class ) && 'main-nav' === $args->container_class ) {
			foreach ( $item->classes as $value ) {
				if ( 'menu-item-has-children' === $value ) {
					$arrow_direction = 'down';

					if ( 'primary' === $args->theme_location ) {
						if ( 0 !== $depth ) {
							$arrow_direction = 'right';

							if ( 'left' === webpress_get_option( 'nav_dropdown_direction' ) ) {
								$arrow_direction = 'left';
							}
						}

						if ( 'nav-left-sidebar' === webpress_get_navigation_location() ) {
							$arrow_direction = 'right';

							if ( 'both-right' === webpress_get_layout() ) {
								$arrow_direction = 'left';
							}
						}

						if ( 'nav-right-sidebar' === webpress_get_navigation_location() ) {
							$arrow_direction = 'left';

							if ( 'both-left' === webpress_get_layout() ) {
								$arrow_direction = 'right';
							}
						}

						if ( 'hover' !== webpress_get_option( 'nav_dropdown_type' ) ) {
							$arrow_direction = 'down';
						}
					}

					/**
					 * Filters the direction of the dropdown arrow on a menu item.
					 *
					 * @since 1.0.0
					 *
					 * @param string $arrow_direction One of 'down', 'right' or 'left'.
					 * @param int    $depth           Depth of the current menu item.
					 * @param WP_Post $item           The current menu item.
					 * @return string The arrow direction to use.
					 */
					$arrow_direction = apply_filters( 'webpress_dropdown_arrow_direction', $arrow_direction, $depth, $item );

					if ( 'down' === $arrow_direction ) {
						$arrow_direction = '';
					} else {
						$arrow_direction = '-' . $arrow_direction;
					}

					$icon = webpress_get_svg_icon( 'arrow' . $arrow_direction );
					$title = $title . '<span role="' . $role . '" class="dropdown-menu-toggle"' . $tabindex . $aria_label . '>' . $icon . '</span>';
				}
			}
		}

		return $title;
	}
}

add_filter( 'nav_menu_link_attributes', 'webpress_set_menu_item_link_attributes', 10, 4 );
/**
 * Add attributes to the menu item link when using the Click - Menu Item option.
 *
 * @since 1.0.0
 *
 * @param array    $atts The menu item attributes.
 * @param WP_Post  $item The current menu item.
 * @param stdClass $args The menu item args.
 * @param int      $depth The depth of the menu item.
 * @return array The menu item attributes.
 */
function webpress_set_menu_item_link_attributes( $atts, $item, $args, $depth ) {
	if ( ! isset( $args->container_class ) || 'main-nav' !== $args->container_class ) {
		return $atts;
	}

	if ( 'click' !== webpress_get_option( 'nav_dropdown_type' ) ) {
		return $atts;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$atts['role'] = 'button';
		$atts['aria-expanded'] = 'false';
		$atts['aria-haspopup'] = 'true';
		$atts['aria-label'] = esc_attr__( 'Open Sub-Menu', 'webpress' );
	}

	return $atts;
}

if ( ! function_exists( 'webpress_navigation_search' ) ) {
	/**
	 * Add the search bar to the navigation.
	 *
	 * @since 1.0.0
	 */
	function webpress_navigation_search() {
		$webpress_settings = wp_parse_args(
			get_option( 'webpress_settings', array() ),
			webpress_get_defaults()
		);

		if ( 'enable' !== $webpress_settings['nav_search'] ) {
			return;
		}

		echo sprintf(
			'<form method="get" class="search-form navigation-search" action="%1$s">
				<input type="search" class="search-field" value="%2$s" name="s" title="%3$s" />
			</form>',
			esc_url( home_url( '/' ) ),
			esc_attr( get_search_query() ),
			esc_attr_x( 'Search', 'label', 'webpress' )
		);
	}
}

if ( ! function_exists( 'webpress_do_menu_bar_item_container' ) ) {
	/**
	 * Add a container for menu bar items.
	 *
	 * @since 1.0.0
	 */
	function webpress_do_menu_bar_item_container() {
		if ( webpress_has_menu_bar_items() ) {
			echo '<div class="menu-bar-items">';
				webpress_do_navigation_search_button();
				webpress_do_search_modal_trigger();

				/**
				 * Fires inside the menu bar items container, after the built-in items.
				 *
				 * Does not fire when no menu bar items are enabled, as the container
				 * itself is not output in that case.
				 *
				 * @since 1.0.0
				 */
				do_action( 'webpress_menu_bar_items' );
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'webpress_do_navigation_search_button' ) ) {
	/**
	 * Add the navigation search button.
	 *
	 * @since 1.0.0
	 */
	function webpress_do_navigation_search_button() {
		if ( 'enable' !== webpress_get_option( 'nav_search' ) ) {
			return;
		}

		$search_item = sprintf(
			'<span class="menu-bar-item search-item"><a aria-label="%1$s" href="#">%2$s</a></span>',
			esc_attr__( 'Open Search Bar', 'webpress' ),
			webpress_get_svg_icon( 'search', true ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
		);

		echo $search_item; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- No escaping needed.
	}
}

if ( ! function_exists( 'webpress_menu_search_icon' ) ) {
	add_filter( 'wp_nav_menu_items', 'webpress_menu_search_icon', 10, 2 );
	/**
	 * Add search icon to primary menu if set.
	 * Only used if using old float system.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $nav The HTML list content for the menu items.
	 * @param stdClass $args An object containing wp_nav_menu() arguments.
	 * @return string The search icon menu item.
	 */
	function webpress_menu_search_icon( $nav, $args ) {
		$webpress_settings = wp_parse_args(
			get_option( 'webpress_settings', array() ),
			webpress_get_defaults()
		);

		return $nav;

		// If the search icon isn't enabled, return the regular nav.
		if ( 'enable' !== $webpress_settings['nav_search'] ) {
			return $nav;
		}

		// If our primary menu is set, add the search icon.
		if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
			$search_item = sprintf(
				'<li class="search-item menu-item-align-right"><a aria-label="%1$s" href="#">%2$s</a></li>',
				esc_attr__( 'Open Search Bar', 'webpress' ),
				webpress_get_svg_icon( 'search', true ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
			);

			return $nav . $search_item;
		}

		// Our primary menu isn't set, return the regular nav.
		// In this case, the search icon is added to the webpress_menu_fallback() function in navigation.php.
		return $nav;
	}
}

if ( ! function_exists( 'webpress_mobile_menu_search_icon' ) ) {
	/**
	 * Add search icon to mobile menu bar.
	 * Only used if using old float system.
	 *
	 * @since 1.0.0
	 */
	function webpress_mobile_menu_search_icon() {
		$webpress_settings = wp_parse_args(
			get_option( 'webpress_settings', array() ),
			webpress_get_defaults()
		);

		// If the search icon isn't enabled, return the regular nav.
		if ( 'enable' !== $webpress_settings['nav_search'] ) {
			return;
		}

		return;

		?>
		<div class="mobile-bar-items">
			<?php?>
			<span class="search-item">
				<a aria-label="<?php esc_attr_e( 'Open Search Bar', 'webpress' ); ?>" href="#">
					<?php webpress_do_svg_icon( 'search', true ); ?>
				</a>
			</span>
		</div>
		<?php
	}
}

add_action( 'wp_footer', 'webpress_clone_sidebar_navigation' );
/**
 * Clone our sidebar navigation and place it below the header.
 * This places our mobile menu in a more user-friendly location.
 *
 * This must run before menu.js, which is enqueued in the footer and therefore
 * printed by wp_print_footer_scripts() on wp_footer at priority 20. Printing
 * here at the default priority 10 guarantees the clone exists first.
 *
 * @since 1.0.0
 */
function webpress_clone_sidebar_navigation() {
	if ( 'nav-left-sidebar' !== webpress_get_navigation_location() && 'nav-right-sidebar' !== webpress_get_navigation_location() ) {
		return;
	}

	$script = sprintf(
		'var target, nav, clone;
		nav = document.getElementById( "site-navigation" );
		if ( nav ) {
			clone = nav.cloneNode( true );
			clone.className += " sidebar-nav-mobile";
			clone.setAttribute( "aria-label", %s );
			target = document.getElementById( "masthead" );
			if ( target ) {
				target.insertAdjacentHTML( "afterend", clone.outerHTML );
			} else {
				document.body.insertAdjacentHTML( "afterbegin", clone.outerHTML );
			}
		}',
		wp_json_encode( __( 'Mobile Menu', 'webpress' ) )
	);

	wp_print_inline_script_tag(
		$script,
		array(
			'id' => 'webpress-clone-sidebar-navigation',
		)
	);
}
