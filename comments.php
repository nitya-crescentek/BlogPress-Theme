<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to blogpress_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>
<div id="comments">

	<?php

	if ( have_comments() ) :
		$comments_number = get_comments_number();
		$comments_title = sprintf(
			esc_html(
				/* translators: 1: number of comments, 2: post title */
				_nx(
					'%1$s thought on &ldquo;%2$s&rdquo;',
					'%1$s thoughts on &ldquo;%2$s&rdquo;',
					$comments_number,
					'comments title',
					'blogpress'
				)
			),
			number_format_i18n( $comments_number ),
			get_the_title()
		);

		echo sprintf(
			'<h2 class="comments-title">%s</h2>',
			esc_html( $comments_title )
		);

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'blogpress' ); ?></h2>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'blogpress' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'blogpress' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			/*
			 * Loop through and list the comments. Tell wp_list_comments()
			 * to use blogpress_comment() to format the comments.
			 * If you want to override this in a child theme, then you can
			 * define blogpress_comment() and that will be used instead.
			 * See blogpress_comment() in inc/template-tags.php for more.
			 */
			wp_list_comments(
				array(
					'callback' => 'blogpress_comment',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'blogpress' ); ?></h2>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'blogpress' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'blogpress' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php
		endif;

	endif;

	// phpcs:ignore Universal.Operators.StrictComparisons.LooseNotEqual
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'blogpress' ); ?></p>
		<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
