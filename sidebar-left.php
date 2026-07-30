<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div <?php blogpress_do_attr( 'left-sidebar' ); ?>>
	<div class="inside-left-sidebar">
		<?php
		blogpress_add_navigation_before_left_sidebar();

		dynamic_sidebar( 'sidebar-2' );

		?>
	</div>
</div>
