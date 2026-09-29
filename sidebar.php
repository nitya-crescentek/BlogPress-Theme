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
<div <?php webpress_do_attr( 'right-sidebar' ); ?>>
	<div class="inside-right-sidebar">
		<?php
		webpress_add_navigation_before_right_sidebar();

		/**
		 * Fires inside the right sidebar, before its widgets.
		 *
		 * @since 1.0.0
		 *
		 * @param string $sidebar_id The widget area ID being output.
		 */
		do_action( 'webpress_before_right_sidebar_content', 'sidebar-1' );

		dynamic_sidebar( 'sidebar-1' );

		/**
		 * Fires inside the right sidebar, after its widgets.
		 *
		 * @since 1.0.0
		 *
		 * @param string $sidebar_id The widget area ID being output.
		 */
		do_action( 'webpress_after_right_sidebar_content', 'sidebar-1' );

		?>
	</div>
</div>
