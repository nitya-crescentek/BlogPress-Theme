<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php webpress_do_attr( 'content' ); ?>>
		<main <?php webpress_do_attr( 'main' ); ?>>
			<?php

			if ( webpress_has_default_loop() ) {
				if ( have_posts() ) :

					webpress_archive_title();

					webpress_do_search_results_title( 'archive' );

					while ( have_posts() ) :

						the_post();

						webpress_do_template_part( 'archive' );

					endwhile;

					webpress_do_post_navigation( 'archive' );

				else :

					webpress_do_template_part( 'none' );

				endif;
			}

			?>
		</main>
	</div>

	<?php

	webpress_construct_sidebars();

	get_footer();
