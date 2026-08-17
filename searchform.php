<?php
/**
 * The template for displaying search forms in Blogpress
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'blogpress' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( _x( 'Search &hellip;', 'placeholder', 'blogpress' ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr( _x( 'Search for:', 'label', 'blogpress' ) ); ?>">
	</label>
	<?php
	printf(
		'<button class="search-submit" aria-label="%1$s">%2$s</button>',
		esc_attr( _x( 'Search', 'submit button', 'blogpress' ) ),
		blogpress_get_svg_icon( 'search' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Returns a hardcoded SVG string built in the theme.
	);

	?>
</form>
