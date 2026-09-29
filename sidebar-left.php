<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div <?php webpress_do_attr( 'left-sidebar' ); ?>>
	<div class="inside-left-sidebar">
		<?php
		webpress_add_navigation_before_left_sidebar();

		/**
		 * Fires inside the left sidebar, before its widgets.
		 *
		 * @since 1.0.0
		 *
		 * @param string $sidebar_id The widget area ID being output.
		 */
		do_action( 'webpress_before_left_sidebar_content', 'sidebar-2' );

		dynamic_sidebar( 'sidebar-2' );

		/**
		 * Fires inside the left sidebar, after its widgets.
		 *
		 * @since 1.0.0
		 *
		 * @param string $sidebar_id The widget area ID being output.
		 */
		do_action( 'webpress_after_left_sidebar_content', 'sidebar-2' );

		?>
	</div>
</div>
