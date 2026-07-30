<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
				while ( have_posts() ) :

					the_post();

					blogpress_do_template_part( 'page' );

				endwhile;
			}

			?>
		</main>
	</div>

	<?php

	blogpress_construct_sidebars();

	get_footer();
