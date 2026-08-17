<?php
/**
 * Comment structure.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'blogpress_comment' ) ) {
	/**
	 * Template for comments and pingbacks.
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @param object $comment The comment object.
	 * @param array  $args The existing args.
	 * @param int    $depth The thread depth.
	 */
	function blogpress_comment( $comment, $args, $depth ) {
		$args['avatar_size'] = 50;

		if ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'blogpress' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'blogpress' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article <?php blogpress_do_attr( 'comment-body', array(), array( 'comment-id' => get_comment_ID() ) ); ?>>
				<footer <?php blogpress_do_attr( 'comment-meta' ); ?>>
					<?php
					if ( 0 != $args['avatar_size'] ) { // phpcs:ignore Universal.Operators.StrictComparisons.LooseNotEqual -- Arg may be string or int; loose compare is intentional.
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<div class="comment-author-info">
						<div <?php blogpress_do_element_classes( 'comment-author' ); ?>>
							<?php printf( '<cite itemprop="name" class="fn">%s</cite>', get_comment_author_link() ); ?>
						</div>

						<?php

						/**
						 * Filters whether the comment date is shown in the comment meta.
						 *
						 * @since 1.0.0
						 *
						 * @param bool       $show    Whether to show the comment date. Default true.
						 * @param WP_Comment $comment The comment being rendered.
						 * @return bool Whether to show the comment date.
						 */
						if ( apply_filters( 'blogpress_show_comment_date', true, $comment ) ) :
							/**
							 * Filters whether the comment date links to the comment permalink.
							 *
							 * @since 1.0.0
							 *
							 * @param bool       $link    Whether to link the date. Default true.
							 * @param WP_Comment $comment The comment being rendered.
							 * @return bool Whether to link the date.
							 */
							$has_comment_date_link = apply_filters( 'blogpress_show_comment_date_link', true, $comment );

							?>
							<div class="entry-meta comment-metadata">
								<?php
								if ( $has_comment_date_link ) {
									printf(
										'<a href="%s">',
										esc_url( get_comment_link( $comment->comment_ID ) )
									);
								}
								?>
									<time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
										<?php
											printf(
												/* translators: 1: date, 2: time */
												esc_html_x( '%1$s at %2$s', '1: date, 2: time', 'blogpress' ),
												esc_html( get_comment_date() ),
												esc_html( get_comment_time() )
											);
										?>
									</time>
								<?php
								if ( $has_comment_date_link ) {
									echo '</a>';
								}

								// The separator before the link is added in CSS.
								edit_comment_link( __( 'Edit', 'blogpress' ), '<span class="edit-link">', '</span>' );
								?>
							</div>
							<?php
						endif;
						?>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual -- comment_approved may be string or int; loose compare is intentional. ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'blogpress' ); ?></p>
					<?php endif; ?>
				</footer>

				<div class="comment-content" itemprop="text">
					<?php

					comment_text();

					blogpress_do_comment_reply_link( $comment, $args, $depth );
					?>
				</div>
			</article>
			<?php
		endif;
	}
}

/**
 * Add our comment reply link after the comment text.
 *
 * @since 1.0.0
 * @param object $comment The comment object.
 * @param array  $args The existing args.
 * @param int    $depth The thread depth.
 */
function blogpress_do_comment_reply_link( $comment, $args, $depth ) {
	comment_reply_link(
		array_merge(
			$args,
			array(
				'add_below' => 'div-comment',
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<span class="reply">',
				'after'     => '</span>',
			)
		)
	);
}

add_filter( 'comment_form_defaults', 'blogpress_set_comment_form_defaults' );
/**
 * Set the default settings for our comments.
 *
 * @since 1.0.0
 *
 * @param array $defaults The existing defaults.
 * @return array
 */
function blogpress_set_comment_form_defaults( $defaults ) {
	$defaults['comment_field'] = sprintf(
		'<p class="comment-form-comment"><label for="comment" class="screen-reader-text">%1$s</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>',
		esc_html__( 'Comment', 'blogpress' )
	);

	$defaults['comment_notes_before'] = '';
	$defaults['comment_notes_after']  = '';
	$defaults['id_form']              = 'commentform';
	$defaults['id_submit']            = 'submit';
	$defaults['title_reply']          = __( 'Leave a Comment', 'blogpress' );
	$defaults['label_submit']         = __( 'Post Comment', 'blogpress' );

	return $defaults;
}

add_filter( 'comment_form_default_fields', 'blogpress_filter_comment_fields' );
/**
 * Customizes the existing comment fields.
 *
 * @since 1.0.0
 * @param array $fields The existing fields.
 * @return array
 */
function blogpress_filter_comment_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$required = get_option( 'require_name_email' );

	$fields['author'] = sprintf(
		'<label for="author" class="screen-reader-text">%1$s</label><input placeholder="%1$s%3$s" id="author" name="author" type="text" value="%2$s" size="30"%4$s />',
		esc_html__( 'Name', 'blogpress' ),
		esc_attr( $commenter['comment_author'] ),
		$required ? ' *' : '',
		$required ? ' required' : ''
	);

	$fields['email'] = sprintf(
		'<label for="email" class="screen-reader-text">%1$s</label><input placeholder="%1$s%3$s" id="email" name="email" type="email" value="%2$s" size="30"%4$s />',
		esc_html__( 'Email', 'blogpress' ),
		esc_attr( $commenter['comment_author_email'] ),
		$required ? ' *' : '',
		$required ? ' required' : ''
	);

	$fields['url'] = sprintf(
		'<label for="url" class="screen-reader-text">%1$s</label><input placeholder="%1$s" id="url" name="url" type="url" value="%2$s" size="30" />',
		esc_html__( 'Website', 'blogpress' ),
		esc_attr( $commenter['comment_author_url'] )
	);

	return $fields;
}

/**
 * Add the comments template to pages and single posts.
 *
 * @since 1.0.0
 * @param string $template The template we're targeting.
 */
function blogpress_do_comments_template( $template ) {
	if ( 'single' === $template || 'page' === $template ) {
		// If comments are open or we have at least one comment, load up the comment template.
		// phpcs:ignore Universal.Operators.StrictComparisons.LooseNotEqual -- Intentionally loose.
		if ( comments_open() || '0' != get_comments_number() ) :
			?>

			<div class="comments-area">
				<?php comments_template(); ?>
			</div>

			<?php
		endif;
	}
}
