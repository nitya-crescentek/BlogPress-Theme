<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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

					blogpress_do_search_results_title( 'index' );

					while ( have_posts() ) :

						the_post();

						blogpress_do_template_part( 'index' );

					endwhile;

					blogpress_do_post_navigation( 'index' );

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
