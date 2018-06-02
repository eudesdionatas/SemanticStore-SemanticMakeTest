<?php
/**
 * Archive page template.
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

get_header();

	capri_show_page_header( 'archive' ); ?>

	<div class="container">
		<div class="row">

			<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
				<span class="capri-sidebar-open"><i class="fa fa-list" aria-hidden="true"></i></span>
			<?php
}

			echo '<div id="primary" class="col-xs-12 ';

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	echo ' col-md-8 col-md-offset-2 ';
} else {
	echo ' col-md-8 ';
}
			echo ' content-area">';
			?>
				<main id="main" class="site-main">

				<?php
				if ( have_posts() ) :
				?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

					// Previous/next page navigation.
					the_posts_pagination(
						array(
							'prev_text'          => esc_html__( 'Newer posts', 'capri-lite' ),
							'next_text'          => esc_html__( 'Older posts', 'capri-lite' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'capri-lite' ) . ' </span>',
						)
					);

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php
				get_sidebar();
			?>

		</div><!-- .row -->
	</div><!-- .container -->

	<?php get_template_part( 'template-parts/blog', 'ribbon' ); ?>

<?php
get_footer();
