<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */
get_header(); ?>

	<div class="container">
		<div class="row">

			<div id="primary" class="col-xs-12 col-md-8 col-md-offset-2 content-area">
				<main id="main" class="site-main">

					<?php
						/* Start the Loop */
					while ( have_posts() ) :
						the_post();
?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content' ); ?>>
								<header class="entry-header">
									<?php
									capri_the_attached_image();
									?>

									<div class="entry-header-title-wrap without-featured-image">

										<?php
										the_title( '<h1 class="entry-title">', '</h1>' );
										?>


										<div class="entry-meta">
											<?php
											/* translators: %1$s is date attribute, %2$s is date */
											$published_text = __( '<span class="attachment-meta"><time class="entry-date" datetime="%1$s">%2$s</time>', 'capri-lite' );
											$post_title     = get_the_title( $post->post_parent );
											if ( empty( $post_title ) || 0 == $post->post_parent ) {
												$published_text = '<span class="attachment-meta"><time class="entry-date" datetime="%1$s">%2$s</time></span>';
											}
											printf(
												$published_text,
												esc_attr( get_the_date( 'c' ) ),
												esc_html( get_the_date() )
											);
											?>
										</div><!-- .entry-meta -->



									</div>

								</header><!-- .entry-header -->
								<div class="entry-content<?php echo ! is_single() ? ' entry-content-blog' : ''; ?>">
									<?php
									$metadata = wp_get_attachment_metadata();
									/* translators: %1$s is attachment url, %2$s is attachment title, %3$s is full resolution, %4$s is image width, %5$s is image height */
									printf(
										'<span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s">%3$s (%4$s &times; %5$s)</a></span>',
										esc_url( wp_get_attachment_url() ),
										esc_attr__( 'Link to full-size image', 'capri-lite' ),
										esc_html__( 'Full resolution', 'capri-lite' ),
										$metadata['width'],
										$metadata['height']
									);
									?>
									<div class="single-cat-links">
									<?php
									/* translators: %1$s is post title */
									$published_text = '<span class="cat-links">' . esc_html__( 'posted under: %1$s', 'capri-lite' ) . '</span>';
									$post_title     = get_the_title( $post->post_parent );

									printf(
										$published_text,
										/* translators: %1$s is post parent url, %2$s is post title as attribute, %3$s is post parent */
										sprintf(
											'<a href="%1$s" title="Return to %2$s" rel="gallery">%3$s</a>',
											esc_url( get_permalink( $post->post_parent ) ),
											esc_attr( strip_tags( $post_title ) ),
											esc_html( $post_title )
										)
									);

									?>
									</div>

								</div><!-- .entry-content -->
							</article><!-- #post-## -->
							<?php

						endwhile;
						?>

						<nav class="navigation post-navigation">
							<div class="nav-links">
								<div class="nav-previous">
									<?php
									/* translators: %s is previous text */
									previous_image_link( false, sprintf( '<span class="meta-nav">&larr;</span> %s', esc_html__( 'Previous', 'capri-lite' ) ) );
									?>
								</div>
								<div class="nav-next">
									<?php
									/* translators: %s is next text */
									next_image_link( false, sprintf( '%s <span class="meta-nav">&rarr;</span>', esc_html__( 'Next', 'capri-lite' ) ) );
									?>
								</div>
							</div>
						</nav>
				</main>
			</div>
		</div>
	</div>

<?php if ( is_active_sidebar( 'ribbon-area' ) ) { ?>
	<div class="ribbon-area page-ribbon">
		<?php dynamic_sidebar( 'ribbon-area' ); ?>
	</div>
<?php } ?>

<?php
get_footer();
