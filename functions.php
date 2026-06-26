<?php
/**
 * Advanced WordPress Theme Functions
 * Includes comprehensive customizer settings and header/footer builder
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function advanced_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'advanced-theme'),
        'footer' => __('Footer Menu', 'advanced-theme'),
        'mobile' => __('Mobile Menu', 'advanced-theme'),
    ));
    
    // Add image sizes
    add_image_size('hero-banner', 1920, 800, true);
    add_image_size('featured-large', 800, 600, true);
    add_image_size('featured-medium', 400, 300, true);
}
add_action('after_setup_theme', 'advanced_theme_setup');

/**
 * Enqueue styles and scripts
 */
function advanced_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style('advanced-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Google Fonts
    $google_fonts = get_theme_mod('typography_google_fonts', 'Inter:300,400,500,600,700');
    if (!empty($google_fonts)) {
        wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=' . urlencode($google_fonts) . '&display=swap');
    }
    
    // Custom CSS
    wp_add_inline_style('advanced-theme-style', advanced_theme_custom_css());
    
    // JavaScript
    wp_enqueue_script('advanced-theme-script', get_template_directory_uri() . '/js/theme.js', array('jquery'), '1.0.0', true);
    
    // Customizer live preview
    if (is_customize_preview()) {
        wp_enqueue_script('advanced-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array('jquery', 'customize-preview'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'advanced_theme_scripts');

/**
 * Register widget areas
 */
function advanced_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'advanced-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'advanced-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 1', 'advanced-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here.', 'advanced-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 2', 'advanced-theme'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here.', 'advanced-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 3', 'advanced-theme'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here.', 'advanced-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 4', 'advanced-theme'),
        'id'            => 'footer-4',
        'description'   => __('Add widgets here.', 'advanced-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'advanced_theme_widgets_init');

/**
 * Customizer Settings
 */
function advanced_theme_customize_register($wp_customize) {
    
    // Custom Colors Panel
    $wp_customize->add_panel('colors_panel', array(
        'title'    => __('Theme Colors', 'advanced-theme'),
        'priority' => 30,
    ));
    
    // Primary Colors Section
    $wp_customize->add_section('primary_colors', array(
        'title' => __('Primary Colors', 'advanced-theme'),
        'panel' => 'colors_panel',
    ));
    
    $wp_customize->add_setting('primary_color', array(
        'default'   => '#007cba',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'advanced-theme'),
        'section' => 'primary_colors',
    )));
    
    $wp_customize->add_setting('secondary_color', array(
        'default'   => '#005a87',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'   => __('Secondary Color', 'advanced-theme'),
        'section' => 'primary_colors',
    )));
    
    $wp_customize->add_setting('accent_color', array(
        'default'   => '#ff6b35',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'   => __('Accent Color', 'advanced-theme'),
        'section' => 'primary_colors',
    )));
    
    // Text Colors Section
    $wp_customize->add_section('text_colors', array(
        'title' => __('Text Colors', 'advanced-theme'),
        'panel' => 'colors_panel',
    ));
    
    $wp_customize->add_setting('text_color', array(
        'default'   => '#333333',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'text_color', array(
        'label'   => __('Text Color', 'advanced-theme'),
        'section' => 'text_colors',
    )));
    
    $wp_customize->add_setting('heading_color', array(
        'default'   => '#222222',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'heading_color', array(
        'label'   => __('Heading Color', 'advanced-theme'),
        'section' => 'text_colors',
    )));
    
    $wp_customize->add_setting('link_color', array(
        'default'   => '#007cba',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_color', array(
        'label'   => __('Link Color', 'advanced-theme'),
        'section' => 'text_colors',
    )));
    
    $wp_customize->add_setting('link_hover_color', array(
        'default'   => '#005a87',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_hover_color', array(
        'label'   => __('Link Hover Color', 'advanced-theme'),
        'section' => 'text_colors',
    )));
    
    // Typography Panel
    $wp_customize->add_panel('typography_panel', array(
        'title'    => __('Typography', 'advanced-theme'),
        'priority' => 40,
    ));
    
    // Google Fonts Section
    $wp_customize->add_section('google_fonts', array(
        'title' => __('Google Fonts', 'advanced-theme'),
        'panel' => 'typography_panel',
    ));
    
    $wp_customize->add_setting('typography_google_fonts', array(
        'default'   => 'Inter:300,400,500,600,700',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('typography_google_fonts', array(
        'label'   => __('Google Fonts URL', 'advanced-theme'),
        'section' => 'google_fonts',
        'type'    => 'text',
        'description' => __('Enter Google Fonts URL (e.g., Inter:300,400,500,600,700)', 'advanced-theme'),
    ));
    
    // Body Typography Section
    $wp_customize->add_section('body_typography', array(
        'title' => __('Body Typography', 'advanced-theme'),
        'panel' => 'typography_panel',
    ));
    
    $wp_customize->add_setting('body_font_family', array(
        'default'   => 'Inter, sans-serif',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('body_font_family', array(
        'label'   => __('Font Family', 'advanced-theme'),
        'section' => 'body_typography',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('body_font_size', array(
        'default'   => '16',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('body_font_size', array(
        'label'   => __('Font Size (px)', 'advanced-theme'),
        'section' => 'body_typography',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
        ),
    ));
    
    $wp_customize->add_setting('body_line_height', array(
        'default'   => '1.6',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('body_line_height', array(
        'label'   => __('Line Height', 'advanced-theme'),
        'section' => 'body_typography',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 3,
            'step' => 0.1,
        ),
    ));
    
    // Heading Typography Section
    $wp_customize->add_section('heading_typography', array(
        'title' => __('Heading Typography', 'advanced-theme'),
        'panel' => 'typography_panel',
    ));
    
    $wp_customize->add_setting('heading_font_family', array(
        'default'   => 'Inter, sans-serif',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('heading_font_family', array(
        'label'   => __('Heading Font Family', 'advanced-theme'),
        'section' => 'heading_typography',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('heading_font_weight', array(
        'default'   => '600',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('heading_font_weight', array(
        'label'   => __('Heading Font Weight', 'advanced-theme'),
        'section' => 'heading_typography',
        'type'    => 'select',
        'choices' => array(
            '300' => '300 (Light)',
            '400' => '400 (Normal)',
            '500' => '500 (Medium)',
            '600' => '600 (Semi Bold)',
            '700' => '700 (Bold)',
            '800' => '800 (Extra Bold)',
        ),
    ));
    
    // Layout Panel
    $wp_customize->add_panel('layout_panel', array(
        'title'    => __('Layout Options', 'advanced-theme'),
        'priority' => 50,
    ));
    
    // Container Section
    $wp_customize->add_section('container_settings', array(
        'title' => __('Container Settings', 'advanced-theme'),
        'panel' => 'layout_panel',
    ));
    
    $wp_customize->add_setting('container_width', array(
        'default'   => '1200',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('container_width', array(
        'label'   => __('Container Max Width (px)', 'advanced-theme'),
        'section' => 'container_settings',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 960,
            'max' => 1920,
        ),
    ));
    
    $wp_customize->add_setting('site_layout', array(
        'default'   => 'wide',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('site_layout', array(
        'label'   => __('Site Layout', 'advanced-theme'),
        'section' => 'container_settings',
        'type'    => 'select',
        'choices' => array(
            'boxed' => __('Boxed', 'advanced-theme'),
            'wide'  => __('Wide', 'advanced-theme'),
            'full'  => __('Full Width', 'advanced-theme'),
        ),
    ));
    
    // Header Builder Panel
    $wp_customize->add_panel('header_builder_panel', array(
        'title'    => __('Header Builder', 'advanced-theme'),
        'priority' => 60,
    ));
    
    // Header Layout Section
    $wp_customize->add_section('header_layout', array(
        'title' => __('Header Layout', 'advanced-theme'),
        'panel' => 'header_builder_panel',
    ));
    
    $wp_customize->add_setting('header_layout_type', array(
        'default'   => 'default',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_layout_type', array(
        'label'   => __('Header Layout', 'advanced-theme'),
        'section' => 'header_layout',
        'type'    => 'select',
        'choices' => array(
            'default' => __('Logo Left, Menu Right', 'advanced-theme'),
            'center'  => __('Logo Center, Menu Below', 'advanced-theme'),
            'split'   => __('Logo Center, Menu Split', 'advanced-theme'),
            'minimal' => __('Minimal Header', 'advanced-theme'),
        ),
    ));
    
    $wp_customize->add_setting('header_height', array(
        'default'   => '80',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('header_height', array(
        'label'   => __('Header Height (px)', 'advanced-theme'),
        'section' => 'header_layout',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 60,
            'max' => 150,
        ),
    ));
    
    $wp_customize->add_setting('header_sticky', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_sticky', array(
        'label'   => __('Sticky Header', 'advanced-theme'),
        'section' => 'header_layout',
        'type'    => 'checkbox',
    ));
    
    // Header Elements Section
    $wp_customize->add_section('header_elements', array(
        'title' => __('Header Elements', 'advanced-theme'),
        'panel' => 'header_builder_panel',
    ));
    
    $wp_customize->add_setting('header_search', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('header_search', array(
        'label'   => __('Show Search Icon', 'advanced-theme'),
        'section' => 'header_elements',
        'type'    => 'checkbox',
    ));
    
    $wp_customize->add_setting('header_button_text', array(
        'default'   => '',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('header_button_text', array(
        'label'   => __('Header Button Text', 'advanced-theme'),
        'section' => 'header_elements',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('header_button_url', array(
        'default'   => '',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('header_button_url', array(
        'label'   => __('Header Button URL', 'advanced-theme'),
        'section' => 'header_elements',
        'type'    => 'url',
    ));
    
    // Footer Builder Panel
    $wp_customize->add_panel('footer_builder_panel', array(
        'title'    => __('Footer Builder', 'advanced-theme'),
        'priority' => 70,
    ));
    
    // Footer Layout Section
    $wp_customize->add_section('footer_layout', array(
        'title' => __('Footer Layout', 'advanced-theme'),
        'panel' => 'footer_builder_panel',
    ));
    
    $wp_customize->add_setting('footer_columns', array(
        'default'   => '4',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_columns', array(
        'label'   => __('Footer Columns', 'advanced-theme'),
        'section' => 'footer_layout',
        'type'    => 'select',
        'choices' => array(
            '1' => __('1 Column', 'advanced-theme'),
            '2' => __('2 Columns', 'advanced-theme'),
            '3' => __('3 Columns', 'advanced-theme'),
            '4' => __('4 Columns', 'advanced-theme'),
        ),
    ));
    
    $wp_customize->add_setting('footer_copyright', array(
        'default'   => '© 2025 Your Site Name. All rights reserved.',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Copyright Text', 'advanced-theme'),
        'section' => 'footer_layout',
        'type'    => 'textarea',
    ));
    
    // Footer Colors Section
    $wp_customize->add_section('footer_colors', array(
        'title' => __('Footer Colors', 'advanced-theme'),
        'panel' => 'footer_builder_panel',
    ));
    
    $wp_customize->add_setting('footer_bg_color', array(
        'default'   => '#1a1a1a',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
        'label'   => __('Footer Background Color', 'advanced-theme'),
        'section' => 'footer_colors',
    )));
    
    $wp_customize->add_setting('footer_text_color', array(
        'default'   => '#ffffff',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
        'label'   => __('Footer Text Color', 'advanced-theme'),
        'section' => 'footer_colors',
    )));
    
    // Blog Settings Panel
    $wp_customize->add_panel('blog_panel', array(
        'title'    => __('Blog Settings', 'advanced-theme'),
        'priority' => 80,
    ));
    
    // Blog Layout Section
    $wp_customize->add_section('blog_layout', array(
        'title' => __('Blog Layout', 'advanced-theme'),
        'panel' => 'blog_panel',
    ));
    
    $wp_customize->add_setting('blog_layout_type', array(
        'default'   => 'grid',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('blog_layout_type', array(
        'label'   => __('Blog Layout', 'advanced-theme'),
        'section' => 'blog_layout',
        'type'    => 'select',
        'choices' => array(
            'list'     => __('List View', 'advanced-theme'),
            'grid'     => __('Grid View', 'advanced-theme'),
            'masonry'  => __('Masonry', 'advanced-theme'),
            'magazine' => __('Magazine Style', 'advanced-theme'),
        ),
    ));
    
    $wp_customize->add_setting('blog_sidebar', array(
        'default'   => 'right',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('blog_sidebar', array(
        'label'   => __('Blog Sidebar', 'advanced-theme'),
        'section' => 'blog_layout',
        'type'    => 'select',
        'choices' => array(
            'left'  => __('Left Sidebar', 'advanced-theme'),
            'right' => __('Right Sidebar', 'advanced-theme'),
            'none'  => __('No Sidebar', 'advanced-theme'),
        ),
    ));
    
    // Performance Section
    $wp_customize->add_section('performance', array(
        'title' => __('Performance', 'advanced-theme'),
        'priority' => 90,
    ));
    
    $wp_customize->add_setting('lazy_loading', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('lazy_loading', array(
        'label'   => __('Enable Lazy Loading', 'advanced-theme'),
        'section' => 'performance',
        'type'    => 'checkbox',
    ));
    
    $wp_customize->add_setting('preload_fonts', array(
        'default'   => true,
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('preload_fonts', array(
        'label'   => __('Preload Google Fonts', 'advanced-theme'),
        'section' => 'performance',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'advanced_theme_customize_register');

/**
 * Generate Custom CSS
 */
function advanced_theme_custom_css() {
    $css = '';
    
    // Colors
    $primary_color = get_theme_mod('primary_color', '#007cba');
    $secondary_color = get_theme_mod('secondary_color', '#005a87');
    $accent_color = get_theme_mod('accent_color', '#ff6b35');
    $text_color = get_theme_mod('text_color', '#333333');
    $heading_color = get_theme_mod('heading_color', '#222222');
    $link_color = get_theme_mod('link_color', '#007cba');
    $link_hover_color = get_theme_mod('link_hover_color', '#005a87');
    
    $css .= "
    :root {
        --primary-color: {$primary_color};
        --secondary-color: {$secondary_color};
        --accent-color: {$accent_color};
        --text-color: {$text_color};
        --heading-color: {$heading_color};
        --link-color: {$link_color};
        --link-hover-color: {$link_hover_color};
    }
    
    body {
        color: {$text_color};
    }
    
    h1, h2, h3, h4, h5, h6 {
        color: {$heading_color};
    }
    
    a {
        color: {$link_color};
    }
    
    a:hover {
        color: {$link_hover_color};
    }
    
    .btn-primary {
        background-color: {$primary_color};
        border-color: {$primary_color};
    }
    
    .btn-primary:hover {
        background-color: {$secondary_color};
        border-color: {$secondary_color};
    }
    ";
    
    // Typography
    $body_font_family = get_theme_mod('body_font_family', 'Inter, sans-serif');
    $body_font_size = get_theme_mod('body_font_size', '16');
    $body_line_height = get_theme_mod('body_line_height', '1.6');
    $heading_font_family = get_theme_mod('heading_font_family', 'Inter, sans-serif');
    $heading_font_weight = get_theme_mod('heading_font_weight', '600');
    
    $css .= "
    body {
        font-family: {$body_font_family};
        font-size: {$body_font_size}px;
        line-height: {$body_line_height};
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: {$heading_font_family};
        font-weight: {$heading_font_weight};
    }
    ";
    
    // Layout
    $container_width = get_theme_mod('container_width', '1200');
    $header_height = get_theme_mod('header_height', '80');
    
    $css .= "
    .container {
        max-width: {$container_width}px;
    }
    
    .site-header {
        min-height: {$header_height}px;
    }
    ";
    
    // Footer
    $footer_bg_color = get_theme_mod('footer_bg_color', '#1a1a1a');
    $footer_text_color = get_theme_mod('footer_text_color', '#ffffff');
    
    $css .= "
    .site-footer {
        background-color: {$footer_bg_color};
        color: {$footer_text_color};
    }
    
    .site-footer a {
        color: {$footer_text_color};
        opacity: 0.8;
    }
    
    .site-footer a:hover {
        opacity: 1;
    }
    ";
    
    return $css;
}