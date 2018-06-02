<?php
/**
 * Single post page template.
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

get_header();
capri_show_categories( 'blog' ); ?>

	<div class="container">
		<div class="row">

			<div id="primary" class="col-xs-12 col-sm-12 col-md-8 content-area content-area-single">
				<main id="main" class="site-main">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_format() );

					the_post_navigation(
						array(
							'prev_text' => esc_html__( 'Prev Post', 'capri-lite' ),
							'next_text' => esc_html__( 'Next Post', 'capri-lite' ),
						)
					);

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php
			get_sidebar();
			?>
		</div><!-- .row -->
	</div><!-- .container -->

<?php
get_footer();
