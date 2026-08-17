<?php
/**
 * Post meta elements.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'blogpress_content_nav' ) ) {
	/**
	 * Display navigation to next/previous pages when applicable.
	 *
	 * @since 1.0.0
	 *
	 * @param string $nav_id The id of our navigation.
	 */
	function blogpress_content_nav( $nav_id ) {
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
		<nav <?php blogpress_do_attr( 'post-navigation', array( 'id' => esc_attr( $nav_id ) ) ); ?>>
			<?php
			if ( is_single() ) : // navigation links for single posts.

				$post_navigation_args = array(
					'previous_format' => '<div class="nav-previous">' . blogpress_get_svg_icon( 'arrow-left' ) . '<span class="prev">%link</span></div>',
					'next_format' => '<div class="nav-next">' . blogpress_get_svg_icon( 'arrow-right' ) . '<span class="next">%link</span></div>',
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
						<?php blogpress_do_svg_icon( 'arrow' ); ?>
						<span class="prev" title="<?php esc_attr_e( 'Previous', 'blogpress' ); ?>"><?php next_posts_link( __( 'Older posts', 'blogpress' ) ); ?></span>
					</div>
					<?php
				endif;

				if ( get_previous_posts_link() ) :
					?>
					<div class="nav-next">
						<?php blogpress_do_svg_icon( 'arrow' ); ?>
						<span class="next" title="<?php esc_attr_e( 'Next', 'blogpress' ); ?>"><?php previous_posts_link( __( 'Newer posts', 'blogpress' ) ); ?></span>
					</div>
					<?php
				endif;

				if ( function_exists( 'the_posts_pagination' ) ) {
					the_posts_pagination(
						array(
							'mid_size' => 1,
							'prev_text' => sprintf(
								/* translators: left arrow */
								__( '%s Previous', 'blogpress' ),
								'<span aria-hidden="true">&larr;</span>'
							),
							'next_text' => sprintf(
								/* translators: right arrow */
								__( 'Next %s', 'blogpress' ),
								'<span aria-hidden="true">&rarr;</span>'
							),
							'before_page_number' => sprintf(
								'<span class="screen-reader-text">%s</span>',
								_x( 'Page', 'prepends the pagination page number for screen readers', 'blogpress' )
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

if ( ! function_exists( 'blogpress_modify_posts_pagination_template' ) ) {
	add_filter( 'navigation_markup_template', 'blogpress_modify_posts_pagination_template', 10, 2 );
	/**
	 * Remove the container and screen reader text from the_posts_pagination()
	 * We add this in ourselves in blogpress_content_nav()
	 *
	 * @since 1.0.0
	 *
	 * @param string $template The default template.
	 * @param string $class The class passed by the calling function.
	 * @return string The HTML for the post navigation.
	 */
	function blogpress_modify_posts_pagination_template( $template, $class ) {
		if ( ! empty( $class ) && false !== strpos( $class, 'pagination' ) ) {
			$template = '<div class="nav-links">%3$s</div>';
		}

		return $template;
	}
}

/**
 * Output requested post meta.
 *
 * @since 1.0.0
 *
 * @param string $item The post meta item we're requesting.
 */
function blogpress_do_post_meta_item( $item ) {
	if ( 'date' === $item ) {
		$time_string = '<time class="entry-date published" datetime="%1$s"%5$s>%2$s</time>';

		$updated_time = get_the_modified_time( 'U' );
		$published_time = get_the_time( 'U' ) + 1800;
		$schema_type = blogpress_get_schema_type();

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
			$posted_on, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- blogpress_do_post_meta_prefix() returns theme-built markup.
			blogpress_do_post_meta_prefix( '', 'date' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $time_string is assembled from esc_attr()/esc_html() parts above.
		);
	}

	if ( 'author' === $item ) {
		$schema_type = blogpress_get_schema_type();

		$byline = '<span class="byline">%1$s<span class="author%8$s" %5$s><a class="url fn n" href="%2$s" title="%3$s" rel="author"%6$s><span class="author-name"%7$s>%4$s</span></a></span></span> ';

		echo sprintf(
			$byline, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
			blogpress_do_post_meta_prefix( '', 'author' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- blogpress_do_post_meta_prefix() returns theme-built markup.
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			/* translators: 1: Author name */
			esc_attr( sprintf( __( 'View all posts by %s', 'blogpress' ), get_the_author() ) ),
			esc_html( get_the_author() ),
			blogpress_get_microdata( 'post-author' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- blogpress_get_microdata() returns a theme-built attribute string.
			'microdata' === $schema_type ? ' itemprop="url"' : '',
			'microdata' === $schema_type ? ' itemprop="name"' : '',
			blogpress_is_using_hatom() ? ' vcard' : ''
		);
	}

	if ( 'categories' === $item ) {
		$term_separator = _x( ', ', 'Used between list items, there is a space after the comma.', 'blogpress' );
		$categories_list = get_the_category_list( $term_separator );

		if ( $categories_list ) {
			echo sprintf(
				'<span class="cat-links">%3$s<span class="screen-reader-text">%1$s </span>%2$s</span> ',
				esc_html_x( 'Categories', 'Used before category names.', 'blogpress' ),
				$categories_list, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
				blogpress_do_post_meta_prefix( '', 'categories' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_the_category_list() returns core-escaped markup.
			);
		}
	}

	if ( 'tags' === $item ) {
		$term_separator = _x( ', ', 'Used between list items, there is a space after the comma.', 'blogpress' );
		$tags_list = get_the_tag_list( '', $term_separator );

		if ( $tags_list ) {
			echo sprintf(
				'<span class="tags-links">%3$s<span class="screen-reader-text">%1$s </span>%2$s</span> ',
				esc_html_x( 'Tags', 'Used before tag names.', 'blogpress' ),
				$tags_list, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Format string is a theme literal defined above.
				blogpress_do_post_meta_prefix( '', 'tags' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_the_tag_list() returns core-escaped markup.
			);
		}
	}

	if ( 'comments-link' === $item ) {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
				echo blogpress_do_post_meta_prefix( '', 'comments-link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				comments_popup_link( __( 'Leave a comment', 'blogpress' ), __( '1 Comment', 'blogpress' ), __( '% Comments', 'blogpress' ) );
			echo '</span> ';
		}
	}

	if ( 'post-navigation' === $item && is_single() ) {
		blogpress_content_nav( 'nav-below' );
	}
}

/**
 * Add svg icons or text to our post meta output.
 *
 * @since 1.0.0
 * @param string $output The existing output.
 * @param string $item The item to target.
 */
function blogpress_do_post_meta_prefix( $output, $item ) {
	if ( 'author' === $item ) {
		$output = __( 'by', 'blogpress' ) . ' ';
	}

	if ( 'categories' === $item ) {
		$output = blogpress_get_svg_icon( 'categories' );
	}

	if ( 'tags' === $item ) {
		$output = blogpress_get_svg_icon( 'tags' );
	}

	if ( 'comments-link' === $item ) {
		$output = blogpress_get_svg_icon( 'comments' );
	}

	return $output;
}

/**
 * Remove post meta items that shouldn't display in the current context.
 *
 * @since 1.0.0
 * @param array $items The post meta items.
 */
function blogpress_disable_post_meta_items( $items ) {
	if ( is_singular() ) {
		$items = array_diff( $items, array( 'comments-link' ) );
	}

	return $items;
}

/**
 * Get the post meta items in the header entry meta.
 *
 * @since 1.0.0
 */
function blogpress_get_header_entry_meta_items() {
	$items = array(
		'date',
		'author',
	);

	// Disable post meta items based on their individual filters.
	$items = blogpress_disable_post_meta_items( $items );

	return $items;
}

/**
 * Get the post meta items in the footer entry meta.
 *
 * @since 1.0.0
 */
function blogpress_get_footer_entry_meta_items() {
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
	$items = blogpress_disable_post_meta_items( $items );

	return $items;
}

if ( ! function_exists( 'blogpress_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 */
	function blogpress_posted_on() {
		$items = blogpress_get_header_entry_meta_items();

		foreach ( $items as $item ) {
			blogpress_do_post_meta_item( $item );
		}
	}
}

if ( ! function_exists( 'blogpress_entry_meta' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * @since 1.0.0
	 */
	function blogpress_entry_meta() {
		$items = blogpress_get_footer_entry_meta_items();

		foreach ( $items as $item ) {
			blogpress_do_post_meta_item( $item );
		}
	}
}

if ( ! function_exists( 'blogpress_excerpt_more' ) ) {
	add_filter( 'excerpt_more', 'blogpress_excerpt_more' );
	/**
	 * Prints the read more HTML to post excerpts.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link.
	 */
	function blogpress_excerpt_more( $more ) {
		return sprintf(
			' ... <a title="%1$s" class="read-more" href="%2$s" aria-label="%4$s">%3$s</a>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) ),
			blogpress_get_read_more_text(),
			blogpress_get_read_more_aria_label()
		);
	}
}

if ( ! function_exists( 'blogpress_content_more' ) ) {
	add_filter( 'the_content_more_link', 'blogpress_content_more' );
	/**
	 * Prints the read more HTML to post content using the more tag.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The HTML for the more link
	 */
	function blogpress_content_more( $more ) {
		return sprintf(
			'<p class="read-more-container"><a title="%1$s" class="read-more content-read-more" href="%2$s" aria-label="%4$s">%3$s</a></p>',
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink( get_the_ID() ) . '#more-' . get_the_ID() ),
			blogpress_get_read_more_text(),
			blogpress_get_read_more_aria_label()
		);
	}
}

add_action( 'wp', 'blogpress_add_post_meta', 5 );
/**
 * Add our post meta items to the page.
 *
 * @since 1.0.0
 */
function blogpress_add_post_meta() {
	$header_items = blogpress_get_header_entry_meta_items();

	$header_post_types = array(
		'post',
	);

	if ( in_array( get_post_type(), $header_post_types ) && ! empty( $header_items ) ) {
	}

	$footer_items = blogpress_get_footer_entry_meta_items();

	$footer_post_types = array(
		'post',
	);

	if ( in_array( get_post_type(), $footer_post_types ) && ! empty( $footer_items ) ) {
	}
}

if ( ! function_exists( 'blogpress_post_meta' ) ) {
	/**
	 * Build the post meta.
	 *
	 * @since 1.0.0
	 */
	function blogpress_post_meta() {
		?>
		<div class="entry-meta">
			<?php blogpress_posted_on(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'blogpress_footer_meta' ) ) {
	/**
	 * Build the footer post meta.
	 *
	 * @since 1.0.0
	 */
	function blogpress_footer_meta() {
		?>
		<footer <?php blogpress_do_attr( 'footer-entry-meta' ); ?>>
			<?php blogpress_entry_meta(); ?>
		</footer>
		<?php
	}
}

/**
 * Add our post navigation after post loops.
 *
 * @since 1.0.0
 * @param string $template The template of the current action.
 */
function blogpress_do_post_navigation( $template ) {
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
	if ( in_array( $template, $templates ) && apply_filters( 'blogpress_show_post_navigation', true, $template ) ) {
		blogpress_content_nav( 'nav-below' );
	}
}

/**
 * Returns the read more text for our posts.
 *
 * @since 1.0.0
 */
function blogpress_get_read_more_text() {
	return __( 'Read more', 'blogpress' );
}

/**
 * Returns the read more `aria-label` for our posts.
 *
 * @since 1.0.0
 */
function blogpress_get_read_more_aria_label() {
	return sprintf(
		/* translators: Aria-label describing the read more button */
		_x( 'Read more about %s', 'read more about post title', 'blogpress' ),
		the_title_attribute( 'echo=0' )
	);
}
