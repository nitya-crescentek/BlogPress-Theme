<?php
/**
 * Footer elements.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'blogpress_construct_footer' ) ) {
	/**
	 * Build our footer.
	 *
	 * @since 1.0.0
	 */
	function blogpress_construct_footer() {
		?>
		<footer <?php blogpress_do_attr( 'site-info' ); ?>>
			<div <?php blogpress_do_attr( 'inside-site-info' ); ?>>
				<?php
				/**
				 * Fires inside the site info footer, before the footer bar.
				 *
				 * @since 1.0.0
				 */
				do_action( 'blogpress_before_footer_content' );

				blogpress_footer_bar();
				?>
				<div class="copyright-bar">
					<?php
					blogpress_add_footer_info();
					?>
				</div>
				<?php
				/**
				 * Fires inside the site info footer, after the copyright bar.
				 *
				 * @since 1.0.0
				 */
				do_action( 'blogpress_after_footer_content' );
				?>
			</div>
		</footer>
		<?php
	}
}

if ( ! function_exists( 'blogpress_footer_bar' ) ) {
	/**
	 * Build our footer bar
	 *
	 * @since 1.0.0
	 */
	function blogpress_footer_bar() {
		if ( ! is_active_sidebar( 'footer-bar' ) ) {
			return;
		}
		?>
		<div class="footer-bar">
			<?php dynamic_sidebar( 'footer-bar' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'blogpress_add_footer_info' ) ) {
	/**
	 * Add the copyright to the footer
	 *
	 * @since 1.0.0
	 */
	function blogpress_add_footer_info() {
		$copyright = sprintf(
			'<span class="copyright">&copy; %1$s %2$s</span> &bull; %3$s %4$s',
			esc_html( gmdate( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) ),
			esc_html_x( 'Built with', 'BlogPress', 'blogpress' ),
			esc_html__( 'BlogPress', 'blogpress' )
		);

		/**
		 * Filters the copyright line in the site footer.
		 *
		 * Post-level HTML is allowed; the return value is passed through
		 * wp_kses_post() before output.
		 *
		 * @since 1.0.0
		 *
		 * @param string $copyright The copyright markup.
		 * @return string The copyright markup to output.
		 */
		$copyright = apply_filters( 'blogpress_copyright', $copyright );

		// The blogpress_copyright filter is documented as HTML-capable, so allow post-level markup.
		echo wp_kses_post( $copyright );
	}
}

/**
 * Build our individual footer widgets.
 * Displays a sample widget if no widget is found in the area.
 *
 * @since 1.0.0
 *
 * @param int $widget_width The width class of our widget.
 * @param int $widget The ID of our widget.
 */
function blogpress_do_footer_widget( $widget_width, $widget ) {
	$widget_classes = sprintf(
		'footer-widget-%s',
		absint( $widget )
	);

	?>
	<div class="<?php echo esc_attr( $widget_classes ); ?>">
		<?php dynamic_sidebar( 'footer-' . absint( $widget ) ); ?>
	</div>
	<?php
}

if ( ! function_exists( 'blogpress_construct_footer_widgets' ) ) {
	/**
	 * Build our footer widgets.
	 *
	 * @since 1.0.0
	 */
	function blogpress_construct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = blogpress_get_footer_widgets();

		if ( ! empty( $widgets ) && 0 !== $widgets ) :

			// If no footer widgets exist, we don't need to continue.
			if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_active_sidebar( 'footer-4' ) && ! is_active_sidebar( 'footer-5' ) ) {
				return;
			}

			// Set up the widget width.
			$widget_width = '';

			if ( 1 === (int) $widgets ) {
				$widget_width = '100';
			}

			if ( 2 === (int) $widgets ) {
				$widget_width = '50';
			}

			if ( 3 === (int) $widgets ) {
				$widget_width = '33';
			}

			if ( 4 === (int) $widgets ) {
				$widget_width = '25';
			}

			if ( 5 === (int) $widgets ) {
				$widget_width = '20';
			}
			?>
			<div id="footer-widgets" class="site footer-widgets">
				<div <?php blogpress_do_attr( 'footer-widgets-container' ); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							blogpress_do_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							blogpress_do_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							blogpress_do_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							blogpress_do_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							blogpress_do_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'blogpress_back_to_top' ) ) {
	/**
	 * Build the back to top button
	 *
	 * @since 1.0.0
	 */
	function blogpress_back_to_top() {
		$blogpress_settings = wp_parse_args(
			get_option( 'blogpress_settings', array() ),
			blogpress_get_defaults()
		);

		if ( 'enable' !== $blogpress_settings['back_to_top'] ) {
			return;
		}

		echo sprintf(
			'<a title="%1$s" aria-label="%1$s" rel="nofollow" href="#" class="blogpress-back-to-top" data-scroll-speed="%2$s" data-start-scroll="%3$s" role="button">
				%4$s
			</a>',
			esc_attr__( 'Scroll back to top', 'blogpress' ),
			absint( blogpress_get_option( 'back_to_top_scroll_speed' ) ),
			absint( blogpress_get_option( 'back_to_top_scroll_start' ) ),
			blogpress_get_svg_icon( 'arrow-up' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- blogpress_get_svg_icon() returns a hardcoded SVG string built in the theme.
		);
	}
}
