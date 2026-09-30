<?php
/**
 * The template for displaying search forms in WebPress
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'webpress' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( _x( 'Search &hellip;', 'placeholder', 'webpress' ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr( _x( 'Search for:', 'label', 'webpress' ) ); ?>">
	</label>
	<?php
	printf(
		'<button class="search-submit" aria-label="%1$s">%2$s</button>',
		esc_attr( _x( 'Search', 'submit button', 'webpress' ) ),
		webpress_get_svg_icon( 'search' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Returns a hardcoded SVG string built in the theme.
	);

	?>
</form>
