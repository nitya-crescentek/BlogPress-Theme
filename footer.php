<?php
/**
 * The template for displaying the footer.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

		<?php
		/**
		 * Fires inside the site content wrapper, after the main content.
		 *
		 * @since 1.0.0
		 */
		do_action( 'blogpress_after_main_content' );
		?>
	</div>
</div>

<?php
/**
 * Fires after the page container closes, before the site footer.
 *
 * @since 1.0.0
 */
do_action( 'blogpress_before_footer' );
?>

<div <?php blogpress_do_attr( 'footer' ); ?>>
	<?php

	blogpress_construct_footer_widgets();
	blogpress_construct_footer();

	?>
</div>

<?php
/**
 * Fires after the site footer is output.
 *
 * @since 1.0.0
 */
do_action( 'blogpress_after_footer' );

blogpress_back_to_top();

wp_footer();
?>

</body>
</html>
