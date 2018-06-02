<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * <?php if ( get_header_image() ) : ?>
 * <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
 * <img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
 * </a>
 * <?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @since   1.0.0
 * @access  public
 * @uses capri_header_style()
 */
function capri_custom_header_setup() {
	add_theme_support(
		'custom-header', apply_filters(
			'capri_custom_header_args', array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1920,
				'height'             => 450,
				'flex-height'        => true,
				'wp-head-callback'   => 'capri_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'capri_custom_header_setup' );

if ( ! function_exists( 'capri_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @see capri_custom_header_setup().
	 */
	function capri_header_style() {
		$header_text_color = get_header_textcolor();

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
			<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}

			<?php
				// If the user has set a custom color for the text use that.
				else :
			?>
			.site-branding .site-title a,
			.site-description,
			.transparent-header .site-branding .site-title a,
			.transparent-header .site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}

			<?php endif; ?>
		</style>
		<?php
	}
endif;
