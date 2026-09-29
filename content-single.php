<?php
/**
 * The template for displaying single posts.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php webpress_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		webpress_featured_page_header_inside_single();

		/** This action is documented in content.php */
		do_action( 'webpress_before_content', 'single' );

		if ( webpress_show_entry_header() ) :
			?>
			<header <?php webpress_do_attr( 'entry-header' ); ?>>
				<?php
				/** This action is documented in content.php */
				do_action( 'webpress_before_entry_title', 'single' );

				if ( webpress_show_title() ) {
					$params = webpress_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/** This action is documented in content.php */
				do_action( 'webpress_after_entry_title', 'single' );

				webpress_post_meta();
				?>
			</header>
			<?php
		endif;

		/** This action is documented in content.php */
		do_action( 'webpress_after_entry_header', 'single' );

		webpress_post_image();

		$itemprop = '';

		if ( 'microdata' === webpress_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}
		?>

		<div class="entry-content"<?php echo $itemprop; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Literal attribute string built above; escaping would break the markup. ?>>
			<?php
			/** This action is documented in content.php */
			do_action( 'webpress_before_content_output', 'single' );

			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'webpress' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>

		<?php
		/** This action is documented in content.php */
		do_action( 'webpress_after_entry_content', 'single' );

		webpress_footer_meta();

		/** This action is documented in content.php */
		do_action( 'webpress_after_content', 'single' );

		?>
	</div>
</article>
