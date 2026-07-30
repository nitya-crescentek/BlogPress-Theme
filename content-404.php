<?php
/**
 * The template for displaying 404 pages.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="inside-article">

	<?php
	blogpress_featured_page_header_inside_single();
	?>

	<header <?php blogpress_do_attr( 'entry-header' ); ?>>
		<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is allowed in filter here. ?>
		<h1 class="entry-title" itemprop="headline"><?php echo __( 'Oops! That page can&rsquo;t be found.', 'blogpress' ); ?></h1>
	</header>

	<?php
	blogpress_post_image();

	$itemprop = '';

	if ( 'microdata' === blogpress_get_schema_type() ) {
		$itemprop = ' itemprop="text"';
	}
	?>

	<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
		<?php
		printf(
			'<p>%s</p>',
			__( 'It looks like nothing was found at this location. Maybe try searching?', 'blogpress' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is allowed in filter here.
		);

		get_search_form();
		?>
	</div>

	<?php
	?>

</div>
