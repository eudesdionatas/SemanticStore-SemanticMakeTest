<?php
/**
 * Front page content template.
 * The default template for displaying content
 *
 * Used for front page.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

if ( is_customize_preview() ) {
	$frontpage_id = get_option( 'page_on_front' );
	$default      = '';
	if ( ! empty( $frontpage_id ) ) {
		$default = get_post_field( 'post_content', $frontpage_id );
		$content = get_theme_mod( 'capri_page_editor', $default );
		$content = apply_filters( 'capri_text', $content );
		echo wp_kses_post( $content );
	} else {
		the_content();
	}
} else {
	the_content();
}
