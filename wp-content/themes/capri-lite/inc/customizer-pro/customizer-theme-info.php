<?php
/**
 * Theme info customizer controls.
 *
 * @package capri
 * @author Themeisle
 * @version 1.1.3
 */

/**
 * Hook Theme Info section to customizer.
 *
 * @access public
 * @since 1.1.0
 * @param WP_Customize_Manager $wp_customize The wp_customize object.
 */
function capri_theme_info_customize_register( $wp_customize ) {
	// Include upsell class.
	require_once( get_template_directory() . '/inc/customizer-pro/class/class-capri-control-upsell.php' );

	// Add Theme Info Section.
	$wp_customize->add_section(
		'capri_features_section', array(
			'title'    => __( 'View PRO version', 'capri-lite' ),
			'priority' => 1,
		)
	);

	// Add upsells.
	$wp_customize->add_setting(
		'capri_upsell_pro_features_main', array(
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		new Capri_Control_Upsell(
			$wp_customize, 'capri_upsell_pro_features_main', array(
				'section'     => 'capri_features_section',
				'priority'    => 1,
				'options'     => array(
					esc_html__( 'Big title frontpage section', 'capri-lite' ),
					esc_html__( 'Featured products frontpage section', 'capri-lite' ),
					esc_html__( 'Categories frontpage section', 'capri-lite' ),
					esc_html__( 'Special offers frontpage section', 'capri-lite' ),
					esc_html__( 'About frontpage section', 'capri-lite' ),
					esc_html__( 'WPML/Polylang compatibility', 'capri-lite' ),
					esc_html__( 'Support', 'capri-lite' ),
				),
				'button_url'  => esc_url( 'https://themeisle.com/themes/capri-pro/' ),
				// xss ok
				'button_text' => esc_html__( 'View PRO version', 'capri-lite' ),
			)
		)
	);

}
add_action( 'customize_register', 'capri_theme_info_customize_register' );

