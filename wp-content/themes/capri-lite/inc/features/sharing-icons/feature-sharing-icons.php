<?php
/**
 * Display sharing icons for single posts, shop items, events & food menu.
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/**
 * Enqueue sharing icons style.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_enqueue_style_sharing_icons() {
	wp_enqueue_style( 'capri-sharing-icons', get_template_directory_uri() . '/inc/features/sharing-icons/css/sharing-icons.css' );
}
add_action( 'wp_enqueue_scripts', 'capri_enqueue_style_sharing_icons' );

/**
 * Adding sharing icons.
 *
 * @since   1.0.0
 * @access  public
 */
function capri_register_sharing_icons() {
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'sharedaddy' ) ) {
		echo '<div class="share">';
		if ( function_exists( 'sharing_display' ) ) {
			sharing_display( '', true );
		}
		if ( class_exists( 'Jetpack_Likes' ) ) {
			$custom_likes = new Jetpack_Likes;
			echo $custom_likes->post_likes( '' );
		}
		echo '</div>';
		add_action( 'woocommerce_share', 'jetpack_woocommerce_social_share_icons', 15 );
	}
}
if ( function_exists( 'capri_register_sharing_icons' ) ) {
	add_action( 'capri_sharing_icons', 'capri_register_sharing_icons' );
}

// Remove sharing icons on single shop page
if ( function_exists( 'jetpack_woocommerce_social_share_icons' ) ) {
	remove_action( 'woocommerce_share', 'jetpack_woocommerce_social_share_icons' );
}

/**
 * Remove defaul Jetpack icons
 *
 * @since   1.0.0
 * @access  public
 */
function capri_remove_share() {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
add_action( 'loop_start', 'capri_remove_share' );
