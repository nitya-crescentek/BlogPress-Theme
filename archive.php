<?php
/**
 * The template for displaying Archive pages.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php blogpress_do_attr( 'content' ); ?>>
		<main <?php blogpress_do_attr( 'main' ); ?>>
			<?php

			if ( blogpress_has_default_loop() ) {
				if ( have_posts() ) :

					blogpress_archive_title();

					blogpress_do_search_results_title( 'archive' );

					while ( have_posts() ) :

						the_post();

						blogpress_do_template_part( 'archive' );

					endwhile;

					blogpress_do_post_navigation( 'archive' );

				else :

					blogpress_do_template_part( 'none' );

				endif;
			}

			?>
		</main>
	</div>

	<?php

	blogpress_construct_sidebars();

	get_footer();
