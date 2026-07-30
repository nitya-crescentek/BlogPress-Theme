<?php
/**
 * The template for displaying 404 pages (Not Found).
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

			blogpress_do_template_part( '404' );

			?>
		</main>
	</div>

	<?php

	blogpress_construct_sidebars();

	get_footer();
