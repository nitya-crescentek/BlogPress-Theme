<?php
/**
 * Footer elements.
 *
 * @package WebPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'webpress_construct_footer' ) ) {
	/**
	 * Build our footer.
	 *
	 * @since 1.0.0
	 */
	function webpress_construct_footer() {
		?>
		<footer <?php webpress_do_attr( 'site-info' ); ?>>
			<div <?php webpress_do_attr( 'inside-site-info' ); ?>>
				<?php
				/**
				 * Fires inside the site info footer, before the footer bar.
				 *
				 * @since 1.0.0
				 */
				do_action( 'webpress_before_footer_content' );

				webpress_footer_bar();
				?>
				<div class="copyright-bar">
					<?php
					webpress_add_footer_info();
					?>
				</div>
				<?php
				/**
				 * Fires inside the site info footer, after the copyright bar.
				 *
				 * @since 1.0.0
				 */
				do_action( 'webpress_after_footer_content' );
				?>
			</div>
		</footer>
		<?php
	}
}

if ( ! function_exists( 'webpress_footer_bar' ) ) {
	/**
	 * Build our footer bar
	 *
	 * @since 1.0.0
	 */
	function webpress_footer_bar() {
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

if ( ! function_exists( 'webpress_add_footer_info' ) ) {
	/**
	 * Add the copyright to the footer
	 *
	 * @since 1.0.0
	 */
	function webpress_add_footer_info() {
		$copyright = sprintf(
			'<span class="copyright">&copy; %1$s %2$s</span> &bull; %3$s %4$s',
			esc_html( date_i18n( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) ),
			esc_html_x( 'Built with', 'WebPress', 'webpress' ),
			esc_html__( 'WebPress', 'webpress' )
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
		$copyright = apply_filters( 'webpress_copyright', $copyright );

		// The webpress_copyright filter is documented as HTML-capable, so allow post-level markup.
		echo wp_kses_post( $copyright );
	}
}

if ( ! function_exists( 'webpress_do_footer_widget' ) ) {
	/**
	 * Build our individual footer widgets.
	 * Displays a sample widget if no widget is found in the area.
	 *
	 * @since 1.0.0
	 *
	 * @param int $widget_width The width class of our widget.
	 * @param int $widget The ID of our widget.
	 */
	function webpress_do_footer_widget( $widget_width, $widget ) {
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
}

if ( ! function_exists( 'webpress_construct_footer_widgets' ) ) {
	/**
	 * Build our footer widgets.
	 *
	 * @since 1.0.0
	 */
	function webpress_construct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = webpress_get_footer_widgets();

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
				<div <?php webpress_do_attr( 'footer-widgets-container' ); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							webpress_do_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							webpress_do_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							webpress_do_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							webpress_do_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							webpress_do_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'webpress_back_to_top' ) ) {
	/**
	 * Build the back to top button
	 *
	 * @since 1.0.0
	 */
	function webpress_back_to_top() {
		$webpress_settings = wp_parse_args(
			get_option( 'webpress_settings', array() ),
			webpress_get_defaults()
		);

		if ( 'enable' !== $webpress_settings['back_to_top'] ) {
			return;
		}

		echo sprintf(
			'<a title="%1$s" aria-label="%1$s" rel="nofollow" href="#" class="webpress-back-to-top" data-scroll-speed="%2$s" data-start-scroll="%3$s" role="button">
				%4$s
			</a>',
			esc_attr__( 'Scroll back to top', 'webpress' ),
			absint( webpress_get_option( 'back_to_top_scroll_speed' ) ),
			absint( webpress_get_option( 'back_to_top_scroll_start' ) ),
			webpress_get_svg_icon( 'arrow-up' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- webpress_get_svg_icon() returns a hardcoded SVG string built in the theme.
		);
	}
}
