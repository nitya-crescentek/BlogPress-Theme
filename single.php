<?php
/**
 * The Template for displaying all single posts.
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

					webpress_do_template_part( 'single' );

				endwhile;
			}

			?>
		</main>
	</div>

	<?php

	webpress_construct_sidebars();

	get_footer();
