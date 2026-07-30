<?php
/**
 * The template for displaying Search Results pages.
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
					blogpress_do_search_results_title( 'search' );

					while ( have_posts() ) :

						the_post();

						blogpress_do_template_part( 'search' );

					endwhile;

					blogpress_do_post_navigation( 'search' );

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
