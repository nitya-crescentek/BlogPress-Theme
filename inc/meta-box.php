<?php
/**
 * Builds our main Layout meta box.
 *
 * @package BlogPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'admin_enqueue_scripts', 'blogpress_enqueue_meta_box_scripts' );
/**
 * Adds any scripts for this meta box.
 *
 * @since 1.0.0
 *
 * @param string $hook The current admin page.
 */
function blogpress_enqueue_meta_box_scripts( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		$post_types = get_post_types( array( 'public' => true ) );
		$screen = get_current_screen();
		$post_type = $screen->id;

		if ( in_array( $post_type, (array) $post_types ) ) {
			wp_enqueue_style( 'blogpress-layout-metabox', get_template_directory_uri() . '/assets/css/admin/meta-box.css', array(), BLOGPRESS_VERSION );
		}
	}
}

add_action( 'add_meta_boxes', 'blogpress_register_layout_meta_box' );
/**
 * Blogpress the layout metabox
 *
 * @since 1.0.0
 */
function blogpress_register_layout_meta_box() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	if ( ! defined( 'BLOGPRESS_LAYOUT_META_BOX' ) ) {
		define( 'BLOGPRESS_LAYOUT_META_BOX', true );
	}

	global $post;

	$blog_id = get_option( 'page_for_posts' );

	// No need for the Layout metabox on the blog page.
	if ( isset( $post->ID ) && $blog_id && (int) $blog_id === (int) $post->ID ) {
		return;
	}

	$post_types = get_post_types( array( 'public' => true ) );

	foreach ( $post_types as $type ) {
		if ( 'attachment' !== $type ) {
			add_meta_box(
				'blogpress_layout_options_meta_box',
				esc_html__( 'Layout', 'blogpress' ),
				'blogpress_do_layout_meta_box',
				$type,
				'side'
			);
		}
	}
}

/**
 * Build our meta box.
 *
 * @since 1.0.0
 *
 * @param object $post All post information.
 */
function blogpress_do_layout_meta_box( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'blogpress_layout_nonce' );
	$stored_meta = (array) get_post_meta( $post->ID );
	$stored_meta['_blogpress-sidebar-layout-meta'][0] = ( isset( $stored_meta['_blogpress-sidebar-layout-meta'][0] ) ) ? $stored_meta['_blogpress-sidebar-layout-meta'][0] : '';
	$stored_meta['_blogpress-footer-widget-meta'][0] = ( isset( $stored_meta['_blogpress-footer-widget-meta'][0] ) ) ? $stored_meta['_blogpress-footer-widget-meta'][0] : '';
	$stored_meta['_blogpress-full-width-content'][0] = ( isset( $stored_meta['_blogpress-full-width-content'][0] ) ) ? $stored_meta['_blogpress-full-width-content'][0] : '';
	$stored_meta['_blogpress-disable-headline'][0] = ( isset( $stored_meta['_blogpress-disable-headline'][0] ) ) ? $stored_meta['_blogpress-disable-headline'][0] : '';

	$tabs = array(
		'sidebars' => array(
			'title' => esc_html__( 'Sidebars', 'blogpress' ),
			'target' => '#blogpress-layout-sidebars',
			'class' => 'current',
		),
		'footer_widgets' => array(
			'title' => esc_html__( 'Footer Widgets', 'blogpress' ),
			'target' => '#blogpress-layout-footer-widgets',
			'class' => '',
		),
		'disable_elements' => array(
			'title' => esc_html__( 'Disable Elements', 'blogpress' ),
			'target' => '#blogpress-layout-disable-elements',
			'class' => '',
		),
		'container' => array(
			'title' => esc_html__( 'Content Container', 'blogpress' ),
			'target' => '#blogpress-layout-page-builder-container',
			'class' => '',
		),
	);
	?>
	<script>
		jQuery(document).ready(function($) {
			$( '.blogpress-meta-box-menu li a' ).on( 'click', function( event ) {
				event.preventDefault();
				$( this ).parent().addClass( 'current' );
				$( this ).parent().siblings().removeClass( 'current' );
				var tab = $( this ).attr( 'data-target' );

				// Page header module still using href.
				if ( ! tab ) {
					tab = $( this ).attr( 'href' );
				}

				$( '.blogpress-meta-box-content' ).children( 'div' ).not( tab ).css( 'display', 'none' );
				$( tab ).fadeIn( 100 );
			});
		});
	</script>
	<div id="blogpress-meta-box-container">
		<ul class="blogpress-meta-box-menu">
			<?php
			foreach ( (array) $tabs as $tab => $data ) {
				echo '<li class="' . esc_attr( $data['class'] ) . '"><a data-target="' . esc_attr( $data['target'] ) . '" href="#">' . esc_html( $data['title'] ) . '</a></li>';
			}

			?>
		</ul>
		<div class="blogpress-meta-box-content">
			<div id="blogpress-layout-sidebars">
				<div class="blogpress_layouts">
					<label for="blogpress-sidebar-layout" class="blogpress-layout-metabox-section-title"><?php esc_html_e( 'Sidebar Layout', 'blogpress' ); ?></label>

					<select name="_blogpress-sidebar-layout-meta" id="blogpress-sidebar-layout">
						<option value="" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], '' ); ?>><?php esc_html_e( 'Default', 'blogpress' ); ?></option>
						<option value="right-sidebar" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], 'right-sidebar' ); ?>><?php esc_html_e( 'Right Sidebar', 'blogpress' ); ?></option>
						<option value="left-sidebar" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], 'left-sidebar' ); ?>><?php esc_html_e( 'Left Sidebar', 'blogpress' ); ?></option>
						<option value="no-sidebar" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], 'no-sidebar' ); ?>><?php esc_html_e( 'No Sidebars', 'blogpress' ); ?></option>
						<option value="both-sidebars" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], 'both-sidebars' ); ?>><?php esc_html_e( 'Both Sidebars', 'blogpress' ); ?></option>
						<option value="both-left" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], 'both-left' ); ?>><?php esc_html_e( 'Both Sidebars on Left', 'blogpress' ); ?></option>
						<option value="both-right" <?php selected( $stored_meta['_blogpress-sidebar-layout-meta'][0], 'both-right' ); ?>><?php esc_html_e( 'Both Sidebars on Right', 'blogpress' ); ?></option>
					</select>
				</div>
			</div>

			<div id="blogpress-layout-footer-widgets" style="display: none;">
				<div class="blogpress_footer_widget">
					<label for="blogpress-footer-widget" class="blogpress-layout-metabox-section-title"><?php esc_html_e( 'Footer Widgets', 'blogpress' ); ?></label>

					<select name="_blogpress-footer-widget-meta" id="blogpress-footer-widget">
						<option value="" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '' ); ?>><?php esc_html_e( 'Default', 'blogpress' ); ?></option>
						<option value="0" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '0' ); ?>><?php esc_html_e( '0 Widgets', 'blogpress' ); ?></option>
						<option value="1" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '1' ); ?>><?php esc_html_e( '1 Widgets', 'blogpress' ); ?></option>
						<option value="2" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '2' ); ?>><?php esc_html_e( '2 Widgets', 'blogpress' ); ?></option>
						<option value="3" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '3' ); ?>><?php esc_html_e( '3 Widgets', 'blogpress' ); ?></option>
						<option value="4" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '4' ); ?>><?php esc_html_e( '4 Widgets', 'blogpress' ); ?></option>
						<option value="5" <?php selected( $stored_meta['_blogpress-footer-widget-meta'][0], '5' ); ?>><?php esc_html_e( '5 Widgets', 'blogpress' ); ?></option>
					</select>
				</div>
			</div>
			<div id="blogpress-layout-page-builder-container" style="display: none;">
				<label for="_blogpress-full-width-content" class="blogpress-layout-metabox-section-title"><?php esc_html_e( 'Content Container', 'blogpress' ); ?></label>

				<p class="page-builder-content" style="color:#666;font-size:13px;margin-top:0;">
					<?php esc_html_e( 'Choose your content container type.', 'blogpress' ); ?>
				</p>

				<select name="_blogpress-full-width-content" id="_blogpress-full-width-content">
					<option value="" <?php selected( $stored_meta['_blogpress-full-width-content'][0], '' ); ?>><?php esc_html_e( 'Default', 'blogpress' ); ?></option>
					<option value="true" <?php selected( $stored_meta['_blogpress-full-width-content'][0], 'true' ); ?>><?php esc_html_e( 'Full Width', 'blogpress' ); ?></option>
					<option value="contained" <?php selected( $stored_meta['_blogpress-full-width-content'][0], 'contained' ); ?>><?php esc_html_e( 'Contained', 'blogpress' ); ?></option>
				</select>
			</div>
			<div id="blogpress-layout-disable-elements" style="display: none;">
				<label class="blogpress-layout-metabox-section-title"><?php esc_html_e( 'Disable Elements', 'blogpress' ); ?></label>
				<?php if ( ! defined( 'BLOGPRESS_DE_VERSION' ) ) : ?>
					<div class="blogpress_disable_elements">
						<label for="meta-blogpress-disable-headline" style="display:block;margin: 0 0 1em;" title="<?php esc_attr_e( 'Content Title', 'blogpress' ); ?>">
							<input type="checkbox" name="_blogpress-disable-headline" id="meta-blogpress-disable-headline" value="true" <?php checked( $stored_meta['_blogpress-disable-headline'][0], 'true' ); ?>>
							<?php esc_html_e( 'Content Title', 'blogpress' ); ?>
						</label>

					</div>
				<?php endif; ?>

				<?php?>
			</div>
			<?php?>
		</div>
	</div>
	<?php
}

add_action( 'save_post', 'blogpress_save_layout_meta_data' );
/**
 * Saves the sidebar layout meta data.
 *
 * @since 1.0.0
 * @param int $post_id Post ID.
 */
function blogpress_save_layout_meta_data( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['blogpress_layout_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['blogpress_layout_nonce'] ), basename( __FILE__ ) ) ) ? true : false;

	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$sidebar_layout_key   = '_blogpress-sidebar-layout-meta';
	$sidebar_layout_value = isset( $_POST[ $sidebar_layout_key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $sidebar_layout_key ] ) )
		: '';

	if ( $sidebar_layout_value ) {
		update_post_meta( $post_id, $sidebar_layout_key, $sidebar_layout_value );
	} else {
		delete_post_meta( $post_id, $sidebar_layout_key );
	}

	$footer_widget_key   = '_blogpress-footer-widget-meta';
	$footer_widget_value = isset( $_POST[ $footer_widget_key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $footer_widget_key ] ) )
		: '';

	// Check for empty string to allow 0 as a value.
	if ( '' !== $footer_widget_value ) {
		update_post_meta( $post_id, $footer_widget_key, $footer_widget_value );
	} else {
		delete_post_meta( $post_id, $footer_widget_key );
	}

	$page_builder_container_key   = '_blogpress-full-width-content';
	$page_builder_container_value = isset( $_POST[ $page_builder_container_key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $page_builder_container_key ] ) )
		: '';

	if ( $page_builder_container_value ) {
		update_post_meta( $post_id, $page_builder_container_key, $page_builder_container_value );
	} else {
		delete_post_meta( $post_id, $page_builder_container_key );
	}

	// We only need this if the Disable Elements module doesn't exist.
	if ( ! defined( 'BLOGPRESS_DE_VERSION' ) ) {
		$disable_content_title_key   = '_blogpress-disable-headline';
		$disable_content_title_value = isset( $_POST[ $disable_content_title_key ] )
			? sanitize_text_field( wp_unslash( $_POST[ $disable_content_title_key ] ) )
			: '';

		if ( $disable_content_title_value ) {
			update_post_meta( $post_id, $disable_content_title_key, $disable_content_title_value );
		} else {
			delete_post_meta( $post_id, $disable_content_title_key );
		}
	}
}
