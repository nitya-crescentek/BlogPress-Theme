<?php
/**
 * Post meta elements.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_footer', 'blogpress_do_search_modal' );
/**
 * Create the search modal HTML.
 */
function blogpress_do_search_modal() {
	if ( ! blogpress_get_option( 'nav_search_modal' ) ) {
		return;
	}
	?>
	<div class="gp-modal gp-search-modal" id="gp-search" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'blogpress' ); ?>">
		<div class="gp-modal__overlay" tabindex="-1" data-gpmodal-close>
			<div class="gp-modal__container">
				<?php blogpress_do_search_fields();
?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Create the search modal trigger.
 */
function blogpress_do_search_modal_trigger() {
	if ( ! blogpress_get_option( 'nav_search_modal' ) || 'svg' !== blogpress_get_option( 'icons' ) ) {
		return;
	}
	?>
	<span class="menu-bar-item">
		<a href="#" role="button" aria-label="<?php _e( 'Open search', 'blogpress' ); ?>" aria-haspopup="dialog" aria-controls="gp-search" data-gpmodal-trigger="gp-search"><?php echo blogpress_get_svg_icon( 'search', true ); // phpcs:ignore -- Escaped in function. ?></a>
	</span>
	<?php
}

/**
 * Do the modal CSS.
 *
 * @param Object $css The existing CSS object.
 */
function blogpress_do_search_modal_css( $css ) {
	if ( ! blogpress_get_option( 'nav_search_modal' ) ) {
		return;
	}

	$css->set_selector( '.search-modal-fields' );
	$css->add_property( 'display', 'flex' );

	$css->set_selector( '.gp-search-modal .gp-modal__overlay' );
	$css->add_property( 'align-items', 'flex-start' );
	$css->add_property( 'padding-top', '25vh' );
	$css->add_property( 'background', 'var(--gp-search-modal-overlay-bg-color)' );

	$css->set_selector( '.search-modal-form' );
	$css->add_property( 'width', '500px' );
	$css->add_property( 'max-width', '100%' );
	$css->add_property( 'background-color', 'var(--gp-search-modal-bg-color)' );
	$css->add_property( 'color', 'var(--gp-search-modal-text-color)' );

	$css->set_selector( '.search-modal-form .search-field, .search-modal-form .search-field:focus' );
	$css->add_property( 'width', '100%' );
	$css->add_property( 'height', '60px' );
	$css->add_property( 'background-color', 'transparent' );
	$css->add_property( 'border', 0 );
	$css->add_property( 'appearance', 'none' );
	$css->add_property( 'color', 'currentColor' );

	$css->set_selector( '.search-modal-fields button, .search-modal-fields button:active, .search-modal-fields button:focus, .search-modal-fields button:hover' );
	$css->add_property( 'background-color', 'transparent' );
	$css->add_property( 'border', 0 );
	$css->add_property( 'color', 'currentColor' );
	$css->add_property( 'width', '60px' );

	return $css;
}

/**
 * Add our search fields to the modal.
 */
function blogpress_do_search_fields() {
	?>
	<form role="search" method="get" class="search-modal-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="search-modal-input" class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'blogpress' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></label>
		<div class="search-modal-fields">
			<input id="search-modal-input" type="search" class="search-field" placeholder="<?php echo esc_attr( _x( 'Search &hellip;', 'placeholder', 'blogpress' ) ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<button aria-label="<?php echo esc_attr( _x( 'Search', 'submit button', 'blogpress' ) ); ?>"><?php echo blogpress_get_svg_icon( 'search' ); // phpcs:ignore -- Escaped in function. ?></button>
		</div>
		<?php?>
	</form>
	<?php
}
