<?php
/**
 * Search content template.
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author Themeisle
 * @version 1.1.3
 * @package capri-pro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content hentry' ); ?>>
	<header class="entry-header">
		<div class="entry-header-title-wrap">

			<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>

			<div class="entry-meta">
				<?php capri_posted_on(); ?>
			</div><!-- .entry-meta -->

		</div>
	</header><!-- .entry-header -->

	<div class="entry-content<?php echo ! is_single() ? ' entry-content-blog' : ''; ?>">
		<?php
		$capri_more = strpos( $post->post_content, '<!--more' );

		if ( $capri_more || is_single() ) {
			the_content(
				sprintf(
					/* translators: %s: Name of current post. */
					esc_html__( 'Continue reading %s', 'capri-lite' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);
		} else {
			the_excerpt();
		}

		if ( is_single() ) {
			capri_entry_footer();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'capri-lite' ),
					'after'  => '</div>',
				)
			);

		}
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
