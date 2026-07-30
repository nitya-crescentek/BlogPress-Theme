<?php
/**
 * The template for displaying posts within the loop.
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

		if ( blogpress_show_entry_header() ) :
			?>
			<header <?php blogpress_do_attr( 'entry-header' ); ?>>
				<?php

				if ( blogpress_show_title() ) {
					$params = blogpress_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				blogpress_post_meta();
				?>
			</header>
			<?php
		endif;

		blogpress_post_image();

		$itemprop = '';

		if ( 'microdata' === blogpress_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}

		if ( blogpress_show_excerpt() ) :
			?>

			<div class="entry-summary"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
				<?php the_excerpt(); ?>
			</div>

		<?php else : ?>

			<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
				<?php
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

		blogpress_footer_meta();

		?>
	</div>
</article>
