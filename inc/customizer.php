<?php
/**
 * Builds our Customizer controls.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'customize_register', 'blogpress_set_customizer_helpers', 1 );
/**
 * Set up helpers early so they're always available.
 * Other modules might need access to them at some point.
 *
 * @since 2.0
 */
function blogpress_set_customizer_helpers() {
	require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-helpers.php';
}

if ( ! function_exists( 'blogpress_customize_register' ) ) {
	add_action( 'customize_register', 'blogpress_customize_register', 20 );
	/**
	 * Add our base options to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function blogpress_customize_register( $wp_customize ) {
		if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
			return;
		}

		$defaults = blogpress_get_defaults();
		$color_defaults = blogpress_get_color_defaults();
		$typography_defaults = blogpress_get_default_fonts();

		if ( $wp_customize->get_control( 'blogdescription' ) ) {
			$wp_customize->get_control( 'blogdescription' )->priority = 3;
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'blogname' ) ) {
			$wp_customize->get_control( 'blogname' )->priority = 1;
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'custom_logo' ) ) {
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
		}

		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'Blogpress_Range_Slider_Control' );
		}

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector' => '.main-title a',
					'render_callback' => 'blogpress_customize_partial_blogname',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector' => '.site-description',
					'render_callback' => 'blogpress_customize_partial_blogdescription',
				)
			);
		}

		$wp_customize->add_setting(
			'blogpress_settings[hide_title]',
			array(
				'default' => $defaults['hide_title'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[hide_title]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hide site title', 'blogpress' ),
				'section' => 'title_tagline',
				'priority' => 2,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[hide_tagline]',
			array(
				'default' => $defaults['hide_tagline'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[hide_tagline]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hide site tagline', 'blogpress' ),
				'section' => 'title_tagline',
				'priority' => 4,
			)
		);

		if ( ! function_exists( 'the_custom_logo' ) ) {
			$wp_customize->add_setting(
				'blogpress_settings[logo]',
				array(
					'default' => $defaults['logo'],
					'type' => 'option',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'blogpress_settings[logo]',
					array(
						'label' => __( 'Logo', 'blogpress' ),
						'section' => 'title_tagline',
						'settings' => 'blogpress_settings[logo]',
					)
				)
			);
		}

		$wp_customize->add_setting(
			'blogpress_settings[retina_logo]',
			array(
				'default' => $defaults['retina_logo'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'blogpress_settings[retina_logo]',
				array(
					'label' => __( 'Retina Logo', 'blogpress' ),
					'section' => 'title_tagline',
					'settings' => 'blogpress_settings[retina_logo]',
					'active_callback' => 'blogpress_has_custom_logo_callback',
				)
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[logo_width]',
			array(
				'default' => $defaults['logo_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_empty_absint',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Blogpress_Range_Slider_Control(
				$wp_customize,
				'blogpress_settings[logo_width]',
				array(
					'label' => __( 'Logo Width', 'blogpress' ),
					'section' => 'title_tagline',
					'settings' => array(
						'desktop' => 'blogpress_settings[logo_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 20,
							'max' => 1200,
							'step' => 10,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'active_callback' => 'blogpress_has_custom_logo_callback',
				)
			)
		);

		$wp_customize->add_section(
			'blogpress_colors_section',
			array(
				'title' => esc_attr__( 'Colors', 'blogpress' ),
				'priority' => 30,
			)
		);

		BlogPress_Customize_Field::add_title(
			'blogpress_color_manager_title',
			array(
				'section' => 'blogpress_colors_section',
				'title' => __( 'Global Colors', 'blogpress' ),
			)
		);

		BlogPress_Customize_Field::add_field(
			'blogpress_settings[global_colors]',
			'BlogPress_Customize_React_Control',
			array(
				'default' => $defaults['global_colors'],
				'sanitize_callback' => function( $colors ) {
					if ( ! is_array( $colors ) ) {
						return;
					}

					$new_settings = array();

					foreach ( (array) $colors as $key => $data ) {
						if ( empty( $data['slug'] ) || empty( $data['color'] ) ) {
							continue;
						}

						$slug = preg_replace( '/[^a-z0-9-\s]+/i', '', $data['slug'] );
						$slug = strtolower( $slug );
						$new_settings[ $key ]['name'] = sanitize_text_field( $slug );
						$new_settings[ $key ]['slug'] = sanitize_text_field( $slug );
						$new_settings[ $key ]['color'] = blogpress_sanitize_rgba_color( $data['color'] );
					}

					// Reset array keys starting at 0.
					$new_settings = array_values( $new_settings );

					return $new_settings;
				},
				'transport' => 'postMessage',
			),
			array(
				'type' => 'blogpress-color-manager-control',
				'label' => __( 'Choose Color', 'blogpress' ),
				'section' => 'blogpress_colors_section',
				'choices' => array(
					'alpha' => true,
					'showPalette' => false,
					'showReset' => false,
					'showVarName' => true,
				),
			)
		);

		$fields_dir = trailingslashit( get_template_directory() ) . 'inc/customizer/fields';
		require_once $fields_dir . '/body.php';
		require_once $fields_dir . '/top-bar.php';
		require_once $fields_dir . '/header.php';
		require_once $fields_dir . '/primary-navigation.php';

		require_once $fields_dir . '/buttons.php';
		require_once $fields_dir . '/content.php';
		require_once $fields_dir . '/forms.php';
		require_once $fields_dir . '/sidebar-widgets.php';
		require_once $fields_dir . '/footer-widgets.php';
		require_once $fields_dir . '/footer-bar.php';
		require_once $fields_dir . '/back-to-top.php';
		require_once $fields_dir . '/search-modal.php';

		$wp_customize->add_section(
			'blogpress_typography_section',
			array(
				'title' => esc_attr__( 'Typography', 'blogpress' ),
				'priority' => 35,
				'active_callback' => function() {
					return true;
				},
			)
		);

		BlogPress_Customize_Field::add_title(
			'blogpress_font_manager_title',
			array(
				'section' => 'blogpress_typography_section',
				'title' => __( 'Font Manager', 'blogpress' ),
			)
		);

		BlogPress_Customize_Field::add_field(
			'blogpress_settings[font_manager]',
			'BlogPress_Customize_React_Control',
			array(
				'default' => $defaults['font_manager'],
				'sanitize_callback' => function( $fonts ) {
					if ( ! is_array( $fonts ) ) {
						return;
					}

					$options = array(
						'fontFamily' => 'sanitize_text_field',
						'googleFont' => 'rest_sanitize_boolean',
						'googleFontApi' => 'absint',
						'googleFontCategory' => 'sanitize_text_field',
						'googleFontVariants' => 'sanitize_text_field',
					);

					$new_settings = array();

					foreach ( (array) $fonts as $key => $data ) {
						if ( empty( $data['fontFamily'] ) ) {
							continue;
						}

						foreach ( $options as $option => $sanitize ) {
							if ( array_key_exists( $option, $data ) ) {
								$new_settings[ $key ][ $option ] = $sanitize( $data[ $option ] );
							}
						}
					}

					// Reset array keys starting at 0.
					$new_settings = array_values( $new_settings );

					return $new_settings;
				},
				'transport' => 'refresh',
			),
			array(
				'type' => 'blogpress-font-manager-control',
				'label' => __( 'Choose Font', 'blogpress' ),
				'section' => 'blogpress_typography_section',
			)
		);

		BlogPress_Customize_Field::add_field(
			'blogpress_settings[google_font_display]',
			'',
			array(
				'default' => $defaults['google_font_display'],
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'refresh',
			),
			array(
				'type' => 'select',
				'label' => __( 'Google font-display', 'blogpress' ),
				'description' => sprintf(
					'<a href="%s" target="_blank" rel="noreferrer noopener">%s</a>',
					'https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display',
					esc_html__( 'Learn about font-display', 'blogpress' )
				),
				'section' => 'blogpress_typography_section',
				'choices' => array(
					'auto' => esc_html__( 'Auto', 'blogpress' ),
					'block' => esc_html__( 'Block', 'blogpress' ),
					'swap' => esc_html__( 'Swap', 'blogpress' ),
					'fallback' => esc_html__( 'Fallback', 'blogpress' ),
					'optional' => esc_html__( 'Optional', 'blogpress' ),
				),
				'active_callback' => function() {
					$font_manager = blogpress_get_option( 'font_manager' );
					$has_google_font = false;

					foreach ( (array) $font_manager as $key => $data ) {
						if ( ! empty( $data['googleFont'] ) ) {
							$has_google_font = true;
							break;
						}
					}

					return $has_google_font;
				},
			)
		);

		BlogPress_Customize_Field::add_title(
			'blogpress_typography_manager_title',
			array(
				'section' => 'blogpress_typography_section',
				'title' => __( 'Typography Manager', 'blogpress' ),
			)
		);

		BlogPress_Customize_Field::add_field(
			'blogpress_settings[typography]',
			'BlogPress_Customize_React_Control',
			array(
				'default' => $defaults['typography'],
				'sanitize_callback' => function( $settings ) {
					if ( ! is_array( $settings ) ) {
						return;
					}

					$options = array(
						'selector' => 'sanitize_text_field',
						'customSelector' => 'sanitize_text_field',
						'fontFamily' => 'sanitize_text_field',
						'fontWeight' => 'sanitize_text_field',
						'textTransform' => 'sanitize_text_field',
						'textDecoration' => 'sanitize_text_field',
						'fontStyle' => 'sanitize_text_field',
						'fontSize' => 'sanitize_text_field',
						'fontSizeTablet' => 'sanitize_text_field',
						'fontSizeMobile' => 'sanitize_text_field',
						'fontSizeUnit' => 'sanitize_text_field',
						'lineHeight' => 'sanitize_text_field',
						'lineHeightTablet' => 'sanitize_text_field',
						'lineHeightMobile' => 'sanitize_text_field',
						'lineHeightUnit' => 'sanitize_text_field',
						'letterSpacing' => 'sanitize_text_field',
						'letterSpacingTablet' => 'sanitize_text_field',
						'letterSpacingMobile' => 'sanitize_text_field',
						'letterSpacingUnit' => 'sanitize_text_field',
						'marginBottom' => 'sanitize_text_field',
						'marginBottomTablet' => 'sanitize_text_field',
						'marginBottomMobile' => 'sanitize_text_field',
						'marginBottomUnit' => 'sanitize_text_field',
						'module' => 'sanitize_text_field',
						'group' => 'sanitize_text_field',
					);

					$new_settings = array();

					foreach ( (array) $settings as $key => $data ) {
						if ( empty( $data['selector'] ) ) {
							continue;
						}

						foreach ( $options as $option => $sanitize ) {
							if ( array_key_exists( $option, $data ) ) {
								$new_settings[ $key ][ $option ] = $sanitize( $data[ $option ] );
							}
						}
					}

					// Reset array keys starting at 0.
					$new_settings = array_values( $new_settings );

					return $new_settings;
				},
				'transport' => 'refresh',
			),
			array(
				'type' => 'blogpress-typography-control',
				'label' => __( 'Configure', 'blogpress' ),
				'section' => 'blogpress_typography_section',
			)
		);

		if ( ! $wp_customize->get_panel( 'blogpress_layout_panel' ) ) {
			$wp_customize->add_panel(
				'blogpress_layout_panel',
				array(
					'priority' => 25,
					'title' => __( 'Layout', 'blogpress' ),
				)
			);
		}

		$wp_customize->add_section(
			'blogpress_layout_container',
			array(
				'title' => __( 'Container', 'blogpress' ),
				'priority' => 10,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[container_width]',
			array(
				'default' => $defaults['container_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_integer',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Blogpress_Range_Slider_Control(
				$wp_customize,
				'blogpress_settings[container_width]',
				array(
					'type' => 'blogpress-range-slider',
					'label' => __( 'Container Width', 'blogpress' ),
					'section' => 'blogpress_layout_container',
					'settings' => array(
						'desktop' => 'blogpress_settings[container_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 700,
							'max' => 2000,
							'step' => 5,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 0,
				)
			)
		);

		$wp_customize->add_section(
			'blogpress_top_bar',
			array(
				'title' => __( 'Top Bar', 'blogpress' ),
				'priority' => 15,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[top_bar_width]',
			array(
				'default' => $defaults['top_bar_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[top_bar_width]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Width', 'blogpress' ),
				'section' => 'blogpress_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'blogpress' ),
					'contained' => __( 'Contained', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[top_bar_width]',
				'priority' => 5,
				'active_callback' => 'blogpress_is_top_bar_active',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[top_bar_inner_width]',
			array(
				'default' => $defaults['top_bar_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[top_bar_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Inner Width', 'blogpress' ),
				'section' => 'blogpress_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'blogpress' ),
					'contained' => __( 'Contained', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[top_bar_inner_width]',
				'priority' => 10,
				'active_callback' => 'blogpress_is_top_bar_active',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[top_bar_alignment]',
			array(
				'default' => $defaults['top_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[top_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Alignment', 'blogpress' ),
				'section' => 'blogpress_top_bar',
				'choices' => array(
					'left' => __( 'Left', 'blogpress' ),
					'center' => __( 'Center', 'blogpress' ),
					'right' => __( 'Right', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[top_bar_alignment]',
				'priority' => 15,
				'active_callback' => 'blogpress_is_top_bar_active',
			)
		);

		$wp_customize->add_section(
			'blogpress_layout_header',
			array(
				'title' => __( 'Header', 'blogpress' ),
				'priority' => 20,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_header_helper',
			array(
				'default' => 'current',
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_preset_layout',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_header_helper',
			array(
				'type' => 'select',
				'label' => __( 'Header Presets', 'blogpress' ),
				'section' => 'blogpress_layout_header',
				'choices' => array(
					'current' => __( 'Current', 'blogpress' ),
					'default' => __( 'Default', 'blogpress' ),
					'classic' => __( 'Classic', 'blogpress' ),
					'nav-before' => __( 'Navigation Before', 'blogpress' ),
					'nav-after' => __( 'Navigation After', 'blogpress' ),
					'nav-before-centered' => __( 'Navigation Before - Centered', 'blogpress' ),
					'nav-after-centered' => __( 'Navigation After - Centered', 'blogpress' ),
					'nav-left' => __( 'Navigation Left', 'blogpress' ),
				),
				'settings' => 'blogpress_header_helper',
				'priority' => 4,
			)
		);

		if ( ! $wp_customize->get_setting( 'blogpress_settings[site_title_font_size]' ) ) {
			$typography_defaults = blogpress_get_default_fonts();

			$wp_customize->add_setting(
				'blogpress_settings[site_title_font_size]',
				array(
					'default' => $typography_defaults['site_title_font_size'],
					'type' => 'option',
					'sanitize_callback' => 'absint',
					'transport' => 'postMessage',
				)
			);
		}

		if ( ! $wp_customize->get_setting( 'blogpress_spacing_settings[header_top]' ) ) {
			$spacing_defaults = blogpress_spacing_get_defaults();

			$wp_customize->add_setting(
				'blogpress_spacing_settings[header_top]',
				array(
					'default' => $spacing_defaults['header_top'],
					'type' => 'option',
					'sanitize_callback' => 'absint',
					'transport' => 'postMessage',
				)
			);
		}

		if ( ! $wp_customize->get_setting( 'blogpress_spacing_settings[header_bottom]' ) ) {
			$spacing_defaults = blogpress_spacing_get_defaults();

			$wp_customize->add_setting(
				'blogpress_spacing_settings[header_bottom]',
				array(
					'default' => $spacing_defaults['header_bottom'],
					'type' => 'option',
					'sanitize_callback' => 'absint',
					'transport' => 'postMessage',
				)
			);
		}

		$wp_customize->add_setting(
			'blogpress_settings[header_layout_setting]',
			array(
				'default' => $defaults['header_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[header_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Header Width', 'blogpress' ),
				'section' => 'blogpress_layout_header',
				'choices' => array(
					'fluid-header' => __( 'Full', 'blogpress' ),
					'contained-header' => __( 'Contained', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[header_layout_setting]',
				'priority' => 5,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[header_inner_width]',
			array(
				'default' => $defaults['header_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[header_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Header Width', 'blogpress' ),
				'section' => 'blogpress_layout_header',
				'choices' => array(
					'contained' => __( 'Contained', 'blogpress' ),
					'full-width' => __( 'Full', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[header_inner_width]',
				'priority' => 6,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[header_alignment_setting]',
			array(
				'default' => $defaults['header_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[header_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Header Alignment', 'blogpress' ),
				'section' => 'blogpress_layout_header',
				'choices' => array(
					'left' => __( 'Left', 'blogpress' ),
					'center' => __( 'Center', 'blogpress' ),
					'right' => __( 'Right', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[header_alignment_setting]',
				'priority' => 10,
			)
		);

		$wp_customize->add_section(
			'blogpress_layout_navigation',
			array(
				'title' => __( 'Primary Navigation', 'blogpress' ),
				'priority' => 30,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_layout_setting]',
			array(
				'default' => $defaults['nav_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Width', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'fluid-nav' => __( 'Full', 'blogpress' ),
					'contained-nav' => __( 'Contained', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_layout_setting]',
				'priority' => 15,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_inner_width]',
			array(
				'default' => $defaults['nav_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Navigation Width', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'contained' => __( 'Contained', 'blogpress' ),
					'full-width' => __( 'Full', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_inner_width]',
				'priority' => 16,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_alignment_setting]',
			array(
				'default' => $defaults['nav_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Alignment', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'left' => __( 'Left', 'blogpress' ),
					'center' => __( 'Center', 'blogpress' ),
					'right' => __( 'Right', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_alignment_setting]',
				'priority' => 20,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_position_setting]',
			array(
				'default' => $defaults['nav_position_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_position_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Location', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'nav-below-header' => __( 'Below Header', 'blogpress' ),
					'nav-above-header' => __( 'Above Header', 'blogpress' ),
					'nav-float-right' => __( 'Float Right', 'blogpress' ),
					'nav-float-left' => __( 'Float Left', 'blogpress' ),
					'nav-left-sidebar' => __( 'Left Sidebar', 'blogpress' ),
					'nav-right-sidebar' => __( 'Right Sidebar', 'blogpress' ),
					'' => __( 'No Navigation', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_position_setting]',
				'priority' => 22,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_drop_point]',
			array(
				'default' => $defaults['nav_drop_point'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_empty_absint',
			)
		);

		$wp_customize->add_control(
			new Blogpress_Range_Slider_Control(
				$wp_customize,
				'blogpress_settings[nav_drop_point]',
				array(
					'label' => __( 'Navigation Drop Point', 'blogpress' ),
					'sub_description' => __( 'The width when the navigation ceases to float and drops below your logo.', 'blogpress' ),
					'section' => 'blogpress_layout_navigation',
					'settings' => array(
						'desktop' => 'blogpress_settings[nav_drop_point]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 500,
							'max' => 2000,
							'step' => 10,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 22,
				)
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_dropdown_type]',
			array(
				'default' => $defaults['nav_dropdown_type'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_dropdown_type]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Dropdown', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'hover' => __( 'Hover', 'blogpress' ),
					'click' => __( 'Click - Menu Item', 'blogpress' ),
					'click-arrow' => __( 'Click - Arrow', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_dropdown_type]',
				'priority' => 22,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_dropdown_direction]',
			array(
				'default' => $defaults['nav_dropdown_direction'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_dropdown_direction]',
			array(
				'type' => 'select',
				'label' => __( 'Dropdown Direction', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'right' => __( 'Right', 'blogpress' ),
					'left' => __( 'Left', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_dropdown_direction]',
				'priority' => 22,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_search]',
			array(
				'default' => $defaults['nav_search'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_search]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Search', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'choices' => array(
					'enable' => __( 'Enable', 'blogpress' ),
					'disable' => __( 'Disable', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[nav_search]',
				'priority' => 23,
				'active_callback' => function() {
					return 'enable' === blogpress_get_option( 'nav_search' ) || 'font' === blogpress_get_option( 'icons' );
				},
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[nav_search_modal]',
			array(
				'default' => $defaults['nav_search_modal'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[nav_search_modal]',
			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Enable navigation search modal', 'blogpress' ),
				'section' => 'blogpress_layout_navigation',
				'priority' => 23,
				'active_callback' => function() {
					return 'disable' === blogpress_get_option( 'nav_search' ) && 'svg' === blogpress_get_option( 'icons' );
				},
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[content_layout_setting]',
			array(
				'default' => $defaults['content_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[content_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Content Layout', 'blogpress' ),
				'section' => 'blogpress_layout_container',
				'choices' => array(
					'separate-containers' => __( 'Separate Containers', 'blogpress' ),
					'one-container' => __( 'One Container', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[content_layout_setting]',
				'priority' => 25,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[container_alignment]',
			array(
				'default' => $defaults['container_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[container_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Container Alignment', 'blogpress' ),
				'section' => 'blogpress_layout_container',
				'choices' => array(
					'boxes' => __( 'Boxes', 'blogpress' ),
					'text' => __( 'Text', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[container_alignment]',
				'priority' => 30,
			)
		);

		$wp_customize->add_section(
			'blogpress_layout_sidebars',
			array(
				'title' => __( 'Sidebars', 'blogpress' ),
				'priority' => 40,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[layout_setting]',
			array(
				'default' => $defaults['layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Sidebar Layout', 'blogpress' ),
				'section' => 'blogpress_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'blogpress' ),
					'right-sidebar' => __( 'Content / Sidebar', 'blogpress' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'blogpress' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'blogpress' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'blogpress' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[layout_setting]',
				'priority' => 30,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[blog_layout_setting]',
			array(
				'default' => $defaults['blog_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[blog_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Blog Sidebar Layout', 'blogpress' ),
				'section' => 'blogpress_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'blogpress' ),
					'right-sidebar' => __( 'Content / Sidebar', 'blogpress' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'blogpress' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'blogpress' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'blogpress' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[blog_layout_setting]',
				'priority' => 35,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[single_layout_setting]',
			array(
				'default' => $defaults['single_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[single_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Single Post Sidebar Layout', 'blogpress' ),
				'section' => 'blogpress_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'blogpress' ),
					'right-sidebar' => __( 'Content / Sidebar', 'blogpress' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'blogpress' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'blogpress' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'blogpress' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[single_layout_setting]',
				'priority' => 36,
			)
		);

		$wp_customize->add_section(
			'blogpress_layout_footer',
			array(
				'title' => __( 'Footer', 'blogpress' ),
				'priority' => 50,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[footer_layout_setting]',
			array(
				'default' => $defaults['footer_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[footer_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Width', 'blogpress' ),
				'section' => 'blogpress_layout_footer',
				'choices' => array(
					'fluid-footer' => __( 'Full', 'blogpress' ),
					'contained-footer' => __( 'Contained', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[footer_layout_setting]',
				'priority' => 40,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[footer_inner_width]',
			array(
				'default' => $defaults['footer_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[footer_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Footer Width', 'blogpress' ),
				'section' => 'blogpress_layout_footer',
				'choices' => array(
					'contained' => __( 'Contained', 'blogpress' ),
					'full-width' => __( 'Full', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[footer_inner_width]',
				'priority' => 41,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[footer_widget_setting]',
			array(
				'default' => $defaults['footer_widget_setting'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[footer_widget_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Widgets', 'blogpress' ),
				'section' => 'blogpress_layout_footer',
				'choices' => array(
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'settings' => 'blogpress_settings[footer_widget_setting]',
				'priority' => 45,
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[footer_bar_alignment]',
			array(
				'default' => $defaults['footer_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[footer_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Bar Alignment', 'blogpress' ),
				'section' => 'blogpress_layout_footer',
				'choices' => array(
					'left' => __( 'Left', 'blogpress' ),
					'center' => __( 'Center', 'blogpress' ),
					'right' => __( 'Right', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[footer_bar_alignment]',
				'priority' => 47,
				'active_callback' => 'blogpress_is_footer_bar_active',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[back_to_top]',
			array(
				'default' => $defaults['back_to_top'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[back_to_top]',
			array(
				'type' => 'select',
				'label' => __( 'Back to Top Button', 'blogpress' ),
				'section' => 'blogpress_layout_footer',
				'choices' => array(
					'enable' => __( 'Enable', 'blogpress' ),
					'' => __( 'Disable', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[back_to_top]',
				'priority' => 50,
			)
		);

		// The options below only make sense once the button is switched on.
		$back_to_top_is_active = function() {
			return 'enable' === blogpress_get_option( 'back_to_top' );
		};

		$back_to_top_options = array(
			'back_to_top_position' => array(
				'label' => __( 'Button Position', 'blogpress' ),
				'type' => 'select',
				'sanitize' => 'blogpress_sanitize_choices',
				'choices' => array(
					'right' => __( 'Bottom Right', 'blogpress' ),
					'left' => __( 'Bottom Left', 'blogpress' ),
				),
				'priority' => 51,
			),
			'back_to_top_size' => array(
				'label' => __( 'Button Size', 'blogpress' ),
				'description' => __( 'Width and height of the button, in pixels.', 'blogpress' ),
				'type' => 'number',
				'sanitize' => 'blogpress_sanitize_integer',
				'input_attrs' => array(
					'min' => 20,
					'max' => 100,
					'step' => 1,
				),
				'priority' => 52,
			),
			'back_to_top_border_radius' => array(
				'label' => __( 'Border Radius', 'blogpress' ),
				'description' => __( 'Use half the button size for a circle.', 'blogpress' ),
				'type' => 'number',
				'sanitize' => 'blogpress_sanitize_integer',
				'input_attrs' => array(
					'min' => 0,
					'max' => 50,
					'step' => 1,
				),
				'priority' => 53,
			),
			'back_to_top_offset' => array(
				'label' => __( 'Distance From Edge', 'blogpress' ),
				'description' => __( 'Space between the button and the edge of the screen, in pixels.', 'blogpress' ),
				'type' => 'number',
				'sanitize' => 'blogpress_sanitize_integer',
				'input_attrs' => array(
					'min' => 0,
					'max' => 200,
					'step' => 1,
				),
				'priority' => 54,
			),
			'back_to_top_scroll_start' => array(
				'label' => __( 'Show After Scrolling', 'blogpress' ),
				'description' => __( 'How far down the page the visitor must scroll before the button appears, in pixels.', 'blogpress' ),
				'type' => 'number',
				'sanitize' => 'blogpress_sanitize_integer',
				'input_attrs' => array(
					'min' => 0,
					'step' => 50,
				),
				'priority' => 55,
			),
			'back_to_top_scroll_speed' => array(
				'label' => __( 'Scroll Speed', 'blogpress' ),
				'description' => __( 'Duration of the scroll animation, in milliseconds.', 'blogpress' ),
				'type' => 'number',
				'sanitize' => 'blogpress_sanitize_integer',
				'input_attrs' => array(
					'min' => 0,
					'max' => 3000,
					'step' => 50,
				),
				'priority' => 56,
			),
		);

		foreach ( $back_to_top_options as $option => $args ) {
			$wp_customize->add_setting(
				'blogpress_settings[' . $option . ']',
				array(
					'default' => $defaults[ $option ],
					'type' => 'option',
					'sanitize_callback' => $args['sanitize'],
				)
			);

			$control_args = array(
				'type' => $args['type'],
				'label' => $args['label'],
				'section' => 'blogpress_layout_footer',
				'settings' => 'blogpress_settings[' . $option . ']',
				'priority' => $args['priority'],
				'active_callback' => $back_to_top_is_active,
			);

			if ( isset( $args['description'] ) ) {
				$control_args['description'] = $args['description'];
			}

			if ( isset( $args['choices'] ) ) {
				$control_args['choices'] = $args['choices'];
			}

			if ( isset( $args['input_attrs'] ) ) {
				$control_args['input_attrs'] = $args['input_attrs'];
			}

			$wp_customize->add_control( 'blogpress_settings[' . $option . ']', $control_args );
		}

		$wp_customize->add_setting(
			'blogpress_settings[back_to_top_smooth_scroll]',
			array(
				'default' => $defaults['back_to_top_smooth_scroll'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[back_to_top_smooth_scroll]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Smooth Scrolling', 'blogpress' ),
				'description' => __( 'Animate the scroll instead of jumping straight to the top.', 'blogpress' ),
				'section' => 'blogpress_layout_footer',
				'settings' => 'blogpress_settings[back_to_top_smooth_scroll]',
				'priority' => 57,
				'active_callback' => $back_to_top_is_active,
			)
		);

		$wp_customize->add_section(
			'blogpress_blog_section',
			array(
				'title' => __( 'Blog', 'blogpress' ),
				'priority' => 55,
				'panel' => 'blogpress_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[post_content]',
			array(
				'default' => $defaults['post_content'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_blog_excerpt',
			)
		);

		$wp_customize->add_control(
			'blog_content_control',
			array(
				'type' => 'select',
				'label' => __( 'Content Type', 'blogpress' ),
				'section' => 'blogpress_blog_section',
				'choices' => array(
					'full' => __( 'Full Content', 'blogpress' ),
					'excerpt' => __( 'Excerpt', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[post_content]',
				'priority' => 10,
			)
		);

		$wp_customize->add_section(
			'blogpress_general_section',
			array(
				'title' => __( 'General', 'blogpress' ),
				'priority' => 99,
			)
		);

		if ( ! blogpress_get_option( 'font_awesome_essentials' ) ) {
			$wp_customize->add_setting(
				'blogpress_settings[font_awesome_essentials]',
				array(
					'default' => $defaults['font_awesome_essentials'],
					'type' => 'option',
					'sanitize_callback' => 'blogpress_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'blogpress_settings[font_awesome_essentials]',
				array(
					'type' => 'checkbox',
					'label' => __( 'Load essential icons only', 'blogpress' ),
					'description' => __( 'Load essential Font Awesome icons instead of the full library.', 'blogpress' ),
					'section' => 'blogpress_general_section',
					'settings' => 'blogpress_settings[font_awesome_essentials]',
				)
			);
		}

		$wp_customize->add_setting(
			'blogpress_settings[icons]',
			array(
				'default' => $defaults['icons'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[icons]',
			array(
				'type' => 'select',
				'label' => __( 'Icon Type', 'blogpress' ),
				'section' => 'blogpress_general_section',
				'choices' => array(
					'svg' => __( 'SVG', 'blogpress' ),
					'font' => __( 'Font', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[icons]',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[underline_links]',
			array(
				'default' => $defaults['underline_links'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[underline_links]',
			array(
				'type' => 'select',
				'label' => __( 'Underline Links', 'blogpress' ),
				'description' => __( 'Add underlines to your links in your main content areas.', 'blogpress' ),
				'section' => 'blogpress_general_section',
				'choices' => array(
					'always' => __( 'Always', 'blogpress' ),
					'hover' => __( 'On hover', 'blogpress' ),
					'not-hover' => __( 'Not on hover', 'blogpress' ),
					'never' => __( 'Never', 'blogpress' ),
				),
				'settings' => 'blogpress_settings[underline_links]',
			)
		);

		$wp_customize->add_setting(
			'blogpress_settings[dynamic_css_cache]',
			array(
				'default' => $defaults['dynamic_css_cache'],
				'type' => 'option',
				'sanitize_callback' => 'blogpress_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'blogpress_settings[dynamic_css_cache]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Cache dynamic CSS', 'blogpress' ),
				'description' => __( 'Cache CSS blogpressd by your options to boost performance.', 'blogpress' ),
				'section' => 'blogpress_general_section',
			)
		);
	}
}
