<?php
/**
 * Footer template.
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

?>

	</div><!-- #content -->

		<footer id="colophon" class="site-footer">
			<?php
			$show_footer = is_active_sidebar( 'capri-footer-widget-area' ) || is_active_sidebar( 'capri-footer-widget-area-2' ) || is_active_sidebar( 'capri-footer-widget-area-3' );
			if ( $show_footer ) {
			?>
				<div class="container container-footer">

					<div class="footer-inner">
						<div class="row">
							<div class="col-md-4 footer-inner-item">
								<?php
								if ( is_active_sidebar( 'capri-footer-widget-area' ) ) {
									dynamic_sidebar( 'capri-footer-widget-area' );
								}
								?>
							</div>

							<div class="col-md-4 footer-inner-item">
								<?php
								if ( is_active_sidebar( 'capri-footer-widget-area-2' ) ) {
									dynamic_sidebar( 'capri-footer-widget-area-2' );
								}
								?>
							</div>

							<div class="col-md-4 footer-inner-item">
								<?php
								if ( is_active_sidebar( 'capri-footer-widget-area-3' ) ) {
									dynamic_sidebar( 'capri-footer-widget-area-3' );
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php
			}

			$capri_footer_copyright = get_theme_mod(
				'capri_footer_copyright',
				sprintf(
					/* translators: $1%s: Theme link, %2$s WordPress link */
						apply_filters( 'capri_filter_copyright', esc_html__( '%1$s | Powered by %2$s', 'capri-lite' ) ),
					/* translators: %s is Theme link */
						sprintf( '<a href="https://themeisle.com/themes/capri-pro" rel="nofollow" target="_blank">%s</a>', esc_html__( 'CAPRI', 'capri-lite' ) ),
					/* translators: %s is WordPress name*/
						sprintf( '<a href="http://wordpress.org/" rel="nofollow" target="_blank">%s</a>', esc_html__( 'WordPress', 'capri-lite' ) )
				)
			);

			if ( ! empty( $capri_footer_copyright ) || is_customize_preview() ) {
			?>
				<div class="site-info">
					<div class="container">
						<div class="footer-copyright">
							<?php
							if ( ! empty( $capri_footer_copyright ) ) {
								echo wp_kses_post( $capri_footer_copyright );
							}
							?>
						</div>
					</div>
				</div><!-- .site-info -->
			<?php
			}
			?>

		</footer><!-- #colophon -->
	</div><!-- .site-inner -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
