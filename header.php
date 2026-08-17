<?php
/**
 * The template for displaying the header.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php blogpress_do_microdata( 'body' ); ?>>
	<?php
	/**
	 * wp_body_open hook.
	 *
	 * @since 1.0.0
	 */
	do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.

	blogpress_do_skip_to_content_link();
	blogpress_top_bar();
	blogpress_add_navigation_before_header();

	/**
	 * Fires immediately before the site header is output.
	 *
	 * @since 1.0.0
	 */
	do_action( 'blogpress_before_header' );

	blogpress_construct_header();

	blogpress_add_navigation_after_header();

	/**
	 * Fires after the site header and any below-header navigation.
	 *
	 * @since 1.0.0
	 */
	do_action( 'blogpress_after_header' );

	blogpress_featured_page_header();
	?>

	<div <?php blogpress_do_attr( 'page' ); ?>>
		<?php
		/**
		 * Fires inside the page container, before the site content wrapper.
		 *
		 * @since 1.0.0
		 */
		do_action( 'blogpress_inside_container' );
		?>
		<div <?php blogpress_do_attr( 'site-content' ); ?>>
			<?php
			/**
			 * Fires inside the site content wrapper, before the main content.
			 *
			 * @since 1.0.0
			 */
			do_action( 'blogpress_before_main_content' );
