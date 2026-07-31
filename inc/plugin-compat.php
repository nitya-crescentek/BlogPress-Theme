<?php
/**
 * Add compatibility for some popular third party plugins.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'blogpress_setup_woocommerce' );
/**
 * Set up WooCommerce
 *
 * @since 1.3.47
 */
function blogpress_setup_woocommerce() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Add support for WC features.
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/**
	 * Image sizes and grid defaults so a fresh install looks right without
	 * any setup. Runs after blogpress_setup(), so these arguments are added
	 * to the existing woocommerce support.
	 */
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 400,
			'single_image_width' => 800,
			'product_grid' => array(
				'default_columns' => 3,
				'min_columns' => 1,
				'max_columns' => 6,
			),
		)
	);

	// Remove default WooCommerce wrappers.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_sidebar', 'blogpress_construct_sidebars' );
}

/**
 * Get the tag name for our WooCommerce wrappers.
 *
 * @since 3.2.0
 */
function blogpress_get_woocommerce_wrapper_tagname() {
	echo is_singular()
		? 'article'
		: 'div';
}

if ( ! function_exists( 'blogpress_woocommerce_start' ) ) {
	add_action( 'woocommerce_before_main_content', 'blogpress_woocommerce_start', 10 );
	/**
	 * Add WooCommerce starting wrappers
	 *
	 * @since 1.3.22
	 */
	function blogpress_woocommerce_start() {
		?>
		<div <?php blogpress_do_attr( 'content' ); ?>>
			<main <?php blogpress_do_attr( 'main' ); ?>>
				<?php
				?>
				<<?php blogpress_get_woocommerce_wrapper_tagname(); ?> <?php blogpress_do_attr( 'woocommerce-content' ); ?>>
					<div class="inside-article">
						<?php
						blogpress_featured_page_header_inside_single();

						$itemprop = '';

						if ( 'microdata' === blogpress_get_schema_type() ) {
							$itemprop = ' itemprop="text"';
						}
						?>
						<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
		<?php
	}
}

if ( ! function_exists( 'blogpress_woocommerce_end' ) ) {
	add_action( 'woocommerce_after_main_content', 'blogpress_woocommerce_end', 10 );
	/**
	 * Add WooCommerce ending wrappers
	 *
	 * @since 1.3.22
	 */
	function blogpress_woocommerce_end() {
		?>
						</div>
						<?php
						?>
					</div>
				</<?php blogpress_get_woocommerce_wrapper_tagname(); ?>>
				<?php
				?>
			</main>
		</div>
		<?php
	}
}

if ( ! function_exists( 'blogpress_woocommerce_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'blogpress_woocommerce_css', 100 );
	/**
	 * Add WooCommerce CSS
	 *
	 * @since 1.3.45
	 */
	function blogpress_woocommerce_css() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$mobile = blogpress_get_media_query( 'mobile' );

		$css = '.woocommerce .page-header-image-single {
			display: none;
		}

		.woocommerce .entry-content,
		.woocommerce .product .entry-summary {
			margin-top: 0;
		}

		.related.products {
			clear: both;
		}

		.checkout-subscribe-prompt.clear {
			visibility: visible;
			height: initial;
			width: initial;
		}

		@media ' . esc_attr( $mobile ) . ' {
			.woocommerce .woocommerce-ordering,
			.woocommerce-page .woocommerce-ordering {
				float: none;
			}

			.woocommerce .woocommerce-ordering select {
				max-width: 100%;
			}

			.woocommerce ul.products li.product,
			.woocommerce-page ul.products li.product,
			.woocommerce-page[class*=columns-] ul.products li.product,
			.woocommerce[class*=columns-] ul.products li.product {
				width: 100%;
				float: none;
			}
		}';

		$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
		wp_add_inline_style( 'woocommerce-general', $css );
	}
}

if ( ! function_exists( 'blogpress_woocommerce_loop_toolbar_open' ) ) {
	add_action( 'woocommerce_before_shop_loop', 'blogpress_woocommerce_loop_toolbar_open', 19 );
	/**
	 * Open a wrapper around the result count and catalog ordering.
	 *
	 * WooCommerce floats those two elements. Wrapping them lets us lay the row
	 * out with flexbox instead, which keeps them aligned on any screen size.
	 *
	 * @since 3.6.1
	 */
	function blogpress_woocommerce_loop_toolbar_open() {
		echo '<div class="blogpress-shop-toolbar">';
	}
}

if ( ! function_exists( 'blogpress_woocommerce_loop_toolbar_close' ) ) {
	add_action( 'woocommerce_before_shop_loop', 'blogpress_woocommerce_loop_toolbar_close', 31 );
	/**
	 * Close the result count and catalog ordering wrapper.
	 *
	 * @since 3.6.1
	 */
	function blogpress_woocommerce_loop_toolbar_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'blogpress_woocommerce_theme_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'blogpress_woocommerce_theme_css', 100 );
	/**
	 * Enqueue our WooCommerce stylesheet and the colors it can't know about.
	 *
	 * WooCommerce ships its own button colors, and its selectors are more
	 * specific than ours, so the theme's form button settings are re-applied
	 * to the matching WooCommerce selectors here.
	 *
	 * @since 3.6.1
	 */
	function blogpress_woocommerce_theme_css() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Load after WooCommerce so we can override it without !important.
		$deps = wp_style_is( 'woocommerce-general', 'registered' )
			? array( 'woocommerce-general' )
			: array();

		wp_enqueue_style(
			'blogpress-woocommerce',
			get_template_directory_uri() . "/assets/css/components/woocommerce{$suffix}.css",
			$deps,
			BLOGPRESS_VERSION,
			'all'
		);

		$settings = wp_parse_args(
			get_option( 'blogpress_settings', array() ),
			blogpress_get_color_defaults()
		);

		$buttons = array(
			'.woocommerce a.button',
			'.woocommerce button.button',
			'.woocommerce input.button',
			'.woocommerce a.button.alt',
			'.woocommerce button.button.alt',
			'.woocommerce input.button.alt',
			'.woocommerce #respond input#submit',
			'.woocommerce #respond input#submit.alt',
			'.woocommerce .widget_shopping_cart a.button',
			'.woocommerce .widget_price_filter .price_slider_amount .button',
			// Block cart and checkout, excluding the outlined/link variants.
			'.woocommerce-page .wc-block-components-button:not(.is-link):not(.is-style-outline):not(.outlined)',
		);

		$buttons_hover = array();

		foreach ( $buttons as $button ) {
			$buttons_hover[] = $button . ':hover';
			$buttons_hover[] = $button . ':focus';
		}

		$css = new BlogPress_CSS();

		$css->set_selector( implode( ',', $buttons ) );
		$css->add_property( 'color', $settings['form_button_text_color'] );
		$css->add_property( 'background-color', $settings['form_button_background_color'] );

		$css->set_selector( implode( ',', $buttons_hover ) );
		$css->add_property( 'color', $settings['form_button_text_color_hover'] );
		$css->add_property( 'background-color', $settings['form_button_background_color_hover'] );

		if ( $css->css_output() ) {
			wp_add_inline_style( 'blogpress-woocommerce', $css->css_output() );
		}
	}
}

if ( ! function_exists( 'blogpress_bbpress_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'blogpress_bbpress_css', 100 );
	/**
	 * Add bbPress CSS
	 *
	 * @since 1.3.45
	 */
	function blogpress_bbpress_css() {
		if ( ! class_exists( 'bbPress' ) ) {
			return;
		}

		$css = '#bbpress-forums ul.bbp-lead-topic,
		#bbpress-forums ul.bbp-topics,
		#bbpress-forums ul.bbp-forums,
		#bbpress-forums ul.bbp-replies,
		#bbpress-forums ul.bbp-search-results,
		#bbpress-forums,
		div.bbp-breadcrumb,
		div.bbp-topic-tags {
			font-size: inherit;
		}

		.single-forum #subscription-toggle {
			display: block;
			margin: 1em 0;
			clear: left;
		}

		#bbpress-forums .bbp-search-form {
			margin-bottom: 10px;
		}

		.bbp-login-form fieldset {
			border: 0;
			padding: 0;
		}';

		$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
		wp_add_inline_style( 'bbp-default', $css );
	}
}

if ( ! function_exists( 'blogpress_buddypress_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'blogpress_buddypress_css', 100 );
	/**
	 * Add BuddyPress CSS
	 *
	 * @since 1.3.45
	 */
	function blogpress_buddypress_css() {
		if ( ! class_exists( 'BuddyPress' ) ) {
			return;
		}

		$css = '#buddypress form#whats-new-form #whats-new-options[style] {
			min-height: 6rem;
			overflow: visible;
		}';

		$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
		wp_add_inline_style( 'bp-legacy-css', $css );
	}
}

if ( ! function_exists( 'blogpress_beaver_builder_css' ) ) {
	add_action( 'wp_enqueue_scripts', 'blogpress_beaver_builder_css', 100 );
	/**
	 * Add Beaver Builder CSS
	 *
	 * Beaver Builder pages set to no sidebar used to automatically be full width, however
	 * now that we have the Page Builder Container meta box, we want to give the user
	 * the option to set the page to full width or contained.
	 *
	 * We can't remove this CSS as people who are depending on it will lose their full
	 * width layout when they update.
	 *
	 * So instead, we only apply this CSS to posts older than the date of this update.
	 *
	 * @since 1.3.45
	 */
	function blogpress_beaver_builder_css() {
		return;

		$body_classes = get_body_class();

		// Check is Beaver Builder is active
		// If we have the full-width-content class, we don't need to do anything else.
		if ( in_array( 'fl-builder', $body_classes ) && ! in_array( 'full-width-content', $body_classes ) && ! in_array( 'contained-content', $body_classes ) ) {
			global $post;

			if ( ! isset( $post ) ) {
				return;
			}

			$compare_date = strtotime( '2017-03-14' );
			$post_date    = strtotime( $post->post_date );
			if ( $post_date < $compare_date ) {
				$css = '.fl-builder.no-sidebar .container.grid-container {
					max-width: 100%;
				}

				.fl-builder.one-container.no-sidebar .site-content {
					padding:0;
				}';
				$css = str_replace( array( "\r", "\n", "\t" ), '', $css );
				wp_add_inline_style( 'blogpress-style', $css );
			}
		}
	}
}

add_action( 'wp_enqueue_scripts', 'blogpress_do_third_party_plugin_css', 50 );
/**
 * Add CSS for third-party plugins.
 *
 * @since 3.0.1
 */
function blogpress_do_third_party_plugin_css() {
	$css = new BlogPress_CSS();

	if ( class_exists( 'Elementor\Plugin' ) ) {
		$css->set_selector( '.elementor-template-full-width .site-content' );
		$css->add_property( 'display', 'block' );
	}

	if ( $css->css_output() ) {
		wp_add_inline_style( 'blogpress-style', $css->css_output() );
	}
}
