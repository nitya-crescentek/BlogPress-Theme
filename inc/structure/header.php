<?php
/**
 * Header elements.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'blogpress_construct_header' ) ) {
	/**
	 * Build the header.
	 *
	 * @since 1.0.0
	 */
	function blogpress_construct_header() {
		?>
		<header <?php blogpress_do_attr( 'header' ); ?>>
			<div <?php blogpress_do_attr( 'inside-header' ); ?>>
				<?php
				blogpress_do_site_logo();
				blogpress_do_site_branding();

				blogpress_add_navigation_float_right();
				blogpress_do_header_widget();
				?>
			</div>
		</header>
		<?php
	}
}

if ( ! function_exists( 'blogpress_construct_logo' ) ) {
	/**
	 * Build the logo
	 *
	 * @since 1.0.0
	 */
	function blogpress_construct_logo() {
		$logo_url = ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'custom_logo' ) ) ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) : false;
		$logo_url = ( $logo_url ) ? $logo_url[0] : blogpress_get_option( 'logo' );

		$logo_url = esc_url( $logo_url );
		$retina_logo_url = esc_url( blogpress_get_option( 'retina_logo' ) );

		// If we don't have a logo, bail.
		if ( empty( $logo_url ) ) {
			return;
		}

		$attr = array(
			'class' => 'header-image is-logo-image',
			'alt'   => esc_attr( get_bloginfo( 'name', 'display' ) ),
			'src'   => $logo_url,
		);

		$data = get_theme_mod( 'custom_logo' )
			? wp_get_attachment_metadata( get_theme_mod( 'custom_logo' ) )
			: false;

		if ( '' !== $retina_logo_url ) {
			$attr['srcset'] = $logo_url . ' 1x, ' . $retina_logo_url . ' 2x';
		}

		if ( $data ) {
			if ( isset( $data['width'] ) ) {
				$attr['width'] = $data['width'];
			}

			if ( isset( $data['height'] ) ) {
				$attr['height'] = $data['height'];
			}
		}

		$attr = array_map( 'esc_attr', $attr );

		$html_attr = '';
		foreach ( $attr as $name => $value ) {
			$html_attr .= " $name=" . '"' . $value . '"';
		}

		// Print our HTML.
		echo sprintf(
			'<div class="site-logo">
				<a href="%1$s" rel="home">
					<img %2$s />
				</a>
			</div>',
			esc_url( home_url( '/' ) ),
			$html_attr
		);
	}
}

if ( ! function_exists( 'blogpress_construct_site_title' ) ) {
	/**
	 * Build the site title and tagline.
	 *
	 * @since 1.0.0
	 */
	function blogpress_construct_site_title() {
		$blogpress_settings = wp_parse_args(
			get_option( 'blogpress_settings', array() ),
			blogpress_get_defaults()
		);

		// Get the title and tagline.
		$title = get_bloginfo( 'title' );
		$tagline = get_bloginfo( 'description' );

		// If the disable title checkbox is checked, or the title field is empty, return true.
		$disable_title = ( '1' == $blogpress_settings['hide_title'] || '' == $title ) ? true : false; // phpcs:ignore

		// If the disable tagline checkbox is checked, or the tagline field is empty, return true.
		$disable_tagline = ( '1' == $blogpress_settings['hide_tagline'] || '' == $tagline ) ? true : false;  // phpcs:ignore

		$schema_type = blogpress_get_schema_type();

		// Build our site title.
		$site_title = sprintf(
			'<%1$s class="main-title"%4$s>
				<a href="%2$s" rel="home">%3$s</a>
			</%1$s>',
			( is_front_page() && is_home() ) ? 'h1' : 'p',
			esc_url( home_url( '/' ) ),
			get_bloginfo( 'name' ),
			'microdata' === blogpress_get_schema_type() ? ' itemprop="headline"' : ''
		);

		// Build our tagline.
		$site_tagline = sprintf(
			'<p class="site-description"%2$s>%1$s</p>',
			html_entity_decode( get_bloginfo( 'description', 'display' ) ), // phpcs:ignore
			'microdata' === blogpress_get_schema_type() ? ' itemprop="description"' : ''
		);

		// Site title and tagline.
		if ( false === $disable_title || false === $disable_tagline ) {
			if ( blogpress_needs_site_branding_container() ) {
				echo '<div class="site-branding-container">';
				blogpress_construct_logo();
			}

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- outputting site title and tagline. False positive.
			echo sprintf(
				'<div class="site-branding">
					%1$s
					%2$s
				</div>',
				( ! $disable_title ) ? $site_title : '',
				( ! $disable_tagline ) ? $site_tagline : ''
			);

			if ( blogpress_needs_site_branding_container() ) {
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'blogpress_construct_header_widget' ) ) {
	/**
	 * Build the header widget.
	 *
	 * @since 1.0.0
	 */
	function blogpress_construct_header_widget() {
		if ( is_active_sidebar( 'header' ) ) :
			?>
			<div class="header-widget">
				<?php dynamic_sidebar( 'header' ); ?>
			</div>
			<?php
		endif;
	}
}

/**
 * Add the site logo to our header.
 * Only added if we aren't using floats to preserve backwards compatibility.
 *
 * @since 1.0.0
 */
function blogpress_do_site_logo() {
	if ( blogpress_needs_site_branding_container() ) {
		return;
	}

	blogpress_construct_logo();
}

/**
 * Add the site branding to our header.
 * Only added if we aren't using floats to preserve backwards compatibility.
 *
 * @since 1.0.0
 */
function blogpress_do_site_branding() {
	blogpress_construct_site_title();
}

/**
 * Add the header widget to our header.
 * Only used when grid isn't using floats to preserve backwards compatibility.
 *
 * @since 1.0.0
 */
function blogpress_do_header_widget() {
	blogpress_construct_header_widget();
}

if ( ! function_exists( 'blogpress_top_bar' ) ) {
	/**
	 * Build our top bar.
	 *
	 * @since 1.0.0
	 */
	function blogpress_top_bar() {
		if ( ! is_active_sidebar( 'top-bar' ) ) {
			return;
		}
		?>
		<div <?php blogpress_do_attr( 'top-bar' ); ?>>
			<div <?php blogpress_do_attr( 'inside-top-bar' ); ?>>
				<?php dynamic_sidebar( 'top-bar' ); ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'blogpress_pingback_header' ) ) {
	add_action( 'wp_head', 'blogpress_pingback_header' );
	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 *
	 * @since 1.0.0
	 */
	function blogpress_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}

if ( ! function_exists( 'blogpress_add_viewport' ) ) {
	add_action( 'wp_head', 'blogpress_add_viewport', 1 );
	/**
	 * Add viewport to wp_head.
	 *
	 * @since 1.0.0
	 */
	function blogpress_add_viewport() {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Add skip to content link before the header.
 *
 * @since 1.0.0
 */
function blogpress_do_skip_to_content_link() {
	printf(
		'<a class="screen-reader-text skip-link" href="#content" title="%1$s">%2$s</a>',
		esc_attr__( 'Skip to content', 'blogpress' ),
		esc_html__( 'Skip to content', 'blogpress' )
	);
}
