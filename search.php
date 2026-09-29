<?php
/**
 * The template for displaying Search Results pages.
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
					webpress_do_search_results_title( 'search' );

					while ( have_posts() ) :

						the_post();

						webpress_do_template_part( 'search' );

					endwhile;

					webpress_do_post_navigation( 'search' );

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
