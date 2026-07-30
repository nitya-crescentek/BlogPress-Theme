<?php
/**
 * The Template for displaying all single posts.
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

					blogpress_do_template_part( 'single' );

				endwhile;
			}

			?>
		</main>
	</div>

	<?php

	blogpress_construct_sidebars();

	get_footer();
