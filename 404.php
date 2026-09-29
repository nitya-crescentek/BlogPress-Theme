<?php
/**
 * The template for displaying 404 pages (Not Found).
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

			webpress_do_template_part( '404' );

			?>
		</main>
	</div>

	<?php

	webpress_construct_sidebars();

	get_footer();
