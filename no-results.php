<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="no-results not-found">
	<div class="inside-article">
		<?php
		webpress_featured_page_header_inside_single();

		/** This action is documented in content.php */
		do_action( 'webpress_before_content', 'none' );
		?>

		<header <?php webpress_do_attr( 'entry-header' ); ?>>
			<?php
			/** This action is documented in content.php */
			do_action( 'webpress_before_entry_title', 'none' );
			?>
			<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'webpress' ); ?></h1>
			<?php
			/** This action is documented in content.php */
			do_action( 'webpress_after_entry_title', 'none' );
			?>
		</header>

		<?php
		/** This action is documented in content.php */
		do_action( 'webpress_after_entry_header', 'none' );

		webpress_post_image();
		?>

		<div class="entry-content">

				<?php
				/** This action is documented in content.php */
				do_action( 'webpress_before_content_output', 'none' );
				?>

				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p>
						<?php
						echo wp_kses_post(
							sprintf(
								/* translators: 1: Admin URL */
								__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'webpress' ),
								esc_url( admin_url( 'post-new.php' ) )
							)
						);
						?>
					</p>

				<?php elseif ( is_search() ) : ?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'webpress' ); ?></p>
					<?php get_search_form(); ?>

				<?php else : ?>

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'webpress' ); ?></p>
					<?php get_search_form(); ?>

				<?php endif; ?>

		</div>

		<?php
		/** This action is documented in content.php */
		do_action( 'webpress_after_entry_content', 'none' );

		/** This action is documented in content.php */
		do_action( 'webpress_after_content', 'none' );
		?>
	</div>
</div>
