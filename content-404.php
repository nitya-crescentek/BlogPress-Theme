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

	/** This action is documented in content.php */
	do_action( 'blogpress_before_content', '404' );
	?>

	<header <?php blogpress_do_attr( 'entry-header' ); ?>>
		<?php
		/** This action is documented in content.php */
		do_action( 'blogpress_before_entry_title', '404' );
		?>
		<h1 class="entry-title" itemprop="headline"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'blogpress' ); ?></h1>
		<?php
		/** This action is documented in content.php */
		do_action( 'blogpress_after_entry_title', '404' );
		?>
	</header>

	<?php
	/** This action is documented in content.php */
	do_action( 'blogpress_after_entry_header', '404' );

	blogpress_post_image();

	$itemprop = '';

	if ( 'microdata' === blogpress_get_schema_type() ) {
		$itemprop = ' itemprop="text"';
	}
	?>

	<div class="entry-content"<?php echo $itemprop; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Literal attribute string built above; escaping would break the markup. ?>>
		<?php
		/** This action is documented in content.php */
		do_action( 'blogpress_before_content_output', '404' );

		printf(
			'<p>%s</p>',
			esc_html__( 'It looks like nothing was found at this location. Maybe try searching?', 'blogpress' )
		);

		get_search_form();
		?>
	</div>

	<?php
	/** This action is documented in content.php */
	do_action( 'blogpress_after_entry_content', '404' );

	/** This action is documented in content.php */
	do_action( 'blogpress_after_content', '404' );
	?>

</div>
