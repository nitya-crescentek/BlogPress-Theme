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
<div <?php blogpress_do_attr( 'right-sidebar' ); ?>>
	<div class="inside-right-sidebar">
		<?php
		blogpress_add_navigation_before_right_sidebar();

		dynamic_sidebar( 'sidebar-1' );

		?>
	</div>
</div>
