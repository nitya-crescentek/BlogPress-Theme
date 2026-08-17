<?php
/**
 * The template for displaying Link post formats.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php blogpress_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		blogpress_featured_page_header_inside_single();

		/** This action is documented in content.php */
		do_action( 'blogpress_before_content', 'link' );

		if ( blogpress_show_entry_header() ) :
			?>
			<header <?php blogpress_do_attr( 'entry-header' ); ?>>
				<?php
				/** This action is documented in content.php */
				do_action( 'blogpress_before_entry_title', 'link' );

				if ( blogpress_show_title() ) {
					$params = blogpress_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/** This action is documented in content.php */
				do_action( 'blogpress_after_entry_title', 'link' );

				blogpress_post_meta();
				?>
			</header>
			<?php
		endif;

		/** This action is documented in content.php */
		do_action( 'blogpress_after_entry_header', 'link' );

		blogpress_post_image();

		$itemprop = '';

		if ( 'microdata' === blogpress_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}

		if ( blogpress_show_excerpt() ) :
			?>

			<div class="entry-summary"<?php echo $itemprop; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Literal attribute string built above; escaping would break the markup. ?>>
				<?php
				/** This action is documented in content.php */
				do_action( 'blogpress_before_content_output', 'link' );

				the_excerpt();
				?>
			</div>

		<?php else : ?>

			<div class="entry-content"<?php echo $itemprop; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Literal attribute string built above; escaping would break the markup. ?>>
				<?php
				/** This action is documented in content.php */
				do_action( 'blogpress_before_content_output', 'link' );

				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'blogpress' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<?php
		endif;

		/** This action is documented in content.php */
		do_action( 'blogpress_after_entry_content', 'link' );

		blogpress_footer_meta();

		/** This action is documented in content.php */
		do_action( 'blogpress_after_content', 'link' );

		?>
	</div>
</article>
