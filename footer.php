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

	</div>
</div>

<?php
?>

<div <?php blogpress_do_attr( 'footer' ); ?>>
	<?php

	blogpress_construct_footer_widgets();
	blogpress_construct_footer();

	?>
</div>

<?php
blogpress_back_to_top();

wp_footer();
?>

</body>
</html>
