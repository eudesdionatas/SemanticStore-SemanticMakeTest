<?php
/**
 * Sync functions for control.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

// Load Customizer page editor.
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer-page-editor/class/class-capri-page-editor.php' );

/**
 * Sync frontpage content with customizer control
 *
 * @since   1.0.0
 * @access  public
 * @param string $value New value.
 * @param string $old_value Old value.
 * @return mixed
 */
function capri_sync_content_from_control( $value = '', $old_value = '' ) {
	$frontpage_id = get_option( 'page_on_front' );
	if ( ! wp_is_post_revision( $frontpage_id ) ) {

		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post', 'capri_sync_control_from_page' );

		// update the post, which calls save_post again
		$post = array(
			'ID'           => $frontpage_id,
			'post_content' => wp_kses_post( $value ),
		);

		wp_update_post( $post );

		// re-hook this function
		add_action( 'save_post', 'capri_sync_control_from_page' );
	}

	return $value;
}
add_filter( 'pre_set_theme_mod_capri_page_editor', 'capri_sync_content_from_control', 10, 2 );


/**
 * Sync frontpage thumbnail with customizer control
 *
 * @since   1.0.0
 * @access  public
 * @param string $value New value.
 * @param string $old_value Old value.
 * @return mixed
 */
function capri_sync_thumbnail_from_control( $value, $old_value ) {

	$frontpage_id = get_option( 'page_on_front' );
	if ( ! empty( $frontpage_id ) ) {
		$thumbnail_id = attachment_url_to_postid( $value );
		update_post_meta( $frontpage_id, '_thumbnail_id', $thumbnail_id );
	}
	return $value;
}
add_filter( 'pre_set_theme_mod_capri_feature_thumbnail', 'capri_sync_thumbnail_from_control', 10, 2 );

/**
 * Sync page thumbnail and content with customizer control
 *
 * @since   1.0.0
 * @access  public
 * @param int $post_id Page id.
 */
function capri_sync_control_from_page( $post_id, $ajax_call = false ) {
	$parent_id = wp_is_post_revision( $post_id );
	if ( ! empty( $parent_id ) ) {
		$post_id = $parent_id;
	}
	$return_value = array();
	remove_action( 'save_post', 'capri_sync_control_from_page' );
	remove_filter( 'pre_set_theme_mod_capri_feature_thumbnail', 'capri_sync_thumbnail_from_control', 10 );
	remove_filter( 'pre_set_theme_mod_capri_page_editor', 'capri_sync_content_from_control', 10 );

	$frontpage_id = get_option( 'page_on_front' );
	if ( (int) $frontpage_id !== (int) $post_id ) {
		return;
	}

	$content = '';
	if ( ! empty( $frontpage_id ) ) {
		$content_post = get_post( $frontpage_id );
		$content      = $content_post->post_content;
		$content      = apply_filters( 'capri_text', $content );
		$content      = str_replace( ']]>', ']]&gt;', $content );
	}
	set_theme_mod( 'capri_page_editor', $content );

	$capri_frontpage_featured = '';
	if ( has_post_thumbnail( $frontpage_id ) ) {
		$capri_frontpage_featured = get_the_post_thumbnail_url( $frontpage_id );
	}
	set_theme_mod( 'capri_feature_thumbnail', $capri_frontpage_featured );

	if ( $ajax_call === true ) {
		$return_value['post_content']   = $content;
		$return_value['post_thumbnail'] = $capri_frontpage_featured;
		echo json_encode( $return_value );
	}
	add_action( 'save_post', 'capri_sync_control_from_page' );
	add_filter( 'pre_set_theme_mod_capri_feature_thumbnail', 'capri_sync_thumbnail_from_control', 10, 2 );
	add_filter( 'pre_set_theme_mod_capri_page_editor', 'capri_sync_content_from_control', 10, 2 );

	echo '';
}
add_action( 'save_post', 'capri_sync_control_from_page' );


/**
 * Ajax call to sync page content and thumbnail when you switch to static frontpage
 *
 * @since   1.0.0
 * @access  public
 */
function capri_ajax_call() {
	$pid = $_POST['pid'];
	capri_sync_control_from_page( $pid, true );
	die();
}
add_action( 'wp_ajax_capri_ajax_call', 'capri_ajax_call' );

/**
 * Change the default editor to html when using the tinyMce editor in customizer.
 *
 * @since   1.0.0
 * @access  public
 * @param string $r The current value of the default editor.
 * @return string The new value of the editor, if we are in the customizer page.
 */
function capri_set_default_editor( $r ) {
	if ( is_customize_preview() && function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) ) {
			if ( $screen->id === 'customize' ) {
				return 'tmce';
			}
		}
	}
	return $r;
}
add_filter( 'wp_default_editor', 'capri_set_default_editor' );


/**
 * Filters for text format
 */
add_filter( 'capri_text', 'wptexturize' );
add_filter( 'capri_text', 'convert_smilies' );
add_filter( 'capri_text', 'convert_chars' );
add_filter( 'capri_text', 'wpautop' );
add_filter( 'capri_text', 'shortcode_unautop' );
add_filter( 'capri_text', 'do_shortcode' );
