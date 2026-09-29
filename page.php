<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
				while ( have_posts() ) :

					the_post();

					webpress_do_template_part( 'page' );

				endwhile;
			}

			?>
		</main>
	</div>

	<?php

	webpress_construct_sidebars();

	get_footer();
