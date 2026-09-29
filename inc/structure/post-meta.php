<?php
/**
 * Post meta elements.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'webpress_content_nav' ) ) {
	/**
	 * Display navigation to next/previous pages when applicable.
	 *
	 * @since 1.0.0
	 *
	 * @param string $nav_id The id of our navigation.
	 */
	function webpress_content_nav( $nav_id ) {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}
		?>
		<nav <?php webpress_do_attr( 'post-navigation', array( 'id' => esc_attr( $nav_id ) ) ); ?>>
			<?php
			if ( is_single() ) : // navigation links for single posts.

				$post_navigation_args = array(
					'previous_format' => '<div class="nav-previous">' . webpress_get_svg_icon( 'arrow-left' ) . '<span class="prev">%link</span></div>',
					'next_format' => '<div class="nav-next">' . webpress_get_svg_icon( 'arrow-right' ) . '<span class="next">%link</span></div>',
					'link' => '%title',
					'in_same_term' => false,
					'excluded_terms' => '',
					'taxonomy' => 'category',
				);

				previous_post_link(
					$post_navigation_args['previous_format'],
					$post_navigation_args['link'],
					$post_navigation_args['in_same_term'],
					$post_navigation_args['excluded_terms'],
					$post_navigation_args['taxonomy']
				);

				next_post_link(
					$post_navigation_args['next_format'],
					$post_navigation_args['link'],
					$post_navigation_args['in_same_term'],
					$post_navigation_args['excluded_terms'],
					$post_navigation_args['taxonomy']
				);

			elseif ( is_home() || is_archive() || is_search() ) : // navigation links for home, archive, and search pages.

				if ( get_next_posts_link() ) :
					?>
					<div class="nav-previous">
						<?php webpress_do_svg_icon( 'arrow' ); ?>
						<span class="prev" title="<?php esc_attr_e( 'Previous', 'webpress' ); ?>"><?php next_posts_link( __( 'Older posts', 'webpress' ) ); ?></span>
					</div>
					<?php
				endif;

				if ( get_previous_posts_link() ) :
					?>
					<div class="nav-next">
						<?php webpress_do_svg_icon( 'arrow' ); ?>
						<span class="next" title="<?php esc_attr_e( 'Next', 'webpress' ); ?>"><?php previous_posts_link( __( 'Newer posts', 'webpress' ) ); ?></span>
					</div>
					<?php
				endif;

				if ( function_exists( 'the_posts_pagination' ) ) {
					the_posts_pagination(
						array(
							'mid_size' => 1,
							'prev_text' => sprintf(
								/* translators: left arrow */
								__( '%s Previous', 'webpress' ),
								'<span aria-hidden="true">&larr;</span>'
							),
							'next_text' => sprintf(
								/* translators: right arrow */
								__( 'Next %s', 'webpress' ),
								'<span aria-hidden="true">&rarr;</span>'
							),
							'before_page_number' => sprintf(
								'<span class="screen-reader-text">%s</span>',
								_x( 'Page', 'prepends the pagination page number for screen readers', 'webpress' )
							),
						)
					);
				}

			endif;
			?>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'webpress_modify_posts_pagination_template' ) ) {
	add_filter( 'navigation_markup_template', 'webpress_modify_posts_pagination_template', 10, 2 );
	/**
	 * Remove the container and screen reader text from the_posts_pagination()
	 * We add this in ourselves in webpress_content_nav()
	 *
	 * @since 1.0.0
	 *
	 * @param string $template The default template.
	 * @param string $class The class passed by the calling function.
	 * @return string The HTML for the post navigation.
	 */
	function webpress_modify_posts_pagination_template( $template, $class ) {
		if ( ! empty( $class ) && false !== strpos( $class, 'pagination' ) ) {
			$template = '<div class="nav-links">%3$s</div>';
		}

		return $template;
	}
}

if ( ! function_exists( 'webpress_do_post_meta_item' ) ) {
	/**
	 * Output requested post meta.
	 *
	 * @since 1.0.0
	 *
	 * @param string $item The post meta item we're requesting.
	 */
	function webpress_do_post_meta_item( $item ) {
		if ( 'date' === $item ) {
			$time_string = '<time class="entry-date published" datetime="%1$s"%5$s>%2$s</time>';

			$updated_time = get_the_modified_time( 'U' );
			$published_time = get_the_time( 'U' ) + 1800;
			$schema_type = webpress_get_schema_type();

			if ( $updated_time > $published_time ) {
				$time_string = '<time class="updated" datetime="%3$s"%6$s>%4$s</time>' . $time_string;
			}

			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() ),
				'microdata' === $schema_type ? ' itemprop="datePublished"' : '',
				'microdata' === $schema_type ? ' itemprop="dateModified"' : ''
			);

			$posted_on = '<span class="posted-on">%1$s%4$s</span> ';

			echo sprintf(
				$posted_on, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- webpress_do_post_meta_prefix() returns theme-built markup.
				webpress_do_post_meta_prefix( '', 'date' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $time_string is assembled from esc_attr()/esc_html() parts above.
			);
		}

		if ( 'author' === $item ) {
			$schema_type = webpress_get_schema_type();

			$byline = '<span class="byline">%1$s<span class="author%8$s" %5$s><a class="url fn n" href="%2$s" title="%3$s" rel="author"%6$s><span class="author-name"%7$s>%4$s</span></a></span></span> ';

			echo sprintf(
				$byline, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
				webpress_do_post_meta_prefix( '', 'author' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- webpress_do_post_meta_prefix() returns theme-built markup.
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				/* translators: 1: Author name */
				esc_attr( sprintf( __( 'View all posts by %s', 'webpress' ), get_the_author() ) ),
				esc_html( get_the_author() ),
				webpress_get_microdata( 'post-author' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- webpress_get_microdata() returns a theme-built attribute string.
				'microdata' === $schema_type ? ' itemprop="url"' : '',
				'microdata' === $schema_type ? ' itemprop="name"' : '',
				webpress_is_using_hatom() ? ' vcard' : ''
			);
		}

		if ( 'categories' === $item ) {
			$term_separator = _x( ', ', 'Used between list items, there is a space after the comma.', 'webpress' );
			$categories_list = get_the_category_list( $term_separator );

			if ( $categories_list ) {
				echo sprintf(
					'<span class="cat-links">%3$s<span class="screen-reader-text">%1$s </span>%2$s</span> ',
					esc_html_x( 'Categories', 'Used before category names.', 'webpress' ),
					$categories_list, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
					webpress_do_post_meta_prefix( '', 'categories' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_the_category_list() returns core-escaped markup.
				);
			}
		}

		if ( 'tags' === $item ) {
			$term_separator = _x( ', ', 'Used between list items, there is a space after the comma.', 'webpress' );
			$tags_list = get_the_tag_list( '', $term_separator );

			if ( $tags_list ) {
				echo sprintf(
					'<span class="tags-links">%3$s<span class="screen-reader-text">%1$s </span>%2$s</span> ',
					esc_html_x( 'Tags', 'Used before tag names.', 'webpress' ),
					$tags_list, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
					webpress_do_post_meta_prefix( '', 'tags' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_the_tag_list() returns core-escaped markup.
				);
			}
		}

		if ( 'comments-link' === $item ) {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="comments-link">';
					echo webpress_do_post_meta_prefix( '', 'comments-link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					comments_popup_link( __( 'Leave a comment', 'webpress' ), __( '1 Comment', 'webpress' ), __( '% Comments', 'webpress' ) );
				echo '</span> ';
			}
		}

		if ( 'post-navigation' === $item && is_single() ) {
			webpress_content_nav( 'nav-below' );
		}
	}
}

if ( ! function_exists( 'webpress_do_post_meta_prefix' ) ) {
	/**
	 * Add svg icons or text to our post meta output.
	 *
	 * @since 1.0.0
	 * @param string $output The existing output.
	 * @param string $item The item to target.
	 */
	function webpress_do_post_meta_prefix( $output, $item ) {
		if ( 'author' === $item ) {
			$output = __( 'by', 'webpress' ) . ' ';
		}

		if ( 'categories' === $item ) {
			$output = webpress_get_svg_icon( 'categories' );
		}

		if ( 'tags' === $item ) {
			$output = webpress_get_svg_icon( 'tags' );
		}

		if ( 'comments-link' === $item ) {
			$output = webpress_get_svg_icon( 'comments' );
		}

		return $output;
	}
}

/**
 * Remove post meta items that shouldn't display in the current context.
 *
 * @since 1.0.0
 * @param array $items The post meta items.
 */
function webpress_disable_post_meta_items( $items ) {
	if ( is_singular() ) {
		$items = array_diff( $items, array( 'comments-link' ) );
	}

	return $items;
}

if ( ! function_exists( 'webpress_get_header_entry_meta_items' ) ) {
	/**
	 * Get the post meta items in the header entry meta.
	 *
	 * @since 1.0.0
	 */
	function webpress_get_header_entry_meta_items() {
		$items = array(
			'date',
			'author',
		);

		// Disable post meta items based on their individual filters.
		$items = webpress_disable_post_meta_items( $items );

		return $items;
	}
}

if ( ! function_exists( 'webpress_get_footer_entry_meta_items' ) ) {
	/**
	 * Get the post meta items in the footer entry meta.
	 *
	 * @since 1.0.0
	 */
	function webpress_get_footer_entry_meta_items() {
		$items = array(
			'categories',
			'tags',
			'comments-link',
			'post-navigation',
		);

		if ( ! is_singular() ) {
			$items = array_diff( (array) $items, array( 'post-navigation' ) );
		}

		// Disable post meta items based on their individual filters.
		$items = webpress_disable_post_meta_items( $items );

		return $items;
	}
}

if ( ! function_exists( 'webpress_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 */
	function webpress_posted_on() {
		$items = webpress_get_header_entry_meta_items();

		foreach ( $items as $item ) {
			webpress_do_post_meta_item( $item );
		}
	}
}

if ( ! function_exists( 'webpress_entry_meta' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * @since 1.0.0
	 */
	function webpress_entry_meta() {
		$items = webpress_get_footer_entry_meta_items();

		foreach ( $items as $item ) {
			webpress_do_post_meta_item( $item );
		}
	}
}

if ( ! function_exists( 'webpress_excerpt_more' ) ) {
	add_filter( 'excerpt_more', 'webpress_excerpt_more' );
	/**
	 * Prints the read more HTML to post excerpts.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link.
	 */
	function webpress_excerpt_more( $more ) {
		return sprintf(
			' ... <a title="%1$s" class="read-more" href="%2$s" aria-label="%4$s">%3$s</a>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) ),
			webpress_get_read_more_text(),
			webpress_get_read_more_aria_label()
		);
	}
}

if ( ! function_exists( 'webpress_content_more' ) ) {
	add_filter( 'the_content_more_link', 'webpress_content_more' );
	/**
	 * Prints the read more HTML to post content using the more tag.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link
	 */
	function webpress_content_more( $more ) {
		return sprintf(
			'<p class="read-more-container"><a title="%1$s" class="read-more content-read-more" href="%2$s" aria-label="%4$s">%3$s</a></p>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) . '#more-' . get_the_ID() ),
			webpress_get_read_more_text(),
			webpress_get_read_more_aria_label()
		);
	}
}

add_action( 'wp', 'webpress_add_post_meta', 5 );
/**
 * Add our post meta items to the page.
 *
 * @since 1.0.0
 */
function webpress_add_post_meta() {
	$header_items = webpress_get_header_entry_meta_items();

	$header_post_types = array(
		'post',
	);

	if ( in_array( get_post_type(), $header_post_types ) && ! empty( $header_items ) ) {
	}

	$footer_items = webpress_get_footer_entry_meta_items();

	$footer_post_types = array(
		'post',
	);

	if ( in_array( get_post_type(), $footer_post_types ) && ! empty( $footer_items ) ) {
	}
}

if ( ! function_exists( 'webpress_post_meta' ) ) {
	/**
	 * Build the post meta.
	 *
	 * @since 1.0.0
	 */
	function webpress_post_meta() {
		?>
		<div class="entry-meta">
			<?php webpress_posted_on(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'webpress_footer_meta' ) ) {
	/**
	 * Build the footer post meta.
	 *
	 * @since 1.0.0
	 */
	function webpress_footer_meta() {
		?>
		<footer <?php webpress_do_attr( 'footer-entry-meta' ); ?>>
			<?php webpress_entry_meta(); ?>
		</footer>
		<?php
	}
}

if ( ! function_exists( 'webpress_do_post_navigation' ) ) {
	/**
	 * Add our post navigation after post loops.
	 *
	 * @since 1.0.0
	 * @param string $template The template of the current action.
	 */
	function webpress_do_post_navigation( $template ) {
		$templates = array(
			'index',
			'archive',
			'search',
		);

		/**
		 * Filters whether the older/newer posts navigation is shown below a loop.
		 *
		 * @since 1.0.0
		 *
		 * @param bool   $show     Whether to show the post navigation. Default true.
		 * @param string $template The template calling the navigation, e.g. 'archive'.
		 * @return bool Whether to show the post navigation.
		 */
		if ( in_array( $template, $templates ) && apply_filters( 'webpress_show_post_navigation', true, $template ) ) {
			webpress_content_nav( 'nav-below' );
		}
	}
}

if ( ! function_exists( 'webpress_get_read_more_text' ) ) {
	/**
	 * Returns the read more text for our posts.
	 *
	 * @since 1.0.0
	 */
	function webpress_get_read_more_text() {
		return __( 'Read more', 'webpress' );
	}
}

if ( ! function_exists( 'webpress_get_read_more_aria_label' ) ) {
	/**
	 * Returns the read more `aria-label` for our posts.
	 *
	 * @since 1.0.0
	 */
	function webpress_get_read_more_aria_label() {
		return sprintf(
			/* translators: Aria-label describing the read more button */
			_x( 'Read more about %s', 'read more about post title', 'webpress' ),
			the_title_attribute( 'echo=0' )
		);
	}
}
