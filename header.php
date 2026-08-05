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

	blogpress_construct_header();

	blogpress_add_navigation_after_header();
	blogpress_featured_page_header();
	?>

	<div <?php blogpress_do_attr( 'page' ); ?>>
		<?php
		?>
		<div <?php blogpress_do_attr( 'site-content' ); ?>>
			<?php
